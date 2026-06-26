<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Project;
use App\Models\ProjectFeature;
use App\Models\ProjectFeatureTranslation;
use App\Models\ProjectImage;
use App\Models\ProjectMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
            [$path] = $this->uploadImage($request->file('main_image'), 'projects');
            $project->main_image = $path;
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
                $oldThumb = preg_replace('/(\.\w+)$/', '_thumb$1', $project->main_image);
                Storage::delete('public/' . $oldThumb);
            }
            [$path] = $this->uploadImage($request->file('main_image'), 'projects');
            $validated['main_image'] = $path;
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
            'images.*' => 'required|image|mimes:jpeg,jpg,png,webp,gif|max:10240',
        ]);

        $uploaded = 0;
        foreach ($request->file('images', []) as $file) {
            [$path, $thumb] = $this->uploadImage($file, 'projects/gallery');
            ProjectMedia::create([
                'project_id'    => $project->id,
                'type'          => 'image',
                'path'          => $path,
                'thumbnail'     => $thumb,
                'original_name' => $file->getClientOriginalName(),
                'file_size'     => $file->getSize(),
                'sort_order'    => $project->media()->count() + 1,
            ]);
            $uploaded++;
        }

        return response()->json(['success' => true, 'uploaded' => $uploaded]);
    }

    public function uploadPdfs(Request $request, Project $project)
    {
        $request->validate([
            'pdfs.*' => 'required|mimes:pdf|max:20480',
        ]);

        $uploaded = 0;
        foreach ($request->file('pdfs', []) as $file) {
            $basename = Str::random(20);
            $filename = $basename . '.pdf';
            $folder   = 'projects/pdfs';
            $file->storeAs("public/{$folder}", $filename);

            ProjectMedia::create([
                'project_id'    => $project->id,
                'type'          => 'pdf',
                'path'          => "{$folder}/{$filename}",
                'original_name' => $file->getClientOriginalName(),
                'file_size'     => $file->getSize(),
                'sort_order'    => $project->media()->count() + 1,
            ]);
            $uploaded++;
        }

        return response()->json(['success' => true, 'uploaded' => $uploaded]);
    }

    public function uploadVideos(Request $request, Project $project)
    {
        $request->validate([
            'videos.*' => 'required|mimes:mp4,mov,avi,webm|max:204800',
        ]);

        $uploaded = 0;
        foreach ($request->file('videos', []) as $file) {
            $basename = Str::random(20);
            $ext      = $file->getClientOriginalExtension();
            $filename = $basename . '.' . $ext;
            $folder   = 'projects/videos';
            $file->storeAs("public/{$folder}", $filename);

            ProjectMedia::create([
                'project_id'    => $project->id,
                'type'          => 'video',
                'path'          => "{$folder}/{$filename}",
                'original_name' => $file->getClientOriginalName(),
                'file_size'     => $file->getSize(),
                'sort_order'    => $project->media()->count() + 1,
            ]);
            $uploaded++;
        }

        return response()->json(['success' => true, 'uploaded' => $uploaded]);
    }

    public function deleteMedia(Project $project, ProjectMedia $media)
    {
        Storage::delete('public/' . $media->path);
        if ($media->thumbnail) {
            Storage::delete('public/' . $media->thumbnail);
        }
        $media->delete();

        return response()->json(['success' => true]);
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

    private function uploadImage($file, string $folder): array
    {
        $ext       = strtolower($file->getClientOriginalExtension());
        $basename  = Str::random(20);
        $filename  = $basename . '.' . $ext;
        $thumbname = $basename . '_thumb.' . $ext;

        $storagePath = storage_path("app/public/{$folder}");
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0775, true);
        }

        $file->storeAs("public/{$folder}", $filename);

        // Strip EXIF and create thumbnail
        $manager = new ImageManager(new Driver());
        $manager->read($file->getRealPath())
            ->cover(800, 600)
            ->save("{$storagePath}/{$thumbname}");

        return ["{$folder}/{$filename}", "{$folder}/{$thumbname}"];
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
