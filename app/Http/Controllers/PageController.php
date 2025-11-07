<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
use App\Models\Category;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {
        return view('home');
    }

    /**
     * Display the quantum page.
     *
     * @param string|null $category
     * @return \Illuminate\View\View
     */
    public function quantum($category = null)
    {
        $selectedCategory = null;
        $contentItems = ContentItem::where('type', 'quantum')
            ->where('status', 'active');

        if ($category) {
            $selectedCategory = Category::where('slug', $category)
                ->where('is_active', true)
                ->firstOrFail();
            $contentItems->where('category_id', $selectedCategory->id);
        }

        $contentItems = $contentItems->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        $categories = Category::getByContentType('quantum');

        return view('quantum', compact('contentItems', 'categories', 'selectedCategory'));
    }

    /**
     * Display the services page.
     *
     * @param string|null $category
     * @return \Illuminate\View\View
     */
    public function services($category = null)
    {
        $selectedCategory = null;
        $contentItems = ContentItem::where('type', 'services')
            ->where('status', 'active');

        if ($category) {
            $selectedCategory = Category::where('slug', $category)
                ->where('is_active', true)
                ->firstOrFail();
            $contentItems->where('category_id', $selectedCategory->id);
        }

        $contentItems = $contentItems->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        $categories = Category::getByContentType('services');

        return view('services', compact('contentItems', 'categories', 'selectedCategory'));
    }

    /**
     * Display the products page.
     *
     * @param string|null $category
     * @return \Illuminate\View\View
     */
    public function products($category = null)
    {
        $selectedCategory = null;
        $contentItems = ContentItem::where('type', 'products')
            ->where('status', 'active');

        if ($category) {
            $selectedCategory = Category::where('slug', $category)
                ->where('is_active', true)
                ->firstOrFail();
            $contentItems->where('category_id', $selectedCategory->id);
        }

        $contentItems = $contentItems->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        $categories = Category::getByContentType('products');

        return view('products', compact('contentItems', 'categories', 'selectedCategory'));
    }

    /**
     * Display the training page.
     *
     * @param string|null $category
     * @return \Illuminate\View\View
     */
    public function training($category = null)
    {
        $selectedCategory = null;
        // Fetch all training courses from content items
        // Show all active trainings (include those with is_enrollable = true, null, or false)
        // This ensures existing trainings without the enrollable flag set will still show
        $trainingsQuery = ContentItem::where('type', 'training')
            ->where('status', 'active');

        if ($category) {
            $selectedCategory = Category::where('slug', $category)
                ->where('is_active', true)
                ->firstOrFail();
            $trainingsQuery->where('category_id', $selectedCategory->id);
        }

        $trainings = $trainingsQuery->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'description' => $item->description ?? $item->content,
                    'image' => $item->image_url ?? asset('images/training.jpeg'),
                    'link' => route('trainings.show', $item->slug),
                    'price' => $item->price,
                    'currency' => $item->currency ?? 'USD',
                    'start_date' => $item->start_date?->format('M d, Y'),
                    'duration_days' => $item->duration_days,
                    'category' => $item->category->title ?? null,
                ];
            })
            ->toArray();

        $categories = Category::getByContentType('training');

        return view('training', compact('trainings', 'categories', 'selectedCategory'));
    }

    /**
     * Display the blog page.
     */
    public function blog()
    {
        return view('blog');
    }

    /**
     * Display the contact page.
     */
    public function contact()
    {
        return view('contact');
    }
}

