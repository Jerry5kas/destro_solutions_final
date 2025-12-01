@props(['editorId'])

<div class="blog-editor-preview-wrapper">
    <div class="preview-header">
        <h3 class="preview-title">Live Preview</h3>
        <div class="preview-actions">
            <button type="button" class="action-btn" id="{{ $editorId }}-preview-toggle" title="Toggle Preview">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </button>
        </div>
    </div>
    <div id="{{ $editorId }}-preview" class="blog-editor-preview">
        {{-- Preview will be rendered here --}}
    </div>
</div>

