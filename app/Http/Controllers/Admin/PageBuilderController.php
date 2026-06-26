<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSection;
use Illuminate\Http\Request;

class PageBuilderController extends Controller
{
    public function index()
    {
        PageSection::seedDefaults();
        $sections = PageSection::where('page', 'home')->orderBy('sort_order')->get();
        return view('admin.page-builder.index', compact('sections'));
    }

    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array']);
        foreach ($request->order as $i => $id) {
            PageSection::where('id', $id)->update(['sort_order' => $i + 1]);
        }
        return response()->json(['success' => true]);
    }

    public function toggle(PageSection $pageSection)
    {
        $pageSection->update(['active' => !$pageSection->active]);
        return response()->json(['success' => true, 'active' => $pageSection->active]);
    }
}
