<x-admin-layout title="Translation Sync Status - Destrosolutions">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 class="page-title">Translation Sync Status</h1>
    </div>
    
    @if(session('success'))
        <div style="padding: 1rem; background: #d1fae5; color: #065f46; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #a7f3d0; font-weight: 500;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="padding: 1rem; background: #fee2e2; color: #991b1b; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #fecaca; font-weight: 500;">
            {{ session('error') }}
        </div>
    @endif
    
    <!-- Language Selection and Sync Section -->
    <div class="dashboard-card" style="margin-bottom: 2rem; padding: 2rem;">
        <div style="margin-bottom: 2rem;">
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin-bottom: 1rem;">Sync All Translations</h2>
            <p style="color: #6b7280; margin-bottom: 1.5rem;">
                Select a language and sync all content items. This will create/update translation entries in the database for all translatable fields.
            </p>
        </div>

        <form action="{{ route('admin.translations.sync') }}" method="POST" id="syncForm" style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
            @csrf
            <div style="flex: 1; min-width: 250px;">
                <label style="display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Select Language to Sync</label>
                <select name="locale" id="syncLocale" required style="width: 100%; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 0.9375rem; font-weight: 500;">
                    @foreach($locales as $loc)
                        <option value="{{ $loc }}" {{ $locale === $loc ? 'selected' : '' }}>
                            {{ strtoupper($loc) }} - {{ $loc === 'en' ? 'English' : 'Deutsch' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" id="syncButton" style="padding: 0.75rem 2rem; background: #10b981; color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; font-size: 1rem; transition: all 0.2s ease; white-space: nowrap;">
                <span id="syncButtonText">Sync All Translations</span>
            </button>
        </form>
    </div>

    <!-- Sync Status Overview -->
    <div class="dashboard-card" style="margin-bottom: 2rem; padding: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin-bottom: 1.5rem;">Sync Status Overview</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
            @foreach($locales as $loc)
                @php
                    $stats = $syncStats[$loc] ?? [];
                    $isSynced = $stats['is_synced'] ?? false;
                @endphp
                <div style="padding: 1.5rem; background: {{ $isSynced ? '#d1fae5' : '#fef3c7' }}; border-radius: 12px; border: 2px solid {{ $isSynced ? '#10b981' : '#f59e0b' }};">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827;">
                            {{ strtoupper($loc) }} - {{ $loc === 'en' ? 'English' : 'Deutsch' }}
                        </h3>
                        @if($isSynced)
                            <span style="padding: 0.25rem 0.75rem; background: #10b981; color: white; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                                ✓ SYNCED
                            </span>
                        @else
                            <span style="padding: 0.25rem 0.75rem; background: #f59e0b; color: white; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                                PENDING
                            </span>
                        @endif
                    </div>
                    
                    <div style="space-y: 0.5rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span style="color: #6b7280; font-size: 0.875rem;">Total Content Items:</span>
                            <span style="font-weight: 600; color: #111827;">{{ $stats['total_items'] ?? 0 }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span style="color: #6b7280; font-size: 0.875rem;">Expected Translations:</span>
                            <span style="font-weight: 600; color: #111827;">{{ $stats['expected_translations'] ?? 0 }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span style="color: #6b7280; font-size: 0.875rem;">Existing Translations:</span>
                            <span style="font-weight: 600; color: #10b981;">{{ $stats['existing_translations'] ?? 0 }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span style="color: #6b7280; font-size: 0.875rem;">Missing Translations:</span>
                            <span style="font-weight: 600; color: #ef4444;">{{ $stats['missing_translations'] ?? 0 }}</span>
                        </div>
                        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(0,0,0,0.1);">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <span style="color: #6b7280; font-size: 0.875rem;">Sync Progress:</span>
                                <span style="font-weight: 700; color: #111827; font-size: 1.125rem;">{{ $stats['sync_percentage'] ?? 0 }}%</span>
                            </div>
                            <div style="width: 100%; height: 8px; background: #e5e7eb; border-radius: 4px; overflow: hidden;">
                                <div style="width: {{ $stats['sync_percentage'] ?? 0 }}%; height: 100%; background: {{ $isSynced ? '#10b981' : '#f59e0b' }}; transition: width 0.3s ease;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="dashboard-card" style="padding: 2rem; background: #f9fafb;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin-bottom: 1rem;">How Translation Sync Works</h2>
        <div style="color: #6b7280; line-height: 1.8;">
            <p style="margin-bottom: 1rem;"><strong>1. Automatic Sync:</strong> When you create or update content (ContentItems), translation entries are automatically created in the database for all translatable fields.</p>
            <p style="margin-bottom: 1rem;"><strong>2. Manual Sync:</strong> Use the "Sync All Translations" button above to sync all existing content for a selected language in one click.</p>
            <p style="margin-bottom: 1rem;"><strong>3. Translation Storage:</strong> All translations are stored in the <code>translations</code> table with proper indexing for fast retrieval.</p>
            <p><strong>4. Sync Status:</strong> The status cards above show real-time sync statistics. Green "SYNCED" badge indicates all translations are complete for that language.</p>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('syncForm').addEventListener('submit', function(e) {
            const button = document.getElementById('syncButton');
            const buttonText = document.getElementById('syncButtonText');
            const locale = document.getElementById('syncLocale').value;
            
            // Confirm before syncing
            if (!confirm(`Are you sure you want to sync all translations for ${locale.toUpperCase()}? This will create/update translation entries for all content items.`)) {
                e.preventDefault();
                return;
            }
            
            // Disable button and show loading
            button.disabled = true;
            button.style.opacity = '0.7';
            button.style.cursor = 'not-allowed';
            buttonText.textContent = 'Syncing... Please wait';
        });
    </script>
    @endpush
</x-admin-layout>
