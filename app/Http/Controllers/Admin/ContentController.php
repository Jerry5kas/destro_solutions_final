<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentItem;
use App\Models\Category;
use App\Models\Currency;
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
            ->with(['category', 'currencyModel'])
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $categories = Category::where('is_active', true)->orderBy('order')->get();
        $currencies = $type === 'training'
            ? Currency::orderByDesc('is_default')->orderBy('code')->get()
            : collect();
        
        return view('admin.content.index', compact('items', 'type', 'categories', 'currencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $type)
    {
        $baseRules = [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:content_items,slug',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'date' => 'nullable|date',
            'objective_list' => 'nullable|array',
            'objective_list.*' => 'string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive,waiting',
        ];

        if ($type === 'training') {
            $trainingRules = [
                'price' => 'nullable|numeric|min:0',
                'currency_code' => 'nullable|exists:currencies,code',
                'duration_days' => 'nullable|integer|min:0',
                'duration_hours' => 'nullable|integer|min:0',
                'session_count' => 'nullable|integer|min:0',
                'session_length_minutes' => 'nullable|integer|min:0',
                'max_students' => 'nullable|integer|min:0',
                'is_enrollable' => 'sometimes|boolean',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'enrollment_deadline' => 'nullable|date',
                'delivery_mode' => 'nullable|string|max:50',
                'level' => 'nullable|string|max:50',
                'language' => 'nullable|string|max:50',
                'prerequisites' => 'nullable|string',
                'instructor_name' => 'nullable|string|max:255',
                'instructor_bio' => 'nullable|string',
                'outcomes_text' => 'nullable|string',
                'materials_text' => 'nullable|string',
                'certification_available' => 'sometimes|boolean',
                'certification_details' => 'nullable|string',
            ];
        } else {
            $trainingRules = [
                'date' => 'nullable|date',
            ];
        }

        $validated = $request->validate(array_merge($baseRules, $trainingRules));

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

        if ($type === 'training') {
            $validated['is_enrollable'] = $request->boolean('is_enrollable');
            $validated['certification_available'] = $request->boolean('certification_available');
            $currencyCode = strtoupper($validated['currency_code'] ?? Currency::defaultCurrency()->code);
            $validated['currency_code'] = $currencyCode;
            $validated['currency'] = $currencyCode;
            $validated['outcomes'] = $request->filled('outcomes_text')
                ? array_values(array_filter(array_map('trim', explode("\n", $request->outcomes_text))))
                : [];
            $validated['materials_provided'] = $request->filled('materials_text')
                ? array_values(array_filter(array_map('trim', explode("\n", $request->materials_text))))
                : [];
            unset($validated['outcomes_text'], $validated['materials_text']);
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

        $baseRules = [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:content_items,slug,' . $id,
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'date' => 'nullable|date',
            'objective_list' => 'nullable|array',
            'objective_list.*' => 'string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive,waiting',
        ];

        if ($type === 'training') {
            $trainingRules = [
                'price' => 'nullable|numeric|min:0',
                'currency_code' => 'nullable|exists:currencies,code',
                'duration_days' => 'nullable|integer|min:0',
                'duration_hours' => 'nullable|integer|min:0',
                'session_count' => 'nullable|integer|min:0',
                'session_length_minutes' => 'nullable|integer|min:0',
                'max_students' => 'nullable|integer|min:0',
                'is_enrollable' => 'sometimes|boolean',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'enrollment_deadline' => 'nullable|date',
                'delivery_mode' => 'nullable|string|max:50',
                'level' => 'nullable|string|max:50',
                'language' => 'nullable|string|max:50',
                'prerequisites' => 'nullable|string',
                'instructor_name' => 'nullable|string|max:255',
                'instructor_bio' => 'nullable|string',
                'outcomes_text' => 'nullable|string',
                'materials_text' => 'nullable|string',
                'certification_available' => 'sometimes|boolean',
                'certification_details' => 'nullable|string',
            ];
        } else {
            $trainingRules = [
                'date' => 'nullable|date',
            ];
        }

        $validated = $request->validate(array_merge($baseRules, $trainingRules));

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

        if ($type === 'training') {
            $validated['is_enrollable'] = $request->boolean('is_enrollable');
            $validated['certification_available'] = $request->boolean('certification_available');
            $currencyCode = strtoupper($validated['currency_code'] ?? $item->currency_code ?? Currency::defaultCurrency()->code);
            $validated['currency_code'] = $currencyCode;
            $validated['currency'] = $currencyCode;
            $validated['outcomes'] = $request->filled('outcomes_text')
                ? array_values(array_filter(array_map('trim', explode("\n", $request->outcomes_text))))
                : [];
            $validated['materials_provided'] = $request->filled('materials_text')
                ? array_values(array_filter(array_map('trim', explode("\n", $request->materials_text))))
                : [];
            unset($validated['outcomes_text'], $validated['materials_text']);
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
