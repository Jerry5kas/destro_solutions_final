@php
    $editorId = $editorId ?? 'blog-editor';
@endphp

(function() {
    'use strict';
    
    const editorId = '{{ $editorId }}';
    const funcs = window.blogEditorFunctions[editorId];
    if (!funcs) return;
    
    const toolbar = document.getElementById(editorId + '-toolbar');
    if (!toolbar) return;
    
    // Toolbar button handlers
    toolbar.addEventListener('click', function(e) {
        const btn = e.target.closest('.toolbar-btn');
        if (!btn) return;
        
        const action = btn.getAttribute('data-action');
        const value = btn.getAttribute('data-value');
        
        if (!action) return;
        
        e.preventDefault();
        e.stopPropagation();
        
        // Handle different actions
        switch(action) {
            case 'bold':
            case 'italic':
            case 'underline':
                applyFormatting(action);
                break;
            case 'heading':
                insertHeading(value);
                break;
            case 'paragraph':
                insertParagraph();
                break;
            case 'ul':
            case 'ol':
                insertList(action);
                break;
            case 'blockquote':
                insertBlockquote();
                break;
            case 'align':
                applyAlignment(value);
                break;
            case 'valign':
                applyVerticalAlignment(value);
                break;
            case 'spacing':
                applySpacing(value);
                break;
            case 'size':
                applyTextSize(value);
                break;
            case 'color':
                applyColor(value);
                break;
            case 'link':
                insertLink();
                break;
            case 'code':
                insertCode();
                break;
            case 'codeblock':
                insertCodeBlock();
                break;
            case 'container':
                insertContainer();
                break;
            case 'divider':
                insertDivider();
                break;
            case 'image':
                handleImageUpload(value);
                break;
            case 'file':
                handleFileUpload();
                break;
            case 'wordwrap':
                toggleWordWrap(btn);
                break;
        }
    });
    
    function applyFormatting(format) {
        const { contentArea, state, updatePreviewAndHidden } = funcs;
        const selection = window.getSelection();
        
        // Check if there's a text selection within a contenteditable block
        if (selection.rangeCount > 0 && !selection.isCollapsed) {
            const range = selection.getRangeAt(0);
            const container = range.commonAncestorContainer;
            const block = container.nodeType === Node.TEXT_NODE 
                ? container.parentElement.closest('.editor-block[contenteditable="true"]')
                : container.closest('.editor-block[contenteditable="true"]');
            
            if (block && (block.getAttribute('data-type') === 'p' || block.getAttribute('data-type')?.startsWith('h'))) {
                // Apply inline formatting to selected text
                document.execCommand(format, false, null);
                updatePreviewAndHidden();
                return;
            }
        }
        
        // Fallback to block-level formatting
        if (state.selectedBlocks.size > 0) {
            state.selectedBlocks.forEach(block => {
                const blockType = block.getAttribute('data-type');
                if (blockType === 'p' || blockType?.startsWith('h')) {
                    const currentStyle = block.getAttribute('data-style') || '';
                    const styles = currentStyle.split(' ').filter(s => s);
                    
                    if (styles.includes(format)) {
                        // Toggle off
                        styles.splice(styles.indexOf(format), 1);
                        if (styles.length > 0) {
                            block.setAttribute('data-style', styles.join(' '));
                        } else {
                            block.removeAttribute('data-style');
                        }
                    } else {
                        // Toggle on
                        styles.push(format);
                        block.setAttribute('data-style', styles.join(' '));
                    }
                }
            });
        } else {
            // Apply to next block
            state.nextFormat.style = format;
            insertParagraph();
        }
        
        updatePreviewAndHidden();
        updateToolbarState();
    }
    
    function getInsertionPoint() {
        const selection = window.getSelection();
        if (selection.rangeCount > 0) {
            const range = selection.getRangeAt(0);
            const container = range.commonAncestorContainer;
            const currentBlock = container.nodeType === Node.TEXT_NODE 
                ? container.parentElement.closest('.editor-block')
                : container.closest('.editor-block');
            
            if (currentBlock && currentBlock.parentElement === contentArea) {
                return currentBlock.nextSibling;
            }
        }
        
        // Check if a block is selected
        if (state.selectedBlocks.size > 0) {
            const selectedBlock = Array.from(state.selectedBlocks)[0];
            if (selectedBlock && selectedBlock.parentElement === contentArea) {
                return selectedBlock.nextSibling;
            }
        }
        
        return null;
    }
    
    function insertHeading(level) {
        const { contentArea, state, updatePreviewAndHidden } = funcs;
        const blockId = window.blogEditorCore[editorId].getNextBlockId();
        
        const block = document.createElement('div');
        block.id = blockId;
        block.className = 'editor-block';
        block.setAttribute('data-type', level);
        block.setAttribute('contenteditable', 'true');
        block.textContent = 'Enter ' + level.toUpperCase();
        
        applyNextFormat(block);
        addDeleteButton(block);
        
        const insertPoint = getInsertionPoint();
        if (insertPoint) {
            contentArea.insertBefore(block, insertPoint);
        } else {
            contentArea.appendChild(block);
        }
        selectBlock(block);
        updatePreviewAndHidden();
    }
    
    function insertParagraph() {
        const { contentArea, state, updatePreviewAndHidden } = funcs;
        const blockId = window.blogEditorCore[editorId].getNextBlockId();
        
        const block = document.createElement('div');
        block.id = blockId;
        block.className = 'editor-block';
        block.setAttribute('data-type', 'p');
        block.setAttribute('contenteditable', 'true');
        block.textContent = 'Enter paragraph text';
        
        applyNextFormat(block);
        addDeleteButton(block);
        
        const insertPoint = getInsertionPoint();
        if (insertPoint) {
            contentArea.insertBefore(block, insertPoint);
        } else {
            contentArea.appendChild(block);
        }
        selectBlock(block);
        updatePreviewAndHidden();
    }
    
    function insertList(type) {
        const { contentArea, state, updatePreviewAndHidden } = funcs;
        const blockId = window.blogEditorCore[editorId].getNextBlockId();
        
        const block = document.createElement('div');
        block.id = blockId;
        block.className = 'editor-block';
        block.setAttribute('data-type', type);
        block.setAttribute('contenteditable', 'false');
        
        const list = document.createElement(type);
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
        block.appendChild(list);
        
        // Add event listener to handle Enter key for new list items
        list.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                const selection = window.getSelection();
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
                    
                    newLi.focus();
                    range.setStart(newLi, 0);
                    range.setEnd(newLi, 0);
                    selection.removeAllRanges();
                    selection.addRange(range);
                }
            }
        });
        
        addDeleteButton(block);
        const insertPoint = getInsertionPoint();
        if (insertPoint) {
            contentArea.insertBefore(block, insertPoint);
        } else {
            contentArea.appendChild(block);
        }
        selectBlock(block);
        updatePreviewAndHidden();
    }
    
    function insertBlockquote() {
        const { contentArea, state, updatePreviewAndHidden } = funcs;
        const blockId = window.blogEditorCore[editorId].getNextBlockId();
        
        const block = document.createElement('div');
        block.id = blockId;
        block.className = 'editor-block';
        block.setAttribute('data-type', 'blockquote');
        block.setAttribute('contenteditable', 'true');
        block.textContent = 'Enter quote text';
        
        addDeleteButton(block);
        const insertPoint = getInsertionPoint();
        if (insertPoint) {
            contentArea.insertBefore(block, insertPoint);
        } else {
            contentArea.appendChild(block);
        }
        selectBlock(block);
        updatePreviewAndHidden();
    }
    
    function applyAlignment(align) {
        const { state, updatePreviewAndHidden } = funcs;
        
        if (state.selectedBlocks.size > 0) {
            state.selectedBlocks.forEach(block => {
                block.setAttribute('data-align', align);
            });
        } else {
            state.nextFormat.align = align;
            insertParagraph();
        }
        
        updatePreviewAndHidden();
        updateToolbarState();
    }
    
    function applyVerticalAlignment(valign) {
        const { state, updatePreviewAndHidden } = funcs;
        
        if (state.selectedBlocks.size > 0) {
            state.selectedBlocks.forEach(block => {
                block.setAttribute('data-valign', valign);
            });
        } else {
            state.nextFormat.valign = valign;
            insertParagraph();
        }
        
        updatePreviewAndHidden();
        updateToolbarState();
    }
    
    function applySpacing(spacing) {
        const { state, updatePreviewAndHidden } = funcs;
        
        if (state.selectedBlocks.size > 0) {
            state.selectedBlocks.forEach(block => {
                block.setAttribute('data-spacing', spacing);
            });
        } else {
            state.nextFormat.spacing = spacing;
            insertParagraph();
        }
        
        updatePreviewAndHidden();
        updateToolbarState();
    }
    
    function applyTextSize(size) {
        const { state, updatePreviewAndHidden } = funcs;
        
        if (state.selectedBlocks.size > 0) {
            state.selectedBlocks.forEach(block => {
                block.setAttribute('data-size', size);
            });
        } else {
            state.nextFormat.size = size;
            insertParagraph();
        }
        
        updatePreviewAndHidden();
        updateToolbarState();
    }
    
    function applyColor(color) {
        const { state, updatePreviewAndHidden } = funcs;
        const selection = window.getSelection();
        
        // Check if there's a text selection for inline color
        if (selection.rangeCount > 0 && !selection.isCollapsed) {
            const range = selection.getRangeAt(0);
            const container = range.commonAncestorContainer;
            const block = container.nodeType === Node.TEXT_NODE 
                ? container.parentElement.closest('.editor-block[contenteditable="true"]')
                : container.closest('.editor-block[contenteditable="true"]');
            
            if (block && (block.getAttribute('data-type') === 'p' || block.getAttribute('data-type')?.startsWith('h'))) {
                // Apply inline color using span
                const span = document.createElement('span');
                span.className = color;
                try {
                    range.surroundContents(span);
                } catch (e) {
                    // If surroundContents fails, use execCommand
                    document.execCommand('foreColor', false, color.replace('text-', '').replace('-', ''));
                }
                updatePreviewAndHidden();
                return;
            }
        }
        
        // Fallback to block-level color
        if (state.selectedBlocks.size > 0) {
            state.selectedBlocks.forEach(block => {
                // Remove existing color classes
                block.className = block.className.replace(/text-\w+-\d+/g, '');
                block.setAttribute('data-color', color);
                block.classList.add(color);
            });
        } else {
            state.nextFormat.color = color;
            insertParagraph();
        }
        
        updatePreviewAndHidden();
        updateToolbarState();
    }
    
    function insertLink() {
        const selection = window.getSelection();
        let url, text;
        
        // Check if text is selected for inline link
        if (selection.rangeCount > 0 && !selection.isCollapsed) {
            const range = selection.getRangeAt(0);
            const container = range.commonAncestorContainer;
            const block = container.nodeType === Node.TEXT_NODE 
                ? container.parentElement.closest('.editor-block[contenteditable="true"]')
                : container.closest('.editor-block[contenteditable="true"]');
            
            if (block && (block.getAttribute('data-type') === 'p' || block.getAttribute('data-type')?.startsWith('h'))) {
                text = selection.toString();
                url = prompt('Enter URL:', 'https://');
                if (url) {
                    // Use execCommand for better browser compatibility
                    try {
                        document.execCommand('createLink', false, url);
                        // Update all links to have target="_blank"
                        const links = block.querySelectorAll('a');
                        links.forEach(link => {
                            if (link.href === url || link.textContent === text) {
                                link.target = '_blank';
                            }
                        });
                    } catch (e) {
                        // Fallback: manually create link
                        const link = document.createElement('a');
                        link.href = url;
                        link.target = '_blank';
                        link.textContent = text;
                        try {
                            range.deleteContents();
                            range.insertNode(link);
                        } catch (err) {
                            // If that fails, just insert at cursor
                            link.textContent = text;
                            range.deleteContents();
                            range.insertNode(link);
                        }
                    }
                    updatePreviewAndHidden();
                    return;
                }
            }
        }
        
        // Fallback to block-level link
        url = prompt('Enter URL:');
        text = prompt('Enter link text:', url);
        if (url && text) {
            const { contentArea, updatePreviewAndHidden } = funcs;
            const blockId = window.blogEditorCore[editorId].getNextBlockId();
            
            const block = document.createElement('div');
            block.id = blockId;
            block.className = 'editor-block';
            block.setAttribute('data-type', 'link');
            block.innerHTML = `<a href="${url}" target="_blank">${text}</a>`;
            
            addDeleteButton(block);
            const insertPoint = getInsertionPoint();
            if (insertPoint) {
                contentArea.insertBefore(block, insertPoint);
            } else {
                contentArea.appendChild(block);
            }
            updatePreviewAndHidden();
        }
    }
    
    function insertCode() {
        const { contentArea, state, updatePreviewAndHidden } = funcs;
        const blockId = window.blogEditorCore[editorId].getNextBlockId();
        
        const block = document.createElement('div');
        block.id = blockId;
        block.className = 'editor-block';
        block.setAttribute('data-type', 'code');
        block.setAttribute('contenteditable', 'true');
        block.textContent = 'code';
        
        addDeleteButton(block);
        const insertPoint = getInsertionPoint();
        if (insertPoint) {
            contentArea.insertBefore(block, insertPoint);
        } else {
            contentArea.appendChild(block);
        }
        selectBlock(block);
        updatePreviewAndHidden();
    }
    
    function insertCodeBlock() {
        const { contentArea, state, updatePreviewAndHidden } = funcs;
        const blockId = window.blogEditorCore[editorId].getNextBlockId();
        
        const block = document.createElement('div');
        block.id = blockId;
        block.className = 'editor-block';
        block.setAttribute('data-type', 'codeblock');
        block.setAttribute('contenteditable', 'true');
        block.textContent = '// Enter code here';
        
        addDeleteButton(block);
        const insertPoint = getInsertionPoint();
        if (insertPoint) {
            contentArea.insertBefore(block, insertPoint);
        } else {
            contentArea.appendChild(block);
        }
        selectBlock(block);
        updatePreviewAndHidden();
    }
    
    function insertContainer() {
        const { contentArea, state, updatePreviewAndHidden } = funcs;
        const blockId = window.blogEditorCore[editorId].getNextBlockId();
        
        const block = document.createElement('div');
        block.id = blockId;
        block.className = 'editor-block';
        block.setAttribute('data-type', 'container');
        block.setAttribute('contenteditable', 'true');
        block.textContent = 'Container content - Add elements inside';
        
        addDeleteButton(block);
        const insertPoint = getInsertionPoint();
        if (insertPoint) {
            contentArea.insertBefore(block, insertPoint);
        } else {
            contentArea.appendChild(block);
        }
        selectBlock(block);
        updatePreviewAndHidden();
    }
    
    function insertDivider() {
        const { contentArea, updatePreviewAndHidden } = funcs;
        const blockId = window.blogEditorCore[editorId].getNextBlockId();
        
        const block = document.createElement('div');
        block.id = blockId;
        block.className = 'editor-block';
        block.setAttribute('data-type', 'divider');
        block.setAttribute('contenteditable', 'false');
        block.innerHTML = '<hr />';
        
        addDeleteButton(block);
        const insertPoint = getInsertionPoint();
        if (insertPoint) {
            contentArea.insertBefore(block, insertPoint);
        } else {
            contentArea.appendChild(block);
        }
        updatePreviewAndHidden();
    }
    
    function toggleWordWrap(btn) {
        const { contentArea, previewArea, state } = funcs;
        state.wordWrap = !state.wordWrap;
        
        if (state.wordWrap) {
            contentArea.classList.add('word-wrap');
            if (previewArea) {
                previewArea.classList.add('word-wrap');
            }
            btn.classList.add('active');
        } else {
            contentArea.classList.remove('word-wrap');
            if (previewArea) {
                previewArea.classList.remove('word-wrap');
            }
            btn.classList.remove('active');
        }
    }
    
    function handleImageUpload(type) {
        const imageInput = document.getElementById(editorId + '-image-input');
        if (imageInput) {
            imageInput.setAttribute('data-image-type', type);
            if (type === 'grid' || type === 'slider') {
                imageInput.setAttribute('multiple', 'multiple');
            } else {
                imageInput.removeAttribute('multiple');
            }
            imageInput.click();
        }
    }
    
    function handleFileUpload() {
        const fileInput = document.getElementById(editorId + '-file-input');
        if (fileInput) {
            fileInput.click();
        }
    }
    
    function applyNextFormat(block) {
        const { state } = funcs;
        const format = state.nextFormat;
        
        if (format.type) {
            block.setAttribute('data-type', format.type);
        }
        if (format.style) {
            block.setAttribute('data-style', format.style);
        }
        if (format.color) {
            block.setAttribute('data-color', format.color);
            block.classList.add(format.color);
        }
        if (format.align) {
            block.setAttribute('data-align', format.align);
        }
        if (format.valign) {
            block.setAttribute('data-valign', format.valign);
        }
        if (format.spacing) {
            block.setAttribute('data-spacing', format.spacing);
        }
        if (format.size) {
            block.setAttribute('data-size', format.size);
        }
        
        // Reset next format type only
        state.nextFormat.type = null;
    }
    
    function selectBlock(block) {
        const { state, clearSelection } = funcs;
        clearSelection();
        state.selectedBlocks.add(block);
        block.classList.add('selected');
        setTimeout(() => block.focus(), 10);
    }
    
    function addDeleteButton(block) {
        const existingBtn = block.querySelector('.block-delete-btn');
        if (existingBtn) existingBtn.remove();
        
        const deleteBtn = document.createElement('button');
        deleteBtn.type = 'button';
        deleteBtn.className = 'block-delete-btn';
        deleteBtn.innerHTML = '×';
        deleteBtn.title = 'Delete block';
        deleteBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            if (typeof deleteBlock === 'function') {
                deleteBlock(block);
            }
        });
        block.appendChild(deleteBtn);
    }
    
    function updateToolbarState() {
        const { state } = funcs;
        const buttons = toolbar.querySelectorAll('.toolbar-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        
        if (state.selectedBlocks.size > 0) {
            state.selectedBlocks.forEach(block => {
                const type = block.getAttribute('data-type');
                const style = block.getAttribute('data-style');
                const color = block.getAttribute('data-color');
                const align = block.getAttribute('data-align');
                const valign = block.getAttribute('data-valign');
                const spacing = block.getAttribute('data-spacing');
                const size = block.getAttribute('data-size');
                
                if (type) {
                    const btn = toolbar.querySelector(`[data-action="heading"][data-value="${type}"]`);
                    if (btn) btn.classList.add('active');
                }
                if (style) {
                    const btn = toolbar.querySelector(`[data-action="${style}"]`);
                    if (btn) btn.classList.add('active');
                }
                if (color) {
                    const btn = toolbar.querySelector(`[data-action="color"][data-value="${color}"]`);
                    if (btn) btn.classList.add('active');
                }
                if (align) {
                    const btn = toolbar.querySelector(`[data-action="align"][data-value="${align}"]`);
                    if (btn) btn.classList.add('active');
                }
                if (valign) {
                    const btn = toolbar.querySelector(`[data-action="valign"][data-value="${valign}"]`);
                    if (btn) btn.classList.add('active');
                }
                if (spacing) {
                    const btn = toolbar.querySelector(`[data-action="spacing"][data-value="${spacing}"]`);
                    if (btn) btn.classList.add('active');
                }
                if (size) {
                    const btn = toolbar.querySelector(`[data-action="size"][data-value="${size}"]`);
                    if (btn) btn.classList.add('active');
                }
            });
        }
    }
    
    // Make functions available
    window.blogEditorToolbar = window.blogEditorToolbar || {};
    window.blogEditorToolbar[editorId] = {
        updateToolbarState,
        addDeleteButton
    };
})();

