<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CountryContact;
use App\Models\Project;
use App\Models\Setting;
use App\Services\CountryContactService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
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

        $whatsapp = $contact['whatsapp'];

        return view('frontend.home', compact(
            'featuredProjects',
            'latestProjects',
            'stats',
            'countryCode',
            'whatsapp',
            'countryContact'
        ));
    }
}
