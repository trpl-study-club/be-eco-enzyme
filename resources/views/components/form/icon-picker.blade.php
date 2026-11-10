@props([
    'name',
    'value' => null,
    'label' => 'Icon (Opsional)',
    'placeholder' => 'Pilih Icon Lucide...',
    'withUpload' => false,
    'uploadName' => null,
    'uploadValue' => null,
    'removeName' => null,
    'hint' => null,
])

@php
    $currentIcon = old($name, $value);
    $uploadInputName = $uploadName ?? ($name . '_file');
    $removeFlagName = $removeName ?? ('remove_' . $uploadInputName);
    $hasImage = !empty($uploadValue);
@endphp

<div class="icon-picker-component">
    @if($label)
        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
            {{ $label }}
        </label>
    @endif

    <!-- Hidden Input for Icon Name -->
    <input type="hidden" name="{{ $name }}" class="icon-picker-input card-icon-name-input" value="{{ $currentIcon ?? '' }}">

    @if($withUpload)
        <!-- Hidden Flag for Image Removal -->
        <input type="hidden" name="{{ $removeFlagName }}" value="0" class="icon-remove-flag card-remove-icon-flag">
    @endif

    <div class="flex items-start gap-3">
        <!-- Lucide Picker Trigger Button -->
        <div class="flex-1">
            <button type="button" onclick="openIconPicker(this)" data-placeholder="{{ $placeholder }}"
                class="icon-picker-trigger w-full flex items-center gap-2.5 px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-600 hover:border-emerald-400 hover:bg-emerald-50/30 transition-all cursor-pointer">
                <span class="icon-picker-preview w-5 h-5 text-slate-400 flex items-center justify-center shrink-0">
                    @if($currentIcon)
                        <i data-lucide="{{ $currentIcon }}" class="w-4 h-4 text-emerald-600"></i>
                    @else
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    @endif
                </span>
                <span class="icon-picker-label flex-1 text-left truncate {{ $currentIcon ? 'text-slate-900 font-semibold' : 'text-slate-600' }}">
                    {{ $currentIcon ?: $placeholder }}
                </span>
                <span class="icon-picker-clear {{ $currentIcon ? '' : 'hidden' }} text-rose-400 hover:text-rose-600 p-0.5 rounded transition-colors"
                      onclick="event.stopPropagation(); clearSelectedIcon(this)" title="Hapus Icon">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </span>
            </button>
        </div>

        @if($withUpload)
            <!-- Upload Custom Icon / Image Zone -->
            <div class="flex-1">
                <div class="icon-upload-zone border border-dashed border-gray-200 hover:border-emerald-400 rounded-xl px-3.5 py-2.5 text-center cursor-pointer transition-all bg-gray-50/50 hover:bg-emerald-50/30"
                     onclick="this.querySelector('.card-icon-image-input, .icon-image-input').click()">
                    <input type="file" name="{{ $uploadInputName }}"
                           accept="image/png,image/jpeg,image/jpg,image/webp,image/svg+xml"
                           onchange="handleIconImagePreview(this)"
                           class="card-icon-image-input icon-image-input hidden">
                    <div class="icon-upload-preview {{ $hasImage ? '' : 'hidden' }} flex items-center gap-2">
                        <img src="{{ $uploadValue ?: '#' }}" alt="Icon Preview" class="icon-upload-preview-img w-6 h-6 object-contain rounded">
                        <span class="text-xs text-slate-700 font-medium truncate flex-1">Custom Icon</span>
                        <button type="button" onclick="event.stopPropagation(); removeIconImage(this)" class="text-rose-400 hover:text-rose-600 p-0.5 shrink-0" title="Hapus Custom Image">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="icon-upload-placeholder {{ $hasImage ? 'hidden' : '' }} flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        <span class="text-xs text-slate-500 truncate">Upload Custom</span>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if($hint)
        <p class="text-[10px] text-slate-400 mt-1">{{ $hint }}</p>
    @elseif($withUpload)
        <p class="text-[10px] text-slate-400 mt-1">Pilih icon Lucide atau upload gambar custom (PNG, SVG, maks 512KB).</p>
    @endif
</div>

{{-- Ensure Modal and Scripts are loaded once per page --}}
@once('lucide-icon-picker-modal-instance')
    <x-form.icon-picker-modal />
@endonce
