<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    private array $pages = ['home', 'about', 'contact', 'projects'];

    public function index()
    {
        return view('admin.pages.index', ['pages' => $this->pages]);
    }

    public function edit(string $page)
    {
        if (!in_array($page, $this->pages)) {
            abort(404);
        }

        $settings = Setting::where('key', 'like', "{$page}_%")->pluck('value', 'key');

        return view("admin.pages.edit", compact('page', 'settings'));
    }

    public function update(Request $request, string $page)
    {
        if (!in_array($page, $this->pages)) {
            abort(404);
        }

        foreach ($request->except(['_token', '_method']) as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->back()->with('success', 'تم تحديث الصفحة بنجاح');
    }
}
