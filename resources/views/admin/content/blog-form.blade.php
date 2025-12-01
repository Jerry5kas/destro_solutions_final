@php
    $isEdit = isset($blog) && $blog !== null;
    $pageTitle = $isEdit ? 'Edit Blog Post' : 'Create Blog Post';
@endphp

<x-blog-editor-layout :title="$pageTitle . ' - Destrosolutions'">
    <div style="width: 100%; height: calc(100vh - 100px); display: flex; flex-direction: column;">
        @if(session('success'))
            <div style="padding: 1rem; background: #d1fae5; color: #065f46; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #a7f3d0;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="padding: 1rem; background: #fee2e2; color: #991b1b; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #fecaca;">
                <ul style="margin: 0; padding-left: 1.5rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form with Sidebar Layout -->
        <form action="{{ $isEdit ? route('admin.content.update', ['type' => 'blog', 'id' => $blog?->id]) : route('admin.content.store', 'blog') }}" method="POST" enctype="multipart/form-data" style="flex: 1; display: flex; background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); overflow: hidden; min-height: 0;">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <!-- Left Sidebar: Form Fields + Toolbar -->
            <div style="width: 380px; min-width: 380px; background: #fff; border-right: 1px solid #e5e7eb; display: flex; flex-direction: column;">
                <div style="flex: 1; overflow-y: auto;">
                    <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.25rem;">
                        <h2 style="font-size: 1.125rem; font-weight: 600; color: #111827;">Post Settings</h2>

                        <!-- Title -->
                        <div>
                            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">
                                Title <span style="color: #ef4444;">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="title" 
                                id="title" 
                                value="{{ old('title', $blog->title ?? '') }}" 
                                required 
                                style="width: 100%; padding: 0.625rem; border: 1px solid #e5e7eb; border-radius: 6px; font-family: 'Montserrat', sans-serif; font-size: 0.875rem; transition: border-color 0.2s;"
                                oninput="updateSlug()"
                            >
                        </div>

                        <!-- Category -->
                        <div>
                            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">
                                Category
                            </label>
                            <select 
                                name="category_id" 
                                id="category_id" 
                                style="width: 100%; padding: 0.625rem; border: 1px solid #e5e7eb; border-radius: 6px; font-family: 'Montserrat', sans-serif; font-size: 0.875rem; background: white;"
                            >
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $blog->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Banner Image -->
                        <div>
                            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">
                                Banner Image
                            </label>
                            <input 
                                type="file" 
                                name="image" 
                                id="image" 
                                accept="image/*" 
                                style="width: 100%; padding: 0.625rem; border: 1px solid #e5e7eb; border-radius: 6px; font-family: 'Montserrat', sans-serif; font-size: 0.875rem;"
                                onchange="previewImage(this)"
                            >
                            @if($isEdit && $blog && $blog->image_url)
                                <div id="imagePreview" style="margin-top: 0.75rem;">
                                    <img src="{{ $blog->image_url }}" alt="Current banner image" style="max-width: 100%; border-radius: 6px; border: 1px solid #e5e7eb;">
                                    <p style="color: #6b7280; font-size: 0.75rem; margin-top: 0.5rem;">Current banner image</p>
                                </div>
                            @else
                                <div id="imagePreview" style="margin-top: 0.75rem;"></div>
                            @endif
                        </div>

                        <!-- Slug -->
                        <div>
                            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">
                                Slug
                            </label>
                            <input 
                                type="text" 
                                name="slug" 
                                id="slug" 
                                value="{{ old('slug', $blog->slug ?? '') }}" 
                                readonly
                                style="width: 100%; padding: 0.625rem; border: 1px solid #e5e7eb; border-radius: 6px; font-family: 'Montserrat', sans-serif; font-size: 0.875rem; background-color: #f3f4f6; color: #111827;"
                            >
                            <small style="color: #6b7280; font-size: 0.75rem; margin-top: 0.25rem; display: block;">
                                Auto-generated clean slug for SEO-friendly URLs
                            </small>
                        </div>
                    </div>

                    <!-- Toolbar -->
                    <div style="padding: 0 1.5rem 1.5rem;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                            <h3 style="font-size: 0.9375rem; font-weight: 600; color: #111827; margin: 0;">Tools & Blocks</h3>
                            <span style="font-size: 0.75rem; color: #6b7280;">Design every section</span>
                        </div>
                        <div style="border: 1px solid #e5e7eb; border-radius: 10px; padding: 0.25rem;">
                            <x-blog-editor-toolbar :editorId="'blog-editor-full'" />
                        </div>
                    </div>

                    <!-- Remaining fields -->
                    <div style="padding: 0 1.5rem 1.5rem; display: flex; flex-direction: column; gap: 1.25rem;">
                        <!-- Short Description -->
                        <div>
                            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">
                                Short Description
                            </label>
                            <textarea 
                                name="description" 
                                id="description" 
                                rows="3" 
                                placeholder="Brief description for blog listing page"
                                style="width: 100%; padding: 0.625rem; border: 1px solid #e5e7eb; border-radius: 6px; font-family: 'Montserrat', sans-serif; font-size: 0.875rem; resize: vertical;"
                            >{{ old('description', $blog->description ?? '') }}</textarea>
                        </div>

                        <!-- Date -->
                        <div>
                            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">
                                Date
                            </label>
                            <input 
                                type="date" 
                                name="date" 
                                id="date" 
                                value="{{ old('date', $blog && $blog->date ? $blog->date->format('Y-m-d') : '') }}" 
                                style="width: 100%; padding: 0.625rem; border: 1px solid #e5e7eb; border-radius: 6px; font-family: 'Montserrat', sans-serif; font-size: 0.875rem;"
                            >
                        </div>

                        <!-- Status -->
                        <div>
                            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">
                                Status <span style="color: #ef4444;">*</span>
                            </label>
                            <select 
                                name="status" 
                                id="status" 
                                required
                                style="width: 100%; padding: 0.625rem; border: 1px solid #e5e7eb; border-radius: 6px; font-family: 'Montserrat', sans-serif; font-size: 0.875rem; background: white;"
                            >
                                <option value="active" {{ old('status', $blog->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="waiting" {{ old('status', $blog->status ?? '') === 'waiting' ? 'selected' : '' }}>Waiting for Reassignment</option>
                                <option value="inactive" {{ old('status', $blog->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div style="padding: 1rem; border-top: 1px solid #e5e7eb; background: #f9fafb; display: flex; gap: 0.75rem;">
                    <a 
                        href="{{ route('admin.content.index', 'blog') }}" 
                        style="flex: 1; padding: 0.625rem; background: #f3f4f6; color: #374151; border: none; border-radius: 6px; font-weight: 500; cursor: pointer; text-decoration: none; font-family: 'Montserrat', sans-serif; text-align: center; transition: all 0.2s ease; font-size: 0.875rem;"
                    >
                        Cancel
                    </a>
                    <button 
                        type="submit" 
                        style="flex: 1; padding: 0.625rem; background: #0D0DE0; color: white; border: none; border-radius: 6px; font-weight: 500; cursor: pointer; font-family: 'Montserrat', sans-serif; transition: all 0.2s ease; font-size: 0.875rem;"
                    >
                        {{ $isEdit ? 'Update' : 'Create' }}
                    </button>
                </div>
            </div>

            <!-- Right Side: Content Editor + Preview -->
            <div style="flex: 1; display: flex; flex-direction: column; min-width: 0; overflow: hidden;">
                <x-blog-editor 
                    name="editor_content" 
                    id="blog-editor-full" 
                    :value="old('editor_content', $blog->editor_content ?? null)"
                    :hideToolbar="true"
                    :banner="$blog->image_url ?? null"
                    titleFieldId="title"
                    categoryFieldId="category_id"
                    dateFieldId="date"
                    mode="single"
                />
            </div>
        </form>
    </div>

    @push('styles')
    <style>
        /* Override blog editor layout for form integration */
        #blog-editor-full {
            height: 100%;
            border: none;
            border-radius: 0;
            background: transparent;
            display: flex;
            flex-direction: column;
        }

        #blog-editor-full .blog-editor-layout {
            height: 100%;
            border: none;
            flex: 1;
            min-height: 0;
        }

        #blog-editor-full .blog-editor-main {
            width: 100%;
            height: 100%;
            flex: 1;
            min-height: 0;
        }

        /* Sidebar toolbar styling */
        #blog-editor-full-toolbar {
            border: none;
            border-radius: 0;
            background: transparent;
        }

        #blog-editor-full-toolbar .toolbar-header {
            padding: 1rem 1rem 0.75rem;
            background: transparent;
            border-bottom: 1px solid #e5e7eb;
        }

        #blog-editor-full-toolbar .toolbar-content {
            padding: 0.75rem;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        const ACTIVE_EDITOR_ID = 'blog-editor-full';

        // Auto-generate slug from title
        function updateSlug() {
            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');
            
            if (!slugInput || !titleInput) return;

            const title = titleInput.value || '';
            slugInput.value = title
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '') // Remove special characters
                .replace(/[\s_-]+/g, '-') // Replace spaces, underscores, multiple dashes with single dash
                .replace(/^-+|-+$/g, ''); // Remove leading/trailing dashes
        }
        document.addEventListener('DOMContentLoaded', updateSlug);

        // Image preview
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <img src="${e.target.result}" alt="Preview" style="max-width: 100%; border-radius: 6px; border: 1px solid #e5e7eb;">
                        <p style="color: #6b7280; font-size: 0.75rem; margin-top: 0.5rem;">New banner image preview</p>
                    `;

                    document.dispatchEvent(new CustomEvent('blog-banner-updated', {
                        detail: {
                            url: e.target.result,
                            editorId: ACTIVE_EDITOR_ID
                        }
                    }));
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Initialize editor content if editing
        @if($isEdit && $blog && $blog->editor_content)
            document.addEventListener('DOMContentLoaded', function() {
                const editorContent = @json($blog->editor_content);
                if (typeof window['updateBlogEditor_blog-editor-full'] === 'function') {
                    window['updateBlogEditor_blog-editor-full'](editorContent);
                }
            });
        @endif
    </script>
    @endpush
</x-blog-editor-layout>
