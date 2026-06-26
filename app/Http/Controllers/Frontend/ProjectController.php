<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CountryContact;
use App\Models\Project;
use App\Services\CountryContactService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $countryCode    = $request->get('visitor_country', 'TR');
        $contact        = CountryContactService::getContact($countryCode);
        $countryContact = CountryContact::getForCountry($countryCode) ?? CountryContact::getDefault();

        $query = Project::active()->with(['translations', 'images']);

        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('translations', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $projects = $query->orderBy('featured', 'desc')
                         ->orderBy('sort_order')
                         ->orderBy('created_at', 'desc')
                         ->paginate(9);

        $whatsapp = $contact['whatsapp'];

        return view('frontend.projects.index', compact('projects', 'countryCode', 'whatsapp', 'countryContact'));
    }

    public function show(Request $request, string $slug)
    {
        $project = Project::where('slug', $slug)
            ->active()
            ->with(['translations', 'images', 'features.translations'])
            ->firstOrFail();

        $countryCode    = $request->get('visitor_country', 'TR');
        $contact        = CountryContactService::getContact($countryCode);
        $countryContact = CountryContact::getForCountry($countryCode) ?? CountryContact::getDefault();

        $relatedProjects = Project::active()
            ->where('id', '!=', $project->id)
            ->where('type', $project->type)
            ->with(['translations', 'images'])
            ->take(3)
            ->get();

        $whatsapp = $contact['whatsapp'];
        $phone    = $contact['phone'];

        return view('frontend.projects.show', compact(
            'project',
            'relatedProjects',
            'countryCode',
            'whatsapp',
            'phone',
            'countryContact'
        ));
    }
}
