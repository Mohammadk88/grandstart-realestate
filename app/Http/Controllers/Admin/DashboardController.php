<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_projects' => Project::count(),
            'active_projects' => Project::where('active', true)->count(),
            'featured_projects' => Project::where('featured', true)->count(),
            'total_contacts' => Contact::count(),
            'unread_contacts' => Contact::where('is_read', false)->count(),
            'today_contacts' => Contact::whereDate('created_at', today())->count(),
        ];

        $recentContacts = Contact::with('project')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentProjects = Project::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $contactsByCountry = Contact::selectRaw('country_code, COUNT(*) as count')
            ->groupBy('country_code')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        $monthlyContacts = Contact::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return view('admin.dashboard', compact(
            'stats',
            'recentContacts',
            'recentProjects',
            'contactsByCountry',
            'monthlyContacts'
        ));
    }
}
