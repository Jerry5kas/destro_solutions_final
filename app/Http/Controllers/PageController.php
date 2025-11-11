<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\ContentItem;
use App\Models\Category;
use App\Models\Currency;
use App\Models\HeroSection;
use Illuminate\Support\Str;
use App\Support\Money;

class PageController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {
        $hero = $this->getHeroData();

        return view('home', [
            'hero' => $hero,
        ]);
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

        $banner = $this->getBannerData('quantum', [
            'title' => __('Quantum'),
            'description' => __('Securing chip-to-cloud in Quantum era.'),
            'image_url' => asset('images/quantum.jpeg'),
        ]);

        return view('quantum', compact('contentItems', 'categories', 'selectedCategory', 'banner'));
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

        $banner = $this->getBannerData('services', [
            'title' => __('Services'),
            'description' => __('Comprehensive security, safety, and SDV services for OEMs and Tier-1s.'),
            'image_url' => asset('images/service.png'),
        ]);

        return view('services', compact('contentItems', 'categories', 'selectedCategory', 'banner'));
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

        $banner = $this->getBannerData('products', [
            'title' => __('Products'),
            'description' => __('Explore our productized accelerators for SDV, cybersecurity, and OTA.'),
            'image_url' => asset('images/products.jpeg'),
        ]);

        return view('products', compact('contentItems', 'categories', 'selectedCategory', 'banner'));
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

        $currencies = Currency::orderByDesc('is_default')->get()->keyBy('code');
        $defaultCurrency = $currencies->firstWhere('is_default', true)
            ?? $currencies->first()
            ?? Currency::defaultCurrency();

        $trainings = $trainingsQuery->with(['category'])
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) use ($defaultCurrency, $currencies) {
                $currencyCode = $item->currency_code ?? $item->currency ?? $defaultCurrency->code;
                $currency = $currencies->get($currencyCode, $defaultCurrency);
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'description' => $item->description ?? $item->content,
                    'image' => $item->image_url ?? asset('images/training.jpeg'),
                    'slug' => $item->slug,
                    'link' => route('training.show', $item->slug),
                    'price' => $item->price,
                    'currency_code' => $currencyCode,
                    'currency_symbol' => $currency->symbol ?? $currencyCode,
                    'currency_decimals' => $currency->decimals ?? 2,
                    'formatted_price' => Money::format($item->price, $currencyCode),
                    'start_date' => $item->start_date?->format('M d, Y'),
                    'duration_days' => $item->duration_days,
                    'duration_hours' => $item->duration_hours,
                    'session_count' => $item->session_count,
                    'category' => $item->category->title ?? null,
                    'level' => $item->level,
                    'language' => $item->language,
                ];
            })
            ->toArray();

        $categories = Category::getByContentType('training');

        $banner = $this->getBannerData('training', [
            'title' => __('Training'),
            'description' => __('Hands-on trainings in cybersecurity, functional safety, and ASPICE.'),
            'image_url' => asset('images/training.jpeg'),
        ]);

        return view('training', compact('trainings', 'categories', 'selectedCategory', 'banner'));
    }

    /**
     * Display the blog page.
     */
    public function blog()
    {
        $blogs = ContentItem::with(['category:id,title'])
            ->where('type', 'blog')
            ->where('status', 'active')
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->get();

        $banner = $this->getBannerData('blog', [
            'title' => __('Blog'),
            'description' => __('Insights and updates on SDV, cybersecurity, and engineering excellence.'),
            'image_url' => asset('images/blog.jpeg'),
        ]);

        return view('blog', compact('blogs', 'banner'));
    }

    /**
     * Display an individual content item detail page.
     */
    public function contentItemShow(string $slug)
    {
        $contentItem = ContentItem::with('category')
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $bannerDescription = Str::limit(strip_tags($contentItem->description ?? ''), 200);

        $relatedItems = collect();

        $sameCategory = ContentItem::with('category')
            ->where('status', 'active')
            ->where('type', $contentItem->type)
            ->where('id', '!=', $contentItem->id)
            ->when($contentItem->category_id, function ($query) use ($contentItem) {
                $query->where('category_id', $contentItem->category_id);
            })
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        $relatedItems = $sameCategory;

        if ($relatedItems->count() < 4) {
            $additional = ContentItem::with('category')
                ->where('status', 'active')
                ->where('type', $contentItem->type)
                ->where('id', '!=', $contentItem->id)
                ->whereNotIn('id', $relatedItems->pluck('id'))
                ->orderByDesc('date')
                ->orderByDesc('created_at')
                ->take(8 - $relatedItems->count())
                ->get();

            $relatedItems = $relatedItems->concat($additional);
        }

        return view('content.show', [
            'contentItem' => $contentItem,
            'bannerDescription' => $bannerDescription,
            'relatedItems' => $relatedItems,
        ]);
    }

    /**
     * Display the contact page.
     */
    public function contact()
    {
        $banner = $this->getBannerData('contact', [
            'title' => __('Contact us'),
            'description' => __('Get in touch for consultations, partnerships, and opportunities.'),
            'image_url' => asset('images/contact.jpeg'),
        ]);

        return view('contact', compact('banner'));
    }

    protected function getHeroData(): array
    {
        $hero = HeroSection::firstWhere('type', 'home');

        $defaults = [
            'title' => __('Software Defined Vehicles'),
            'description' => __("Innovative Tomorrow's Mobility"),
            'image_url' => asset('images/main.png'),
            'video_url' => asset('video/default-video.mp4'),
            'cta_label' => __('Connect Us'),
            'cta_href' => '#contact',
        ];

        if (!$hero) {
            return $defaults;
        }

        return [
            'title' => $hero->title ?: $defaults['title'],
            'description' => $hero->description ?: $defaults['description'],
            'image_url' => $hero->image_url ?: $defaults['image_url'],
            'video_url' => $hero->video_url ?: $defaults['video_url'],
            'cta_label' => $defaults['cta_label'],
            'cta_href' => $defaults['cta_href'],
        ];
    }

    protected function getBannerData(string $type, array $defaults = []): array
    {
        $defaults = array_merge([
            'title' => '',
            'description' => null,
            'image_url' => asset('images/default.png'),
        ], $defaults);

        $banner = Banner::where('type', $type)->latest()->first();

        if ($banner) {
            $defaults['title'] = $banner->title ?: $defaults['title'];
            $defaults['description'] = $banner->description ?: $defaults['description'];
            $defaults['image_url'] = $banner->image_url ?: $defaults['image_url'];
        }

        $defaults['type'] = $type;

        return $defaults;
    }
}

