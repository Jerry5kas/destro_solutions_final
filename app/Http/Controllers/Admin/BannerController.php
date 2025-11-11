<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class BannerController extends Controller
{
    private const BANNER_TYPE_MAP = [
        'like' => 'like',
        'about' => 'about',
        'services' => 'services',
        'serviices' => 'services',
        'quantum' => 'quantum',
        'products' => 'products',
        'blog' => 'blog',
        'contact' => 'contact',
        'home' => 'home',
    ];

    private const HERO_TYPE = 'home';

    public function index()
    {
        $banners = Banner::orderBy('type')->orderByDesc('created_at')->get();
        $hero = HeroSection::firstWhere('type', self::HERO_TYPE);
        $bannerTypes = $this->bannerTypes();
        $bannerPayload = $banners->map(function (Banner $banner) {
            return [
                'id' => $banner->id,
                'type' => $banner->type,
                'title' => $banner->title,
                'description' => $banner->description,
                'image_url' => $banner->image_url,
            ];
        })->values();
        $heroPayload = $hero ? [
            'type' => $hero->type,
            'title' => $hero->title,
            'description' => $hero->description,
            'image_url' => $hero->image_url,
            'video_url' => $hero->video_url,
            'updated_at_for_humans' => optional($hero->updated_at)->diffForHumans(),
        ] : null;

        return view('admin.banners.index', compact('banners', 'hero', 'bannerTypes', 'bannerPayload', 'heroPayload'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateBanner($request);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('banners', 'public');
        }

        Banner::create($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner created successfully.');
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $this->validateBanner($request);

        if ($request->hasFile('image')) {
            $this->deleteFileIfExists($banner->image_path);
            $validated['image_path'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        $this->deleteFileIfExists($banner->image_path);
        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner deleted successfully.');
    }

    public function saveHero(Request $request)
    {
        $hero = HeroSection::firstWhere('type', self::HERO_TYPE);

        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
            'video' => 'nullable|mimetypes:video/mp4,video/webm,video/ogg|max:51200',
        ];

        $validated = $request->validate($rules);

        if (!$hero) {
            $hero = new HeroSection(['type' => self::HERO_TYPE]);
        }

        if ($request->hasFile('image')) {
            $this->deleteFileIfExists($hero->image_path);
            $validated['image_path'] = $request->file('image')->store('hero', 'public');
        }

        if ($request->hasFile('video')) {
            $this->deleteFileIfExists($hero->video_path);
            $validated['video_path'] = $request->file('video')->store('hero', 'public');
        }

        $hero->fill($validated);
        $hero->save();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Hero section saved successfully.');
    }

    private function validateBanner(Request $request): array
    {
        $rules = [
            'type' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
        ];

        $validated = $request->validate($rules);
        $normalizedType = $this->normalizeBannerType($validated['type']);

        if ($normalizedType === null) {
            throw ValidationException::withMessages([
                'type' => ['Invalid banner type selected.'],
            ]);
        }

        $validated['type'] = $normalizedType;

        return $validated;
    }

    private function normalizeBannerType(string $type): ?string
    {
        $normalized = strtolower(trim($type));

        return self::BANNER_TYPE_MAP[$normalized] ?? null;
    }

    private function bannerTypes(): array
    {
        $types = array_values(array_unique(array_filter(self::BANNER_TYPE_MAP)));

        sort($types);

        return array_map(function ($type) {
            return [
                'value' => $type,
                'label' => ucfirst($type),
            ];
        }, $types);
    }

    private function deleteFileIfExists(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}

