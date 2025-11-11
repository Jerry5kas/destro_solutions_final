@php
    $typeOptions = collect($bannerTypes)->mapWithKeys(fn ($type) => [$type['value'] => $type['label']])->toArray();
    $heroTitle = $hero->title ?? '';
    $heroDescription = $hero->description ?? '';
@endphp

<x-admin-layout title="Banner Management - Destrosolutions">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 class="page-title">Banner Management</h1>
        <button onclick="openBannerModal()" style="padding: 0.75rem 1.5rem; background: #0D0DE0; color: white; border: none; border-radius: 10px; font-weight: 500; cursor: pointer; font-family: 'Montserrat', sans-serif; transition: all 0.2s ease;">
            + Add New Banner
        </button>
    </div>

    @if(session('success'))
        <div style="padding: 1rem; background: #d1fae5; color: #065f46; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #a7f3d0;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="padding: 1rem; background: #fee2e2; color: #991b1b; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #fecaca;">
            <strong>There were some problems with your submission:</strong>
            <ul style="margin-top: 0.5rem; padding-left: 1.5rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="dashboard-card hero-section-card" style="margin-bottom: 3rem;">
        <div class="hero-card-header">
            <div>
                <h2 class="hero-card-title">Hero Section</h2>
                <p class="hero-card-subtitle">Manage the main hero content displayed on the home page.</p>
            </div>
            <button type="button" onclick="openHeroModal()" class="hero-edit-button">
                {{ $hero ? 'Edit Hero' : 'Create Hero' }}
            </button>
        </div>

        <div class="hero-data-grid">
            <div class="hero-data-grid-header">
                <div>Type</div>
                <div>Title</div>
                <div>Description</div>
                <div>Image</div>
                <div>Video</div>
                <div>Last Updated</div>
            </div>

            @if($hero)
                <div class="hero-data-grid-row">
                    <div class="hero-data-grid-cell">{{ ucfirst($hero->type ?? 'home') }}</div>
                    <div class="hero-data-grid-cell hero-data-ellipsis">{{ $hero->title ?? '—' }}</div>
                    <div class="hero-data-grid-cell hero-data-ellipsis">{{ \Illuminate\Support\Str::limit($hero->description ?? '—', 160) }}</div>
                    <div class="hero-data-grid-cell hero-media-cell">
                        @if($hero->image_url)
                            <img src="{{ $hero->image_url }}" alt="Hero image" class="hero-media-thumb">
                        @else
                            <span class="hero-placeholder">—</span>
                        @endif
                    </div>
                    <div class="hero-data-grid-cell hero-media-cell">
                        @if($hero->video_url)
                            <video src="{{ $hero->video_url }}" class="hero-media-thumb" muted loop playsinline></video>
                        @else
                            <span class="hero-placeholder">—</span>
                        @endif
                    </div>
                    <div class="hero-data-grid-cell">{{ $hero->updated_at?->diffForHumans() ?? '—' }}</div>
                </div>
            @else
                <div class="hero-data-grid-empty">
                    <p>No hero content configured yet. Click "{{ $hero ? 'Edit Hero' : 'Create Hero' }}" to get started.</p>
                </div>
            @endif
        </div>
    </div>

    <div class="dashboard-card" style="padding: 0; overflow: hidden;">
        <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
            <div style="display: grid; grid-template-columns: 40px 1fr 1fr 2fr 140px; gap: 1.25rem; align-items: center;">
                <div></div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem;">Type</div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem;">Title</div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem;">Description</div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem; text-align: right;">Actions</div>
            </div>
        </div>

        <div>
            @forelse($banners as $banner)
                <div class="content-row" style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #f3f4f6; display: grid; grid-template-columns: 40px 1fr 1fr 2fr 140px; gap: 1.25rem; align-items: center; transition: background 0.2s ease;">
                    <div style="width: 48px; height: 48px; border-radius: 12px; overflow: hidden; background: #f3f4f6; display: flex; align-items: center; justify-content: center;">
                        @if($banner->image_url)
                            <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <span style="font-weight: 600; color: #0D0DE0;">{{ strtoupper(substr($banner->title, 0, 1)) }}</span>
                        @endif
                    </div>

                    <div style="font-weight: 500; color: #111827; text-transform: capitalize;">
                        {{ $banner->type }}
                    </div>

                    <div style="min-width: 0;">
                        <div style="font-weight: 500; color: #111827; margin-bottom: 0.25rem; font-size: 0.9375rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $banner->title }}
                        </div>
                        <div style="font-size: 0.8125rem; color: #6b7280;">Updated {{ $banner->updated_at->diffForHumans() }}</div>
                    </div>

                    <div style="font-size: 0.875rem; color: #4b5563; line-height: 1.5; max-height: 3.6em; overflow: hidden;">
                        {{ \Illuminate\Support\Str::limit($banner->description ?? '—', 140) }}
                    </div>

                    <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                        <button onclick="openBannerModal({{ $banner->id }})" style="padding: 0.5rem 0.75rem; background: #f3f4f6; color: #0D0DE0; border: none; border-radius: 8px; font-weight: 500; cursor: pointer;">
                            Edit
                        </button>
                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this banner?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="padding: 0.5rem 0.75rem; background: #fee2e2; color: #b91c1c; border: none; border-radius: 8px; font-weight: 500; cursor: pointer;">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="padding: 3rem; text-align: center; color: #6b7280;">
                    <p>No banners found. Click "Add New Banner" to create one.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Hero Modal -->
    <div id="heroModal" class="modal-backdrop" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-header">
                <h2 id="heroModalTitle">Update Hero Section</h2>
                <button type="button" onclick="closeHeroModal()" class="modal-close-btn">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="heroForm" action="{{ route('admin.hero.save') }}" method="POST" enctype="multipart/form-data" class="modal-form">
                @csrf
                <div class="modal-field">
                    <label class="admin-label">Title *</label>
                    <input type="text" name="title" id="heroTitle" required class="admin-input">
                </div>

                <div class="modal-field">
                    <label class="admin-label">Description</label>
                    <textarea name="description" id="heroDescription" rows="4" class="admin-input" style="resize: vertical;"></textarea>
                </div>

                <div class="modal-field">
                    <label class="admin-label">Image</label>
                    <input type="file" name="image" id="heroImage" accept="image/*" class="admin-input">
                    <div id="heroImagePreview" class="modal-preview"></div>
                </div>

                <div class="modal-field">
                    <label class="admin-label">Video (mp4/webm/ogg)</label>
                    <input type="file" name="video" id="heroVideo" accept="video/mp4,video/webm,video/ogg" class="admin-input">
                    <div id="heroVideoPreview" class="modal-preview"></div>
                </div>

                <div class="modal-actions">
                    <button type="button" onclick="closeHeroModal()" class="modal-cancel-btn">Cancel</button>
                    <button type="submit" class="modal-save-btn">Save Hero</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <div id="bannerModal" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); z-index: 10000; align-items: center; justify-content: center; padding: 1rem;">
        <div style="background: white; border-radius: 16px; max-width: 540px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);">
            <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827;" id="bannerModalTitle">Add New Banner</h2>
                <button onclick="closeBannerModal()" style="padding: 0.5rem; background: transparent; border: none; color: #6b7280; cursor: pointer; border-radius: 6px;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="bannerForm" method="POST" enctype="multipart/form-data" style="padding: 1.5rem;">
                @csrf
                <div id="bannerFormMethod"></div>

                <div style="margin-bottom: 1.5rem;">
                    <label class="admin-label">Type *</label>
                    <select name="type" id="bannerType" required class="admin-input">
                        @foreach($typeOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label class="admin-label">Title *</label>
                    <input type="text" name="title" id="bannerTitle" required class="admin-input">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label class="admin-label">Description</label>
                    <textarea name="description" id="bannerDescription" rows="4" class="admin-input" style="resize: vertical;"></textarea>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label class="admin-label">Image</label>
                    <input type="file" name="image" id="bannerImage" accept="image/*" class="admin-input">
                    <div id="bannerImagePreview" style="margin-top: 0.75rem;"></div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                    <button type="button" onclick="closeBannerModal()" style="padding: 0.75rem 1.5rem; background: #f3f4f6; color: #374151; border: none; border-radius: 8px; font-weight: 500; cursor: pointer;">
                        Cancel
                    </button>
                    <button type="submit" style="padding: 0.75rem 1.5rem; background: #0D0DE0; color: white; border: none; border-radius: 8px; font-weight: 500; cursor: pointer;">
                        Save Banner
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
    <style>
        .content-row:hover {
            background: #f9fafb;
        }

        .admin-label {
            display: block;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .admin-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.9375rem;
            background: white;
        }

        .hero-section-card {
            padding: 0;
        }

        .hero-card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            gap: 1rem;
        }

        .hero-card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.25rem;
        }

        .hero-card-subtitle {
            font-size: 0.875rem;
            color: #6b7280;
            margin: 0;
        }

        .hero-edit-button {
            padding: 0.75rem 1.5rem;
            background: #0D0DE0;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            font-family: 'Montserrat', sans-serif;
        }

        .hero-data-grid {
            display: grid;
            gap: 1px;
            background: #e5e7eb;
            border-bottom-left-radius: 14px;
            border-bottom-right-radius: 14px;
            overflow: hidden;
        }

        .hero-data-grid-header,
        .hero-data-grid-row {
            display: grid;
            grid-template-columns: 0.6fr 1.1fr 1.6fr 1fr 1fr 0.8fr;
        }

        .hero-data-grid-header > div {
            background: #f9fafb;
            padding: 1rem 1.25rem;
            font-weight: 600;
            font-size: 0.875rem;
            color: #374151;
        }

        .hero-data-grid-row {
            background: white;
        }

        .hero-data-grid-cell {
            padding: 1.25rem;
            font-size: 0.9rem;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .hero-data-grid-cell.hero-data-ellipsis {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .hero-data-grid-cell.hero-media-cell {
            justify-content: center;
        }

        .hero-media-thumb {
            max-width: 140px;
            max-height: 90px;
            border-radius: 10px;
            object-fit: cover;
            box-shadow: 0 8px 16px rgba(15, 23, 42, 0.1);
        }

        .hero-placeholder {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            color: #9ca3af;
        }

        .hero-data-grid-empty {
            background: white;
            padding: 2.5rem;
            text-align: center;
            font-size: 0.95rem;
            color: #6b7280;
        }

        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 10000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal-dialog {
            background: white;
            border-radius: 16px;
            max-width: 560px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .modal-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #111827;
            margin: 0;
        }

        .modal-close-btn {
            padding: 0.5rem;
            background: transparent;
            border: none;
            color: #6b7280;
            cursor: pointer;
            border-radius: 6px;
        }

        .modal-form {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .modal-field {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .modal-preview img,
        .modal-preview video {
            max-width: 220px;
            border-radius: 12px;
            margin-top: 0.5rem;
            box-shadow: 0 8px 16px rgba(15, 23, 42, 0.15);
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1rem;
        }

        .modal-cancel-btn,
        .modal-save-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            font-family: 'Montserrat', sans-serif;
        }

        .modal-cancel-btn {
            background: #f3f4f6;
            color: #374151;
        }

        .modal-save-btn {
            background: #0D0DE0;
            color: white;
        }

        @media (max-width: 1024px) {
            .hero-data-grid-header,
            .hero-data-grid-row {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .hero-data-grid-header > div:nth-child(n+4),
            .hero-data-grid-row > div:nth-child(n+4) {
                border-top: 1px solid #f3f4f6;
            }
        }

        @media (max-width: 640px) {
            .hero-card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .hero-edit-button {
                width: 100%;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        const heroData = @json($heroPayload);

        const heroModal = document.getElementById('heroModal');
        const heroModalTitle = document.getElementById('heroModalTitle');
        const heroForm = document.getElementById('heroForm');
        const heroTitleInput = document.getElementById('heroTitle');
        const heroDescriptionInput = document.getElementById('heroDescription');
        const heroImageInput = document.getElementById('heroImage');
        const heroVideoInput = document.getElementById('heroVideo');
        const heroImagePreview = document.getElementById('heroImagePreview');
        const heroVideoPreview = document.getElementById('heroVideoPreview');

        const bannerModal = document.getElementById('bannerModal');
        const bannerForm = document.getElementById('bannerForm');
        const bannerFormMethod = document.getElementById('bannerFormMethod');
        const bannerModalTitle = document.getElementById('bannerModalTitle');
        const bannerType = document.getElementById('bannerType');
        const bannerTitle = document.getElementById('bannerTitle');
        const bannerDescription = document.getElementById('bannerDescription');
        const bannerImage = document.getElementById('bannerImage');
        const bannerImagePreview = document.getElementById('bannerImagePreview');
        const banners = @json($bannerPayload);

        function openHeroModal() {
            heroForm.reset();
            heroModalTitle.textContent = heroData ? 'Edit Hero Section' : 'Create Hero Section';
            heroTitleInput.value = heroData?.title ?? '';
            heroDescriptionInput.value = heroData?.description ?? '';

            heroImagePreview.innerHTML = heroData?.image_url
                ? `<img src="${heroData.image_url}" alt="Hero image preview">`
                : '';
            heroVideoPreview.innerHTML = heroData?.video_url
                ? `<video src="${heroData.video_url}" controls></video>`
                : '';

            heroModal.style.display = 'flex';
        }

        function closeHeroModal() {
            heroModal.style.display = 'none';
        }

        function resetBannerForm() {
            bannerForm.reset();
            bannerFormMethod.innerHTML = '';
            bannerImagePreview.innerHTML = '';
        }

        function openBannerModal(id = null) {
            resetBannerForm();

            if (id) {
                const banner = banners.find(item => item.id === id);
                if (!banner) {
                    return;
                }
                bannerModalTitle.textContent = 'Edit Banner';
                bannerForm.action = '{{ route("admin.banners.update", ":id") }}'.replace(':id', id);
                bannerFormMethod.innerHTML = '@method("PUT")';
                bannerType.value = banner.type;
                bannerTitle.value = banner.title || '';
                bannerDescription.value = banner.description || '';
                if (banner.image_url) {
                    bannerImagePreview.innerHTML = `<img src="${banner.image_url}" alt="Banner image" style="max-width: 200px; border-radius: 10px;">`;
                }
            } else {
                bannerModalTitle.textContent = 'Add New Banner';
                bannerForm.action = '{{ route("admin.banners.store") }}';
            }

            bannerModal.style.display = 'flex';
        }

        function closeBannerModal() {
            bannerModal.style.display = 'none';
        }

        bannerModal.addEventListener('click', function (event) {
            if (event.target === bannerModal) {
                closeBannerModal();
            }
        });

        bannerImage.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (!file) {
                bannerImagePreview.innerHTML = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function (e) {
                bannerImagePreview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width: 200px; border-radius: 10px;">`;
            };
            reader.readAsDataURL(file);
        });

        heroModal.addEventListener('click', function (event) {
            if (event.target === heroModal) {
                closeHeroModal();
            }
        });

        heroImageInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (!file) {
                heroImagePreview.innerHTML = heroData?.image_url
                    ? `<img src="${heroData.image_url}" alt="Hero image preview">`
                    : '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function (e) {
                heroImagePreview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            };
            reader.readAsDataURL(file);
        });

        heroVideoInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (!file) {
                heroVideoPreview.innerHTML = heroData?.video_url
                    ? `<video src="${heroData.video_url}" controls></video>`
                    : '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function (e) {
                heroVideoPreview.innerHTML = `<video src="${e.target.result}" controls></video>`;
            };
            reader.readAsDataURL(file);
        });
    </script>
    @endpush
</x-admin-layout>

