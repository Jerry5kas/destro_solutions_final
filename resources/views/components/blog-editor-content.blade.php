@props(['editorId', 'value'])

<div class="blog-editor-content-wrapper">
    <div class="blog-editor-preview-shell">
        <div class="blog-preview-banner" id="{{ $editorId }}-preview-banner">
            <div class="blog-preview-banner-overlay">
                <h1 class="blog-preview-title" id="{{ $editorId }}-preview-title">Untitled blog post</h1>
            </div>
        </div>

        <div class="blog-preview-meta">
            <span id="{{ $editorId }}-preview-date"></span>
        </div>

        <div class="blog-preview-body">
            <div id="{{ $editorId }}-content" class="blog-editor-content" contenteditable="true">
                {{-- Content blocks will be inserted here --}}
            </div>
        </div>
    </div>
</div>

