<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;

class SitemapController extends Controller
{
    public function index()
    {
        $projects = Project::active()
            ->with('translations')
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->view('frontend.sitemap', compact('projects'))
            ->header('Content-Type', 'application/xml');
    }
}
