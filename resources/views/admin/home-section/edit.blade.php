@extends('layouts.admin')

@section('title', 'Ubah Banner - Beranda')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900">Halaman Depan</a>
    <span>/</span>
    <a href="{{ route('admin.home-sections.index') }}" class="text-slate-500 hover:text-slate-900">Banner Beranda</a>
    <span>/</span>
    <span class="text-slate-800">Ubah Banner</span>
@endsection

@section('page_title', 'Ubah Banner Beranda')

@section('header_actions')
    <div class="hidden sm:flex items-center gap-2.5">
        <a href="{{ route('admin.home-sections.index') }}" class="px-4 py-2 text-xs font-semibold text-slate-700 hover:text-slate-900 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors shrink-0">
            Kembali
        </a>
        <button type="button" onclick="submitWithAction('draft')" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-gray-50 text-slate-700 text-xs font-semibold rounded-xl border border-gray-200 shadow-2xs hover:border-gray-300 transition-all duration-150 cursor-pointer shrink-0">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
            </svg>
            <span>Simpan Sebagai Draf</span>
        </button>
        <button type="button" onclick="submitWithAction('publish')" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-150 cursor-pointer shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>Simpan & Tampilkan di Website</span>
        </button>
    </div>
@endsection

@section('page_headline', 'Ubah Banner Beranda')
@section('page_subtitle', 'Perbarui judul, deskripsi, tautan tombol, foto banner, serta status penayangan di halaman depan website.')
@section('status_badge')
    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $homeSection->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-gray-100 text-slate-700 border border-gray-200/60' }}">
        <span class="w-2 h-2 rounded-full {{ $homeSection->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
        Status: {{ $homeSection->is_active ? 'Aktif di Website' : 'Draf (Belum Tampil)' }}
    </span>
@endsection

@section('content')
<form id="home-section-form" action="{{ route('admin.home-sections.update', $homeSection) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="action" id="form-action" value="{{ $homeSection->is_active ? 'publish' : 'draft' }}">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- KOLOM KIRI (8 Kolom): Konten Utama & Tombol Aksi -->
        <div class="lg:col-span-8 space-y-6">

            <!-- CARD 1: Konten Utama -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Konten Utama Banner</h3>
                        <p class="text-xs text-slate-500">Tulis judul utama dan penjelasan singkat kegiatan atau program Anda.</p>
                    </div>
                </div>

                <div class="space-y-5">
                    <!-- Judul Field -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="title" class="block text-xs font-bold text-slate-700">
                                Judul Banner <span class="text-rose-500">*</span>
                            </label>
                            <span id="title-counter" class="text-[11px] text-slate-400 font-mono">{{ strlen(old('title', $homeSection->title)) }} / 255 Karakter</span>
                        </div>
                        <input type="text"
                               id="title"
                               name="title"
                               value="{{ old('title', $homeSection->title) }}"
                               required
                               maxlength="255"
                               placeholder="Contoh: Pengabdian Kepada Masyarakat Universitas"
                               oninput="document.getElementById('title-counter').innerText = this.value.length + ' / 255 Karakter'"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                        <p class="text-[11px] text-slate-400 mt-1.5">
                            Gunakan kalimat yang jelas, menarik, dan mudah dipahami pengunjung dalam sekali baca.
                        </p>
                    </div>

                    <!-- Deskripsi Rich Editor -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2">
                            Deskripsi Singkat <span class="text-rose-500">*</span>
                        </label>
                        <x-form.rich-editor name="description" :value="old('description', $homeSection->description)" placeholder="Tulis ringkasan atau pengantar program yang ingin Anda sampaikan kepada pengunjung..." />
                        <p class="text-[11px] text-slate-400 mt-1.5">
                            Tuliskan 1-2 kalimat ringkas untuk menjelaskan secara singkat apa kegiatan atau keunggulan produk Anda.
                        </p>
                    </div>
                </div>
            </div>

            <!-- CARD 2: Tombol Aksi (Call to Action) -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Tombol Tautan Pengunjung (Pilihan)</h3>
                        <p class="text-xs text-slate-500">Pengunjung dapat menekan tombol ini untuk langsung menuju bagian tertentu atau nomor WhatsApp.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Tombol Utama (Button 1) -->
                    <div class="p-4 rounded-xl border border-gray-200 bg-gray-50/50 space-y-3">
                        <div class="flex items-center justify-between pb-2 border-b border-gray-200/60">
                            <span class="text-xs font-bold text-slate-800">Tombol Utama (Pertama)</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-600 text-white">UTAMA</span>
                        </div>
                        <div>
                            <label for="button_one_text" class="block text-[11px] font-semibold text-slate-600 mb-1">Tulisan pada Tombol</label>
                            <input type="text"
                                   id="button_one_text"
                                   name="button_one_text"
                                   value="{{ old('button_one_text', $homeSection->button_one_text) }}"
                                   placeholder="Contoh: Lihat Katalog Produk"
                                   class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                        </div>
                        <div>
                            <label for="button_one_link" class="block text-[11px] font-semibold text-slate-600 mb-1">Tujuan Tautan (Link / URL)</label>
                            <input type="text"
                                   id="button_one_link"
                                   name="button_one_link"
                                   value="{{ old('button_one_link', $homeSection->button_one_link) }}"
                                   placeholder="Contoh: #produk atau https://website.com"
                                   class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            <p class="text-[10px] text-slate-400 mt-1">Bisa berupa bagian halaman (misal: #produk) atau alamat web (https://...).</p>
                        </div>
                    </div>

                    <!-- Tombol Sekunder (Button 2) -->
                    <div class="p-4 rounded-xl border border-gray-200 bg-gray-50/50 space-y-3">
                        <div class="flex items-center justify-between pb-2 border-b border-gray-200/60">
                            <span class="text-xs font-bold text-slate-800">Tombol Tambahan (Kedua)</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-gray-200 text-slate-700">KEDUA</span>
                        </div>
                        <div>
                            <label for="button_two_text" class="block text-[11px] font-semibold text-slate-600 mb-1">Tulisan pada Tombol</label>
                            <input type="text"
                                   id="button_two_text"
                                   name="button_two_text"
                                   value="{{ old('button_two_text', $homeSection->button_two_text) }}"
                                   placeholder="Contoh: Hubungi Kami di WhatsApp"
                                   class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                        </div>
                        <div>
                            <label for="button_two_link" class="block text-[11px] font-semibold text-slate-600 mb-1">Tujuan Tautan (Link / URL)</label>
                            <input type="text"
                                   id="button_two_link"
                                   name="button_two_link"
                                   value="{{ old('button_two_link', $homeSection->button_two_link) }}"
                                   placeholder="Contoh: https://wa.me/6281234567890 atau #kontak"
                                   class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            <p class="text-[10px] text-slate-400 mt-1">Bisa berupa tautan langsung ke WhatsApp atau bagian halaman lainnya.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- KOLOM KANAN (4 Kolom): Media & Visibilitas -->
        <div class="lg:col-span-4 space-y-6">

            <!-- CARD 3: Media Banner -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Foto Banner Utama</h3>
                        <p class="text-xs text-slate-500">Pilih foto atau ilustrasi menarik untuk dipajang di bagian paling atas website.</p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2">Pilih Berkas Foto</label>
                    <input type="hidden" name="remove_image" id="remove-image-flag" value="{{ old('remove_image', '0') }}">
                    <div id="dropzone"
                         onclick="document.getElementById('image-input').click()"
                         class="border-2 border-dashed border-emerald-200 hover:border-emerald-400 rounded-2xl p-6 text-center cursor-pointer transition-all bg-emerald-50/30 hover:bg-emerald-50/60">
                        <input type="file"
                                id="image-input"
                                name="image"
                                accept="image/png,image/jpeg,image/jpg,image/webp"
                                onchange="handleImagePreview(this)"
                                class="hidden">

                        @php
                            $hasImage = ($homeSection->image && old('remove_image') !== '1');
                        @endphp

                        <!-- Preview Container -->
                        <div id="image-preview-wrapper" class="{{ $hasImage ? '' : 'hidden' }} mb-3">
                            <img id="image-preview"
                                 src="{{ $homeSection->image ? asset('storage/' . $homeSection->image) : '#' }}"
                                 alt="Preview Foto"
                                 class="w-full aspect-square object-cover rounded-xl border border-gray-200 shadow-xs mb-2">
                            <div class="flex items-center justify-center gap-4 text-xs">
                                <span class="text-emerald-700 font-semibold underline">Ganti Foto</span>
                                <button type="button"
                                        id="btn-remove-image"
                                        onclick="event.stopPropagation(); removeSelectedImage()"
                                        class="inline-flex items-center gap-1 text-rose-600 hover:text-rose-800 font-semibold underline cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    <span>Hapus Gambar</span>
                                </button>
                            </div>
                        </div>

                        <!-- Dropzone Icon & Text -->
                        <div id="dropzone-content" class="{{ $hasImage ? 'hidden' : '' }}">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                            </div>
                            <p class="text-xs font-bold text-slate-800">
                                Tarik & letakkan foto di sini, atau <span class="text-emerald-700 font-semibold underline">Pilih Berkas</span>
                            </p>
                            <p class="text-[11px] text-slate-500 mt-1">
                                Format yang diterima: PNG, JPG, WEBP • Ukuran maksimal 2 MB
                            </p>
                            <p class="text-[10px] text-slate-400 mt-0.5">
                                Saran: Foto beresolusi baik dengan rasio seimbang (contoh: 800 × 800 piksel)
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD 4: Visibilitas -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
                <div class="flex items-center gap-3 pb-5 border-b border-gray-100">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Status Penayangan</h3>
                        <p class="text-xs text-slate-500">Pilih apakah banner ini langsung tampil atau disimpan sebagai draf.</p>
                    </div>
                </div>

                <div class="flex items-center justify-between py-2">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-slate-800">Tayangkan di Website?</span>
                            <span id="status-badge" class="px-2 py-0.5 rounded text-[10px] font-bold {{ $homeSection->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-200 text-slate-700' }}">
                                {{ $homeSection->is_active ? 'Aktif di Website' : 'Draf (Belum Tampil)' }}
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-0.5">Jika aktif, pengunjung langsung dapat melihat banner ini.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox"
                               name="is_active"
                               id="is_active_toggle"
                               value="1"
                               {{ old('is_active', $homeSection->is_active) ? 'checked' : '' }}
                               onchange="toggleStatusBadge(this)"
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                    </label>
                </div>

                <!-- Info Sistem: Hanya 1 banner aktif -->
                <div class="pt-3 border-t border-gray-100">
                    <div class="p-3 bg-emerald-50/70 border border-emerald-100 rounded-xl flex items-start gap-2.5 text-xs text-emerald-800">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <span class="font-bold block text-emerald-900">Kebijakan 1 Banner Aktif</span>
                            <p class="text-[11px] text-emerald-700/90 mt-0.5">Halaman depan hanya menampilkan 1 banner utama. Jika banner ini diaktifkan, banner lain yang sebelumnya aktif otomatis dijadikan <strong>Draf</strong>.</p>
                        </div>
                    </div>
                </div>

                <!-- Metadata info -->
                <div class="pt-4 border-t border-gray-100 space-y-2 text-xs">
                    <div class="flex justify-between items-start text-slate-500">
                        <span>Terakhir Diperbarui:</span>
                        <div class="text-right">
                            <span class="text-slate-700 font-medium">{{ $homeSection->updated_at->translatedFormat('d M Y, H:i') }} WIB</span>
                            <span class="text-[11px] text-slate-400 block">({{ $homeSection->updated_at->diffForHumans() }})</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Tombol Aksi Khusus Layar Kecil (Mobile / Di Bawah Konten) -->
    <div class="sm:hidden mt-6 bg-white rounded-2xl border border-gray-200/80 shadow-xs p-4 space-y-3">
        <div class="flex items-center gap-2.5">
            <button type="button" onclick="submitWithAction('draft')" class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-4 bg-white hover:bg-gray-50 text-slate-700 text-xs font-semibold rounded-xl border border-gray-200 shadow-2xs transition-all cursor-pointer">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                </svg>
                <span>Simpan Sebagai Draf</span>
            </button>
            <button type="button" onclick="submitWithAction('publish')" class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Simpan & Tampilkan di Website</span>
            </button>
        </div>
        <a href="{{ route('admin.home-sections.index') }}" class="w-full inline-flex items-center justify-center py-2.5 px-4 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors">
            Kembali ke Daftar Banner
        </a>
    </div>
</form>
@endsection

@push('scripts')
<script>
    // Form submit handler dengan aksi draft atau publish
    function submitWithAction(action) {
        document.getElementById('form-action').value = action;
        const toggle = document.getElementById('is_active_toggle');
        if (action === 'draft') {
            if (toggle) toggle.checked = false;
            const badge = document.getElementById('status-badge');
            if (badge) {
                badge.className = 'px-2 py-0.5 rounded text-[10px] font-bold bg-gray-200 text-slate-700';
                badge.innerText = 'Draf (Belum Tampil)';
            }
        } else if (action === 'publish') {
            if (toggle) toggle.checked = true;
            const badge = document.getElementById('status-badge');
            if (badge) {
                badge.className = 'px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800';
                badge.innerText = 'Aktif di Website';
            }
        }

        const form = document.getElementById('home-section-form');
        if (form.reportValidity()) {
            form.submit();
        }
    }

    function toggleStatusBadge(elem) {
        const badge = document.getElementById('status-badge');
        const formAction = document.getElementById('form-action');
        if (elem.checked) {
            badge.className = 'px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800';
            badge.innerText = 'Aktif di Website';
            if (formAction) formAction.value = 'publish';
        } else {
            badge.className = 'px-2 py-0.5 rounded text-[10px] font-bold bg-gray-200 text-slate-700';
            badge.innerText = 'Draf (Belum Tampil)';
            if (formAction) formAction.value = 'draft';
        }
    }

    function handleImagePreview(input) {
        if (input.files && input.files[0]) {
            const removeFlag = document.getElementById('remove-image-flag');
            if (removeFlag) removeFlag.value = '0';
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('image-preview-wrapper').classList.remove('hidden');
                document.getElementById('dropzone-content').classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeSelectedImage() {
        const input = document.getElementById('image-input');
        if (input) input.value = '';
        const removeFlag = document.getElementById('remove-image-flag');
        if (removeFlag) removeFlag.value = '1';
        const preview = document.getElementById('image-preview');
        if (preview) preview.src = '#';
        const wrapper = document.getElementById('image-preview-wrapper');
        if (wrapper) wrapper.classList.add('hidden');
        const dropzoneContent = document.getElementById('dropzone-content');
        if (dropzoneContent) dropzoneContent.classList.remove('hidden');
    }
</script>
@endpush
