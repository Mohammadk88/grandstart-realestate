<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CountryContact;
use App\Models\HeroSlide;
use App\Models\PageSection;
use App\Models\Project;
use App\Models\Setting;
use App\Services\CountryContactService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private function extractCity(string $location): string
    {
        // "بشيكتاش، إسطنبول" → "إسطنبول"
        $parts = preg_split('/[,،]/u', $location);
        return trim(end($parts)) ?: trim($location);
    }

    public function index(Request $request)
    {
        $countryCode    = $request->get('visitor_country', 'TR');
        $contact        = CountryContactService::getContact($countryCode);
        $countryContact = CountryContact::getForCountry($countryCode) ?? CountryContact::getDefault();

        $featuredProjects = Project::active()->featured()
            ->with(['translations', 'images'])
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $latestProjects = Project::active()
            ->with(['translations', 'images'])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $stats = [
            'projects'  => Project::active()->count(),
            'years'     => Setting::get('company_years', '10'),
            'clients'   => Setting::get('total_clients', '500'),
            'countries' => Setting::get('countries_count', '5'),
        ];

        $heroType   = Setting::get('hero_type', 'static');
        $heroSlides = HeroSlide::active();

        PageSection::seedDefaults();
        $sections = PageSection::where('page', 'home')->orderBy('sort_order')->get();

        $whatsapp = $contact['whatsapp'];

        // Projects with coordinates for the map section
        $mapProjects = Project::active()
            ->with(['translations', 'images'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('latitude', '!=', '')
            ->where('longitude', '!=', '')
            ->take(50)
            ->get();

        // Areas/cities extracted from location translations
        $areaProjects = Project::active()
            ->with(['translations', 'images'])
            ->orderBy('sort_order')
            ->get()
            ->groupBy(fn ($p) => $this->extractCity($p->getLocation()));

        return view('frontend.home', compact(
            'featuredProjects',
            'latestProjects',
            'stats',
            'countryCode',
            'whatsapp',
            'countryContact',
            'heroType',
            'heroSlides',
            'sections',
            'mapProjects',
            'areaProjects'
        ));
    }
}
