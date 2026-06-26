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
        $slides   = HeroSlide::orderBy('sort_order')->get();
        $heroType = Setting::get('hero_type', 'static');
        return view('admin.hero.index', compact('slides', 'heroType'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image'      => 'required|image|mimes:jpeg,jpg,png,webp|max:10240',
            'title_ar'   => 'nullable|string|max:255',
            'title_en'   => 'nullable|string|max:255',
            'title_tr'   => 'nullable|string|max:255',
            'subtitle_ar'=> 'nullable|string|max:500',
            'subtitle_en'=> 'nullable|string|max:500',
            'subtitle_tr'=> 'nullable|string|max:500',
            'btn_label_ar'=> 'nullable|string|max:100',
            'btn_label_en'=> 'nullable|string|max:100',
            'btn_label_tr'=> 'nullable|string|max:100',
            'btn_url'    => 'nullable|string|max:255',
        ]);

        $imagePath = $this->uploadSlideImage($request->file('image'));

        HeroSlide::create([
            'image'       => $imagePath,
            'title_ar'    => $request->title_ar,
            'title_en'    => $request->title_en,
            'title_tr'    => $request->title_tr,
            'subtitle_ar' => $request->subtitle_ar,
            'subtitle_en' => $request->subtitle_en,
            'subtitle_tr' => $request->subtitle_tr,
            'btn_label_ar'=> $request->btn_label_ar,
            'btn_label_en'=> $request->btn_label_en,
            'btn_label_tr'=> $request->btn_label_tr,
            'btn_url'     => $request->btn_url,
            'sort_order'  => HeroSlide::count() + 1,
        ]);

        return back()->with('success', 'تم إضافة الشريحة بنجاح');
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $request->validate([
            'image'      => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'title_ar'   => 'nullable|string|max:255',
            'title_en'   => 'nullable|string|max:255',
            'title_tr'   => 'nullable|string|max:255',
            'subtitle_ar'=> 'nullable|string|max:500',
            'subtitle_en'=> 'nullable|string|max:500',
            'subtitle_tr'=> 'nullable|string|max:500',
            'btn_label_ar'=> 'nullable|string|max:100',
            'btn_label_en'=> 'nullable|string|max:100',
            'btn_label_tr'=> 'nullable|string|max:100',
            'btn_url'    => 'nullable|string|max:255',
            'active'     => 'boolean',
        ]);

        $data = $request->only([
            'title_ar','title_en','title_tr',
            'subtitle_ar','subtitle_en','subtitle_tr',
            'btn_label_ar','btn_label_en','btn_label_tr',
            'btn_url',
        ]);
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
