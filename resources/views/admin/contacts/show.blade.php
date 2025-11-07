<x-admin-layout title="Contact Message - Destrosolutions">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 class="page-title">Contact Message</h1>
        <a href="{{ route('admin.contacts.index') }}" style="padding: 0.75rem 1.5rem; background: #f3f4f6; color: #374151; border: none; border-radius: 10px; font-weight: 500; cursor: pointer; font-family: 'Montserrat', sans-serif; text-decoration: none; display: inline-block;">
            ← Back to Messages
        </a>
    </div>
    
    <div class="dashboard-card">
        <div style="display: grid; gap: 1.5rem;">
            <div>
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Name</label>
                <div style="font-size: 1rem; color: #111827;">{{ $contact->name }}</div>
            </div>
            
            <div>
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Email</label>
                <div style="font-size: 1rem; color: #111827;">{{ $contact->email }}</div>
            </div>
            
            @if($contact->mobile)
            <div>
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Mobile</label>
                <div style="font-size: 1rem; color: #111827;">{{ $contact->mobile }}</div>
            </div>
            @endif
            
            <div>
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Message</label>
                <div style="font-size: 1rem; color: #111827; line-height: 1.6; white-space: pre-wrap;">{{ $contact->message }}</div>
            </div>
            
            <div>
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Status</label>
                <div>
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
            </div>
            
            <div>
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Received</label>
                <div style="font-size: 0.875rem; color: #6b7280;">{{ $contact->created_at->format('F d, Y \a\t h:i A') }}</div>
            </div>
            
            @if($contact->read_at)
            <div>
                <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Read At</label>
                <div style="font-size: 0.875rem; color: #6b7280;">{{ $contact->read_at->format('F d, Y \a\t h:i A') }}</div>
            </div>
            @endif
            
            <div style="display: flex; gap: 1rem; margin-top: 1rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
                <form action="{{ route('admin.contacts.update', $contact->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="{{ $contact->status === 'new' ? 'read' : ($contact->status === 'read' ? 'replied' : 'read') }}">
                    <button type="submit" style="padding: 0.75rem 1.5rem; background: #0D0DE0; color: white; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; font-family: 'Montserrat', sans-serif;">
                        {{ $contact->status === 'new' ? 'Mark as Read' : ($contact->status === 'read' ? 'Mark as Replied' : 'Mark as Read') }}
                    </button>
                </form>
                
                <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this contact?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="padding: 0.75rem 1.5rem; background: #ef4444; color: white; border: none; border-radius: 8px; font-weight: 500; cursor: pointer; font-family: 'Montserrat', sans-serif;">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    @push('styles')
    <style>
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

