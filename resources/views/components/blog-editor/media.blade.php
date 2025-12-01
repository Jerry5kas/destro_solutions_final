@php
    $editorId = $editorId ?? 'blog-editor';
@endphp

(function() {
    'use strict';
    
    const editorId = '{{ $editorId }}';
    const funcs = window.blogEditorFunctions[editorId];
    if (!funcs) return;
    
    const { contentArea, updatePreviewAndHidden } = funcs;
    
    // File upload handler
    const fileInput = document.getElementById(editorId + '-file-input');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            Array.from(e.target.files).forEach(file => {
                uploadFile(file);
            });
        });
    }
    
    // Image upload handler
    const imageInput = document.getElementById(editorId + '-image-input');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const imageType = this.getAttribute('data-image-type');
            const gridBlockId = this.getAttribute('data-grid-block-id');
            const sliderBlockId = this.getAttribute('data-slider-block-id');
            
            // If adding to existing slider
            if (sliderBlockId && imageType === 'slider') {
                const sliderBlock = document.getElementById(sliderBlockId);
                if (sliderBlock) {
                    const sliderContainer = sliderBlock.querySelector('.image-slider-container');
                    if (sliderContainer) {
                        const sliderId = sliderContainer.id;
                        const sliderTrack = sliderContainer.querySelector('.image-slider-track');
                        const formData = new FormData();
                        Array.from(e.target.files).forEach(file => {
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
                                data.urls.forEach(url => {
                                    const slide = document.createElement('div');
                                    slide.className = 'image-slider-slide';
                                    const totalSlides = sliderTrack.querySelectorAll('.image-slider-slide').length + 1;
                                    slide.style.cssText = 'flex: 0 0 ' + (100 / totalSlides) + '%; width: ' + (100 / totalSlides) + '%; height: 100%; position: relative;';
                                    
                                    const img = document.createElement('img');
                                    img.src = url;
                                    img.alt = 'Slider image';
                                    img.style.cssText = 'width: 100%; height: 100%; object-fit: cover; display: block;';
                                    
                                    const removeBtn = document.createElement('button');
                                    removeBtn.type = 'button';
                                    removeBtn.className = 'slider-item-remove';
                                    removeBtn.innerHTML = '×';
                                    removeBtn.style.cssText = 'position: absolute; top: 0.5rem; right: 0.5rem; width: 1.5rem; height: 1.5rem; background: rgba(239, 68, 68, 0.9); color: white; border: none; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1rem; font-weight: bold; z-index: 10;';
                                    removeBtn.addEventListener('click', function(e) {
                                        e.stopPropagation();
                                        slide.remove();
                                        updateSliderLayout(sliderId);
                                        updatePreviewAndHidden();
                                    });
                                    
                                    slide.appendChild(img);
                                    slide.appendChild(removeBtn);
                                    sliderTrack.appendChild(slide);
                                });
                                updateSliderLayout(sliderId);
                                updatePreviewAndHidden();
                            }
                        })
                        .catch(error => console.error('Error:', error));
                        this.removeAttribute('data-slider-block-id');
                    }
                }
            }
            // If adding to existing grid
            else if (gridBlockId && imageType === 'grid') {
                const gridBlock = document.getElementById(gridBlockId);
                if (gridBlock) {
                    const gridContainer = gridBlock.querySelector('.image-grid-container');
                    if (gridContainer) {
                        const addBtn = gridContainer.querySelector('.grid-add-image');
                        const formData = new FormData();
                        Array.from(e.target.files).forEach(file => {
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
                                data.urls.forEach(url => {
                                    const gridItem = document.createElement('div');
                                    gridItem.className = 'image-grid-item';
                                    gridItem.style.cssText = 'position: relative; height: 14rem; width: 100%; overflow: hidden; border-radius: 0.5rem; background: #f3f4f6;';
                                    
                                    const img = document.createElement('img');
                                    img.src = url;
                                    img.alt = 'Grid image';
                                    img.style.cssText = 'width: 100%; height: 100%; object-fit: cover; display: block;';
                                    
                                    const removeBtn = document.createElement('button');
                                    removeBtn.type = 'button';
                                    removeBtn.className = 'grid-item-remove';
                                    removeBtn.innerHTML = '×';
                                    removeBtn.style.cssText = 'position: absolute; top: 0.5rem; right: 0.5rem; width: 1.5rem; height: 1.5rem; background: rgba(239, 68, 68, 0.9); color: white; border: none; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1rem; font-weight: bold; z-index: 10;';
                                    removeBtn.addEventListener('click', function(e) {
                                        e.stopPropagation();
                                        gridItem.remove();
                                        updatePreviewAndHidden();
                                    });
                                    
                                    gridItem.appendChild(img);
                                    gridItem.appendChild(removeBtn);
                                    
                                    if (addBtn) {
                                        gridContainer.insertBefore(gridItem, addBtn);
                                    } else {
                                        gridContainer.appendChild(gridItem);
                                    }
                                });
                                updatePreviewAndHidden();
                            }
                        })
                        .catch(error => console.error('Error:', error));
                        this.removeAttribute('data-grid-block-id');
                    }
                }
            } else {
                // New grid, slider, or single image
                const formData = new FormData();
                Array.from(e.target.files).forEach(file => {
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
                        if (imageType === 'grid') {
                            insertImageGridBlock(data.urls);
                        } else if (imageType === 'slider') {
                            insertImageSliderBlock(data.urls);
                        } else {
                            insertImageBlock(data.urls[0], imageType);
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    }
    
    function uploadFile(file) {
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
                insertFileBlock(data.url, file.name);
            }
        })
        .catch(error => console.error('Error:', error));
    }
    
    function getInsertionPoint() {
        const funcs = window.blogEditorFunctions[editorId];
        if (!funcs) return null;
        const { contentArea, state } = funcs;
        
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
        
        if (state.selectedBlocks.size > 0) {
            const selectedBlock = Array.from(state.selectedBlocks)[0];
            if (selectedBlock && selectedBlock.parentElement === contentArea) {
                return selectedBlock.nextSibling;
            }
        }
        
        return null;
    }
    
    function insertFileBlock(url, filename) {
        const blockId = window.blogEditorCore[editorId].getNextBlockId();
        const block = document.createElement('div');
        block.id = blockId;
        block.className = 'editor-block';
        block.setAttribute('data-type', 'file');
        block.innerHTML = `
            <a href="${url}" download="${filename}" class="inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                <span>${filename}</span>
            </a>
        `;
        
        if (window.blogEditorToolbar && window.blogEditorToolbar[editorId]) {
            window.blogEditorToolbar[editorId].addDeleteButton(block);
        }
        const insertPoint = getInsertionPoint();
        if (insertPoint) {
            contentArea.insertBefore(block, insertPoint);
        } else {
            contentArea.appendChild(block);
        }
        updatePreviewAndHidden();
    }
    
    function insertImageBlock(url, type) {
        const blockId = window.blogEditorCore[editorId].getNextBlockId();
        const block = document.createElement('div');
        block.id = blockId;
        block.className = 'editor-block';
        block.setAttribute('data-type', type === 'feature' ? 'feature-image' : 'single-image');
        block.innerHTML = `<img src="${url}" alt="Image" class="max-w-full h-80 object-cover rounded-lg">`;
        
        if (window.blogEditorToolbar && window.blogEditorToolbar[editorId]) {
            window.blogEditorToolbar[editorId].addDeleteButton(block);
        }
        const insertPoint = getInsertionPoint();
        if (insertPoint) {
            contentArea.insertBefore(block, insertPoint);
        } else {
            contentArea.appendChild(block);
        }
        updatePreviewAndHidden();
    }
    
    
    
    
    function insertImageGridBlock(urls) {
        const blockId = window.blogEditorCore[editorId].getNextBlockId();
        const block = document.createElement('div');
        block.id = blockId;
        block.className = 'editor-block';
        block.setAttribute('data-type', 'image-grid');
        block.setAttribute('contenteditable', 'false');
        
        const gridContainer = document.createElement('div');
        gridContainer.className = 'image-grid-container';
        gridContainer.style.cssText = 'display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; width: 100%;';
        
        urls.forEach((url, index) => {
            const gridItem = document.createElement('div');
            gridItem.className = 'image-grid-item';
            gridItem.style.cssText = 'position: relative; height: 14rem; width: 100%; overflow: hidden; border-radius: 0.5rem; background: #f3f4f6;';
            
            const img = document.createElement('img');
            img.src = url;
            img.alt = `Grid image ${index + 1}`;
            img.style.cssText = 'width: 100%; height: 100%; object-fit: cover; display: block;';
            
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'grid-item-remove';
            removeBtn.innerHTML = '×';
            removeBtn.style.cssText = 'position: absolute; top: 0.5rem; right: 0.5rem; width: 1.5rem; height: 1.5rem; background: rgba(239, 68, 68, 0.9); color: white; border: none; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1rem; font-weight: bold; z-index: 10;';
            removeBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                gridItem.remove();
                updatePreviewAndHidden();
            });
            
            gridItem.appendChild(img);
            gridItem.appendChild(removeBtn);
            gridContainer.appendChild(gridItem);
        });
        
        // Add button to add more images
        const addImageBtn = document.createElement('button');
        addImageBtn.type = 'button';
        addImageBtn.className = 'grid-add-image';
        addImageBtn.innerHTML = '+ Add Image';
        addImageBtn.style.cssText = 'width: 100%; height: 14rem; border: 2px dashed #d1d5db; border-radius: 0.5rem; background: #f9fafb; color: #6b7280; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 0.875rem; font-weight: 500; transition: all 0.2s;';
        addImageBtn.addEventListener('mouseenter', function() {
            this.style.borderColor = '#0D0DE0';
            this.style.background = '#eff6ff';
            this.style.color = '#0D0DE0';
        });
        addImageBtn.addEventListener('mouseleave', function() {
            this.style.borderColor = '#d1d5db';
            this.style.background = '#f9fafb';
            this.style.color = '#6b7280';
        });
        addImageBtn.addEventListener('click', function() {
            const imageInput = document.getElementById(editorId + '-image-input');
            if (imageInput) {
                imageInput.setAttribute('data-image-type', 'grid');
                imageInput.setAttribute('data-grid-block-id', blockId);
                imageInput.setAttribute('multiple', 'multiple');
                imageInput.click();
            }
        });
        
        gridContainer.appendChild(addImageBtn);
        block.appendChild(gridContainer);
        
        if (window.blogEditorToolbar && window.blogEditorToolbar[editorId]) {
            window.blogEditorToolbar[editorId].addDeleteButton(block);
        }
        const insertPoint = getInsertionPoint();
        if (insertPoint) {
            contentArea.insertBefore(block, insertPoint);
        } else {
            contentArea.appendChild(block);
        }
        updatePreviewAndHidden();
    }
    
    
    function insertImageSliderBlock(urls) {
        const blockId = window.blogEditorCore[editorId].getNextBlockId();
        const block = document.createElement('div');
        block.id = blockId;
        block.className = 'editor-block';
        block.setAttribute('data-type', 'image-slider');
        block.setAttribute('contenteditable', 'false');
        
        const sliderId = 'slider-' + blockId;
        const sliderContainer = document.createElement('div');
        sliderContainer.className = 'image-slider-container';
        sliderContainer.id = sliderId;
        sliderContainer.style.cssText = 'position: relative; width: 100%; height: 20rem; overflow: hidden; border-radius: 0.5rem; background: #f3f4f6;';
        
        const sliderTrack = document.createElement('div');
        sliderTrack.className = 'image-slider-track';
        sliderTrack.style.cssText = 'display: flex; height: 100%; transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1); width: ' + (urls.length * 100) + '%;';
        
        urls.forEach((url, index) => {
            const slide = document.createElement('div');
            slide.className = 'image-slider-slide';
            slide.style.cssText = 'flex: 0 0 ' + (100 / urls.length) + '%; width: ' + (100 / urls.length) + '%; height: 100%; position: relative;';
            
            const img = document.createElement('img');
            img.src = url;
            img.alt = `Slider image ${index + 1}`;
            img.style.cssText = 'width: 100%; height: 100%; object-fit: cover; display: block;';
            
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'slider-item-remove';
            removeBtn.innerHTML = '×';
            removeBtn.style.cssText = 'position: absolute; top: 0.5rem; right: 0.5rem; width: 1.5rem; height: 1.5rem; background: rgba(239, 68, 68, 0.9); color: white; border: none; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1rem; font-weight: bold; z-index: 10;';
            removeBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                slide.remove();
                updateSliderLayout(sliderId);
                updatePreviewAndHidden();
            });
            
            slide.appendChild(img);
            slide.appendChild(removeBtn);
            sliderTrack.appendChild(slide);
        });
        
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
        
        urls.forEach((url, index) => {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.className = 'slider-dot' + (index === 0 ? ' active' : '');
            dot.setAttribute('data-slide-index', index);
            dot.style.cssText = 'width: 0.625rem; height: 0.625rem; border-radius: 50%; border: none; padding: 0; background: ' + (index === 0 ? 'rgba(255, 255, 255, 1)' : 'rgba(255, 255, 255, 0.5)') + '; cursor: pointer; transition: all 0.3s;';
            dot.addEventListener('click', function() {
                goToSlide(sliderId, index);
            });
            dotsContainer.appendChild(dot);
        });
        
        // Add image button
        const addImageBtn = document.createElement('button');
        addImageBtn.type = 'button';
        addImageBtn.className = 'slider-add-image';
        addImageBtn.innerHTML = '+ Add Image';
        addImageBtn.style.cssText = 'position: absolute; bottom: 3rem; left: 50%; transform: translateX(-50%); padding: 0.5rem 1rem; border: 2px dashed #d1d5db; border-radius: 0.5rem; background: rgba(249, 250, 251, 0.9); color: #6b7280; cursor: pointer; font-size: 0.875rem; font-weight: 500; z-index: 20; transition: all 0.2s;';
        addImageBtn.addEventListener('mouseenter', function() {
            this.style.borderColor = '#0D0DE0';
            this.style.background = 'rgba(239, 246, 255, 0.9)';
            this.style.color = '#0D0DE0';
        });
        addImageBtn.addEventListener('mouseleave', function() {
            this.style.borderColor = '#d1d5db';
            this.style.background = 'rgba(249, 250, 251, 0.9)';
            this.style.color = '#6b7280';
        });
        addImageBtn.addEventListener('click', function() {
            const imageInput = document.getElementById(editorId + '-image-input');
            if (imageInput) {
                imageInput.setAttribute('data-image-type', 'slider');
                imageInput.setAttribute('data-slider-block-id', blockId);
                imageInput.setAttribute('multiple', 'multiple');
                imageInput.click();
            }
        });
        
        sliderContainer.appendChild(sliderTrack);
        sliderContainer.appendChild(prevBtn);
        sliderContainer.appendChild(nextBtn);
        sliderContainer.appendChild(dotsContainer);
        sliderContainer.appendChild(addImageBtn);
        block.appendChild(sliderContainer);
        
        // Initialize slider state
        if (!window.sliderStates) window.sliderStates = {};
        window.sliderStates[sliderId] = 0;
        
        if (window.blogEditorToolbar && window.blogEditorToolbar[editorId]) {
            window.blogEditorToolbar[editorId].addDeleteButton(block);
        }
        const insertPoint = getInsertionPoint();
        if (insertPoint) {
            contentArea.insertBefore(block, insertPoint);
        } else {
            contentArea.appendChild(block);
        }
        updatePreviewAndHidden();
    }
    
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
    
    function updateSliderLayout(sliderId) {
        const slider = document.getElementById(sliderId);
        if (!slider) return;
        
        const sliderTrack = slider.querySelector('.image-slider-track');
        const slides = slider.querySelectorAll('.image-slider-slide');
        const totalSlides = slides.length;
        
        if (totalSlides === 0) return;
        
        // Update track width
        sliderTrack.style.width = (totalSlides * 100) + '%';
        
        // Update slide widths
        slides.forEach(slide => {
            slide.style.flex = '0 0 ' + (100 / totalSlides) + '%';
            slide.style.width = (100 / totalSlides) + '%';
        });
        
        // Update dots
        const dotsContainer = slider.querySelector('.slider-dots');
        dotsContainer.innerHTML = '';
        slides.forEach((slide, index) => {
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
        
        // Reset to first slide
        if (window.sliderStates) {
            window.sliderStates[sliderId] = 0;
            updateSlider(sliderId);
        }
    }

    // Make available globally
    window.blogEditorMedia = window.blogEditorMedia || {};
    window.blogEditorMedia[editorId] = {
        insertFileBlock,
        insertImageBlock,
        insertImageGridBlock,
        insertImageSliderBlock
    };
})();

