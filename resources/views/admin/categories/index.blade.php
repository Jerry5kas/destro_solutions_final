<x-admin-layout title="Categories Management - Destrosolutions">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 class="page-title">Categories Management</h1>
        <button onclick="openCreateModal()" style="padding: 0.75rem 1.5rem; background: #0D0DE0; color: white; border: none; border-radius: 10px; font-weight: 500; cursor: pointer; font-family: 'Montserrat', sans-serif; transition: all 0.2s ease;">
            + Add New Category
        </button>
    </div>
    
    @if(session('success'))
        <div style="padding: 1rem; background: #d1fae5; color: #065f46; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #a7f3d0;">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="dashboard-card" style="padding: 0; overflow: hidden;">
        <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
            <div style="display: grid; grid-template-columns: 40px 2fr 1fr 100px 100px; gap: 1.5rem; align-items: center;">
                <div></div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem;">Title</div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem;">Slug</div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem; text-align: center;">Status</div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem; text-align: center;">Actions</div>
            </div>
        </div>
        
        <div>
            @forelse($categories as $category)
                <div class="content-row" style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #f3f4f6; display: grid; grid-template-columns: 40px 2fr 1fr 100px 100px; gap: 1.5rem; align-items: center; transition: background 0.2s ease;">
                    <div>
                        <input type="checkbox" class="row-checkbox" style="width: 18px; height: 18px; cursor: pointer; accent-color: #0D0DE0; border-radius: 4px;">
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 48px; height: 48px; border-radius: 50%; overflow: hidden; background: #f3f4f6; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            @if($category->image)
                                <img src="{{ $category->image_url }}" alt="{{ $category->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #0D0DE0 0%, #6366f1 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 1.25rem;">
                                    {{ strtoupper(substr($category->title, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div style="min-width: 0;">
                            <div style="font-weight: 500; color: #111827; margin-bottom: 0.25rem; font-size: 0.9375rem;">{{ $category->title }}</div>
                            <div style="font-size: 0.8125rem; color: #6b7280;">Added: {{ $category->created_at->format('m/d/Y') }}</div>
                        </div>
                    </div>
                    
                    <div style="font-weight: 400; color: #6b7280; font-size: 0.875rem;">
                        {{ $category->slug }}
                    </div>
                    
                    <div style="text-align: center;">
                        @if($category->is_active)
                            <span class="status-badge status-active">
                                <span class="status-dot"></span>
                                Active
                            </span>
                        @else
                            <span class="status-badge status-inactive">
                                <span class="status-dot"></span>
                                Inactive
                            </span>
                        @endif
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 0.5rem; justify-content: center;">
                        <button onclick="openEditModal({{ $category->id }})" style="padding: 0.5rem; background: transparent; border: none; color: #0D0DE0; cursor: pointer; border-radius: 6px; transition: all 0.2s ease;" title="Edit">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="padding: 0.5rem; background: transparent; border: none; color: #ef4444; cursor: pointer; border-radius: 6px; transition: all 0.2s ease;" title="Delete">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="padding: 3rem; text-align: center; color: #6b7280;">
                    <p>No categories found. Click "Add New Category" to create one.</p>
                </div>
            @endforelse
        </div>
    </div>
    
    @push('styles')
    <style>
        .content-row:hover {
            background: #f9fafb;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8125rem;
            font-weight: 500;
        }
        
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        
        .status-active {
            background: #d1fae5;
            color: #065f46;
        }
        
        .status-active .status-dot {
            background: #10b981;
        }
        
        .status-inactive {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .status-inactive .status-dot {
            background: #ef4444;
        }
    </style>
    @endpush
    
    <!-- Create/Edit Modal -->
    <div id="categoryModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); z-index: 10000; align-items: center; justify-content: center; padding: 1rem;">
        <div style="background: white; border-radius: 16px; max-width: 500px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);">
            <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827;" id="modalTitle">Add New Category</h2>
                <button onclick="closeModal()" style="padding: 0.5rem; background: transparent; border: none; color: #6b7280; cursor: pointer; border-radius: 6px;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form id="categoryForm" method="POST" enctype="multipart/form-data" style="padding: 1.5rem;">
                @csrf
                <div id="formMethod"></div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Title *</label>
                    <input type="text" name="title" id="title" required style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 0.9375rem;">
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Slug</label>
                    <input type="text" name="slug" id="slug" style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 0.9375rem;">
                    <small style="color: #6b7280; font-size: 0.75rem;">Leave empty to auto-generate from title</small>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Image</label>
                    <input type="file" name="image" id="image" accept="image/*" style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 0.9375rem;">
                    <div id="imagePreview" style="margin-top: 0.5rem;"></div>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="is_active" id="is_active" value="1" checked style="width: 18px; height: 18px; accent-color: #0D0DE0;">
                        <span style="font-weight: 500; color: #374151; font-size: 0.875rem;">Active</span>
                    </label>
                </div>
                
                <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
                    <button type="button" onclick="closeModal()" style="padding: 0.75rem 1.5rem; background: #f3f4f6; color: #374151; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; font-family: 'Montserrat', sans-serif;">
                        Cancel
                    </button>
                    <button type="submit" style="padding: 0.75rem 1.5rem; background: #0D0DE0; color: white; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; font-family: 'Montserrat', sans-serif;">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    @push('scripts')
    <script>
        let currentEditId = null;
        const categoriesData = @json($categories);
        
        function openCreateModal() {
            currentEditId = null;
            document.getElementById('modalTitle').textContent = 'Add New Category';
            document.getElementById('categoryForm').action = '{{ route("admin.categories.store") }}';
            document.getElementById('formMethod').innerHTML = '';
            document.getElementById('categoryForm').reset();
            document.getElementById('imagePreview').innerHTML = '';
            document.getElementById('is_active').checked = true;
            document.getElementById('categoryModal').style.display = 'flex';
        }
        
        function openEditModal(id) {
            const category = categoriesData.find(c => c.id === id);
            if (!category) return;
            
            currentEditId = id;
            document.getElementById('modalTitle').textContent = 'Edit Category';
            document.getElementById('categoryForm').action = '{{ route("admin.categories.update", ":id") }}'.replace(':id', id);
            document.getElementById('formMethod').innerHTML = '@method("PUT")';
            
            document.getElementById('title').value = category.title || '';
            document.getElementById('slug').value = category.slug || '';
            document.getElementById('is_active').checked = category.is_active;
            
            if (category.image_url) {
                document.getElementById('imagePreview').innerHTML = `<img src="${category.image_url}" alt="Preview" style="max-width: 200px; border-radius: 8px; margin-top: 0.5rem;">`;
            } else {
                document.getElementById('imagePreview').innerHTML = '';
            }
            
            document.getElementById('categoryModal').style.display = 'flex';
        }
        
        function closeModal() {
            document.getElementById('categoryModal').style.display = 'none';
            currentEditId = null;
        }
        
        document.getElementById('categoryModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
        
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width: 200px; border-radius: 8px; margin-top: 0.5rem;">`;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    @endpush
</x-admin-layout>

