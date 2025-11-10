@php
    $typeLabels = [
        'category' => 'Category',
        'quantum' => 'Quantum',
        'services' => 'Services',
        'products' => 'Products',
        'training' => 'Training',
        'blog' => 'Blog',
        'contact' => 'Contact',
    ];
    $typeLabel = $typeLabels[$type] ?? ucfirst($type);
@endphp

<x-admin-layout title="{{ $typeLabel }} Management - Destrosolutions">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 class="page-title">{{ $typeLabel }} Management</h1>
        <button onclick="openCreateModal()" style="padding: 0.75rem 1.5rem; background: #0D0DE0; color: white; border: none; border-radius: 10px; font-weight: 500; cursor: pointer; font-family: 'Montserrat', sans-serif; transition: all 0.2s ease;">
            + Add New
        </button>
    </div>
    
    @if(session('success'))
        <div style="padding: 1rem; background: #d1fae5; color: #065f46; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #a7f3d0;">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="dashboard-card" style="padding: 0; overflow: hidden;">
        <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
            <div style="display: grid; grid-template-columns: 40px 2fr 1.5fr 1fr 120px 100px; gap: 1.5rem; align-items: center;">
                <div></div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem;">Title</div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem;">Description</div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem;">Category</div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem; text-align: center;">Status</div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem; text-align: center;">Actions</div>
            </div>
        </div>
        
        <div>
            @forelse($items as $item)
                <div class="content-row" style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #f3f4f6; display: grid; grid-template-columns: 40px 2fr 1.5fr 1fr 120px 100px; gap: 1.5rem; align-items: center; transition: background 0.2s ease;">
                    <div>
                        <input type="checkbox" class="row-checkbox" style="width: 18px; height: 18px; cursor: pointer; accent-color: #0D0DE0; border-radius: 4px;">
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 48px; height: 48px; border-radius: 50%; overflow: hidden; background: #f3f4f6; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            @if($item->image)
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #0D0DE0 0%, #6366f1 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 1.25rem;">
                                    {{ strtoupper(substr($item->title, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div style="min-width: 0;">
                            <div style="font-weight: 500; color: #111827; margin-bottom: 0.25rem; font-size: 0.9375rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $item->title }}</div>
                            <div style="font-size: 0.8125rem; color: #6b7280;">Added: {{ $item->created_at->format('m/d/Y') }}</div>
                        </div>
                    </div>
                    
                    <div style="font-weight: 400; color: #6b7280; font-size: 0.875rem; line-height: 1.5; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                        {{ Str::limit($item->description ?? 'No description', 100) }}
                    </div>
                    
                    <div style="font-weight: 500; color: #111827; font-size: 0.9375rem;">
                        {{ $item->category->title ?? 'N/A' }}
                    </div>
                    
                    <div style="text-align: center;">
                        @if($item->status === 'active')
                            <span class="status-badge status-active">
                                <span class="status-dot"></span>
                                Active
                            </span>
                        @elseif($item->status === 'waiting')
                            <span class="status-badge status-waiting">
                                <span class="status-dot"></span>
                                Waiting
                            </span>
                        @else
                            <span class="status-badge status-inactive">
                                <span class="status-dot"></span>
                                Inactive
                            </span>
                        @endif
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 0.5rem; justify-content: center;">
                        <button onclick="openEditModal({{ $item->id }})" style="padding: 0.5rem; background: transparent; border: none; color: #0D0DE0; cursor: pointer; border-radius: 6px; transition: all 0.2s ease;" title="Edit">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <form action="{{ route('admin.content.destroy', [$type, $item->id]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this item?');">
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
                    <p>No {{ strtolower($typeLabel) }} items found. Click "Add New" to create one.</p>
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
        
        .status-waiting {
            background: #fef3c7;
            color: #92400e;
        }
        
        .status-waiting .status-dot {
            background: #f59e0b;
        }
        
        .status-inactive {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .status-inactive .status-dot {
            background: #ef4444;
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
        
        @media (max-width: 1024px) {
            .dashboard-card > div:first-child > div,
            .content-row {
                grid-template-columns: 40px 2fr 1fr 100px 80px !important;
            }
            
            .dashboard-card > div:first-child > div > div:nth-child(3),
            .content-row > div:nth-child(3) {
                display: none;
            }
        }
        
        @media (max-width: 768px) {
            .dashboard-card > div:first-child > div,
            .content-row {
                grid-template-columns: 1fr !important;
                gap: 1rem !important;
            }
            
            .content-row > div:first-child {
                order: 1;
            }
            
            .content-row > div:last-child {
                order: 2;
                justify-content: flex-start !important;
            }
        }
    </style>
    @endpush
    
    <!-- Create/Edit Modal -->
    <div id="contentModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); z-index: 10000; align-items: center; justify-content: center; padding: 1rem;">
        <div style="background: white; border-radius: 16px; max-width: 600px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);">
            <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827;" id="modalTitle">Add New {{ $typeLabel }}</h2>
                <button onclick="closeModal()" style="padding: 0.5rem; background: transparent; border: none; color: #6b7280; cursor: pointer; border-radius: 6px;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <form id="contentForm" method="POST" enctype="multipart/form-data" style="padding: 1.5rem;">
                @csrf
                <div id="formMethod"></div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Title *</label>
                    <input type="text" name="title" id="title" required style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 0.9375rem;">
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Description</label>
                    <textarea name="description" id="description" rows="4" style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 0.9375rem; resize: vertical;"></textarea>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Category</label>
                    <select name="category_id" id="category_id" style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 0.9375rem; background: white;">
                        <option value="">Select Category</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Slug</label>
                    <input type="text" name="slug" id="slug" style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 0.9375rem;">
                    <small style="color: #6b7280; font-size: 0.75rem;">Leave empty to auto-generate from title</small>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Date</label>
                    <input type="date" name="date" id="date" style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 0.9375rem;">
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Objective List (one per line)</label>
                    <textarea name="objective_list_text" id="objective_list_text" rows="4" placeholder="Enter objectives, one per line" style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 0.9375rem; resize: vertical;"></textarea>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Image</label>
                    <input type="file" name="image" id="image" accept="image/*" style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 0.9375rem;">
                    <div id="imagePreview" style="margin-top: 0.5rem;"></div>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Status *</label>
                    <select name="status" id="status" required style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 0.9375rem; background: white;">
                        <option value="active">Active</option>
                        <option value="waiting">Waiting for Reassignment</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                @if($type === 'training')
                <div id="trainingFields" style="margin-top: 2rem; border-top: 1px solid #e5e7eb; padding-top: 1.5rem;">
                    <h3 style="font-size: 1rem; font-weight: 600; color: #111827; margin-bottom: 1rem;">Training Details</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem;">
                        <div>
                            <label class="admin-label">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="admin-input">
                        </div>
                        <div>
                            <label class="admin-label">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="admin-input">
                        </div>
                        <div>
                            <label class="admin-label">Enrollment Deadline</label>
                            <input type="date" name="enrollment_deadline" id="enrollment_deadline" class="admin-input">
                        </div>
                        <div>
                            <label class="admin-label">Price</label>
                            <input type="number" step="0.01" min="0" name="price" id="price" class="admin-input" placeholder="0.00">
                        </div>
                        <div>
                            <label class="admin-label">Currency</label>
                            <select name="currency_code" id="currency_code" class="admin-input">
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->code }}" data-default="{{ $currency->is_default ? 1 : 0 }}" {{ $currency->is_default ? 'selected' : '' }}>
                                        {{ $currency->code }} &mdash; {{ $currency->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="admin-label">Duration (days)</label>
                            <input type="number" min="0" name="duration_days" id="duration_days" class="admin-input">
                        </div>
                        <div>
                            <label class="admin-label">Duration (hours)</label>
                            <input type="number" min="0" name="duration_hours" id="duration_hours" class="admin-input">
                        </div>
                        <div>
                            <label class="admin-label">Session Count</label>
                            <input type="number" min="0" name="session_count" id="session_count" class="admin-input">
                        </div>
                        <div>
                            <label class="admin-label">Session Length (minutes)</label>
                            <input type="number" min="0" name="session_length_minutes" id="session_length_minutes" class="admin-input">
                        </div>
                        <div>
                            <label class="admin-label">Max Students</label>
                            <input type="number" min="0" name="max_students" id="max_students" class="admin-input">
                        </div>
                        <div>
                            <label class="admin-label">Delivery Mode</label>
                            <input type="text" name="delivery_mode" id="delivery_mode" class="admin-input" placeholder="Virtual / Onsite / Hybrid">
                        </div>
                        <div>
                            <label class="admin-label">Level</label>
                            <select name="level" id="level" class="admin-input">
                                <option value="">Select level</option>
                                <option value="beginner">Beginner</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="advanced">Advanced</option>
                            </select>
                        </div>
                        <div>
                            <label class="admin-label">Language</label>
                            <input type="text" name="language" id="language" class="admin-input" placeholder="EN, DE, ...">
                        </div>
                    </div>

                    <div style="display: flex; flex-wrap: wrap; gap: 1rem; margin-top: 1.5rem;">
                        <label style="display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #374151;">
                            <input type="hidden" name="is_enrollable" value="0">
                            <input type="checkbox" name="is_enrollable" id="is_enrollable" value="1" style="width: 18px; height: 18px; accent-color: #0D0DE0;">
                            <span>Allow enrollments</span>
                        </label>
                        <label style="display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #374151;">
                            <input type="hidden" name="certification_available" value="0">
                            <input type="checkbox" name="certification_available" id="certification_available" value="1" style="width: 18px; height: 18px; accent-color: #0D0DE0;">
                            <span>Certification provided</span>
                        </label>
                    </div>

                    <div style="margin-top: 1.5rem;">
                        <label class="admin-label">Prerequisites (one per line)</label>
                        <textarea name="prerequisites" id="prerequisites" rows="3" class="admin-input" style="resize: vertical;"></textarea>
                    </div>

                    <div style="margin-top: 1rem;">
                        <label class="admin-label">Instructor Name</label>
                        <input type="text" name="instructor_name" id="instructor_name" class="admin-input">
                    </div>

                    <div style="margin-top: 1rem;">
                        <label class="admin-label">Instructor Bio</label>
                        <textarea name="instructor_bio" id="instructor_bio" rows="4" class="admin-input" style="resize: vertical;"></textarea>
                    </div>

                    <div style="margin-top: 1rem;">
                        <label class="admin-label">Learning Outcomes (one per line)</label>
                        <textarea name="outcomes_text" id="outcomes_text" rows="4" class="admin-input" placeholder="Participants will be able to..." style="resize: vertical;"></textarea>
                    </div>

                    <div style="margin-top: 1rem;">
                        <label class="admin-label">Materials Provided (one per line)</label>
                        <textarea name="materials_text" id="materials_text" rows="3" class="admin-input" placeholder="Training handbook&#10;Reference templates" style="resize: vertical;"></textarea>
                    </div>

                    <div style="margin-top: 1rem;">
                        <label class="admin-label">Certification Details</label>
                        <textarea name="certification_details" id="certification_details" rows="3" class="admin-input" style="resize: vertical;"></textarea>
                    </div>
                </div>
                @endif
                
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
        const itemsData = @json($items);
        const isTraining = '{{ $type }}' === 'training';

        const trainingFieldIds = [
            'start_date',
            'end_date',
            'enrollment_deadline',
            'currency_code',
            'price',
            'duration_days',
            'duration_hours',
            'session_count',
            'session_length_minutes',
            'max_students',
            'delivery_mode',
            'level',
            'language',
            'prerequisites',
            'instructor_name',
            'instructor_bio',
            'outcomes_text',
            'materials_text',
            'certification_details'
        ];

        function formatDateValue(value) {
            if (!value) return '';
            return value.length > 10 ? value.substring(0, 10) : value;
        }

        function resetTrainingFields() {
            if (!isTraining) return;
            trainingFieldIds.forEach(id => {
                const field = document.getElementById(id);
                if (field) {
                    field.value = '';
                }
            });
            const enrollCheckbox = document.getElementById('is_enrollable');
            if (enrollCheckbox) enrollCheckbox.checked = false;
            const certCheckbox = document.getElementById('certification_available');
            if (certCheckbox) certCheckbox.checked = false;
            const currencySelect = document.getElementById('currency_code');
            if (currencySelect) {
                const defaultOption = currencySelect.querySelector('option[data-default="1"]');
                currencySelect.value = defaultOption ? defaultOption.value : (currencySelect.options[0]?.value || '');
            }
        }

        function populateTrainingFields(item) {
            if (!isTraining || !item) return;

            const setValue = (id, value) => {
                const field = document.getElementById(id);
                if (!field) return;
                if (id === 'currency_code') {
                    const fallback = field.querySelector('option[data-default="1"]')?.value || field.options[0]?.value || '';
                    field.value = value ?? fallback;
                    return;
                }
                field.value = value ?? '';
            };

            setValue('start_date', formatDateValue(item.start_date));
            setValue('end_date', formatDateValue(item.end_date));
            setValue('enrollment_deadline', formatDateValue(item.enrollment_deadline));
            setValue('price', item.price);
            setValue('currency_code', item.currency_code || item.currency);
            setValue('duration_days', item.duration_days);
            setValue('duration_hours', item.duration_hours);
            setValue('session_count', item.session_count);
            setValue('session_length_minutes', item.session_length_minutes);
            setValue('max_students', item.max_students);
            setValue('delivery_mode', item.delivery_mode);
            setValue('level', item.level);
            setValue('language', item.language);
            setValue('prerequisites', item.prerequisites);
            setValue('instructor_name', item.instructor_name);
            setValue('instructor_bio', item.instructor_bio);

            const outcomesField = document.getElementById('outcomes_text');
            if (outcomesField) {
                outcomesField.value = Array.isArray(item.outcomes) ? item.outcomes.join('\n') : '';
            }
            const materialsField = document.getElementById('materials_text');
            if (materialsField) {
                materialsField.value = Array.isArray(item.materials_provided) ? item.materials_provided.join('\n') : '';
            }
            setValue('certification_details', item.certification_details);

            const enrollCheckbox = document.getElementById('is_enrollable');
            if (enrollCheckbox) enrollCheckbox.checked = !!item.is_enrollable;
            const certCheckbox = document.getElementById('certification_available');
            if (certCheckbox) certCheckbox.checked = !!item.certification_available;
        }
        
        function openCreateModal() {
            currentEditId = null;
            document.getElementById('modalTitle').textContent = 'Add New {{ $typeLabel }}';
            document.getElementById('contentForm').action = '{{ route("admin.content.store", $type) }}';
            document.getElementById('formMethod').innerHTML = '';
            document.getElementById('contentForm').reset();
            document.getElementById('imagePreview').innerHTML = '';
            resetTrainingFields();
            document.getElementById('contentModal').style.display = 'flex';
        }
        
        function openEditModal(id) {
            const item = itemsData.find(i => i.id === id);
            if (!item) return;
            
            currentEditId = id;
            document.getElementById('modalTitle').textContent = 'Edit {{ $typeLabel }}';
            document.getElementById('contentForm').action = '{{ route("admin.content.update", [$type, ":id"]) }}'.replace(':id', id);
            document.getElementById('formMethod').innerHTML = '@method("PUT")';
            
            document.getElementById('title').value = item.title || '';
            document.getElementById('slug').value = item.slug || '';
            document.getElementById('description').value = item.description || '';
            document.getElementById('category_id').value = item.category_id || '';
            document.getElementById('date').value = item.date || '';
            document.getElementById('status').value = item.status || 'active';
            
            if (item.objective_list && item.objective_list.length > 0) {
                document.getElementById('objective_list_text').value = item.objective_list.join('\n');
            } else {
                document.getElementById('objective_list_text').value = '';
            }

            if (isTraining) {
                populateTrainingFields(item);
            }
            
            if (item.image_url) {
                document.getElementById('imagePreview').innerHTML = `<img src="${item.image_url}" alt="Preview" style="max-width: 200px; border-radius: 8px; margin-top: 0.5rem;">`;
            } else {
                document.getElementById('imagePreview').innerHTML = '';
            }
            
            document.getElementById('contentModal').style.display = 'flex';
        }
        
        function closeModal() {
            document.getElementById('contentModal').style.display = 'none';
            currentEditId = null;
        }
        
        // Close modal on outside click
        document.getElementById('contentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
        
        // Handle image preview
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

        if (isTraining) {
            resetTrainingFields();
        }
    </script>
    @endpush
</x-admin-layout>

