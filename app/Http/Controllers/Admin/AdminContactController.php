<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Contact;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    public function index(Request $request)
    {
        $currentAdmin = app('currentAdmin');
        $query = Contact::with(['project', 'assignedAdmin']);

        // Call center sees only their assigned contacts (or unassigned)
        if ($currentAdmin->role === Admin::ROLE_CALL_CENTER) {
            $query->where(function ($q) use ($currentAdmin) {
                $q->where('assigned_to', $currentAdmin->id)
                  ->orWhereNull('assigned_to');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } elseif (!$request->filled('status')) {
            // Default: hide spam
            $query->where('status', '!=', Contact::STATUS_SPAM);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('assigned')) {
            if ($request->assigned === 'unassigned') {
                $query->whereNull('assigned_to');
            } else {
                $query->where('assigned_to', $request->assigned);
            }
        }

        if ($request->filled('country')) {
            $query->where('country_code', $request->country);
        }

        if ($request->filled('follow_up')) {
            $query->dueFollowUp();
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $contacts    = $query->orderByRaw("FIELD(priority,'urgent','high','medium','low')")
                             ->orderBy('created_at', 'desc')
                             ->paginate(20)->withQueryString();

        $unreadCount = Contact::where('is_read', false)->count();
        $dueCount    = Contact::dueFollowUp()->count();
        $agents      = Admin::where('active', true)
                            ->whereIn('role', [Admin::ROLE_SUPER_ADMIN, Admin::ROLE_MANAGER, Admin::ROLE_CALL_CENTER])
                            ->orderBy('name')->get();

        $statusCounts = Contact::selectRaw('status, count(*) as cnt')
            ->where('status', '!=', Contact::STATUS_SPAM)
            ->groupBy('status')->pluck('cnt', 'status');

        return view('admin.contacts.index', compact(
            'contacts', 'unreadCount', 'dueCount', 'agents', 'statusCounts'
        ));
    }

    public function show(Contact $contact)
    {
        $contact->load(['project', 'assignedAdmin', 'lastActionAdmin']);

        if (!$contact->is_read) {
            $contact->update(['is_read' => true]);
        }

        $agents = Admin::where('active', true)
            ->whereIn('role', [Admin::ROLE_SUPER_ADMIN, Admin::ROLE_MANAGER, Admin::ROLE_CALL_CENTER])
            ->orderBy('name')->get();

        return view('admin.contacts.show', compact('contact', 'agents'));
    }

    public function markRead(Contact $contact)
    {
        $contact->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function updateCrm(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'status'      => 'required|in:' . implode(',', array_keys(Contact::STATUSES)),
            'priority'    => 'required|in:' . implode(',', array_keys(Contact::PRIORITIES)),
            'assigned_to' => 'nullable|exists:admins,id',
            'crm_notes'   => 'nullable|string|max:5000',
            'follow_up_at'=> 'nullable|date',
        ]);

        $admin = app('currentAdmin');
        $validated['last_action_at'] = now();
        $validated['last_action_by'] = $admin->id;
        $validated['is_read'] = true;

        $contact->update($validated);

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'تم تحديث بيانات العميل بنجاح');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'ids'    => 'required|array',
            'ids.*'  => 'exists:contacts,id',
            'action' => 'required|in:mark_read,assign,status,delete',
        ]);

        $admin   = app('currentAdmin');
        $query   = Contact::whereIn('id', $request->ids);
        $message = '';

        switch ($request->action) {
            case 'mark_read':
                $query->update(['is_read' => true]);
                $message = 'تم تحديد الرسائل كمقروءة';
                break;

            case 'assign':
                $request->validate(['assign_to' => 'required|exists:admins,id']);
                $query->update([
                    'assigned_to'    => $request->assign_to,
                    'last_action_at' => now(),
                    'last_action_by' => $admin->id,
                ]);
                $message = 'تم تعيين العملاء بنجاح';
                break;

            case 'status':
                $request->validate(['new_status' => 'required|in:' . implode(',', array_keys(Contact::STATUSES))]);
                $query->update([
                    'status'         => $request->new_status,
                    'last_action_at' => now(),
                    'last_action_by' => $admin->id,
                ]);
                $message = 'تم تحديث الحالة بنجاح';
                break;

            case 'delete':
                if (!$admin->hasPermission('contacts.delete')) {
                    return back()->with('error', 'ليس لديك صلاحية الحذف.');
                }
                $query->delete();
                $message = 'تم حذف السجلات المحددة';
                break;
        }

        return back()->with('success', $message);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')
            ->with('success', 'تم حذف الرسالة بنجاح');
    }
}
