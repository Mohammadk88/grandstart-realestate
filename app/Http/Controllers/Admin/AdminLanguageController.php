<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

class AdminLanguageController extends Controller
{
    public function index()
    {
        $languages = Language::orderBy('sort_order')->get();
        return view('admin.languages.index', compact('languages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'        => 'required|string|max:10|unique:languages,code',
            'name_en'     => 'required|string|max:100',
            'name_native' => 'required|string|max:100',
            'direction'   => 'required|in:ltr,rtl',
            'sort_order'  => 'integer|min:0',
        ]);

        $data['active']     = true;
        $data['is_default'] = false;

        Language::create($data);
        Language::clearCache();

        return back()->with('success', 'تم إضافة اللغة بنجاح');
    }

    public function update(Request $request, Language $language)
    {
        $data = $request->validate([
            'name_en'     => 'required|string|max:100',
            'name_native' => 'required|string|max:100',
            'direction'   => 'required|in:ltr,rtl',
            'sort_order'  => 'integer|min:0',
        ]);

        $language->update($data);
        Language::clearCache();

        return back()->with('success', 'تم تحديث اللغة');
    }

    public function destroy(Language $language)
    {
        if ($language->is_default) {
            return back()->with('error', 'لا يمكن حذف اللغة الافتراضية');
        }

        $language->delete();
        Language::clearCache();

        return back()->with('success', 'تم حذف اللغة');
    }

    public function toggleActive(Language $language)
    {
        if ($language->is_default && $language->active) {
            return back()->with('error', 'لا يمكن تعطيل اللغة الافتراضية');
        }

        $language->update(['active' => !$language->active]);
        Language::clearCache();

        return back()->with('success', 'تم تحديث حالة اللغة');
    }

    public function setDefault(Language $language)
    {
        $language->setAsDefault();
        return back()->with('success', 'تم تعيين اللغة الافتراضية');
    }
}
