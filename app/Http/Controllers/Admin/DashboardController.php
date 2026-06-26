<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Contact;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $currentAdmin = app('currentAdmin');

        // ── CRM Stats ─────────────────────────────────────────────────────
        $crmStats = [
            'total'        => Contact::count(),
            'new'          => Contact::where('status', Contact::STATUS_NEW)->count(),
            'in_progress'  => Contact::where('status', Contact::STATUS_IN_PROGRESS)->count(),
            'converted'    => Contact::where('status', Contact::STATUS_CONVERTED)->count(),
            'closed'       => Contact::where('status', Contact::STATUS_CLOSED)->count(),
            'unread'       => Contact::where('is_read', false)->count(),
            'today'        => Contact::whereDate('created_at', today())->count(),
            'this_week'    => Contact::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month'   => Contact::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
            'due_followup' => Contact::dueFollowUp()->count(),
            'urgent'       => Contact::where('priority', Contact::PRIORITY_URGENT)
                                    ->whereNotIn('status', [Contact::STATUS_CONVERTED, Contact::STATUS_CLOSED])
                                    ->count(),
        ];

        // Conversion rate
        $crmStats['conversion_rate'] = $crmStats['total'] > 0
            ? round(($crmStats['converted'] / $crmStats['total']) * 100, 1)
            : 0;

        // ── Project Stats ─────────────────────────────────────────────────
        $projectStats = [
            'total'            => Project::count(),
            'active'           => Project::where('active', true)->count(),
            'featured'         => Project::where('featured', true)->count(),
            'under_construction'=> Project::where('status', 'under_construction')->count(),
            'available'        => Project::where('status', 'available')->count(),
            'sold_out'         => Project::where('status', 'sold_out')->count(),
        ];

        // ── Monthly Contacts (last 6 months) ──────────────────────────────
        $monthlyContacts = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyContacts[] = [
                'label' => $date->locale('ar')->isoFormat('MMM'),
                'total' => Contact::whereYear('created_at', $date->year)
                                  ->whereMonth('created_at', $date->month)
                                  ->count(),
                'converted' => Contact::whereYear('created_at', $date->year)
                                      ->whereMonth('created_at', $date->month)
                                      ->where('status', Contact::STATUS_CONVERTED)
                                      ->count(),
            ];
        }

        // ── Weekly Contacts (last 7 days) ─────────────────────────────────
        $weeklyContacts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $weeklyContacts[] = [
                'label' => $date->locale('ar')->isoFormat('ddd'),
                'count' => Contact::whereDate('created_at', $date)->count(),
            ];
        }

        // ── Contacts by Status (pie) ───────────────────────────────────────
        $statusBreakdown = Contact::selectRaw('status, count(*) as cnt')
            ->groupBy('status')
            ->pluck('cnt', 'status')
            ->toArray();

        // ── Contacts by Country ───────────────────────────────────────────
        $contactsByCountry = Contact::selectRaw('country_code, count(*) as count')
            ->whereNotNull('country_code')
            ->groupBy('country_code')
            ->orderByDesc('count')
            ->limit(8)
            ->get();

        // ── Contacts by Source ────────────────────────────────────────────
        $contactsBySource = Contact::selectRaw('source, count(*) as cnt')
            ->groupBy('source')
            ->orderByDesc('cnt')
            ->limit(6)
            ->get();

        // ── Agent Performance ─────────────────────────────────────────────
        $agentPerformance = Admin::withCount([
            'assignedContacts as total_assigned',
            'assignedContacts as converted' => fn($q) => $q->where('status', Contact::STATUS_CONVERTED),
            'assignedContacts as in_progress' => fn($q) => $q->where('status', Contact::STATUS_IN_PROGRESS),
        ])
        ->where('role', Admin::ROLE_CALL_CENTER)
        ->where('active', true)
        ->orderByDesc('total_assigned')
        ->get();

        // ── Top Projects by Inquiries ─────────────────────────────────────
        $topProjects = Project::withCount('contacts')
            ->orderByDesc('contacts_count')
            ->limit(5)
            ->get();

        // ── Recent Contacts ───────────────────────────────────────────────
        $recentContacts = Contact::with(['project', 'assignedAdmin'])
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // ── Due Follow-ups ────────────────────────────────────────────────
        $dueFollowUps = Contact::with(['assignedAdmin'])
            ->dueFollowUp()
            ->orderBy('follow_up_at')
            ->limit(5)
            ->get();

        // ── Urgent Unhandled ──────────────────────────────────────────────
        $urgentContacts = Contact::with(['project'])
            ->where('priority', Contact::PRIORITY_URGENT)
            ->whereNotIn('status', [Contact::STATUS_CONVERTED, Contact::STATUS_CLOSED])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // ── Priority breakdown ────────────────────────────────────────────
        $priorityBreakdown = Contact::selectRaw('priority, count(*) as cnt')
            ->whereNotIn('status', [Contact::STATUS_CONVERTED, Contact::STATUS_CLOSED, Contact::STATUS_SPAM])
            ->groupBy('priority')
            ->pluck('cnt', 'priority')
            ->toArray();

        return view('admin.dashboard', compact(
            'crmStats', 'projectStats',
            'monthlyContacts', 'weeklyContacts',
            'statusBreakdown', 'priorityBreakdown',
            'contactsByCountry', 'contactsBySource',
            'agentPerformance', 'topProjects',
            'recentContacts', 'dueFollowUps', 'urgentContacts'
        ));
    }
}
