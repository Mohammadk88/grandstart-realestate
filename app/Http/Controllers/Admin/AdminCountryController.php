<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CountryContact;
use App\Models\CountryContactAddress;
use App\Models\Language;
use Illuminate\Http\Request;

class AdminCountryController extends Controller
{
    public function index()
    {
        $countries = CountryContact::with('addresses')->orderBy('is_default', 'desc')->orderBy('country_name_en')->get();
        $languages = Language::allActive();
        return view('admin.countries.index', compact('countries', 'languages'));
    }

    public function create()
    {
        $languages = Language::allActive();
        return view('admin.countries.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'country_code'    => 'nullable|string|max:10|unique:country_contacts,country_code',
            'country_name_ar' => 'required|string|max:100',
            'country_name_en' => 'required|string|max:100',
            'flag_emoji'      => 'nullable|string|max:10',
            'phone'           => 'nullable|string|max:50',
            'whatsapp'        => 'nullable|string|max:50',
            'email'           => 'nullable|email|max:150',
            'currency_code'   => 'required|string|max:10',
            'currency_symbol' => 'required|string|max:10',
            'price_field'     => 'required|in:price_usd,price_try,price_iqd',
        ]);

        $data['active']     = true;
        $data['is_default'] = false;

        $contact = CountryContact::create($data);

        if ($request->has('addresses')) {
            foreach ($request->input('addresses', []) as $locale => $address) {
                if (!empty(trim($address))) {
                    $contact->addresses()->create(['locale' => $locale, 'address' => $address]);
                }
            }
        }

        CountryContact::clearCache();

        return redirect()->route('admin.countries.index')->with('success', 'تم إضافة بيانات الدولة بنجاح');
    }

    public function edit(CountryContact $country)
    {
        $languages = Language::allActive();
        $country->load('addresses');
        return view('admin.countries.edit', compact('country', 'languages'));
    }

    public function update(Request $request, CountryContact $country)
    {
        $data = $request->validate([
            'country_code'    => 'nullable|string|max:10|unique:country_contacts,country_code,' . $country->id,
            'country_name_ar' => 'required|string|max:100',
            'country_name_en' => 'required|string|max:100',
            'flag_emoji'      => 'nullable|string|max:10',
            'phone'           => 'nullable|string|max:50',
            'whatsapp'        => 'nullable|string|max:50',
            'email'           => 'nullable|email|max:150',
            'currency_code'   => 'required|string|max:10',
            'currency_symbol' => 'required|string|max:10',
            'price_field'     => 'required|in:price_usd,price_try,price_iqd',
        ]);

        $country->update($data);

        if ($request->has('addresses')) {
            foreach ($request->input('addresses', []) as $locale => $address) {
                $country->addresses()->updateOrCreate(
                    ['locale' => $locale],
                    ['address' => $address]
                );
            }
        }

        CountryContact::clearCache($country->country_code);

        return redirect()->route('admin.countries.index')->with('success', 'تم تحديث بيانات الدولة');
    }

    public function destroy(CountryContact $country)
    {
        if ($country->is_default) {
            return back()->with('error', 'لا يمكن حذف الدولة الافتراضية');
        }

        $country->delete();
        CountryContact::clearCache();

        return back()->with('success', 'تم حذف الدولة');
    }

    public function setDefault(CountryContact $country)
    {
        $country->setAsDefault();
        return back()->with('success', 'تم تعيين الدولة الافتراضية');
    }

    public function toggleActive(CountryContact $country)
    {
        if ($country->is_default && $country->active) {
            return back()->with('error', 'لا يمكن تعطيل الدولة الافتراضية');
        }

        $country->update(['active' => !$country->active]);
        CountryContact::clearCache($country->country_code);

        return back()->with('success', 'تم تحديث حالة الدولة');
    }
}
