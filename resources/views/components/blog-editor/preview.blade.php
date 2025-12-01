@php
    $editorId = $editorId ?? 'blog-editor';
@endphp

(function() {
    'use strict';
    
    const editorId = '{{ $editorId }}';
    const funcs = window.blogEditorFunctions[editorId];
    if (!funcs) return;
    
    const { contentArea, previewArea, hiddenInput } = funcs;
    const hasPreview = Boolean(previewArea);
    
    // Update preview
    window.updatePreview = function() {
        if (!hasPreview) {
            return;
        }
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
            
            // Remove grid editor buttons from preview
            const gridAddBtn = previewBlock.querySelector('.grid-add-image');
            if (gridAddBtn) {
                gridAddBtn.remove();
            }
            const gridRemoveBtns = previewBlock.querySelectorAll('.grid-item-remove');
            gridRemoveBtns.forEach(btn => btn.remove());
            
            // Remove slider editor buttons from preview
            const sliderAddBtn = previewBlock.querySelector('.slider-add-image');
            if (sliderAddBtn) {
                sliderAddBtn.remove();
            }
            const sliderRemoveBtns = previewBlock.querySelectorAll('.slider-item-remove');
            sliderRemoveBtns.forEach(btn => btn.remove());
            
            // Ensure all attributes are copied
            const attrs = ['data-type', 'data-style', 'data-color', 'data-align', 'data-valign', 'data-spacing', 'data-size'];
            attrs.forEach(attr => {
                const value = block.getAttribute(attr);
                if (value) {
                    previewBlock.setAttribute(attr, value);
                }
            });
            
            // Copy color classes
            block.classList.forEach(cls => {
                if (cls.startsWith('text-')) {
                    previewBlock.classList.add(cls);
                }
            });
            
            previewArea.appendChild(previewBlock);
        });
    };
    
    // Update hidden input
    window.updateHiddenInput = function() {
        const blocks = contentArea.querySelectorAll('.editor-block');
        const content = [];
        
        blocks.forEach(block => {
            const type = block.getAttribute('data-type');
            const blockData = { type };
            
            // Add optional attributes
            const style = block.getAttribute('data-style');
            if (style) blockData.style = style;
            
            const color = block.getAttribute('data-color');
            if (color) blockData.color = color;
            
            const align = block.getAttribute('data-align');
            if (align) blockData.align = align;
            
            const valign = block.getAttribute('data-valign');
            if (valign) blockData.valign = valign;
            
            const spacing = block.getAttribute('data-spacing');
            if (spacing) blockData.spacing = spacing;
            
            const size = block.getAttribute('data-size');
            if (size) blockData.size = size;
            
            // Extract content based on type
            switch(type) {
                case 'h1':
                case 'h2':
                case 'h3':
                case 'h4':
                case 'p':
                case 'blockquote':
                case 'code':
                case 'codeblock':
                case 'container':
                    // Get innerHTML to preserve inline formatting, but remove delete button
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = block.innerHTML;
                    const deleteBtn = tempDiv.querySelector('.block-delete-btn');
                    if (deleteBtn) deleteBtn.remove();
                    blockData.content = tempDiv.innerHTML.trim();
                    break;
                case 'ul':
                case 'ol':
                    const items = Array.from(block.querySelectorAll('li')).map(li => {
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
                    if (link) {
                        blockData.url = link.href;
                        blockData.content = link.textContent.trim();
                    }
                    break;
                case 'file':
                    const fileLink = block.querySelector('a');
                    if (fileLink) {
                        blockData.url = fileLink.href;
                        blockData.filename = fileLink.textContent.trim();
                    }
                    break;
                case 'feature-image':
                case 'single-image':
                    const img = block.querySelector('img');
                    if (img) {
                        blockData.url = img.src;
                    }
                    break;
                case 'image-grid':
                    const gridImgs = block.querySelectorAll('.image-grid-item img');
                    blockData.urls = Array.from(gridImgs).map(img => img.src);
                    break;
                case 'image-slider':
                    const sliderImgs = block.querySelectorAll('.image-slider-slide img');
                    blockData.urls = Array.from(sliderImgs).map(img => img.src);
                    break;
            }
            
            content.push(blockData);
        });
        
        hiddenInput.value = JSON.stringify(content);
    };
    
    // Make available globally
    window.blogEditorPreview = window.blogEditorPreview || {};
    window.blogEditorPreview[editorId] = {
        updatePreview,
        updateHiddenInput
    };
})();

