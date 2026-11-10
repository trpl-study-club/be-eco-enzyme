@props(['name', 'value' => '', 'placeholder' => 'Tuliskan deskripsi singkat di sini...', 'height' => 'h-32'])

@php
    $id = 'rich-editor-' . uniqid();
    $jsId = str_replace('-', '_', $id);
@endphp

<div class="rounded-xl overflow-hidden border border-gray-200 bg-white" wire:ignore>
    <div id="{{ $id }}" class="{{ $height }} text-sm"></div>
</div>
<input type="hidden" name="{{ $name }}" id="input-{{ $id }}" value="{{ old($name, $value) }}">

@push('styles')
<style>
    /* Tailwind override for Quill */
    .ql-toolbar.ql-snow {
        border: none !important;
        border-bottom: 1px solid #e5e7eb !important;
        background-color: #f9fafb;
        font-family: inherit;
    }
    .ql-container.ql-snow {
        border: none !important;
        font-family: inherit;
        font-size: 0.875rem; /* text-sm */
    }
    .ql-editor {
        padding: 1rem;
    }
    .ql-editor p {
        margin-bottom: 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const quill_{{ $jsId }} = new Quill('#{{ $id }}', {
            theme: 'snow',
            placeholder: '{{ $placeholder }}',
            modules: {
                toolbar: [
                    [{ 'header': [2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['link'],
                    ['clean']
                ]
            }
        });

        // Set old value to quill
        const oldDesc_{{ $jsId }} = document.getElementById('input-{{ $id }}').value;
        if (oldDesc_{{ $jsId }}) {
            quill_{{ $jsId }}.clipboard.dangerouslyPasteHTML(oldDesc_{{ $jsId }});
        }

        // On text change, update hidden input
        quill_{{ $jsId }}.on('text-change', function() {
            const html = quill_{{ $jsId }}.root.innerHTML;
            document.getElementById('input-{{ $id }}').value = (html === '<p><br></p>') ? '' : html;
        });
    });
</script>
@endpush
