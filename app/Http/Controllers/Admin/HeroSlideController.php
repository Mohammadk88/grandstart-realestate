<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class HeroSlideController extends Controller
{
    public function index()
    {
        $slides    = HeroSlide::orderBy('sort_order')->get();
        $heroType  = Setting::get('hero_type', 'static');
        $languages = \App\Models\Language::allActive();
        return view('admin.hero.index', compact('slides', 'heroType', 'languages'));
    }

    public function store(Request $request)
    {
        $languages = \App\Models\Language::allActive();
        $rules = ['image' => 'required|image|mimes:jpeg,jpg,png,webp|max:10240', 'btn_url' => 'nullable|string|max:255'];
        foreach ($languages as $lang) {
            $rules["title_{$lang->code}"]     = 'nullable|string|max:255';
            $rules["subtitle_{$lang->code}"]  = 'nullable|string|max:500';
            $rules["btn_label_{$lang->code}"] = 'nullable|string|max:100';
        }
        $request->validate($rules);

        $imagePath = $this->uploadSlideImage($request->file('image'));

        $data = ['image' => $imagePath, 'btn_url' => $request->btn_url, 'sort_order' => HeroSlide::count() + 1];
        foreach ($languages as $lang) {
            $data["title_{$lang->code}"]     = $request->input("title_{$lang->code}");
            $data["subtitle_{$lang->code}"]  = $request->input("subtitle_{$lang->code}");
            $data["btn_label_{$lang->code}"] = $request->input("btn_label_{$lang->code}");
        }

        HeroSlide::create($data);
        return back()->with('success', 'تم إضافة الشريحة بنجاح');
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $languages = \App\Models\Language::allActive();
        $rules = ['image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240', 'btn_url' => 'nullable|string|max:255', 'active' => 'boolean'];
        foreach ($languages as $lang) {
            $rules["title_{$lang->code}"]     = 'nullable|string|max:255';
            $rules["subtitle_{$lang->code}"]  = 'nullable|string|max:500';
            $rules["btn_label_{$lang->code}"] = 'nullable|string|max:100';
        }
        $request->validate($rules);

        $data = ['btn_url' => $request->btn_url];
        foreach ($languages as $lang) {
            $data["title_{$lang->code}"]     = $request->input("title_{$lang->code}");
            $data["subtitle_{$lang->code}"]  = $request->input("subtitle_{$lang->code}");
            $data["btn_label_{$lang->code}"] = $request->input("btn_label_{$lang->code}");
        }
        $data['active'] = $request->boolean('active');

        if ($request->hasFile('image')) {
            Storage::delete('public/' . $heroSlide->image);
            $data['image'] = $this->uploadSlideImage($request->file('image'));
        }

        $heroSlide->update($data);
        return back()->with('success', 'تم تحديث الشريحة');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        Storage::delete('public/' . $heroSlide->image);
        $heroSlide->delete();
        return back()->with('success', 'تم حذف الشريحة');
    }

    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array']);
        foreach ($request->order as $i => $id) {
            HeroSlide::where('id', $id)->update(['sort_order' => $i + 1]);
        }
        return response()->json(['success' => true]);
    }

    public function setType(Request $request)
    {
        $request->validate(['type' => 'required|in:static,slider']);
        Setting::set('hero_type', $request->type);
        return back()->with('success', 'تم تحديث نوع البانر');
    }

    private function uploadSlideImage($file): string
    {
        $basename  = Str::random(20);
        $ext       = strtolower($file->getClientOriginalExtension());
        $filename  = $basename . '.' . $ext;
        $folder    = 'hero';
        $storagePath = storage_path("app/public/{$folder}");

        if (!is_dir($storagePath)) mkdir($storagePath, 0775, true);

        $manager = new ImageManager(new Driver());
        $manager->read($file->getRealPath())
            ->cover(1920, 900)
            ->save("{$storagePath}/{$filename}");

        return "{$folder}/{$filename}";
    }
}
