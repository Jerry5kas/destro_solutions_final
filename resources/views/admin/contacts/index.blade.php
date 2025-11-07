<x-admin-layout title="Contact Messages - Destrosolutions">
    <h1 class="page-title">Contact Messages</h1>
    
    @if(session('success'))
        <div style="padding: 1rem; background: #d1fae5; color: #065f46; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #a7f3d0;">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="dashboard-card" style="padding: 0; overflow: hidden;">
        <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
            <div style="display: grid; grid-template-columns: 40px 2fr 1.5fr 1fr 120px 100px; gap: 1.5rem; align-items: center;">
                <div></div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem;">Name</div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem;">Email</div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem;">Mobile</div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem; text-align: center;">Status</div>
                <div style="font-weight: 600; color: #374151; font-size: 0.875rem; text-align: center;">Actions</div>
            </div>
        </div>
        
        <div>
            @forelse($contacts as $contact)
                <div class="content-row" style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #f3f4f6; display: grid; grid-template-columns: 40px 2fr 1.5fr 1fr 120px 100px; gap: 1.5rem; align-items: center; transition: background 0.2s ease;">
                    <div>
                        <input type="checkbox" class="row-checkbox" style="width: 18px; height: 18px; cursor: pointer; accent-color: #0D0DE0; border-radius: 4px;">
                    </div>
                    
                    <div>
                        <div style="font-weight: 500; color: #111827; margin-bottom: 0.25rem; font-size: 0.9375rem;">{{ $contact->name }}</div>
                        <div style="font-size: 0.8125rem; color: #6b7280;">Received: {{ $contact->created_at->format('m/d/Y') }}</div>
                    </div>
                    
                    <div style="font-weight: 400; color: #6b7280; font-size: 0.875rem;">
                        {{ $contact->email }}
                    </div>
                    
                    <div style="font-weight: 400; color: #6b7280; font-size: 0.875rem;">
                        {{ $contact->mobile ?? 'N/A' }}
                    </div>
                    
                    <div style="text-align: center;">
                        @if($contact->status === 'new')
                            <span class="status-badge status-waiting">
                                <span class="status-dot"></span>
                                New
                            </span>
                        @elseif($contact->status === 'read')
                            <span class="status-badge status-active">
                                <span class="status-dot"></span>
                                Read
                            </span>
                        @else
                            <span class="status-badge status-active">
                                <span class="status-dot"></span>
                                Replied
                            </span>
                        @endif
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 0.5rem; justify-content: center;">
                        <a href="{{ route('admin.contacts.show', $contact->id) }}" style="padding: 0.5rem; background: transparent; border: none; color: #0D0DE0; cursor: pointer; border-radius: 6px; transition: all 0.2s ease;" title="View">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this contact?');">
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
                    <p>No contact messages found.</p>
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
    </style>
    @endpush
</x-admin-layout>

