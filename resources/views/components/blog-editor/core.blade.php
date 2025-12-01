@php
    $editorId = $editorId ?? 'blog-editor';
@endphp

(function() {
    'use strict';
    
    const editorId = '{{ $editorId }}';
    const funcs = window.blogEditorFunctions[editorId];
    if (!funcs) return;
    
    const { contentArea, state } = funcs;
    
    // Block counter increment
    function getNextBlockId() {
        return 'block-' + (state.blockCounter++);
    }
    
    // Make available globally
    window.blogEditorCore = window.blogEditorCore || {};
    window.blogEditorCore[editorId] = {
        getNextBlockId
    };
})();

