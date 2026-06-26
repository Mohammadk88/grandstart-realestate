<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Project;
use App\Models\ProjectFeature;
use App\Models\ProjectFeatureTranslation;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with('translations');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('translations', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $projects = $query->orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $languages = Language::allActive();
        return view('admin.projects.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateProject($request);

        $project = new Project($validated);

        if ($request->hasFile('main_image')) {
            $project->main_image = $this->uploadImage($request->file('main_image'), 'projects');
        }

        $project->slug = Str::slug($request->input('translations.en.title', '') ?: $request->input('translations.' . Language::getDefaultCode() . '.title', 'project'))
            . '-' . Str::random(6);
        $project->save();

        $this->saveTranslations($project, $request->input('translations', []));
        $this->saveFeatures($project, $request->features ?? []);

        return redirect()->route('admin.projects.index')
            ->with('success', 'تم إضافة المشروع بنجاح');
    }

    public function show(Project $project)
    {
        $project->load(['images', 'features.translations', 'contacts', 'translations']);
        $languages = Language::allActive();
        return view('admin.projects.show', compact('project', 'languages'));
    }

    public function edit(Project $project)
    {
        $project->load(['images', 'features.translations', 'translations']);
        $languages = Language::allActive();
        return view('admin.projects.edit', compact('project', 'languages'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $this->validateProject($request);

        if ($request->hasFile('main_image')) {
            if ($project->main_image) {
                Storage::delete('public/' . $project->main_image);
            }
            $validated['main_image'] = $this->uploadImage($request->file('main_image'), 'projects');
        }

        $project->update($validated);

        $this->saveTranslations($project, $request->input('translations', []));
        $this->saveFeatures($project, $request->features ?? []);

        return redirect()->route('admin.projects.index')
            ->with('success', 'تم تحديث المشروع بنجاح');
    }

    public function destroy(Project $project)
    {
        if ($project->main_image) {
            Storage::delete('public/' . $project->main_image);
        }

        foreach ($project->images as $image) {
            Storage::delete('public/' . $image->image);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'تم حذف المشروع بنجاح');
    }

    public function uploadImages(Request $request, Project $project)
    {
        $request->validate([
            'images.*' => 'required|image|max:5120',
        ]);

        $uploaded = 0;
        foreach ($request->file('images', []) as $file) {
            $path = $this->uploadImage($file, 'projects/gallery');
            ProjectImage::create([
                'project_id' => $project->id,
                'image'      => $path,
                'sort_order' => $project->images()->count() + 1,
            ]);
            $uploaded++;
        }

        return response()->json(['success' => true, 'uploaded' => $uploaded]);
    }

    public function deleteImage(Project $project, ProjectImage $image)
    {
        Storage::delete('public/' . $image->image);
        $image->delete();

        return response()->json(['success' => true]);
    }

    public function toggleFeatured(Project $project)
    {
        $project->update(['featured' => !$project->featured]);

        return response()->json([
            'success'  => true,
            'featured' => $project->featured,
        ]);
    }

    private function validateProject(Request $request): array
    {
        return $request->validate([
            'price_usd'     => 'nullable|numeric|min:0',
            'price_try'     => 'nullable|numeric|min:0',
            'price_iqd'     => 'nullable|numeric|min:0',
            'area'          => 'nullable|string|max:100',
            'floors'        => 'nullable|integer|min:1',
            'units'         => 'nullable|integer|min:1',
            'status'        => 'required|in:available,sold_out,under_construction,coming_soon',
            'type'          => 'required|in:residential,commercial,villa,apartment,compound,tower',
            'featured'      => 'boolean',
            'active'        => 'boolean',
            'video_url'     => 'nullable|url',
            'latitude'      => 'nullable|numeric',
            'longitude'     => 'nullable|numeric',
            'delivery_date' => 'nullable|date',
            'sort_order'    => 'nullable|integer',
        ]);
    }

    private function uploadImage($file, string $folder): string
    {
        $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $file->storeAs("public/{$folder}", $filename);
        return "{$folder}/{$filename}";
    }

    private function saveTranslations(Project $project, array $translations): void
    {
        foreach ($translations as $locale => $data) {
            if (empty(trim($data['title'] ?? ''))) {
                continue;
            }
            $project->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'title'       => $data['title'],
                    'description' => $data['description'] ?? null,
                    'location'    => $data['location'] ?? null,
                ]
            );
        }
    }

    private function saveFeatures(Project $project, array $features): void
    {
        $project->features()->delete();

        foreach ($features as $feature) {
            $hasText = false;
            foreach ($feature as $key => $val) {
                if ($key !== 'icon' && !empty(trim($val ?? ''))) {
                    $hasText = true;
                    break;
                }
            }

            if (!$hasText) {
                continue;
            }

            $pf = ProjectFeature::create([
                'project_id' => $project->id,
                'icon'       => $feature['icon'] ?? 'fas fa-check',
            ]);

            foreach ($feature as $key => $val) {
                if ($key !== 'icon' && !empty(trim($val ?? ''))) {
                    ProjectFeatureTranslation::create([
                        'feature_id' => $pf->id,
                        'locale'     => $key,
                        'text'       => $val,
                    ]);
                }
            }
        }
    }
}
