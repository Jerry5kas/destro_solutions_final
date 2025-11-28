@props(['editorId'])

<div id="{{ $editorId }}-toolbar" class="blog-editor-toolbar">
    <div class="toolbar-header">
        <h3 class="toolbar-title">Formatting Tools</h3>
    </div>
    
    <div class="toolbar-content">
        {{-- Text Formatting Section --}}
        <div class="toolbar-section">
            <div class="toolbar-section-title">Text Formatting</div>
            <div class="toolbar-buttons">
                <button type="button" class="toolbar-btn" data-action="bold" title="Bold (Ctrl+B)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 4h8a4 4 0 014 4 4 4 0 01-4 4H6zM6 12h9M6 4v16"/>
                    </svg>
                    <span>Bold</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="italic" title="Italic (Ctrl+I)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                    <span>Italic</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="underline" title="Underline (Ctrl+U)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19h14M5 7h14"/>
                    </svg>
                    <span>Underline</span>
                </button>
            </div>
        </div>

        {{-- Headings Section --}}
        <div class="toolbar-section">
            <div class="toolbar-section-title">Headings</div>
            <div class="toolbar-buttons">
                <button type="button" class="toolbar-btn" data-action="heading" data-value="h1" title="Heading 1">
                    <span class="font-bold text-xl">H1</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="heading" data-value="h2" title="Heading 2">
                    <span class="font-bold text-lg">H2</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="heading" data-value="h3" title="Heading 3">
                    <span class="font-bold">H3</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="heading" data-value="h4" title="Heading 4">
                    <span class="font-semibold text-sm">H4</span>
                </button>
            </div>
        </div>

        {{-- Paragraph & Lists Section --}}
        <div class="toolbar-section">
            <div class="toolbar-section-title">Paragraph & Lists</div>
            <div class="toolbar-buttons">
                <button type="button" class="toolbar-btn" data-action="paragraph" title="Paragraph">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <span>Paragraph</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="ul" title="Unordered List">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <span>Bullet List</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="ol" title="Ordered List">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                    </svg>
                    <span>Numbered List</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="blockquote" title="Blockquote">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v1M9 16l2 2 4-4"/>
                    </svg>
                    <span>Quote</span>
                </button>
            </div>
        </div>

        {{-- Alignment Section --}}
        <div class="toolbar-section">
            <div class="toolbar-section-title">Alignment</div>
            <div class="toolbar-buttons">
                <button type="button" class="toolbar-btn" data-action="align" data-value="left" title="Align Left">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <span>Left</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="align" data-value="center" title="Align Center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    <span>Center</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="align" data-value="right" title="Align Right">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h12M4 12h16M4 18h12"/>
                    </svg>
                    <span>Right</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="align" data-value="justify" title="Justify">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    <span>Justify</span>
                </button>
            </div>
        </div>

        {{-- Vertical Alignment Section --}}
        <div class="toolbar-section">
            <div class="toolbar-section-title">Vertical Alignment</div>
            <div class="toolbar-buttons">
                <button type="button" class="toolbar-btn" data-action="valign" data-value="top" title="Top Align">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                    <span>Top</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="valign" data-value="middle" title="Middle Align">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                    <span>Middle</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="valign" data-value="bottom" title="Bottom Align">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                    <span>Bottom</span>
                </button>
            </div>
        </div>

        {{-- Spacing Section --}}
        <div class="toolbar-section">
            <div class="toolbar-section-title">Spacing</div>
            <div class="toolbar-buttons">
                <button type="button" class="toolbar-btn" data-action="spacing" data-value="tight" title="Tight Spacing">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <span>Tight</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="spacing" data-value="normal" title="Normal Spacing">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <span>Normal</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="spacing" data-value="loose" title="Loose Spacing">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <span>Loose</span>
                </button>
            </div>
        </div>

        {{-- Text Size Section --}}
        <div class="toolbar-section">
            <div class="toolbar-section-title">Text Size</div>
            <div class="toolbar-buttons">
                <button type="button" class="toolbar-btn" data-action="size" data-value="xs" title="Extra Small">
                    <span class="text-xs">XS</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="size" data-value="sm" title="Small">
                    <span class="text-sm">SM</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="size" data-value="base" title="Base">
                    <span class="text-base">MD</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="size" data-value="lg" title="Large">
                    <span class="text-lg">LG</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="size" data-value="xl" title="Extra Large">
                    <span class="text-xl">XL</span>
                </button>
            </div>
        </div>

        {{-- Colors Section --}}
        <div class="toolbar-section">
            <div class="toolbar-section-title">Text Color</div>
            <div class="toolbar-buttons">
                <button type="button" class="toolbar-btn" data-action="color" data-value="text-gray-900" title="Black">
                    <div class="color-swatch bg-gray-900"></div>
                    <span>Black</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="color" data-value="text-blue-600" title="Blue">
                    <div class="color-swatch" style="background-color: #0D0DE0;"></div>
                    <span>Blue</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="color" data-value="text-gray-600" title="Gray">
                    <div class="color-swatch bg-gray-600"></div>
                    <span>Gray</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="color" data-value="text-red-600" title="Red">
                    <div class="color-swatch bg-red-600"></div>
                    <span>Red</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="color" data-value="text-green-600" title="Green">
                    <div class="color-swatch bg-green-600"></div>
                    <span>Green</span>
                </button>
            </div>
        </div>

        {{-- Media Section --}}
        <div class="toolbar-section">
            <div class="toolbar-section-title">Media</div>
            <div class="toolbar-buttons">
                <button type="button" class="toolbar-btn" data-action="image" data-value="single" title="Single Image">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Image</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="image" data-value="grid" title="Image Grid">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                    </svg>
                    <span>Image Grid</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="image" data-value="slider" title="Image Slider">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                    </svg>
                    <span>Slider</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="file" title="Upload File">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <span>File</span>
                </button>
            </div>
        </div>

        {{-- Links & Code Section --}}
        <div class="toolbar-section">
            <div class="toolbar-section-title">Links & Code</div>
            <div class="toolbar-buttons">
                <button type="button" class="toolbar-btn" data-action="link" title="Insert Link">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                    <span>Link</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="code" title="Inline Code">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                    <span>Code</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="codeblock" title="Code Block">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Code Block</span>
                </button>
            </div>
        </div>

        {{-- Special Elements Section --}}
        <div class="toolbar-section">
            <div class="toolbar-section-title">Special Elements</div>
            <div class="toolbar-buttons">
                <button type="button" class="toolbar-btn" data-action="container" title="Container">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                    </svg>
                    <span>Container</span>
                </button>
                <button type="button" class="toolbar-btn" data-action="divider" title="Divider">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                    </svg>
                    <span>Divider</span>
                </button>
            </div>
        </div>

        {{-- Word Wrap Toggle --}}
        <div class="toolbar-section">
            <div class="toolbar-section-title">Options</div>
            <div class="toolbar-buttons">
                <button type="button" class="toolbar-btn toggle-btn" data-action="wordwrap" title="Toggle Word Wrap">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <span>Word Wrap</span>
                </button>
            </div>
        </div>
    </div>
</div>

