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
        
        <div data-contacts-list>
            @include('admin.contacts.partials.rows', ['contacts' => $contacts])
        </div>
    </div>
    
    @push('styles')
    <style>
        .content-row:hover {
            background: #f9fafb;
        }

        .content-row--highlight {
            animation: contact-row-flash 2s ease-out;
        }

        @keyframes contact-row-flash {
            0% {
                background: rgba(59, 130, 246, 0.15);
            }
            100% {
                background: transparent;
            }
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

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const listContainer = document.querySelector('[data-contacts-list]');

            if (!listContainer || typeof window.axios === 'undefined') {
                return;
            }

            const endpoint = @json(route('admin.contacts.index'));
            let knownIds = Array.from(listContainer.querySelectorAll('[data-contact-row]')).map((row) => row.getAttribute('data-contact-row'));
            let pollingHandle = null;

            function highlightNewRows(newRows) {
                newRows.forEach((row) => {
                    row.classList.add('content-row--highlight');
                    setTimeout(() => {
                        row.classList.remove('content-row--highlight');
                    }, 2000);
                });
            }

            function syncRows(nextHtml) {
                const incomingHtml = typeof nextHtml === 'string' ? nextHtml.trim() : '';
                if (!incomingHtml.length) {
                    return;
                }

                if (listContainer.innerHTML.trim() === incomingHtml) {
                    return;
                }

                const parser = document.createElement('div');
                parser.innerHTML = incomingHtml;

                const incomingRows = Array.from(parser.querySelectorAll('[data-contact-row]'));
                const incomingIds = incomingRows.map((row) => row.getAttribute('data-contact-row'));

                listContainer.innerHTML = incomingHtml;

                const currentRows = Array.from(listContainer.querySelectorAll('[data-contact-row]'));
                const newRows = currentRows.filter((row) => !knownIds.includes(row.getAttribute('data-contact-row')));

                if (newRows.length) {
                    highlightNewRows(newRows);
                }

                knownIds = currentRows.map((row) => row.getAttribute('data-contact-row'));
            }

            async function fetchLatest() {
                try {
                    const { data } = await window.axios.get(endpoint, {
                        headers: {
                            Accept: 'application/json',
                        },
                    });

                    if (typeof data.html === 'string') {
                        syncRows(data.html);
                    }
                } catch (error) {
                    console.error('Unable to refresh contacts list', error);
                }
            }

            pollingHandle = window.setInterval(fetchLatest, 10000);

            document.addEventListener('visibilitychange', () => {
                if (document.visibilityState === 'visible') {
                    fetchLatest();
                }
            });

            window.addEventListener('beforeunload', () => {
                if (pollingHandle) {
                    clearInterval(pollingHandle);
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>

