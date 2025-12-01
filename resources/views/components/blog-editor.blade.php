@props([
    'name' => 'editor_content',
    'value' => null,
    'id' => 'blog-editor-' . uniqid(),
    'hideToolbar' => false,
    'mode' => 'split', // split (editor + preview) or single (combined)
    'banner' => null,
    'titleFieldId' => null,
    'categoryFieldId' => null,
    'dateFieldId' => null,
])

@php
    $editorId = $id;
    $wrapperClasses = 'blog-editor-wrapper';
    if ($hideToolbar) {
        $wrapperClasses .= ' toolbar-hidden';
    }
    if ($mode === 'single') {
        $wrapperClasses .= ' single-preview';
    }
@endphp

<div id="{{ $editorId }}" 
     class="{{ $wrapperClasses }}"
     data-banner="{{ $banner }}"
     data-title-field="{{ $titleFieldId }}"
     data-category-field="{{ $categoryFieldId }}"
     data-date-field="{{ $dateFieldId }}">
    {{-- WordPress-style Layout: Left Sidebar + Main Content --}}
    <div class="blog-editor-layout">
        @if(!$hideToolbar)
            {{-- Left Sidebar Toolbar --}}
            <x-blog-editor-toolbar :editorId="$editorId" />
        @endif
        
        {{-- Main Content Area (Editor + Preview) --}}
        <div class="blog-editor-main">
            {{-- Content Editor Area --}}
            <x-blog-editor-content :editorId="$editorId" :value="$value" />
            
            @if($mode === 'split')
                {{-- Live Preview Area --}}
                <x-blog-editor-preview :editorId="$editorId" />
            @endif
        </div>
    </div>
    
    {{-- Hidden Input for Form Submission --}}
    <input type="hidden" id="{{ $editorId }}-hidden-input" name="{{ $name }}" value="">
    
    {{-- File Inputs (Hidden) --}}
    <input type="file" id="{{ $editorId }}-file-input" class="hidden" accept=".pdf,.doc,.docx" multiple>
    <input type="file" id="{{ $editorId }}-image-input" class="hidden" accept="image/*" multiple>
</div>

{{-- Include Styles --}}
@push('styles')
    @include('components.blog-editor.styles', ['editorId' => $editorId])
@endpush

{{-- Include Scripts --}}
@push('scripts')
    @include('components.blog-editor.scripts', [
        'editorId' => $editorId,
        'hasPreview' => $mode !== 'single',
    ])
@endpush

