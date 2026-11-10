@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900">Bagian Website</a>
    <span>/</span>
    <a href="{{ route('admin.product-sections.index') }}" class="text-slate-500 hover:text-slate-900">Kelola Produk</a>
    <span>/</span>
    <span class="text-slate-800 font-semibold">Tambah Produk</span>
@endsection

@section('page_title', 'Tambah Produk Baru')

@section('header_actions')
    <div class="hidden sm:flex items-center gap-2.5">
        <a href="{{ route('admin.product-sections.index') }}"
            class="px-4 py-2 text-xs font-semibold text-slate-700 hover:text-slate-900 bg-white border border-gray-200 rounded-xl hover:bg-slate-50 transition-colors shrink-0">
            Batalkan & Kembali
        </a>
        <button type="button" onclick="submitWithAction('draft')"
            class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-gray-50 text-slate-700 text-xs font-semibold rounded-xl border border-gray-200 shadow-2xs hover:border-gray-300 transition-all duration-150 cursor-pointer shrink-0">
            <span>Simpan Nonaktif</span>
        </button>
        <button type="button" onclick="submitWithAction('publish')"
            class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-150 cursor-pointer shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>Simpan & Aktifkan</span>
        </button>
    </div>
@endsection

@section('page_headline', 'Tambah Produk Baru')
@section('page_subtitle', 'Isi informasi produk seperti nama, harga, deskripsi singkat, foto produk, serta status penayangan.')
@section('status_badge')
    <span
        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
        Produk Baru
    </span>
@endsection

@section('content')
    <form id="product-form" action="{{ route('admin.product-sections.store') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="action" id="form-action" value="publish">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- KOLOM KIRI (8 Kolom): Informasi & Foto Produk -->
            <div class="lg:col-span-8 space-y-6">

                <!-- KARTU 1: Informasi Produk -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                    <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Informasi Produk</h3>
                            <p class="text-xs text-slate-500">Masukkan nama produk, harga, dan deskripsi singkat produk.</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Nama Produk -->
                            <div>
                                <label for="name" class="block text-sm font-bold text-slate-800 mb-2">
                                    Nama Produk <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                    maxlength="255" placeholder="Contoh: Sabun Batang Eco-Enzyme"
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            </div>

                            <!-- Harga Produk -->
                            <div>
                                <label for="price" class="block text-sm font-bold text-slate-800 mb-2">
                                    Harga Produk <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" id="price" name="price" value="{{ old('price') }}" required
                                    maxlength="255" placeholder="Contoh: Rp 15.000"
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            </div>
                        </div>

                        <!-- Deskripsi Singkat / Detail Produk -->
                        <div>
                            <label for="detail" class="block text-sm font-bold text-slate-800 mb-2">
                                Deskripsi Singkat / Detail Produk
                            </label>
                            <textarea id="detail" name="detail" rows="4"
                                placeholder="Tuliskan deskripsi singkat atau detail produk..."
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all leading-relaxed">{{ old('detail') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- KARTU 2: Foto Produk -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-6">
                    <div class="flex items-center gap-3 pb-5 border-b border-gray-100">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Foto Produk</h3>
                            <p class="text-xs text-slate-500">Klik atau seret & lepas (drag and drop) gambar produk ke area di bawah ini.</p>
                        </div>
                    </div>

                    <!-- Foto Utama (Drag & Drop) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">
                            Foto Utama Produk
                        </label>
                        <div id="main-image-dropzone"
                            class="border-2 border-dashed border-gray-200 hover:border-emerald-400 rounded-xl p-6 text-center cursor-pointer transition-all bg-gray-50/50 hover:bg-emerald-50/30"
                            onclick="document.getElementById('main-image-input').click()">
                            <input type="file" id="main-image-input" name="image"
                                accept="image/png,image/jpeg,image/jpg,image/webp" onchange="previewMainImage(this)"
                                class="hidden">

                            <div id="main-preview-wrapper" class="hidden mb-2">
                                <div
                                    class="w-full sm:max-w-xs h-56 sm:h-64 mx-auto bg-white rounded-xl border border-slate-200 shadow-2xs mb-2 flex items-center justify-center overflow-hidden p-2">
                                    <img id="main-preview-img" src="#" alt="Preview"
                                        class="w-full h-full object-contain rounded-lg">
                                </div>
                                <button type="button" onclick="event.stopPropagation(); clearMainImage()"
                                    class="text-xs text-rose-600 hover:text-rose-800 font-semibold underline cursor-pointer">
                                    Hapus / Ganti Foto Utama
                                </button>
                            </div>

                            <div id="main-dropzone-content">
                                <svg class="w-9 h-9 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <p class="text-xs font-semibold text-slate-700">
                                    Klik atau seret & lepas (drop) foto utama di sini
                                </p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Format: PNG, JPG, WEBP • Maks 2MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Foto Tambahan / Galeri (Drag & Drop, Maks 5) -->
                    <div class="pt-4 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <label class="block text-xs font-bold text-slate-700">
                                    Foto Tambahan / Galeri <span class="text-[11px] font-normal text-slate-400">(Maksimal 5 Foto)</span>
                                </label>
                                <p class="text-[11px] text-slate-400 mt-0.5">Opsional, seret & lepas foto tambahan untuk galeri produk.</p>
                            </div>
                            <span id="detail-images-counter"
                                class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                                0 / 5 Foto
                            </span>
                        </div>

                        <div id="detail-images-grid" class="grid grid-cols-2 sm:grid-cols-5 gap-3 mb-3"></div>

                        <input type="file" id="detail-images-input" name="detail_images[]" multiple
                            accept="image/png,image/jpeg,image/jpg,image/webp"
                            onchange="handleDetailImagesSelected(this)" class="hidden">

                        <div id="detail-images-dropzone"
                            onclick="document.getElementById('detail-images-input').click()"
                            class="w-full py-4 px-4 border-2 border-dashed border-gray-200 hover:border-emerald-400 rounded-xl bg-gray-50/50 hover:bg-emerald-50/30 text-slate-600 hover:text-emerald-700 text-xs font-semibold flex flex-col items-center justify-center gap-1 transition-all cursor-pointer">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span>Klik atau seret & lepas (drop) foto galeri di sini</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- KOLOM KANAN (4 Kolom): Status Penayangan -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                    <div class="flex items-center gap-3 pb-5 border-b border-gray-100">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Status Produk</h3>
                            <p class="text-xs text-slate-500">Atur apakah produk ini langsung ditampilkan di halaman depan website.</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-2">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-800">Tampilkan Produk?</span>
                                <span id="status-badge"
                                    class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">Aktif</span>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-0.5">Produk Aktif akan tampil di halaman depan website.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" id="is_active_toggle" value="1" checked
                                onchange="toggleStatusBadge(this)" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600">
                            </div>
                        </label>
                    </div>

                    <div class="pt-3 border-t border-gray-100">
                        <div
                            class="p-3 bg-emerald-50/70 border border-emerald-100 rounded-xl flex items-start gap-2.5 text-xs text-emerald-800">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <span class="font-bold block text-emerald-900">Pengelolaan Individual</span>
                                <p class="text-[11px] text-emerald-800 mt-0.5">Setiap produk memiliki status <strong>Aktif/Nonaktif</strong> tersendiri. Produk Nonaktif tetap tersimpan di database dan dapat diaktifkan kembali kapan saja.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Mobile Submit Buttons -->
        <div class="sm:hidden mt-6 bg-white rounded-2xl border border-gray-200/80 shadow-xs p-4 space-y-3">
            <div class="flex items-center gap-2.5">
                <button type="button" onclick="submitWithAction('draft')"
                    class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-4 bg-white hover:bg-gray-50 text-slate-700 text-xs font-semibold rounded-xl border border-gray-200 shadow-2xs transition-all cursor-pointer">
                    <span>Simpan Nonaktif</span>
                </button>
                <button type="button" onclick="submitWithAction('publish')"
                    class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all cursor-pointer">
                    <span>Simpan & Aktifkan</span>
                </button>
            </div>
            <a href="{{ route('admin.product-sections.index') }}"
                class="w-full inline-flex items-center justify-center py-2.5 px-4 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors">
                Batalkan & Kembali
            </a>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        let selectedDetailFiles = [];
        const allowedImageTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];

        function toggleStatusBadge(checkbox) {
            const badge = document.getElementById('status-badge');
            const actionInput = document.getElementById('form-action');
            if (checkbox.checked) {
                badge.textContent = 'Aktif';
                badge.className = 'px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800';
                actionInput.value = 'publish';
            } else {
                badge.textContent = 'Nonaktif';
                badge.className = 'px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600';
                actionInput.value = 'draft';
            }
        }

        function submitWithAction(action) {
            const toggle = document.getElementById('is_active_toggle');
            const actionInput = document.getElementById('form-action');
            actionInput.value = action;
            toggle.checked = (action === 'publish');
            toggleStatusBadge(toggle);
            document.getElementById('product-form').requestSubmit();
        }

        function previewMainImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('main-preview-img').src = e.target.result;
                    document.getElementById('main-preview-wrapper').classList.remove('hidden');
                    document.getElementById('main-dropzone-content').classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function clearMainImage() {
            const input = document.getElementById('main-image-input');
            input.value = '';
            document.getElementById('main-preview-img').src = '#';
            document.getElementById('main-preview-wrapper').classList.add('hidden');
            document.getElementById('main-dropzone-content').classList.remove('hidden');
        }

        function addDetailFiles(files) {
            const validFiles = Array.from(files || []).filter(f => allowedImageTypes.includes(f.type));
            const remaining = 5 - selectedDetailFiles.length;
            const toAdd = validFiles.slice(0, Math.max(0, remaining));
            selectedDetailFiles = selectedDetailFiles.concat(toAdd);
            syncDetailFilesInput();
            renderDetailPreviews();
        }

        function handleDetailImagesSelected(input) {
            addDetailFiles(input.files);
        }

        function removeDetailImageAt(index) {
            selectedDetailFiles.splice(index, 1);
            syncDetailFilesInput();
            renderDetailPreviews();
        }

        function syncDetailFilesInput() {
            const dt = new DataTransfer();
            selectedDetailFiles.forEach(file => dt.items.add(file));
            document.getElementById('detail-images-input').files = dt.files;
        }

        function renderDetailPreviews() {
            const grid = document.getElementById('detail-images-grid');
            const counter = document.getElementById('detail-images-counter');
            const dropzone = document.getElementById('detail-images-dropzone');

            grid.innerHTML = '';
            counter.textContent = `${selectedDetailFiles.length} / 5 Foto`;
            dropzone.classList.toggle('hidden', selectedDetailFiles.length >= 5);

            selectedDetailFiles.forEach((file, idx) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative w-full h-28 sm:h-32 rounded-xl border border-gray-200 overflow-hidden bg-gray-50 group';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover" alt="Detail">
                        <button type="button" onclick="removeDetailImageAt(${idx})"
                            class="absolute top-1.5 right-1.5 w-6 h-6 rounded-full bg-rose-600 text-white flex items-center justify-center text-xs shadow-sm cursor-pointer">
                            &times;
                        </button>
                    `;
                    grid.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }

        function bindDropzone(dropzoneEl, onFilesDropped) {
            if (!dropzoneEl) return;

            ['dragenter', 'dragover'].forEach(eventName => {
                dropzoneEl.addEventListener(eventName, function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzoneEl.classList.add('border-emerald-500', 'bg-emerald-50/70', 'ring-2', 'ring-emerald-500/20');
                });
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzoneEl.addEventListener(eventName, function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzoneEl.classList.remove('border-emerald-500', 'bg-emerald-50/70', 'ring-2', 'ring-emerald-500/20');
                });
            });

            dropzoneEl.addEventListener('drop', function(e) {
                const files = e.dataTransfer?.files;
                if (files && files.length > 0) {
                    onFilesDropped(files);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            bindDropzone(document.getElementById('main-image-dropzone'), function(files) {
                const validFile = Array.from(files).find(f => allowedImageTypes.includes(f.type));
                if (!validFile) return;
                const dt = new DataTransfer();
                dt.items.add(validFile);
                const mainInput = document.getElementById('main-image-input');
                mainInput.files = dt.files;
                previewMainImage(mainInput);
            });

            bindDropzone(document.getElementById('detail-images-dropzone'), function(files) {
                addDetailFiles(files);
            });
        });
    </script>
@endpush
