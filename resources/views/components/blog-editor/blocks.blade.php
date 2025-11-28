@php
    $editorId = $editorId ?? 'blog-editor';
@endphp

(function() {
    'use strict';
    
    const editorId = '{{ $editorId }}';
    const funcs = window.blogEditorFunctions[editorId];
    if (!funcs) return;
    
    const { contentArea, state, updatePreviewAndHidden } = funcs;
    
    // Delete block function
    window.deleteBlock = function(block) {
        if (state.selectedBlocks.has(block)) {
            state.selectedBlocks.delete(block);
        }
        block.remove();
        updatePreviewAndHidden();
        if (window.blogEditorToolbar && window.blogEditorToolbar[editorId]) {
            window.blogEditorToolbar[editorId].updateToolbarState();
        }
    };
    
    // Render content from JSON
    window.renderContent = function(content) {
        contentArea.innerHTML = '';
        content.forEach(blockData => {
            const block = createBlockFromData(blockData);
            if (block) {
                contentArea.appendChild(block);
            }
        });
        updatePreviewAndHidden();
    };
    
    function createBlockFromData(blockData) {
        const blockId = window.blogEditorCore[editorId].getNextBlockId();
        const block = document.createElement('div');
        block.id = blockId;
        block.className = 'editor-block';
        block.setAttribute('data-type', blockData.type);
        
        // Set attributes
        if (blockData.style) block.setAttribute('data-style', blockData.style);
        if (blockData.color) {
            block.setAttribute('data-color', blockData.color);
            block.classList.add(blockData.color);
        }
        if (blockData.align) block.setAttribute('data-align', blockData.align);
        if (blockData.valign) block.setAttribute('data-valign', blockData.valign);
        if (blockData.spacing) block.setAttribute('data-spacing', blockData.spacing);
        if (blockData.size) block.setAttribute('data-size', blockData.size);
        
        // Set content based on type
        switch(blockData.type) {
            case 'h1':
            case 'h2':
            case 'h3':
            case 'h4':
            case 'p':
            case 'blockquote':
            case 'code':
            case 'codeblock':
            case 'container':
                block.setAttribute('contenteditable', 'true');
                // Use innerHTML to preserve inline formatting
                block.innerHTML = blockData.content || '';
                break;
            case 'ul':
            case 'ol':
                block.setAttribute('contenteditable', 'false');
                const list = document.createElement(blockData.type);
                list.setAttribute('contenteditable', 'true');
                
                if (Array.isArray(blockData.content) && blockData.content.length > 0) {
                    blockData.content.forEach(item => {
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
                
                block.appendChild(list);
                break;
            case 'link':
                block.innerHTML = `<a href="${blockData.url}" target="_blank">${blockData.content}</a>`;
                break;
            case 'file':
                block.innerHTML = `
                    <a href="${blockData.url}" download="${blockData.filename}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <span>${blockData.filename || 'Download File'}</span>
                    </a>
                `;
                break;
            case 'feature-image':
            case 'single-image':
                block.innerHTML = `<img src="${blockData.url}" alt="Image" class="max-w-full h-80 object-cover rounded-lg">`;
                break;
            case 'divider':
                block.innerHTML = '<hr />';
                break;
            case 'image-grid':
                block.setAttribute('contenteditable', 'false');
                const gridContainer = document.createElement('div');
                gridContainer.className = 'image-grid-container';
                gridContainer.style.cssText = 'display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; width: 100%;';
                
                if (Array.isArray(blockData.urls) && blockData.urls.length > 0) {
                    blockData.urls.forEach((url, index) => {
                        const gridItem = document.createElement('div');
                        gridItem.className = 'image-grid-item';
                        gridItem.style.cssText = 'position: relative; height: 14rem; width: 100%; overflow: hidden; border-radius: 0.5rem; background: #f3f4f6;';
                        
                        const img = document.createElement('img');
                        img.src = url;
                        img.alt = `Grid image ${index + 1}`;
                        img.style.cssText = 'width: 100%; height: 100%; object-fit: cover; display: block;';
                        
                        gridItem.appendChild(img);
                        gridContainer.appendChild(gridItem);
                    });
                }
                
                block.appendChild(gridContainer);
                break;
            case 'image-slider':
                block.setAttribute('contenteditable', 'false');
                const sliderId = 'slider-' + blockId;
                const sliderContainer = document.createElement('div');
                sliderContainer.className = 'image-slider-container';
                sliderContainer.id = sliderId;
                sliderContainer.style.cssText = 'position: relative; width: 100%; height: 20rem; overflow: hidden; border-radius: 0.5rem; background: #f3f4f6;';
                
                const sliderTrack = document.createElement('div');
                sliderTrack.className = 'image-slider-track';
                const totalSlides = blockData.urls.length;
                sliderTrack.style.cssText = 'display: flex; height: 100%; transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1); width: ' + (totalSlides * 100) + '%;';
                
                if (Array.isArray(blockData.urls) && blockData.urls.length > 0) {
                    blockData.urls.forEach((url, index) => {
                        const slide = document.createElement('div');
                        slide.className = 'image-slider-slide';
                        slide.style.cssText = 'flex: 0 0 ' + (100 / totalSlides) + '%; width: ' + (100 / totalSlides) + '%; height: 100%; position: relative;';
                        
                        const img = document.createElement('img');
                        img.src = url;
                        img.alt = `Slider image ${index + 1}`;
                        img.style.cssText = 'width: 100%; height: 100%; object-fit: cover; display: block;';
                        
                        slide.appendChild(img);
                        sliderTrack.appendChild(slide);
                    });
                }
                
                // Navigation buttons
                const prevBtn = document.createElement('button');
                prevBtn.type = 'button';
                prevBtn.className = 'slider-nav slider-prev';
                prevBtn.innerHTML = '‹';
                prevBtn.style.cssText = 'position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); width: 2.5rem; height: 2.5rem; background: rgba(255, 255, 255, 0.9); border: none; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; color: #1f2937; z-index: 20; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);';
                prevBtn.addEventListener('click', function() {
                    slideSlider(sliderId, -1);
                });
                
                const nextBtn = document.createElement('button');
                nextBtn.type = 'button';
                nextBtn.className = 'slider-nav slider-next';
                nextBtn.innerHTML = '›';
                nextBtn.style.cssText = 'position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); width: 2.5rem; height: 2.5rem; background: rgba(255, 255, 255, 0.9); border: none; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: bold; color: #1f2937; z-index: 20; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);';
                nextBtn.addEventListener('click', function() {
                    slideSlider(sliderId, 1);
                });
                
                // Dots indicator
                const dotsContainer = document.createElement('div');
                dotsContainer.className = 'slider-dots';
                dotsContainer.style.cssText = 'position: absolute; bottom: 1rem; left: 50%; transform: translateX(-50%); display: flex; gap: 0.5rem; z-index: 20;';
                
                if (blockData.urls.length > 0) {
                    blockData.urls.forEach((url, index) => {
                        const dot = document.createElement('button');
                        dot.type = 'button';
                        dot.className = 'slider-dot' + (index === 0 ? ' active' : '');
                        dot.setAttribute('data-slide-index', index);
                        dot.style.cssText = 'width: ' + (index === 0 ? '0.75rem' : '0.625rem') + '; height: ' + (index === 0 ? '0.75rem' : '0.625rem') + '; border-radius: 50%; border: none; padding: 0; background: ' + (index === 0 ? 'rgba(255, 255, 255, 1)' : 'rgba(255, 255, 255, 0.5)') + '; cursor: pointer; transition: all 0.3s;';
                        dot.addEventListener('click', function() {
                            goToSlide(sliderId, index);
                        });
                        dotsContainer.appendChild(dot);
                    });
                }
                
                sliderContainer.appendChild(sliderTrack);
                if (blockData.urls.length > 1) {
                    sliderContainer.appendChild(prevBtn);
                    sliderContainer.appendChild(nextBtn);
                    sliderContainer.appendChild(dotsContainer);
                }
                block.appendChild(sliderContainer);
                
                // Initialize slider state
                if (!window.sliderStates) window.sliderStates = {};
                window.sliderStates[sliderId] = 0;
                break;
        }
        
        // Add delete button
        if (window.blogEditorToolbar && window.blogEditorToolbar[editorId]) {
            window.blogEditorToolbar[editorId].addDeleteButton(block);
        }
        
        return block;
    }
    
    // Slider functions
    function slideSlider(sliderId, direction) {
        if (!window.sliderStates) window.sliderStates = {};
        const slider = document.getElementById(sliderId);
        if (!slider) return;
        
        const slides = slider.querySelectorAll('.image-slider-slide');
        const totalSlides = slides.length;
        if (totalSlides === 0) return;
        
        if (!window.sliderStates[sliderId]) window.sliderStates[sliderId] = 0;
        window.sliderStates[sliderId] = (window.sliderStates[sliderId] + direction + totalSlides) % totalSlides;
        
        updateSlider(sliderId);
    }
    
    function goToSlide(sliderId, index) {
        if (!window.sliderStates) window.sliderStates = {};
        window.sliderStates[sliderId] = index;
        updateSlider(sliderId);
    }
    
    function updateSlider(sliderId) {
        const slider = document.getElementById(sliderId);
        if (!slider) return;
        
        const sliderTrack = slider.querySelector('.image-slider-track');
        const dots = slider.querySelectorAll('.slider-dot');
        const currentIndex = window.sliderStates[sliderId] || 0;
        
        if (sliderTrack) {
            const translateX = -currentIndex * 100;
            sliderTrack.style.transform = `translateX(${translateX}%)`;
        }
        
        dots.forEach((dot, i) => {
            if (i === currentIndex) {
                dot.classList.add('active');
                dot.style.background = 'rgba(255, 255, 255, 1)';
                dot.style.width = '0.75rem';
                dot.style.height = '0.75rem';
            } else {
                dot.classList.remove('active');
                dot.style.background = 'rgba(255, 255, 255, 0.5)';
                dot.style.width = '0.625rem';
                dot.style.height = '0.625rem';
            }
        });
    }

    // Make available globally
    window.blogEditorBlocks = window.blogEditorBlocks || {};
    window.blogEditorBlocks[editorId] = {
        renderContent,
        createBlockFromData,
        slideSlider,
        goToSlide,
        updateSlider
    };
})();

