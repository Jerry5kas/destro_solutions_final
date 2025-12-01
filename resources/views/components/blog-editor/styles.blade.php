@php
    $editorId = $editorId ?? 'blog-editor';
@endphp

<style>
    /* Main Editor Wrapper */
    #{{ $editorId }} {
        width: 100%;
        max-width: 100%;
        background: #f5f5f5;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
    }

    /* WordPress-style Layout */
    .blog-editor-layout {
        display: flex;
        height: 800px;
        max-height: 90vh;
    }

    /* When toolbar is hidden */
    .blog-editor-wrapper.toolbar-hidden .blog-editor-layout {
        height: 100%;
    }

    .blog-editor-wrapper.toolbar-hidden .blog-editor-main {
        width: 100%;
    }

    /* Single preview mode */
    .blog-editor-wrapper.single-preview {
        background: transparent;
    }

    .blog-editor-wrapper.single-preview .blog-editor-layout {
        max-height: none;
        height: 100%;
    }

    .blog-editor-wrapper.single-preview .blog-editor-main {
        background: transparent;
    }

    .blog-editor-wrapper.single-preview .blog-editor-content-wrapper {
        border-bottom: none;
        height: 100%;
    }

    .blog-editor-wrapper.single-preview .blog-editor-content {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        max-width: 960px;
        margin: 1.5rem auto;
        padding: 2rem 2.5rem;
    }

    .blog-editor-wrapper.single-preview .content-header {
        border-bottom: none;
        background: transparent;
        padding: 1rem 0 0;
    }

    /* Left Sidebar Toolbar */
    .blog-editor-toolbar {
        width: 280px;
        min-width: 280px;
        background: #fff;
        border-right: 1px solid #ddd;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
    }

    .toolbar-header {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
    }

    .toolbar-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .toolbar-content {
        flex: 1;
        overflow-y: auto;
        padding: 0.5rem;
    }

    .toolbar-section {
        margin-bottom: 1.5rem;
    }

    .toolbar-section-title {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
        padding: 0 0.5rem;
    }

    .toolbar-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .toolbar-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 0.75rem;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.875rem;
        color: #374151;
        width: 100%;
        text-align: left;
    }

    .toolbar-btn:hover {
        background: #f3f4f6;
        border-color: #d1d5db;
    }

    .toolbar-btn.active {
        background: #0D0DE0;
        color: #fff;
        border-color: #0D0DE0;
    }

    .toolbar-btn.toggle-btn.active {
        background: #10b981;
        color: #fff;
        border-color: #10b981;
    }

    .color-swatch {
        width: 20px;
        height: 20px;
        border-radius: 4px;
        border: 1px solid #e5e7eb;
    }

    /* Main Content Area */
    .blog-editor-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: transparent;
        min-width: 0;
    }

    /* Content Editor Wrapper */
    .blog-editor-content-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        background: transparent;
    }

    .blog-editor-preview-shell {
        display: flex;
        flex-direction: column;
        gap: 0;
        min-height: 100%;
    }

    .blog-preview-banner {
        position: relative;
        width: 100%;
        min-height: 280px;
        border-radius: 0;
        background: linear-gradient(135deg, rgba(13,13,224,0.55), rgba(15,23,42,0.85));
        background-size: cover;
        background-position: center;
        overflow: hidden;
    }

    .blog-preview-banner.has-image {
        background-image: linear-gradient(135deg, rgba(13,13,224,0.35), rgba(15,23,42,0.85)), var(--preview-banner-image);
    }

    .blog-preview-banner-overlay {
        position: absolute;
        inset: 0;
        padding: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #fff;
        background: radial-gradient(circle at center, rgba(0,0,0,0.2), rgba(0,0,0,0.55));
    }

    .blog-preview-title {
        font-size: clamp(2rem, 4vw, 3rem);
        line-height: 1.2;
        font-weight: 700;
        margin: 0;
        max-width: 900px;
    }

    .blog-preview-meta {
        width: 100%;
        display: flex;
        justify-content: flex-start;
        gap: 1rem;
        color: #475467;
        font-size: 0.9rem;
        padding: 0 1.5rem;
    }

    .blog-preview-body {
        background: transparent;
        border-radius: 0;
        padding: 2.5rem 0 3rem;
        width: 100%;
        margin: 0;
        box-shadow: none;
    }

    /* Editor Content Area */
    .blog-editor-content {
        padding: 0;
        overflow: visible;
        min-height: 400px;
        font-family: 'Montserrat', sans-serif;
        word-wrap: break-word;
        overflow-wrap: break-word;
        width: 100%;
    }

    /* Preview Area */
    .blog-editor-preview-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        border-top: 2px solid #ddd;
    }

    .blog-editor-preview {
        flex: 1;
        padding: 1.5rem;
        overflow-y: auto;
        min-height: 0;
        background: #fafafa;
        font-family: 'Montserrat', sans-serif;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    /* Editor Block Styles */
    .editor-block {
        position: relative;
        margin-bottom: 1rem;
        padding: 0.5rem;
        border: 2px solid transparent;
        border-radius: 4px;
        transition: all 0.2s;
    }

    .editor-block:hover {
        border-color: #e5e7eb;
        background: #f9fafb;
    }

    .editor-block.selected {
        border-color: #0D0DE0;
        background: #eff6ff;
    }

    .editor-block[contenteditable="true"] {
        outline: none;
    }

    /* Delete Button */
    .block-delete-btn {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 24px;
        height: 24px;
        background: #ef4444;
        color: #fff;
        border: 2px solid #fff;
        border-radius: 50%;
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
        z-index: 10;
    }

    .editor-block:hover .block-delete-btn,
    .editor-block.selected .block-delete-btn {
        display: flex;
    }

    .block-delete-btn:hover {
        background: #dc2626;
        transform: scale(1.1);
    }

    /* Typography Styles - Default colors (not blue) */
    .blog-editor-content [data-type="h1"],
    .blog-editor-preview [data-type="h1"] {
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 1rem;
        color: #111827;
    }

    .blog-editor-content [data-type="h2"],
    .blog-editor-preview [data-type="h2"] {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1.3;
        margin-bottom: 0.875rem;
        color: #111827;
    }

    .blog-editor-content [data-type="h3"],
    .blog-editor-preview [data-type="h3"] {
        font-size: 1.5rem;
        font-weight: 600;
        line-height: 1.4;
        margin-bottom: 0.75rem;
        color: #111827;
    }

    .blog-editor-content [data-type="h4"],
    .blog-editor-preview [data-type="h4"] {
        font-size: 1.25rem;
        font-weight: 600;
        line-height: 1.4;
        margin-bottom: 0.75rem;
        color: #111827;
    }

    .blog-editor-content [data-type="p"],
    .blog-editor-preview [data-type="p"] {
        font-size: 1rem;
        line-height: 1.75;
        margin-bottom: 1rem;
        color: #111827;
    }

    /* Bold, italic, underline formatting - inherit parent color */
    .blog-editor-content b,
    .blog-editor-preview b,
    .blog-editor-content strong,
    .blog-editor-preview strong {
        font-weight: 700;
    }

    .blog-editor-content i,
    .blog-editor-preview i,
    .blog-editor-content em,
    .blog-editor-preview em {
        font-style: italic;
    }

    .blog-editor-content u,
    .blog-editor-preview u {
        text-decoration: underline;
    }

    /* Alignment Classes */
    [data-align="left"] {
        text-align: left;
    }

    [data-align="center"] {
        text-align: center;
    }

    [data-align="right"] {
        text-align: right;
    }

    [data-align="justify"] {
        text-align: justify;
    }

    /* Vertical Alignment */
    [data-valign="top"] {
        vertical-align: top;
    }

    [data-valign="middle"] {
        vertical-align: middle;
    }

    [data-valign="bottom"] {
        vertical-align: bottom;
    }

    /* Spacing Classes */
    [data-spacing="tight"] {
        line-height: 1.25;
        margin-bottom: 0.5rem;
    }

    [data-spacing="normal"] {
        line-height: 1.75;
        margin-bottom: 1rem;
    }

    [data-spacing="loose"] {
        line-height: 2;
        margin-bottom: 1.5rem;
    }

    /* Text Size Classes - maintain uniform black color */
    [data-size="xs"] {
        font-size: 0.75rem;
        color: #111827;
    }

    [data-size="sm"] {
        font-size: 0.875rem;
        color: #111827;
    }

    [data-size="base"] {
        font-size: 1rem;
        color: #111827;
    }

    [data-size="lg"] {
        font-size: 1.125rem;
        color: #111827;
    }

    [data-size="xl"] {
        font-size: 1.25rem;
        color: #111827;
    }

    /* Lists */
    .blog-editor-content [data-type="ul"],
    .blog-editor-preview [data-type="ul"],
    .blog-editor-content [data-type="ol"],
    .blog-editor-preview [data-type="ol"] {
        margin-bottom: 1rem;
        padding-left: 1.5rem;
        color: #111827;
    }

    .blog-editor-content [data-type="ul"] ul,
    .blog-editor-content [data-type="ol"] ol {
        outline: none;
        min-height: 1.5rem;
    }

    .blog-editor-content [data-type="ul"] li,
    .blog-editor-preview [data-type="ul"] li {
        list-style-type: disc;
        margin-bottom: 0.5rem;
        color: #111827;
        outline: none;
        min-height: 1.25rem;
        display: list-item;
    }

    .blog-editor-content [data-type="ol"] li,
    .blog-editor-preview [data-type="ol"] li {
        list-style-type: decimal;
        margin-bottom: 0.5rem;
        color: #111827;
        outline: none;
        min-height: 1.25rem;
        display: list-item;
    }

    /* Make list items editable and visible */
    .blog-editor-content [data-type="ul"] li[contenteditable="true"],
    .blog-editor-content [data-type="ol"] li[contenteditable="true"] {
        cursor: text;
    }

    .blog-editor-content [data-type="ul"] li[contenteditable="true"]:focus,
    .blog-editor-content [data-type="ol"] li[contenteditable="true"]:focus {
        outline: 1px dashed #0D0DE0;
        outline-offset: 2px;
    }

    /* Blockquote */
    .blog-editor-content [data-type="blockquote"],
    .blog-editor-preview [data-type="blockquote"] {
        border-left: 4px solid #0D0DE0;
        padding-left: 1rem;
        margin: 1rem 0;
        font-style: italic;
        color: #111827;
    }

    /* Code */
    .blog-editor-content [data-type="code"],
    .blog-editor-preview [data-type="code"] {
        background: #f3f4f6;
        padding: 0.125rem 0.375rem;
        border-radius: 4px;
        font-family: 'Courier New', monospace;
        font-size: 0.875em;
    }

    /* Code Block */
    .blog-editor-content [data-type="codeblock"],
    .blog-editor-preview [data-type="codeblock"] {
        background: #1f2937;
        color: #f9fafb;
        padding: 1rem;
        border-radius: 6px;
        margin: 1rem 0;
        font-family: 'Courier New', monospace;
        font-size: 0.875rem;
        overflow-x: auto;
    }

    /* Container */
    .blog-editor-content [data-type="container"],
    .blog-editor-preview [data-type="container"] {
        max-width: 48rem;
        margin: 1rem auto;
        padding: 1.25rem;
        border: 1px solid #d1d5db;
        border-radius: 0.75rem;
    }

    /* Divider */
    .blog-editor-content [data-type="divider"],
    .blog-editor-preview [data-type="divider"] {
        border: none;
        border-top: 2px solid #e5e7eb;
        margin: 1.5rem 0;
    }

    /* Image Grid */
    .blog-editor-content [data-type="image-grid"],
    .blog-editor-preview [data-type="image-grid"] {
        margin: 1.5rem 0;
        width: 100%;
    }

    .blog-editor-content [data-type="image-grid"] .image-grid-container,
    .blog-editor-preview [data-type="image-grid"] .image-grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        width: 100%;
    }

    .blog-editor-content [data-type="image-grid"] .image-grid-item,
    .blog-editor-preview [data-type="image-grid"] .image-grid-item {
        position: relative;
        height: 14rem;
        width: 100%;
        overflow: hidden;
        border-radius: 0.5rem;
        background: #f3f4f6;
    }

    .blog-editor-content [data-type="image-grid"] .image-grid-item img,
    .blog-editor-preview [data-type="image-grid"] .image-grid-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .blog-editor-content [data-type="image-grid"] .grid-item-remove {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        width: 1.5rem;
        height: 1.5rem;
        background: rgba(239, 68, 68, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: bold;
        z-index: 10;
        transition: all 0.2s;
    }

    .blog-editor-content [data-type="image-grid"] .grid-item-remove:hover {
        background: rgba(220, 38, 38, 1);
        transform: scale(1.1);
    }

    .blog-editor-content [data-type="image-grid"] .grid-add-image {
        width: 100%;
        height: 14rem;
        border: 2px dashed #d1d5db;
        border-radius: 0.5rem;
        background: #f9fafb;
        color: #6b7280;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s;
    }

    .blog-editor-content [data-type="image-grid"] .grid-add-image:hover {
        border-color: #0D0DE0;
        background: #eff6ff;
        color: #0D0DE0;
    }

    @media (max-width: 640px) {
        .blog-editor-content [data-type="image-grid"] .image-grid-container,
        .blog-editor-preview [data-type="image-grid"] .image-grid-container {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 0.75rem;
        }
        
        .blog-editor-content [data-type="image-grid"] .image-grid-item,
        .blog-editor-preview [data-type="image-grid"] .image-grid-item {
            height: 12rem;
        }
        
        .blog-editor-content [data-type="image-grid"] .grid-add-image {
            height: 12rem;
        }
    }

    @media (min-width: 641px) and (max-width: 1024px) {
        .blog-editor-content [data-type="image-grid"] .image-grid-container,
        .blog-editor-preview [data-type="image-grid"] .image-grid-container {
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        }
    }

    /* Link */
    .blog-editor-content [data-type="link"] a,
    .blog-editor-preview [data-type="link"] a {
        color: #0D0DE0;
        text-decoration: underline;
        text-decoration-color: #0D0DE0;
    }

    .blog-editor-content [data-type="link"] a:hover,
    .blog-editor-preview [data-type="link"] a:hover {
        color: #0A0AB4;
        text-decoration-color: #0A0AB4;
    }

    /* Blue color override - use brand blue #0D0DE0 only when explicitly selected */
    .blog-editor-content .text-blue-600,
    .blog-editor-preview .text-blue-600,
    .blog-editor-content [data-color="text-blue-600"],
    .blog-editor-preview [data-color="text-blue-600"],
    .blog-editor-content [data-color="text-blue-600"] *,
    .blog-editor-preview [data-color="text-blue-600"] * {
        color: #0D0DE0 !important;
    }

    /* Gray color options */
    .blog-editor-content .text-gray-600,
    .blog-editor-preview .text-gray-600,
    .blog-editor-content [data-color="text-gray-600"],
    .blog-editor-preview [data-color="text-gray-600"],
    .blog-editor-content [data-color="text-gray-600"] *,
    .blog-editor-preview [data-color="text-gray-600"] * {
        color: #4b5563 !important;
    }

    .blog-editor-content .text-gray-900,
    .blog-editor-preview .text-gray-900,
    .blog-editor-content [data-color="text-gray-900"],
    .blog-editor-preview [data-color="text-gray-900"],
    .blog-editor-content [data-color="text-gray-900"] *,
    .blog-editor-preview [data-color="text-gray-900"] * {
        color: #111827 !important;
    }

    /* Images */
    .blog-editor-content [data-type="single-image"] img,
    .blog-editor-preview [data-type="single-image"] img,
    .blog-editor-content [data-type="feature-image"] img,
    .blog-editor-preview [data-type="feature-image"] img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1rem 0;
    }

    

    /* File */
    .blog-editor-content [data-type="file"],
    .blog-editor-preview [data-type="file"] {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        background: #f3f4f6;
        border-radius: 6px;
        margin: 0.5rem 0;
    }

    /* Word Wrap */
    .blog-editor-content.word-wrap,
    .blog-editor-preview.word-wrap {
        white-space: pre-wrap;
        word-break: break-word;
    }

    /* Scrollbar Styling */
    .blog-editor-toolbar::-webkit-scrollbar,
    .blog-editor-content::-webkit-scrollbar,
    .blog-editor-preview::-webkit-scrollbar {
        width: 8px;
    }

    .blog-editor-toolbar::-webkit-scrollbar-track,
    .blog-editor-content::-webkit-scrollbar-track,
    .blog-editor-preview::-webkit-scrollbar-track {
        background: #f1f5f9;
    }

    .blog-editor-toolbar::-webkit-scrollbar-thumb,
    .blog-editor-content::-webkit-scrollbar-thumb,
    .blog-editor-preview::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    .blog-editor-toolbar::-webkit-scrollbar-thumb:hover,
    .blog-editor-content::-webkit-scrollbar-thumb:hover,
    .blog-editor-preview::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .blog-editor-layout {
            flex-direction: column;
            height: auto;
        }

        .blog-editor-toolbar {
            width: 100%;
            min-width: 100%;
            max-height: 300px;
            border-right: none;
            border-bottom: 1px solid #ddd;
        }

        .blog-editor-main {
            flex-direction: column;
        }

        .blog-editor-preview-wrapper {
            border-top: 1px solid #ddd;
            border-left: none;
        }
    }

    /* Image Slider */
    .blog-editor-content [data-type="image-slider"],
    .blog-editor-preview [data-type="image-slider"] {
        margin: 1.5rem 0;
        width: 100%;
    }

    .blog-editor-content [data-type="image-slider"] .image-slider-container,
    .blog-editor-preview [data-type="image-slider"] .image-slider-container {
        position: relative;
        width: 100%;
        height: 20rem;
        overflow: hidden;
        border-radius: 0.5rem;
        background: #f3f4f6;
    }

    .blog-editor-content [data-type="image-slider"] .image-slider-track,
    .blog-editor-preview [data-type="image-slider"] .image-slider-track {
        display: flex;
        height: 100%;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .blog-editor-content [data-type="image-slider"] .image-slider-slide,
    .blog-editor-preview [data-type="image-slider"] .image-slider-slide {
        flex: 0 0 100%;
        width: 100%;
        height: 100%;
        position: relative;
    }

    .blog-editor-content [data-type="image-slider"] .image-slider-slide img,
    .blog-editor-preview [data-type="image-slider"] .image-slider-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .blog-editor-content [data-type="image-slider"] .slider-nav,
    .blog-editor-preview [data-type="image-slider"] .slider-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 2.5rem;
        height: 2.5rem;
        background: rgba(255, 255, 255, 0.9);
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: bold;
        color: #1f2937;
        z-index: 20;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        transition: all 0.3s;
    }

    .blog-editor-content [data-type="image-slider"] .slider-nav:hover,
    .blog-editor-preview [data-type="image-slider"] .slider-nav:hover {
        background: rgba(255, 255, 255, 1);
        transform: translateY(-50%) scale(1.1);
    }

    .blog-editor-content [data-type="image-slider"] .slider-prev,
    .blog-editor-preview [data-type="image-slider"] .slider-prev {
        left: 1rem;
    }

    .blog-editor-content [data-type="image-slider"] .slider-next,
    .blog-editor-preview [data-type="image-slider"] .slider-next {
        right: 1rem;
    }

    .blog-editor-content [data-type="image-slider"] .slider-dots,
    .blog-editor-preview [data-type="image-slider"] .slider-dots {
        position: absolute;
        bottom: 1rem;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 0.5rem;
        z-index: 20;
    }

    .blog-editor-content [data-type="image-slider"] .slider-dot,
    .blog-editor-preview [data-type="image-slider"] .slider-dot {
        width: 0.625rem;
        height: 0.625rem;
        border-radius: 50%;
        border: none;
        padding: 0;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: all 0.3s;
    }

    .blog-editor-content [data-type="image-slider"] .slider-dot.active,
    .blog-editor-preview [data-type="image-slider"] .slider-dot.active {
        background: rgba(255, 255, 255, 1);
        width: 0.75rem;
        height: 0.75rem;
    }

    .blog-editor-content [data-type="image-slider"] .slider-item-remove {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        width: 1.5rem;
        height: 1.5rem;
        background: rgba(239, 68, 68, 0.9);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: bold;
        z-index: 10;
        transition: all 0.2s;
    }

    .blog-editor-content [data-type="image-slider"] .slider-item-remove:hover {
        background: rgba(220, 38, 38, 1);
        transform: scale(1.1);
    }

    .blog-editor-content [data-type="image-slider"] .slider-add-image {
        position: absolute;
        bottom: 3rem;
        left: 50%;
        transform: translateX(-50%);
        padding: 0.5rem 1rem;
        border: 2px dashed #d1d5db;
        border-radius: 0.5rem;
        background: rgba(249, 250, 251, 0.9);
        color: #6b7280;
        cursor: pointer;
        font-size: 0.875rem;
        font-weight: 500;
        z-index: 20;
        transition: all 0.2s;
    }

    .blog-editor-content [data-type="image-slider"] .slider-add-image:hover {
        border-color: #0D0DE0;
        background: rgba(239, 246, 255, 0.9);
        color: #0D0DE0;
    }
</style>

