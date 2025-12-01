@php
    $editorId = $editorId ?? 'blog-editor';
    $hasPreview = $hasPreview ?? true;
@endphp

<script>
(function() {
    'use strict';
    
    const editorId = '{{ $editorId }}';
    const contentId = editorId + '-content';
    const previewId = editorId + '-preview';
    const hiddenInputId = editorId + '-hidden-input';
    const hasPreview = {{ $hasPreview ? 'true' : 'false' }};
    const initialContentRaw = @json($value ?? null);
    
    const contentArea = document.getElementById(contentId);
    const previewArea = hasPreview ? document.getElementById(previewId) : null;
    const hiddenInput = document.getElementById(hiddenInputId);
    
    if (!contentArea || !hiddenInput) {
        console.error('Blog editor elements not found');
        return;
    }
    
    // Global editor state
    window.blogEditorState = window.blogEditorState || {};
    window.blogEditorState[editorId] = {
        blockCounter: 0,
        selectedBlocks: new Set(),
        wordWrap: false,
        nextFormat: {
            type: null,
            style: null,
            color: null,
            align: null,
            valign: null,
            spacing: null,
            size: null
        }
    };
    
    const state = window.blogEditorState[editorId];
    
    // Expose update function globally
    window['updateBlogEditor_' + editorId] = function(content) {
        hydrateInitialContent(content);
    };
    
    // Prepare global references for modular scripts
    window.blogEditorFunctions = window.blogEditorFunctions || {};
    window.blogEditorFunctions[editorId] = {
        contentArea,
        previewArea,
        hiddenInput,
        state,
        updatePreviewAndHidden,
        clearSelection,
        handleBlockClick
    };
    
    // Include modular scripts (depend on blogEditorFunctions)
    @include('components.blog-editor.core', ['editorId' => $editorId])
    @include('components.blog-editor.toolbar', ['editorId' => $editorId])
    @include('components.blog-editor.blocks', ['editorId' => $editorId])
    @include('components.blog-editor.formatting', ['editorId' => $editorId])
    @include('components.blog-editor.media', ['editorId' => $editorId])
    @include('components.blog-editor.preview', ['editorId' => $editorId])
    
    // Hydrate existing content after modules are loaded
    hydrateInitialContent(initialContentRaw);
    
    // Initialize editor
    initializeEditor();
    setupPreviewBindings();
    
    function initializeEditor() {
        // Set up content change listeners
        contentArea.addEventListener('input', updatePreviewAndHidden);
        contentArea.addEventListener('paste', handlePaste);
        
        // Set up block selection
        contentArea.addEventListener('click', handleBlockClick);
        
        // Click outside to deselect
        document.addEventListener('click', function(e) {
            if (!contentArea.contains(e.target)) {
                clearSelection();
            }
        });
        
        // Keyboard shortcuts
        contentArea.addEventListener('keydown', handleKeyboard);
        
        // Clear button
        const clearBtn = document.getElementById(editorId + '-clear-btn');
        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to clear all content?')) {
                    contentArea.innerHTML = '';
                    updatePreviewAndHidden();
                }
            });
        }
        
        // Preview toggle
        const previewToggle = document.getElementById(editorId + '-preview-toggle');
        if (previewToggle && previewArea) {
            previewToggle.addEventListener('click', function() {
                const previewWrapper = previewArea.closest('.blog-editor-preview-wrapper');
                if (previewWrapper) {
                    previewWrapper.style.display = previewWrapper.style.display === 'none' ? 'flex' : 'none';
                }
            });
        }
    }
    
    function handlePaste(e) {
        e.preventDefault();
        const text = (e.clipboardData || window.clipboardData).getData('text/plain');
        document.execCommand('insertText', false, text);
        updatePreviewAndHidden();
    }
    
    function handleKeyboard(e) {
        // Ctrl+B for bold
        if (e.ctrlKey && e.key === 'b') {
            e.preventDefault();
            applyFormatting('bold');
        }
        // Ctrl+I for italic
        if (e.ctrlKey && e.key === 'i') {
            e.preventDefault();
            applyFormatting('italic');
        }
        // Ctrl+U for underline
        if (e.ctrlKey && e.key === 'u') {
            e.preventDefault();
            applyFormatting('underline');
        }
        // Delete key for selected blocks
        if (e.key === 'Delete' && state.selectedBlocks.size > 0) {
            e.preventDefault();
            state.selectedBlocks.forEach(block => {
                if (typeof deleteBlock === 'function') {
                    deleteBlock(block);
                }
            });
            state.selectedBlocks.clear();
        }
    }
    
    function updatePreviewAndHidden() {
        if (typeof updatePreview === 'function') {
            updatePreview();
        }
        if (typeof updateHiddenInput === 'function') {
            updateHiddenInput();
        }
    }
    
    function handleBlockClick(e) {
        const block = e.target.closest('.editor-block');
        if (!block) return;
        
        if (e.ctrlKey || e.metaKey) {
            // Multi-select
            if (state.selectedBlocks.has(block)) {
                state.selectedBlocks.delete(block);
                block.classList.remove('selected');
            } else {
                state.selectedBlocks.add(block);
                block.classList.add('selected');
            }
        } else {
            // Single select
            clearSelection();
            state.selectedBlocks.add(block);
            block.classList.add('selected');
        }
        
        if (typeof updateToolbarState === 'function') {
            updateToolbarState();
        }
        
        e.stopPropagation();
    }
    
    function clearSelection() {
        state.selectedBlocks.forEach(b => b.classList.remove('selected'));
        state.selectedBlocks.clear();
    }
    
    function hydrateInitialContent(rawContent) {
        if (!rawContent) {
            hiddenInput.value = '[]';
            return;
        }
        
        let parsed = rawContent;
        if (typeof rawContent === 'string') {
            try {
                parsed = JSON.parse(rawContent);
            } catch (error) {
                console.error('Unable to parse editor content:', error);
                return;
            }
        }
        
        if (Array.isArray(parsed)) {
            if (typeof renderContent === 'function') {
                renderContent(parsed);
                hiddenInput.value = JSON.stringify(parsed);
            }
        }
    }
    function setupPreviewBindings() {
        const wrapper = document.getElementById(editorId);
        if (!wrapper) return;

        const titleFieldId = wrapper.dataset.titleField;
        const categoryFieldId = wrapper.dataset.categoryField;
        const dateFieldId = wrapper.dataset.dateField;
        const initialBanner = wrapper.dataset.banner;

        const titleEl = titleFieldId ? document.getElementById(titleFieldId) : null;
        const categoryEl = categoryFieldId ? document.getElementById(categoryFieldId) : null;
        const dateEl = dateFieldId ? document.getElementById(dateFieldId) : null;

        const previewTitle = document.getElementById(editorId + '-preview-title');
        const previewCategory = document.getElementById(editorId + '-preview-category');
        const previewDate = document.getElementById(editorId + '-preview-date');
        const previewBanner = document.getElementById(editorId + '-preview-banner');

        const syncTitle = () => {
            if (!previewTitle) return;
            const value = titleEl?.value?.trim();
            previewTitle.textContent = value || 'Untitled blog post';
        };

        const syncCategory = () => {
            if (!previewCategory) return;
            if (!categoryEl) {
                previewCategory.textContent = 'Uncategorized';
                return;
            }
            const selected = categoryEl.options[categoryEl.selectedIndex];
            previewCategory.textContent = selected ? selected.text : 'Uncategorized';
        };

        const syncDate = () => {
            if (!previewDate) return;
            if (!dateEl || !dateEl.value) {
                previewDate.textContent = '';
                return;
            }
            const parsed = new Date(dateEl.value);
            if (isNaN(parsed.getTime())) {
                previewDate.textContent = '';
                return;
            }
            previewDate.textContent = new Intl.DateTimeFormat(undefined, {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            }).format(parsed);
        };

        const setBanner = (url) => {
            if (!previewBanner) return;
            if (url) {
                previewBanner.style.setProperty('--preview-banner-image', `url('${url}')`);
                previewBanner.classList.add('has-image');
            } else {
                previewBanner.style.removeProperty('--preview-banner-image');
                previewBanner.classList.remove('has-image');
            }
        };

        if (titleEl) {
            titleEl.addEventListener('input', syncTitle);
        }
        if (categoryEl) {
            categoryEl.addEventListener('change', syncCategory);
        }
        if (dateEl) {
            dateEl.addEventListener('change', syncDate);
        }

        syncTitle();
        syncCategory();
        syncDate();
        if (initialBanner) {
            setBanner(initialBanner);
        }

        document.addEventListener('blog-banner-updated', function(event) {
            if (event.detail?.editorId === editorId) {
                setBanner(event.detail.url);
            }
        });
    }
})();
</script>

