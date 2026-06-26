<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Services\CountryContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $countryCode = $request->get('visitor_country', 'AE');
        $contact = CountryContactService::getContact($countryCode);

        return view('frontend.contact', [
            'countryCode' => $countryCode,
            'whatsapp'    => $contact['whatsapp'],
            'phone'       => $contact['phone'],
            'email'       => $contact['email'],
            'address'     => $contact['address'],
            'hasCustom'   => $contact['has_custom'],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255',
            'phone'   => 'required|string|max:50',
            'message' => 'required|string|max:2000',
        ]);

        Contact::create([
            'name'         => $validated['name'],
            'email'        => $validated['email'] ?? null,
            'phone'        => $validated['phone'],
            'message'      => $validated['message'],
            'country_code' => $request->get('visitor_country', 'AE'),
            'source'       => 'contact_form',
        ]);

        return back()->with('success', __('app.message_sent'));
    }
}
