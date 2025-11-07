<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $type)
    {
        $validTypes = ['quantum', 'services', 'products', 'training', 'blog'];
        
        if (!in_array($type, $validTypes)) {
            abort(404);
        }
        
        $items = ContentItem::where('type', $type)
            ->with('category')
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $categories = Category::where('is_active', true)->orderBy('order')->get();
        
        return view('admin.content.index', compact('items', 'type', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $type)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:content_items,slug',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'date' => 'nullable|date',
            'objective_list' => 'nullable|array',
            'objective_list.*' => 'string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive,waiting',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('content', 'public');
        }

        $validated['type'] = $type;
        
        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
            // Ensure uniqueness
            $baseSlug = $validated['slug'];
            $counter = 1;
            while (ContentItem::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $baseSlug . '-' . $counter;
                $counter++;
            }
        }
        
        // Handle objective list from textarea
        if ($request->has('objective_list_text')) {
            $objectives = array_filter(
                array_map('trim', explode("\n", $request->objective_list_text)),
                function($item) { return !empty($item); }
            );
            $validated['objective_list'] = $objectives;
        } else {
            $validated['objective_list'] = $request->objective_list ?? [];
        }

        ContentItem::create($validated);

        return redirect()->route('admin.content.index', $type)
            ->with('success', 'Content item created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $type, $id)
    {
        $item = ContentItem::where('type', $type)->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:content_items,slug,' . $id,
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'date' => 'nullable|date',
            'objective_list' => 'nullable|array',
            'objective_list.*' => 'string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive,waiting',
        ]);

        if ($request->hasFile('image')) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $validated['image'] = $request->file('image')->store('content', 'public');
        }

        // Generate slug if not provided and title changed
        if (empty($validated['slug']) && $item->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
            // Ensure uniqueness
            $baseSlug = $validated['slug'];
            $counter = 1;
            while (ContentItem::where('slug', $validated['slug'])->where('id', '!=', $id)->exists()) {
                $validated['slug'] = $baseSlug . '-' . $counter;
                $counter++;
            }
        }

        // Handle objective list from textarea
        if ($request->has('objective_list_text')) {
            $objectives = array_filter(
                array_map('trim', explode("\n", $request->objective_list_text)),
                function($item) { return !empty($item); }
            );
            $validated['objective_list'] = $objectives;
        } else {
            $validated['objective_list'] = $request->objective_list ?? [];
        }

        $item->update($validated);

        return redirect()->route('admin.content.index', $type)
            ->with('success', 'Content item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($type, $id)
    {
        $item = ContentItem::where('type', $type)->findOrFail($id);
        
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }
        
        $item->delete();

        return redirect()->route('admin.content.index', $type)
            ->with('success', 'Content item deleted successfully.');
    }
}
