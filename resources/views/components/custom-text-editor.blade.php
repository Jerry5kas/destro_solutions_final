@props([
    'name' => 'editor_content',
    'value' => null,
    'id' => 'custom-text-editor-' . uniqid(),
])

@php
    $editorId = $id;
    $toolbarId = $editorId . '-toolbar';
    $contentId = $editorId . '-content';
    $previewId = $editorId . '-preview';
    $hiddenInputId = $editorId . '-hidden-input';
@endphp

<div id="{{ $editorId }}" class="custom-text-editor border border-gray-300 rounded-lg overflow-hidden bg-white">
    <!-- Format Indicator -->
    <div id="{{ $editorId }}-format-indicator" class="bg-blue-50 border-b border-blue-200 px-4 py-2 text-xs text-gray-600 hidden">
        <span class="font-semibold">Next format:</span>
        <span id="{{ $editorId }}-format-text">None</span>
    </div>
    
    <!-- Toolbar -->
    <div id="{{ $toolbarId }}" class="editor-toolbar bg-gray-50 border-b border-gray-200 p-3 flex flex-wrap gap-2">
        <!-- Headings -->
        <div class="flex items-center gap-1 border-r border-gray-300 pr-2">
            <button type="button" id="{{ $editorId }}-h1" class="editor-btn px-3 py-1.5 text-sm font-semibold bg-white border border-gray-300 rounded hover:bg-gray-100 transition-all" data-type="h1" title="Heading 1">
                H1
            </button>
            <button type="button" id="{{ $editorId }}-h2" class="editor-btn px-3 py-1.5 text-sm font-semibold bg-white border border-gray-300 rounded hover:bg-gray-100 transition-all" data-type="h2" title="Heading 2">
                H2
            </button>
            <button type="button" id="{{ $editorId }}-h3" class="editor-btn px-3 py-1.5 text-sm font-semibold bg-white border border-gray-300 rounded hover:bg-gray-100 transition-all" data-type="h3" title="Heading 3">
                H3
            </button>
            <button type="button" id="{{ $editorId }}-h4" class="editor-btn px-3 py-1.5 text-sm font-semibold bg-white border border-gray-300 rounded hover:bg-gray-100 transition-all" data-type="h4" title="Heading 4">
                H4
            </button>
        </div>

        <!-- Paragraph Formatting -->
        <div class="flex items-center gap-1 border-r border-gray-300 pr-2">
            <button type="button" id="{{ $editorId }}-paragraph" class="editor-btn px-3 py-1.5 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100 transition-all" data-type="p" title="Paragraph">
                P
            </button>
            <button type="button" id="{{ $editorId }}-bold" class="editor-btn px-3 py-1.5 text-sm font-bold bg-white border border-gray-300 rounded hover:bg-gray-100 transition-all" data-style="bold" title="Bold">
                <strong>B</strong>
            </button>
            <button type="button" id="{{ $editorId }}-italic" class="editor-btn px-3 py-1.5 text-sm italic bg-white border border-gray-300 rounded hover:bg-gray-100 transition-all" data-style="italic" title="Italic">
                <em>I</em>
            </button>
            <button type="button" id="{{ $editorId }}-normal" class="editor-btn px-3 py-1.5 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100 transition-all" data-style="normal" title="Normal">
                N
            </button>
        </div>

        <!-- Text Colors -->
        <div class="flex items-center gap-1 border-r border-gray-300 pr-2">
            <button type="button" id="{{ $editorId }}-color-blue" class="editor-btn px-3 py-1.5 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100 transition-all text-blue-600" data-color="text-blue-600" title="Blue Text">
                A
            </button>
            <button type="button" id="{{ $editorId }}-color-gray" class="editor-btn px-3 py-1.5 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100 transition-all text-gray-600" data-color="text-gray-600" title="Gray Text">
                A
            </button>
        </div>

        <!-- Container/Wrapper -->
        <div class="flex items-center gap-1 border-r border-gray-300 pr-2">
            <button type="button" id="{{ $editorId }}-container" class="editor-btn px-3 py-1.5 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100 transition-all" data-type="container" title="Container/Wrapper">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                </svg>
            </button>
        </div>

        <!-- Lists -->
        <div class="flex items-center gap-1 border-r border-gray-300 pr-2">
            <button type="button" id="{{ $editorId }}-ul" class="editor-btn px-3 py-1.5 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100 transition-all" data-type="ul" title="Unordered List">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <button type="button" id="{{ $editorId }}-ol" class="editor-btn px-3 py-1.5 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100 transition-all" data-type="ol" title="Ordered List">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                </svg>
            </button>
        </div>

        <!-- Link -->
        <div class="flex items-center gap-1 border-r border-gray-300 pr-2">
            <button type="button" id="{{ $editorId }}-link" class="editor-btn px-3 py-1.5 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100 transition-all" data-type="link" title="Add Link">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                </svg>
            </button>
        </div>

        <!-- File Upload -->
        <div class="flex items-center gap-1 border-r border-gray-300 pr-2">
            <button type="button" id="{{ $editorId }}-file" class="editor-btn px-3 py-1.5 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100 transition-all" data-type="file" title="Upload File">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
            </button>
        </div>

        <!-- Images -->
        <div class="flex items-center gap-1">
            <button type="button" id="{{ $editorId }}-feature-image" class="editor-btn px-3 py-1.5 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100 transition-all" data-type="feature-image" title="Feature Image">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </button>
            <button type="button" id="{{ $editorId }}-single-image" class="editor-btn px-3 py-1.5 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100 transition-all" data-type="single-image" title="Single Image">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Editor Content Area with Preview -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 p-4 bg-gray-50">
        <!-- Editor -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="bg-gray-100 px-4 py-2 border-b border-gray-200 text-sm font-semibold text-gray-700">
                Editor
            </div>
            <div id="{{ $contentId }}" class="editor-content min-h-[400px] max-h-[600px] p-6 bg-white" contenteditable="true" style="word-wrap: break-word; overflow-x: hidden; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #cbd5e1 #f1f5f9;">
                <!-- Content will be rendered here -->
            </div>
        </div>

        <!-- Live Preview -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="bg-gray-100 px-4 py-2 border-b border-gray-200 text-sm font-semibold text-gray-700">
                Live Preview
            </div>
            <div id="{{ $previewId }}" class="preview-content min-h-[400px] max-h-[600px] p-6 bg-white overflow-y-auto" style="scrollbar-width: thin; scrollbar-color: #cbd5e1 #f1f5f9;">
                <!-- Preview will be rendered here -->
            </div>
        </div>
    </div>

    <!-- Hidden Input for Form Submission -->
    <input type="hidden" id="{{ $hiddenInputId }}" name="{{ $name }}" value="">

    <!-- File Input (Hidden) -->
    <input type="file" id="{{ $editorId }}-file-input" class="hidden" accept="image/*,.pdf,.doc,.docx" multiple>
    <input type="file" id="{{ $editorId }}-image-input" class="hidden" accept="image/*" multiple>
</div>

@push('styles')
<style>
    /* Editor Container */
    #{{ $editorId }} {
        width: 100%;
        max-width: 100%;
        overflow: hidden;
    }
    
    /* Active Button State - Much more visible */
    .editor-btn.active {
        background-color: #0D0DE0 !important;
        color: white !important;
        border-color: #0D0DE0 !important;
        box-shadow: 0 2px 8px rgba(13, 13, 224, 0.3) !important;
        transform: scale(1.05);
        font-weight: 700 !important;
    }
    
    /* Preparation Mode - Button is ready to use for next block */
    .editor-btn.preparing {
        background-color: #3B82F6 !important;
        color: white !important;
        border-color: #3B82F6 !important;
        box-shadow: 0 2px 6px rgba(59, 130, 246, 0.3) !important;
        position: relative;
    }
    
    .editor-btn.preparing::after {
        content: '→';
        position: absolute;
        right: 4px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 10px;
    }
    
    /* Hover effects */
    .editor-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .editor-btn.active:hover,
    .editor-btn.preparing:hover {
        transform: scale(1.05) translateY(-1px);
    }
    
    /* Editor Content Area */
    #{{ $contentId }} {
        word-wrap: break-word;
        overflow-wrap: break-word;
        overflow-x: hidden;
    }
    
    /* Preview Content Area */
    #{{ $previewId }} {
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    
    /* Selected Block Highlight */
    .editor-block.selected {
        outline: 2px solid #0D0DE0;
        outline-offset: 2px;
        background-color: rgba(13, 13, 224, 0.05);
        position: relative;
    }
    
    /* Delete button for blocks */
    .editor-block .block-delete-btn {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 24px;
        height: 24px;
        background-color: #ef4444;
        color: white;
        border: 2px solid white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        opacity: 0;
        transition: opacity 0.2s;
        z-index: 10;
        font-size: 14px;
        font-weight: bold;
    }
    
    .editor-block:hover .block-delete-btn,
    .editor-block.selected .block-delete-btn {
        opacity: 1;
    }
    
    .editor-block .block-delete-btn:hover {
        background-color: #dc2626;
        transform: scale(1.1);
    }
    
    /* Editor Content Styles */
    #{{ $contentId }} [data-type="h1"] {
        @apply text-5xl font-bold mb-4;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    #{{ $contentId }} [data-type="h2"] {
        @apply text-4xl font-bold mb-3;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    #{{ $contentId }} [data-type="h3"] {
        @apply text-3xl font-semibold mb-2;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    #{{ $contentId }} [data-type="h4"] {
        @apply text-2xl font-semibold mb-2;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    #{{ $contentId }} [data-type="p"] {
        @apply text-base mb-4;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    
    /* Style application for paragraphs */
    #{{ $contentId }} [data-type="p"][data-style="bold"] {
        @apply font-bold;
    }
    #{{ $contentId }} [data-type="p"][data-style="italic"] {
        @apply italic;
    }
    
    /* Style application for headings - bold and italic */
    #{{ $contentId }} [data-type="h1"][data-style="bold"],
    #{{ $contentId }} [data-type="h2"][data-style="bold"],
    #{{ $contentId }} [data-type="h3"][data-style="bold"],
    #{{ $contentId }} [data-type="h4"][data-style="bold"] {
        @apply font-bold;
    }
    #{{ $contentId }} [data-type="h1"][data-style="italic"],
    #{{ $contentId }} [data-type="h2"][data-style="italic"],
    #{{ $contentId }} [data-type="h3"][data-style="italic"],
    #{{ $contentId }} [data-type="h4"][data-style="italic"] {
        @apply italic;
    }
    
    /* Color application - works on all text types */
    #{{ $contentId }} [data-type="h1"].text-blue-600,
    #{{ $contentId }} [data-type="h2"].text-blue-600,
    #{{ $contentId }} [data-type="h3"].text-blue-600,
    #{{ $contentId }} [data-type="h4"].text-blue-600,
    #{{ $contentId }} [data-type="p"].text-blue-600 {
        color: #2563eb !important;
    }
    #{{ $contentId }} [data-type="h1"].text-gray-600,
    #{{ $contentId }} [data-type="h2"].text-gray-600,
    #{{ $contentId }} [data-type="h3"].text-gray-600,
    #{{ $contentId }} [data-type="h4"].text-gray-600,
    #{{ $contentId }} [data-type="p"].text-gray-600 {
        color: #4b5563 !important;
    }
    #{{ $contentId }} [data-type="container"] {
        @apply max-w-6xl h-auto border border-gray-600 rounded-xl p-5 mb-4;
        margin-left: auto;
        margin-right: auto;
    }
    #{{ $contentId }} [data-type="ul"],
    #{{ $contentId }} [data-type="ol"] {
        @apply mb-4 ml-6;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    
    #{{ $contentId }} [data-type="ul"] ul,
    #{{ $contentId }} [data-type="ol"] ol {
        outline: none;
        min-height: 1.5rem;
    }
    
    #{{ $contentId }} [data-type="ul"] li {
        @apply list-disc;
        word-wrap: break-word;
        overflow-wrap: break-word;
        outline: none;
        min-height: 1.25rem;
        display: list-item;
        cursor: text;
    }
    
    #{{ $contentId }} [data-type="ul"] li[contenteditable="true"]:focus,
    #{{ $contentId }} [data-type="ol"] li[contenteditable="true"]:focus {
        outline: 1px dashed #0D0DE0;
        outline-offset: 2px;
    }
    
    #{{ $contentId }} [data-type="ol"] li {
        @apply list-decimal;
        word-wrap: break-word;
        overflow-wrap: break-word;
        outline: none;
        min-height: 1.25rem;
        display: list-item;
        cursor: text;
    }
    #{{ $contentId }} [data-type="link"] {
        @apply text-blue-600 underline hover:text-blue-800;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    #{{ $contentId }} [data-type="single-image"] img,
    #{{ $contentId }} [data-type="feature-image"] img {
        @apply max-w-full h-80 object-cover rounded-lg mb-4;
        width: 100%;
    }
    #{{ $contentId }} [data-type="file"] {
        @apply inline-flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200 mb-4;
        word-wrap: break-word;
        overflow-wrap: break-word;
        max-width: 100%;
    }
    
    /* Preview Styles (Same as editor but for preview) */
    #{{ $previewId }} [data-type="h1"] {
        @apply text-5xl font-bold mb-4 text-gray-900;
    }
    #{{ $previewId }} [data-type="h2"] {
        @apply text-4xl font-bold mb-3 text-gray-900;
    }
    #{{ $previewId }} [data-type="h3"] {
        @apply text-3xl font-semibold mb-2 text-gray-900;
    }
    #{{ $previewId }} [data-type="h4"] {
        @apply text-2xl font-semibold mb-2 text-gray-900;
    }
    #{{ $previewId }} [data-type="p"] {
        @apply text-base mb-4 text-gray-700;
    }
    
    /* Style application for paragraphs in preview */
    #{{ $previewId }} [data-type="p"][data-style="bold"] {
        @apply font-bold;
    }
    #{{ $previewId }} [data-type="p"][data-style="italic"] {
        @apply italic;
    }
    
    /* Style application for headings in preview */
    #{{ $previewId }} [data-type="h1"][data-style="bold"],
    #{{ $previewId }} [data-type="h2"][data-style="bold"],
    #{{ $previewId }} [data-type="h3"][data-style="bold"],
    #{{ $previewId }} [data-type="h4"][data-style="bold"] {
        @apply font-bold;
    }
    #{{ $previewId }} [data-type="h1"][data-style="italic"],
    #{{ $previewId }} [data-type="h2"][data-style="italic"],
    #{{ $previewId }} [data-type="h3"][data-style="italic"],
    #{{ $previewId }} [data-type="h4"][data-style="italic"] {
        @apply italic;
    }
    
    /* Color application in preview */
    #{{ $previewId }} [data-type="h1"].text-blue-600,
    #{{ $previewId }} [data-type="h2"].text-blue-600,
    #{{ $previewId }} [data-type="h3"].text-blue-600,
    #{{ $previewId }} [data-type="h4"].text-blue-600,
    #{{ $previewId }} [data-type="p"].text-blue-600 {
        color: #2563eb !important;
    }
    #{{ $previewId }} [data-type="h1"].text-gray-600,
    #{{ $previewId }} [data-type="h2"].text-gray-600,
    #{{ $previewId }} [data-type="h3"].text-gray-600,
    #{{ $previewId }} [data-type="h4"].text-gray-600,
    #{{ $previewId }} [data-type="p"].text-gray-600 {
        color: #4b5563 !important;
    }
    #{{ $previewId }} [data-type="container"] {
        @apply max-w-6xl h-auto border border-gray-600 rounded-xl p-5 mb-4 mx-auto;
    }
    #{{ $previewId }} [data-type="ul"],
    #{{ $previewId }} [data-type="ol"] {
        @apply mb-4 ml-6 text-gray-700;
    }
    #{{ $previewId }} [data-type="ul"] li {
        @apply list-disc;
    }
    #{{ $previewId }} [data-type="ol"] li {
        @apply list-decimal;
    }
    #{{ $previewId }} [data-type="link"] {
        @apply text-blue-600 underline hover:text-blue-800;
    }
    #{{ $previewId }} [data-type="single-image"] img,
    #{{ $previewId }} [data-type="feature-image"] img {
        @apply max-w-full h-80 object-cover rounded-lg mb-4;
        width: 100%;
    }
    #{{ $previewId }} [data-type="file"] {
        @apply inline-flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200 mb-4;
    }
    
    /* Scrollbar Styling */
    .editor-content::-webkit-scrollbar,
    .preview-content::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    .editor-content::-webkit-scrollbar-track,
    .preview-content::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }
    
    .editor-content::-webkit-scrollbar-thumb,
    .preview-content::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    
    .editor-content::-webkit-scrollbar-thumb:hover,
    .preview-content::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endpush

@push('scripts')
<script>
(function() {
    const editorId = '{{ $editorId }}';
    const contentId = '{{ $contentId }}';
    const previewId = '{{ $previewId }}';
    const hiddenInputId = '{{ $hiddenInputId }}';
    const contentArea = document.getElementById(contentId);
    const previewArea = document.getElementById(previewId);
    const hiddenInput = document.getElementById(hiddenInputId);
    
    let blockCounter = 0;
    let selectedBlocks = new Set();
    let isMultiSelect = false;
    
    // Next format state - applies to new blocks
    let nextFormat = {
        type: null,
        style: null,
        color: null
    };
    
    // Expose updateContent function globally for form editing
    window['updateEditorContent_' + editorId] = function(content) {
        if (Array.isArray(content)) {
            renderContent(content);
        } else if (content) {
            try {
                const parsed = JSON.parse(content);
                if (Array.isArray(parsed)) {
                    renderContent(parsed);
                }
            } catch (e) {
                console.error('Invalid editor content:', e);
            }
        }
    };
    
    // Initialize with existing content if any
    @if($value)
        const existingContent = @json($value);
        if (Array.isArray(existingContent)) {
            renderContent(existingContent);
        }
    @endif
    
    // Initialize format indicator
    updateFormatIndicator();
    
    // Handle block selection
    contentArea.addEventListener('click', function(e) {
        const block = e.target.closest('.editor-block');
        if (!block) return;
        
        if (e.ctrlKey || e.metaKey) {
            // Multi-select
            isMultiSelect = true;
            if (selectedBlocks.has(block)) {
                selectedBlocks.delete(block);
                block.classList.remove('selected');
            } else {
                selectedBlocks.add(block);
                block.classList.add('selected');
            }
        } else {
            // Single select
            isMultiSelect = false;
            selectedBlocks.forEach(b => b.classList.remove('selected'));
            selectedBlocks.clear();
            selectedBlocks.add(block);
            block.classList.add('selected');
        }
        
        updateActiveButtons();
        e.stopPropagation();
    });
    
    // Click outside to deselect
    document.addEventListener('click', function(e) {
        if (!contentArea.contains(e.target)) {
            selectedBlocks.forEach(b => b.classList.remove('selected'));
            selectedBlocks.clear();
            updateActiveButtons();
        }
    });
    
    // Update format indicator
    function updateFormatIndicator() {
        const indicator = document.getElementById(editorId + '-format-indicator');
        const formatText = document.getElementById(editorId + '-format-text');
        const parts = [];
        
        if (nextFormat.type) {
            parts.push(nextFormat.type.toUpperCase());
        }
        if (nextFormat.style) {
            parts.push(nextFormat.style);
        }
        if (nextFormat.color) {
            const colorName = nextFormat.color === 'text-blue-600' ? 'Blue' : 
                            nextFormat.color === 'text-gray-600' ? 'Gray' : 'Custom';
            parts.push(colorName);
        }
        
        if (parts.length > 0) {
            formatText.textContent = parts.join(' + ');
            indicator.classList.remove('hidden');
        } else {
            formatText.textContent = 'None';
            indicator.classList.add('hidden');
        }
    }
    
    // Update active button states - shows both active (selected blocks) and preparing (next format)
    function updateActiveButtons() {
        const buttons = document.querySelectorAll(`#{{ $toolbarId }} .editor-btn`);
        buttons.forEach(btn => {
            btn.classList.remove('active', 'preparing');
        });
        
        // Show active state for selected blocks
        if (selectedBlocks.size > 0) {
            selectedBlocks.forEach(block => {
                const type = block.getAttribute('data-type');
                const style = block.getAttribute('data-style');
                const color = block.getAttribute('data-color');
                
                // Update type buttons
                if (type) {
                    const typeBtn = document.querySelector(`#{{ $toolbarId }} .editor-btn[data-type="${type}"]`);
                    if (typeBtn) typeBtn.classList.add('active');
                }
                
                // Update style buttons
                if (style) {
                    const styleBtn = document.querySelector(`#{{ $toolbarId }} .editor-btn[data-style="${style}"]`);
                    if (styleBtn) styleBtn.classList.add('active');
                }
                
                // Update color buttons
                if (color) {
                    const colorBtn = document.querySelector(`#{{ $toolbarId }} .editor-btn[data-color="${color}"]`);
                    if (colorBtn) colorBtn.classList.add('active');
                }
            });
        }
        
        // Show preparing state for next format (only when no blocks selected)
        if (selectedBlocks.size === 0) {
            if (nextFormat.type) {
                const typeBtn = document.querySelector(`#{{ $toolbarId }} .editor-btn[data-type="${nextFormat.type}"]`);
                if (typeBtn) typeBtn.classList.add('preparing');
            }
            
            if (nextFormat.style) {
                const styleBtn = document.querySelector(`#{{ $toolbarId }} .editor-btn[data-style="${nextFormat.style}"]`);
                if (styleBtn) styleBtn.classList.add('preparing');
            }
            
            if (nextFormat.color) {
                const colorBtn = document.querySelector(`#{{ $toolbarId }} .editor-btn[data-color="${nextFormat.color}"]`);
                if (colorBtn) colorBtn.classList.add('preparing');
            }
        }
        
        updateFormatIndicator();
    }
    
    // Helper function to handle type button clicks with toggle
    function handleTypeButton(type) {
        if (selectedBlocks.size > 0) {
            // Check if all selected blocks already have this type - if so, toggle off
            let allSameType = true;
            selectedBlocks.forEach(block => {
                if (block.getAttribute('data-type') !== type) {
                    allSameType = false;
                }
            });
            
            if (allSameType && selectedBlocks.size > 0) {
                // Toggle off - change to paragraph
                selectedBlocks.forEach(block => {
                    block.setAttribute('data-type', 'p');
                    updatePreview();
                });
                updateHiddenInput();
                updateActiveButtons();
            } else {
                // Apply type to selected blocks
                selectedBlocks.forEach(block => {
                    block.setAttribute('data-type', type);
                    updatePreview();
                });
                updateHiddenInput();
                updateActiveButtons();
            }
        } else {
            // Create new block with accumulated format
            nextFormat.type = type;
            nextFormat.style = null; // Reset style when changing type
            insertBlock(type, '', nextFormat.style, nextFormat.color);
            updateActiveButtons();
        }
    }
    
    // Toolbar button handlers - Updated to support preparation mode
    document.getElementById(editorId + '-h1').addEventListener('click', () => handleTypeButton('h1'));
    document.getElementById(editorId + '-h2').addEventListener('click', () => handleTypeButton('h2'));
    document.getElementById(editorId + '-h3').addEventListener('click', () => handleTypeButton('h3'));
    document.getElementById(editorId + '-h4').addEventListener('click', () => handleTypeButton('h4'));
    document.getElementById(editorId + '-paragraph').addEventListener('click', () => handleTypeButton('p'));
    
    document.getElementById(editorId + '-bold').addEventListener('click', () => applyStyle('bold'));
    document.getElementById(editorId + '-italic').addEventListener('click', () => applyStyle('italic'));
    document.getElementById(editorId + '-normal').addEventListener('click', () => applyStyle('normal'));
    document.getElementById(editorId + '-color-blue').addEventListener('click', () => applyColor('text-blue-600'));
    document.getElementById(editorId + '-color-gray').addEventListener('click', () => applyColor('text-gray-600'));
    document.getElementById(editorId + '-container').addEventListener('click', () => insertBlock('container', ''));
    document.getElementById(editorId + '-ul').addEventListener('click', () => insertBlock('ul', []));
    document.getElementById(editorId + '-ol').addEventListener('click', () => insertBlock('ol', []));
    document.getElementById(editorId + '-link').addEventListener('click', () => insertLink());
    document.getElementById(editorId + '-file').addEventListener('click', () => document.getElementById(editorId + '-file-input').click());
    document.getElementById(editorId + '-feature-image').addEventListener('click', () => {
        document.getElementById(editorId + '-image-input').setAttribute('data-image-type', 'feature');
        document.getElementById(editorId + '-image-input').click();
    });
    document.getElementById(editorId + '-single-image').addEventListener('click', () => {
        document.getElementById(editorId + '-image-input').setAttribute('data-image-type', 'single');
        document.getElementById(editorId + '-image-input').removeAttribute('multiple');
        document.getElementById(editorId + '-image-input').click();
    });
    
    // File upload handler
    document.getElementById(editorId + '-file-input').addEventListener('change', function(e) {
        handleFileUpload(e.target.files, 'file');
    });
    
    // Image upload handler
    document.getElementById(editorId + '-image-input').addEventListener('change', function(e) {
        const imageType = this.getAttribute('data-image-type');
        handleImageUpload(e.target.files, imageType);
    });
    
    function applyStyle(style) {
        if (selectedBlocks.size > 0) {
            // Check if all selected blocks already have this style - if so, toggle off
            let allSameStyle = true;
            selectedBlocks.forEach(block => {
                const blockType = block.getAttribute('data-type');
                if ((blockType === 'p' || blockType === 'h1' || blockType === 'h2' || blockType === 'h3' || blockType === 'h4') 
                    && block.getAttribute('data-style') !== style) {
                    allSameStyle = false;
                }
            });
            
            if (allSameStyle && selectedBlocks.size > 0) {
                // Toggle off - remove style
                selectedBlocks.forEach(block => {
                    const blockType = block.getAttribute('data-type');
                    if (blockType === 'p' || blockType === 'h1' || blockType === 'h2' || blockType === 'h3' || blockType === 'h4') {
                        block.removeAttribute('data-style');
                        updatePreview();
                    }
                });
                updateHiddenInput();
                updateActiveButtons();
            } else {
                // Apply style to selected blocks
                selectedBlocks.forEach(block => {
                    const blockType = block.getAttribute('data-type');
                    // Apply style to paragraphs and headings
                    if (blockType === 'p' || blockType === 'h1' || blockType === 'h2' || blockType === 'h3' || blockType === 'h4') {
                        block.setAttribute('data-style', style);
                        updatePreview();
                    }
                });
                updateHiddenInput();
                updateActiveButtons();
            }
        } else {
            // Set as next format for new blocks
            // Toggle nextFormat style if same
            if (nextFormat.style === style) {
                nextFormat.style = null;
            } else {
                nextFormat.style = style;
            }
            // If no type selected, default to paragraph
            if (!nextFormat.type) {
                nextFormat.type = 'p';
            }
            insertBlock(nextFormat.type, '', nextFormat.style, nextFormat.color);
            updateActiveButtons();
        }
    }
    
    function applyColor(color) {
        if (selectedBlocks.size > 0) {
            // Check if all selected blocks already have this color - if so, toggle off
            let allSameColor = true;
            selectedBlocks.forEach(block => {
                const blockType = block.getAttribute('data-type');
                if ((blockType === 'p' || blockType === 'h1' || blockType === 'h2' || blockType === 'h3' || blockType === 'h4' || blockType === 'container') 
                    && block.getAttribute('data-color') !== color) {
                    allSameColor = false;
                }
            });
            
            if (allSameColor && selectedBlocks.size > 0) {
                // Toggle off - remove color
                selectedBlocks.forEach(block => {
                    const blockType = block.getAttribute('data-type');
                    if (blockType === 'p' || blockType === 'h1' || blockType === 'h2' || blockType === 'h3' || blockType === 'h4' || blockType === 'container') {
                        block.removeAttribute('data-color');
                        block.className = block.className.replace(/text-\w+-\d+/g, '');
                        updatePreview();
                    }
                });
                updateHiddenInput();
                updateActiveButtons();
            } else {
                // Apply color to selected blocks
                selectedBlocks.forEach(block => {
                    const blockType = block.getAttribute('data-type');
                    // Apply color to paragraphs, headings, and containers
                    if (blockType === 'p' || blockType === 'h1' || blockType === 'h2' || blockType === 'h3' || blockType === 'h4' || blockType === 'container') {
                        block.setAttribute('data-color', color);
                        block.className = block.className.replace(/text-\w+-\d+/g, '');
                        block.classList.add(color);
                        updatePreview();
                    }
                });
                updateHiddenInput();
                updateActiveButtons();
            }
        } else {
            // Set as next format for new blocks - toggle if same
            if (nextFormat.color === color) {
                nextFormat.color = null;
            } else {
                nextFormat.color = color;
            }
            // If no type selected, default to paragraph
            if (!nextFormat.type) {
                nextFormat.type = 'p';
            }
            insertBlock(nextFormat.type, '', nextFormat.style, nextFormat.color);
            updateActiveButtons();
        }
    }
    
    function insertBlock(type, content, style = null, color = null) {
        // Use nextFormat if provided, otherwise use parameters
        const blockType = type || nextFormat.type || 'p';
        const blockStyle = style !== null ? style : nextFormat.style;
        const blockColor = color !== null ? color : nextFormat.color;
        
        const blockId = 'block-' + blockCounter++;
        const block = document.createElement('div');
        block.id = blockId;
        block.className = 'editor-block mb-4';
        block.setAttribute('data-type', blockType);
        block.setAttribute('contenteditable', 'true');
        
        // Apply style
        if (blockStyle) {
            block.setAttribute('data-style', blockStyle);
        }
        
        // Apply color
        if (blockColor) {
            block.setAttribute('data-color', blockColor);
            block.classList.add(blockColor);
        }
        
        // Set content based on type
        if (blockType === 'h1' || blockType === 'h2' || blockType === 'h3' || blockType === 'h4') {
            block.textContent = content || 'Enter ' + blockType.toUpperCase();
        } else if (blockType === 'p') {
            block.textContent = content || 'Enter paragraph text';
        } else if (blockType === 'container') {
            block.textContent = 'Container content - Add elements inside';
            block.style.cursor = 'pointer';
        } else if (blockType === 'ul' || blockType === 'ol') {
            block.setAttribute('contenteditable', 'false');
            const list = document.createElement(blockType);
            list.setAttribute('contenteditable', 'true');
            
            // Create editable list items
            const li1 = document.createElement('li');
            li1.setAttribute('contenteditable', 'true');
            li1.textContent = 'List item 1';
            
            const li2 = document.createElement('li');
            li2.setAttribute('contenteditable', 'true');
            li2.textContent = 'List item 2';
            
            list.appendChild(li1);
            list.appendChild(li2);
            
            // Add event listener to handle Enter key for new list items
            list.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    const selection = window.getSelection();
                    if (selection.rangeCount === 0) return;
                    
                    const range = selection.getRangeAt(0);
                    const currentLi = range.commonAncestorContainer.nodeType === Node.TEXT_NODE 
                        ? range.commonAncestorContainer.parentElement 
                        : range.commonAncestorContainer;
                    
                    if (currentLi && currentLi.tagName === 'LI') {
                        const newLi = document.createElement('li');
                        newLi.setAttribute('contenteditable', 'true');
                        newLi.textContent = '';
                        
                        if (currentLi.nextSibling) {
                            list.insertBefore(newLi, currentLi.nextSibling);
                        } else {
                            list.appendChild(newLi);
                        }
                        
                        setTimeout(() => {
                            newLi.focus();
                            const newRange = document.createRange();
                            newRange.setStart(newLi, 0);
                            newRange.setEnd(newLi, 0);
                            selection.removeAllRanges();
                            selection.addRange(newRange);
                        }, 10);
                    }
                }
            });
            
            block.appendChild(list);
        }
        
        // Add delete button to block
        addDeleteButton(block);
        
        contentArea.appendChild(block);
        
        // Select the new block immediately and ensure it's in the set
        selectedBlocks.forEach(b => {
            b.classList.remove('selected');
        });
        selectedBlocks.clear();
        selectedBlocks.add(block);
        block.classList.add('selected');
        
        // Focus and ensure selection is maintained
        setTimeout(() => {
            block.focus();
            // Re-select in case it was lost
            if (!selectedBlocks.has(block)) {
                selectedBlocks.add(block);
                block.classList.add('selected');
            }
            updateActiveButtons();
        }, 10);
        
        // Reset nextFormat after creating block (but preserve style/color for next block)
        // Keep style and color, reset type only
        nextFormat.type = null;
        
        updateActiveButtons();
        updatePreview();
        updateHiddenInput();
    }
    
    // Function to add delete button to a block
    function addDeleteButton(block) {
        // Remove existing delete button if any
        const existingBtn = block.querySelector('.block-delete-btn');
        if (existingBtn) {
            existingBtn.remove();
        }
        
        const deleteBtn = document.createElement('button');
        deleteBtn.type = 'button';
        deleteBtn.className = 'block-delete-btn';
        deleteBtn.innerHTML = '×';
        deleteBtn.title = 'Delete block';
        deleteBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            deleteBlock(block);
        });
        block.appendChild(deleteBtn);
    }
    
    // Function to delete a block
    function deleteBlock(block) {
        if (selectedBlocks.has(block)) {
            selectedBlocks.delete(block);
        }
        block.remove();
        updatePreview();
        updateHiddenInput();
        updateActiveButtons();
    }
    
    function insertLink() {
        const url = prompt('Enter URL:');
        const text = prompt('Enter link text:', url);
        if (url && text) {
            const blockId = 'block-' + blockCounter++;
            const block = document.createElement('div');
            block.id = blockId;
            block.className = 'editor-block mb-4';
            block.setAttribute('data-type', 'link');
            block.innerHTML = `<a href="${url}" target="_blank">${text}</a>`;
            addDeleteButton(block);
            contentArea.appendChild(block);
            updatePreview();
            updateHiddenInput();
        }
    }
    
    function handleFileUpload(files, type) {
        Array.from(files).forEach(file => {
            const formData = new FormData();
            formData.append('file', file);
            formData.append('_token', '{{ csrf_token() }}');
            
            fetch('{{ route("admin.upload-file") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    insertFileBlock(data.url, file.name, type);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }
    
    function handleImageUpload(files, imageType) {
        const formData = new FormData();
        Array.from(files).forEach(file => {
            formData.append('images[]', file);
        });
        formData.append('_token', '{{ csrf_token() }}');
        
        fetch('{{ route("admin.upload-images") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.urls.length > 0) {
                insertImageBlock(data.urls[0], imageType);
            }
        })
        .catch(error => console.error('Error:', error));
    }
    
    function insertFileBlock(url, filename, type) {
        const blockId = 'block-' + blockCounter++;
        const block = document.createElement('div');
        block.id = blockId;
        block.className = 'editor-block mb-4';
        block.setAttribute('data-type', 'file');
        block.innerHTML = `
            <a href="${url}" download="${filename}" class="inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                <span>${filename}</span>
            </a>
        `;
        addDeleteButton(block);
        contentArea.appendChild(block);
        updatePreview();
        updateHiddenInput();
    }
    
    function insertImageBlock(url, type) {
        const blockId = 'block-' + blockCounter++;
        const block = document.createElement('div');
        block.id = blockId;
        block.className = 'editor-block mb-4';
        block.setAttribute('data-type', type === 'feature' ? 'feature-image' : 'single-image');
        block.innerHTML = `<img src="${url}" alt="Image" class="max-w-full h-80 object-cover rounded-lg">`;
        addDeleteButton(block);
        contentArea.appendChild(block);
        updatePreview();
        updateHiddenInput();
    }
    
    
    
    
    function updatePreview() {
        const blocks = contentArea.querySelectorAll('.editor-block');
        previewArea.innerHTML = '';
        
        blocks.forEach(block => {
            const previewBlock = block.cloneNode(true);
            previewBlock.classList.remove('selected', 'editor-block');
            previewBlock.setAttribute('contenteditable', 'false');
            
            // Remove delete button from preview
            const deleteBtn = previewBlock.querySelector('.block-delete-btn');
            if (deleteBtn) {
                deleteBtn.remove();
            }
            
            // Ensure all attributes are copied (data-type, data-style, data-color, classes)
            const type = block.getAttribute('data-type');
            const style = block.getAttribute('data-style');
            const color = block.getAttribute('data-color');
            
            if (type) previewBlock.setAttribute('data-type', type);
            if (style) previewBlock.setAttribute('data-style', style);
            if (color) {
                previewBlock.setAttribute('data-color', color);
                previewBlock.classList.add(color);
            }
            
            // Ensure classes are copied for proper styling
            block.classList.forEach(cls => {
                if (cls.startsWith('text-') || cls === 'font-bold' || cls === 'italic') {
                    previewBlock.classList.add(cls);
                }
            });
            
            previewArea.appendChild(previewBlock);
        });
    }
    
    function renderContent(content) {
        contentArea.innerHTML = '';
        content.forEach(block => {
            const blockEl = document.createElement('div');
            blockEl.className = 'editor-block mb-4';
            blockEl.setAttribute('data-type', block.type);
            blockEl.setAttribute('contenteditable', block.type !== 'file' && block.type !== 'feature-image' && block.type !== 'single-image' && block.type !== 'ul' && block.type !== 'ol');
            
            if (block.style) {
                blockEl.setAttribute('data-style', block.style);
            }
            if (block.color) {
                blockEl.setAttribute('data-color', block.color);
                blockEl.classList.add(block.color);
            }
            
            switch(block.type) {
                case 'h1':
                case 'h2':
                case 'h3':
                case 'h4':
                case 'p':
                case 'container':
                    blockEl.textContent = block.content || '';
                    break;
                case 'ul':
                case 'ol':
                    blockEl.setAttribute('contenteditable', 'false');
                    const list = document.createElement(block.type);
                    list.setAttribute('contenteditable', 'true');
                    
                    if (Array.isArray(block.content) && block.content.length > 0) {
                        block.content.forEach(item => {
                            const li = document.createElement('li');
                            li.setAttribute('contenteditable', 'true');
                            // Preserve HTML formatting if present
                            li.innerHTML = item || '';
                            list.appendChild(li);
                        });
                    } else {
                        // Create default empty list items if no content
                        const li1 = document.createElement('li');
                        li1.setAttribute('contenteditable', 'true');
                        li1.textContent = 'List item 1';
                        const li2 = document.createElement('li');
                        li2.setAttribute('contenteditable', 'true');
                        li2.textContent = 'List item 2';
                        list.appendChild(li1);
                        list.appendChild(li2);
                    }
                    
                    // Add event listener to handle Enter key for new list items
                    list.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' && !e.shiftKey) {
                            e.preventDefault();
                            const selection = window.getSelection();
                            if (selection.rangeCount === 0) return;
                            
                            const range = selection.getRangeAt(0);
                            const currentLi = range.commonAncestorContainer.nodeType === Node.TEXT_NODE 
                                ? range.commonAncestorContainer.parentElement 
                                : range.commonAncestorContainer;
                            
                            if (currentLi && currentLi.tagName === 'LI') {
                                const newLi = document.createElement('li');
                                newLi.setAttribute('contenteditable', 'true');
                                newLi.textContent = '';
                                
                                if (currentLi.nextSibling) {
                                    list.insertBefore(newLi, currentLi.nextSibling);
                                } else {
                                    list.appendChild(newLi);
                                }
                                
                                setTimeout(() => {
                                    newLi.focus();
                                    const newRange = document.createRange();
                                    newRange.setStart(newLi, 0);
                                    newRange.setEnd(newLi, 0);
                                    selection.removeAllRanges();
                                    selection.addRange(newRange);
                                }, 10);
                            }
                        }
                    });
                    
                    blockEl.appendChild(list);
                    break;
                case 'link':
                    blockEl.innerHTML = `<a href="${block.url}" target="_blank">${block.content}</a>`;
                    break;
                case 'file':
                    blockEl.innerHTML = `<a href="${block.url}" download="${block.filename}">${block.filename}</a>`;
                    break;
                case 'feature-image':
                case 'single-image':
                    blockEl.innerHTML = `<img src="${block.url}" alt="Image" class="max-w-full h-80 object-cover rounded-lg">`;
                    break;
            }
            
            // Add delete button to loaded blocks
            addDeleteButton(blockEl);
            
            contentArea.appendChild(blockEl);
        });
        updatePreview();
        updateHiddenInput();
    }
    
    function updateHiddenInput() {
        const blocks = contentArea.querySelectorAll('.editor-block');
        const content = [];
        
        blocks.forEach(block => {
            const type = block.getAttribute('data-type');
            const style = block.getAttribute('data-style');
            const color = block.getAttribute('data-color');
            const blockData = { type };
            
            if (style) {
                blockData.style = style;
            }
            if (color) {
                blockData.color = color;
            }
            
            switch(type) {
                case 'h1':
                case 'h2':
                case 'h3':
                case 'h4':
                case 'p':
                case 'container':
                    blockData.content = block.textContent.trim();
                    break;
                case 'ul':
                case 'ol':
                    const items = Array.from(block.querySelectorAll('li')).map(li => {
                        // Preserve HTML formatting if present
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = li.innerHTML;
                        const deleteBtn = tempDiv.querySelector('.block-delete-btn');
                        if (deleteBtn) deleteBtn.remove();
                        return tempDiv.innerHTML.trim();
                    });
                    blockData.content = items;
                    break;
                case 'link':
                    const link = block.querySelector('a');
                    blockData.url = link.href;
                    blockData.content = link.textContent.trim();
                    break;
                case 'file':
                    const fileLink = block.querySelector('a');
                    blockData.url = fileLink.href;
                    blockData.filename = fileLink.textContent.trim();
                    break;
                case 'feature-image':
                case 'single-image':
                    const img = block.querySelector('img');
                    blockData.url = img.src;
                    break;
            }
            
            content.push(blockData);
        });
        
        hiddenInput.value = JSON.stringify(content);
    }
    
    // Update on content change
    contentArea.addEventListener('input', function() {
        updatePreview();
        updateHiddenInput();
    });
    
    contentArea.addEventListener('paste', function(e) {
        e.preventDefault();
        const text = (e.clipboardData || window.clipboardData).getData('text');
        document.execCommand('insertText', false, text);
        updatePreview();
        updateHiddenInput();
    });
})();
</script>
@endpush
