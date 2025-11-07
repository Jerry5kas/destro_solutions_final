<x-admin-layout title="SEO Management - Destrosolutions">
    <h1 class="page-title">SEO Management</h1>
    
    @if(session('success'))
        <div style="padding: 1rem; background: #d1fae5; color: #065f46; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #a7f3d0;">
            {{ session('success') }}
        </div>
    @endif
    
    <div style="display: grid; gap: 1.5rem;">
        @foreach($pages as $page)
            @php
                $seo = $seoData[$page] ?? null;
                $pageLabels = [
                    'home' => 'Home',
                    'about' => 'About',
                    'contact' => 'Contact',
                    'quantum' => 'Quantum',
                    'services' => 'Services',
                    'training' => 'Training',
                    'blog' => 'Blog',
                ];
                $pageLabel = $pageLabels[$page] ?? ucfirst($page);
            @endphp
            
            <div class="dashboard-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h2 style="font-size: 1.25rem; font-weight: 600; color: #111827;">{{ $pageLabel }} Page</h2>
                    <button onclick="toggleForm('{{ $page }}')" style="padding: 0.5rem 1rem; background: #0D0DE0; color: white; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; font-family: 'Montserrat', sans-serif; font-size: 0.875rem;">
                        Edit SEO
                    </button>
                </div>
                
                <div id="view-{{ $page }}" style="display: block;">
                    <div style="display: grid; gap: 1rem;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.25rem; font-size: 0.875rem;">Meta Title</label>
                            <div style="font-size: 0.9375rem; color: #111827;">{{ $seo->meta_title ?? 'Not set' }}</div>
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.25rem; font-size: 0.875rem;">Meta Description</label>
                            <div style="font-size: 0.9375rem; color: #111827;">{{ $seo->meta_description ?? 'Not set' }}</div>
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.25rem; font-size: 0.875rem;">Meta Keywords</label>
                            <div style="font-size: 0.9375rem; color: #111827;">{{ $seo->meta_keywords ?? 'Not set' }}</div>
                        </div>
                    </div>
                </div>
                
                <form id="form-{{ $page }}" method="POST" action="{{ route('admin.seo.update', $page) }}" enctype="multipart/form-data" style="display: none;">
                    @csrf
                    @method('PUT')
                    
                    <div style="display: grid; gap: 1.5rem;">
                        <div>
                            <label style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Meta Title</label>
                            <input type="text" name="meta_title" value="{{ $seo->meta_title ?? '' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 0.9375rem;">
                        </div>
                        
                        <div>
                            <label style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Meta Description</label>
                            <textarea name="meta_description" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 0.9375rem; resize: vertical;">{{ $seo->meta_description ?? '' }}</textarea>
                        </div>
                        
                        <div>
                            <label style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Meta Keywords (comma separated)</label>
                            <input type="text" name="meta_keywords" value="{{ $seo->meta_keywords ?? '' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 0.9375rem;">
                        </div>
                        
                        <div>
                            <label style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">OG Title</label>
                            <input type="text" name="og_title" value="{{ $seo->og_title ?? '' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 0.9375rem;">
                        </div>
                        
                        <div>
                            <label style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">OG Description</label>
                            <textarea name="og_description" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 0.9375rem; resize: vertical;">{{ $seo->og_description ?? '' }}</textarea>
                        </div>
                        
                        <div>
                            <label style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">OG Image</label>
                            <input type="file" name="og_image" accept="image/*" style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 0.9375rem;">
                            @if($seo && $seo->og_image)
                                <div style="margin-top: 0.5rem;">
                                    <img src="{{ $seo->og_image_url }}" alt="OG Image" style="max-width: 200px; border-radius: 8px;">
                                </div>
                            @endif
                        </div>
                        
                        <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1rem;">
                            <button type="button" onclick="toggleForm('{{ $page }}')" style="padding: 0.75rem 1.5rem; background: #f3f4f6; color: #374151; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; font-family: 'Montserrat', sans-serif;">
                                Cancel
                            </button>
                            <button type="submit" style="padding: 0.75rem 1.5rem; background: #0D0DE0; color: white; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; font-family: 'Montserrat', sans-serif;">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endforeach
    </div>
    
    @push('scripts')
    <script>
        function toggleForm(page) {
            const viewDiv = document.getElementById('view-' + page);
            const formDiv = document.getElementById('form-' + page);
            
            if (viewDiv.style.display === 'none') {
                viewDiv.style.display = 'block';
                formDiv.style.display = 'none';
            } else {
                viewDiv.style.display = 'none';
                formDiv.style.display = 'block';
            }
        }
    </script>
    @endpush
</x-admin-layout>

