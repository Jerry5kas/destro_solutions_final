@php
    $editorId = $editorId ?? 'blog-editor';
@endphp

(function() {
    'use strict';
    
    const editorId = '{{ $editorId }}';
    const funcs = window.blogEditorFunctions[editorId];
    if (!funcs) return;
    
    // Formatting functions are handled in toolbar.blade.php
    // This file can be used for additional formatting utilities if needed
    
    window.blogEditorFormatting = window.blogEditorFormatting || {};
    window.blogEditorFormatting[editorId] = {};
})();

