<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoMetadata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = ['home', 'about', 'contact', 'quantum', 'services', 'training', 'blog'];
        $seoData = [];
        
        foreach ($pages as $page) {
            $seoData[$page] = SeoMetadata::firstOrCreate(['page' => $page]);
        }
        
        return view('admin.seo.index', compact('seoData', 'pages'));
    }

    /**
     * Update SEO metadata for a page.
     */
    public function update(Request $request, $page)
    {
        $validPages = ['home', 'about', 'contact', 'quantum', 'services', 'training', 'blog'];
        
        if (!in_array($page, $validPages)) {
            abort(404);
        }

        $validated = $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|image|max:2048',
        ]);

        $seo = SeoMetadata::firstOrCreate(['page' => $page]);

        if ($request->hasFile('og_image')) {
            if ($seo->og_image) {
                Storage::disk('public')->delete($seo->og_image);
            }
            $validated['og_image'] = $request->file('og_image')->store('seo', 'public');
        }

        $seo->update($validated);

        return redirect()->route('admin.seo.index')
            ->with('success', 'SEO metadata updated successfully.');
    }
}
