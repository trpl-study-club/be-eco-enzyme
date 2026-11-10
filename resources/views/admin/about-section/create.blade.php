@extends('layouts.admin')

@section('title', 'Buat Konten Baru - Tentang Kami')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900">Halaman Depan</a>
    <span>/</span>
    <a href="{{ route('admin.about-sections.index') }}" class="text-slate-500 hover:text-slate-900">Tentang Kami</a>
    <span>/</span>
    <span class="text-slate-800">Buat Baru</span>
@endsection

@section('page_title', 'Buat Konten Tentang Kami')

@section('header_actions')
    <div class="hidden sm:flex items-center gap-2.5">
        <a href="{{ route('admin.about-sections.index') }}"
            class="px-4 py-2 text-xs font-semibold text-slate-700 hover:text-slate-900 bg-white border border-gray-200 rounded-xl hover:bg-slate-50 transition-colors shrink-0">
            Kembali
        </a>
        <button type="button" onclick="submitWithAction('draft')"
            class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-gray-50 text-slate-700 text-xs font-semibold rounded-xl border border-gray-200 shadow-2xs hover:border-gray-300 transition-all duration-150 cursor-pointer shrink-0">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
            </svg>
            <span>Simpan Sebagai Draf</span>
        </button>
        <button type="button" onclick="submitWithAction('publish')"
            class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-150 cursor-pointer shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>Simpan & Tampilkan di Website</span>
        </button>
    </div>
@endsection

@section('page_headline', 'Buat Konten Tentang Kami')
@section('page_subtitle', 'Tuliskan informasi pengenalan dan kartu kegiatan program untuk ditampilkan di halaman depan website.')
@section('status_badge')
    <span
        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/60">
        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
        Mode Tambah Baru
    </span>
@endsection

@section('content')
    <form action="{{ route('admin.about-sections.store') }}" method="POST" id="about-section-form"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="action" id="form-action" value="publish">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- KOLOM KIRI (8 Kolom): Konten Utama & Daftar Cards -->
            <div class="lg:col-span-8 space-y-6">

                <!-- CARD 1: Konten Utama & Deskripsi -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                    <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Informasi Utama Tentang Kami</h3>
                            <p class="text-xs text-slate-500">Tulis judul dan cerita ringkas mengenai latar belakang atau tujuan program.</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <!-- Judul Field -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="title" class="block text-xs font-bold text-slate-700">
                                    Judul Konten <span class="text-rose-500">*</span>
                                </label>
                                <span id="title-counter" class="text-[11px] text-slate-400 font-mono">0 / 255 Karakter</span>
                            </div>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                maxlength="255" placeholder="Contoh: Mengenal Lebih Dekat Pengabdian Masyarakat Kami"
                                oninput="document.getElementById('title-counter').innerText = this.value.length + ' / 255 Karakter'"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            <p class="text-[11px] text-slate-400 mt-1.5">
                                Gunakan judul yang ramah, jelas, dan mudah dipahami pengunjung.
                            </p>
                        </div>

                        <!-- Deskripsi Rich Editor -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2">
                                Deskripsi Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <x-form.rich-editor name="description" :value="old('description')" placeholder="Tuliskan latar belakang, tujuan, atau manfaat kegiatan pengabdian ini..." />
                            <p class="text-[11px] text-slate-400 mt-1.5">
                                Tuliskan penjelasan tentang program dengan kalimat yang santun dan mudah dibaca.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: Daftar Cards Program / Fitur (Multiple) -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                    <div class="flex items-center justify-between pb-5 border-b border-gray-100 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-base font-bold text-slate-900">Kartu Program & Kegiatan</h3>
                                </div>
                                <p class="text-xs text-slate-500">Tambahkan poin-poin kegiatan atau keunggulan program (dilengkapi ikon dan penjelasan singkat).</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 text-xs font-medium">
                            <button type="button" onclick="collapseAllCards()"
                                class="text-slate-500 hover:text-slate-900 underline">Tutup Semua Rincian</button>
                            <span class="text-slate-300">|</span>
                            <button type="button" onclick="expandAllCards()"
                                class="text-slate-500 hover:text-slate-900 underline">Buka Semua Rincian</button>
                        </div>
                    </div>

                    <!-- Cards Container (Repeater) -->
                    <div id="cards-container" class="space-y-4">
                        <!-- Default Initial Card -->
                        <div class="card-item rounded-xl border border-slate-200 bg-slate-50/40 overflow-hidden transition-all shadow-2xs"
                            data-index="0">
                            <!-- Card Item Header -->
                            <div class="p-3.5 bg-slate-100/70 border-b border-slate-200/70 flex items-center justify-between cursor-pointer"
                                onclick="toggleCardAccordion(this)">
                                <div class="flex items-center gap-2.5">
                                    <span
                                        class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center card-badge-num">1</span>
                                    <span class="card-header-title text-xs font-bold text-slate-800">Kartu 1</span>
                                </div>
                                <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                                    <button type="button" onclick="removeCardItem(this)" title="Hapus Kartu"
                                        class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                    <button type="button" onclick="toggleCardAccordion(this.parentElement)"
                                        class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg transition-colors">
                                        <svg class="w-4 h-4 card-accordion-icon transform transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Card Item Body -->
                            <div class="card-body p-4 space-y-4 bg-white">
                                <!-- Judul Card -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        Judul Kartu Kegiatan <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" name="cards[0][title]" value="{{ old('cards.0.title') }}"
                                        required placeholder="Contoh: Pemberdayaan Petani Lokal"
                                        oninput="updateCardHeaderTitle(this)"
                                        class="card-title-input w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                                </div>

                                <!-- Icon Selection -->
                                <x-form.icon-picker
                                    name="cards[0][icon_name]"
                                    :value="old('cards.0.icon_name')"
                                    label="Ikon Kartu (Pilihan)"
                                    :with-upload="true"
                                    upload-name="cards[0][icon_image]"
                                    remove-name="cards[0][remove_icon_image]"
                                />

                                <!-- Deskripsi Card -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        Penjelasan Singkat <span class="text-rose-500">*</span>
                                    </label>
                                    <textarea name="cards[0][description]" rows="3" required
                                        placeholder="Jelaskan secara ringkas kegiatan, fokus, atau manfaat pada poin ini..."
                                        class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">{{ old('cards.0.description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Button -->
                    <button type="button" onclick="addNewCardItem()"
                        class="mt-5 w-full py-3 border-2 border-dashed border-emerald-300 hover:border-emerald-500 bg-emerald-50/30 hover:bg-emerald-50/80 rounded-xl text-xs font-bold text-emerald-800 hover:text-emerald-900 transition-all flex items-center justify-center gap-2 cursor-pointer shadow-2xs">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        <span>Tambah Kartu Kegiatan Baru</span>
                    </button>
                </div>

            </div>

            <!-- KOLOM KANAN (4 Kolom): Status & Aksi -->
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
                            <h3 class="text-base font-bold text-slate-900">Status Penayangan</h3>
                            <p class="text-xs text-slate-500">Pilih apakah konten Tentang Kami ini langsung tampil atau disimpan sebagai draf.</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-2">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-800">Tayangkan di Website?</span>
                                <span id="status-badge"
                                    class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">Aktif di Website</span>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-0.5">Jika aktif, pengunjung langsung dapat membaca profil dan kegiatan program ini.</p>
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
                                <span class="font-bold block text-emerald-900">Kebijakan 1 Konten Aktif</span>
                                <p class="text-[11px] text-emerald-700/90 mt-0.5">Halaman depan hanya menampilkan 1 konten Tentang Kami. Jika konten ini diaktifkan, konten lama yang sebelumnya aktif otomatis dijadikan <strong>Draf</strong>.</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 space-y-2 text-xs">
                        <div class="flex justify-between items-start text-slate-500">
                            <span>Terakhir Diperbarui:</span>
                            <div class="text-right">
                                <span class="text-slate-700 font-medium">{{ now()->translatedFormat('d M Y, H:i') }} WIB</span>
                                <span class="text-[11px] text-emerald-600 font-medium block">Saat disimpan (Baru)</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Tombol Aksi Khusus Layar Kecil (Mobile / Di Bawah Konten) -->
        <div class="sm:hidden mt-6 bg-white rounded-2xl border border-gray-200/80 shadow-xs p-4 space-y-3">
            <div class="flex items-center gap-2.5">
                <button type="button" onclick="submitWithAction('draft')"
                    class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-4 bg-white hover:bg-gray-50 text-slate-700 text-xs font-semibold rounded-xl border border-gray-200 shadow-2xs transition-all cursor-pointer">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                        </path>
                    </svg>
                    <span>Simpan Sebagai Draf</span>
                </button>
                <button type="button" onclick="submitWithAction('publish')"
                    class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Simpan & Tampilkan di Website</span>
                </button>
            </div>
            <a href="{{ route('admin.about-sections.index') }}"
                class="w-full inline-flex items-center justify-center py-2.5 px-4 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors">
                Kembali ke Daftar Konten
            </a>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const titleInput = document.getElementById('title');
            if (titleInput) {
                document.getElementById('title-counter').innerText = titleInput.value.length + ' / 255 Karakter';
            }

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });

        function submitWithAction(action) {
            document.getElementById('form-action').value = action;
            const toggle = document.getElementById('is_active_toggle');
            const badge = document.getElementById('status-badge');
            if (action === 'draft') {
                if (toggle) toggle.checked = false;
                if (badge) {
                    badge.className = 'px-2 py-0.5 rounded text-[10px] font-bold bg-gray-200 text-slate-700';
                    badge.innerText = 'Draf (Belum Tampil)';
                }
            } else if (action === 'publish') {
                if (toggle) toggle.checked = true;
                if (badge) {
                    badge.className = 'px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800';
                    badge.innerText = 'Aktif di Website';
                }
            }

            const form = document.getElementById('about-section-form');
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

        // ─── Cards Repeater Scripts ──────────────────────────────────────────
        let cardIndexCounter = 1;

        function updateCardBadgeCount() {
            const count = document.querySelectorAll('#cards-container .card-item').length;
            const el = document.getElementById('card-count-badge');
            if (el) el.innerText = count + ' Kartu Kegiatan';
        }

        function reindexCards() {
            const items = document.querySelectorAll('#cards-container .card-item');
            items.forEach((item, idx) => {
                const badge = item.querySelector('.card-badge-num');
                if (badge) badge.innerText = idx + 1;

                const headerTitle = item.querySelector('.card-header-title');
                const titleInput = item.querySelector('.card-title-input');
                if (headerTitle) {
                    const val = titleInput && titleInput.value.trim() ? titleInput.value.trim() : 'Kartu ' + (idx + 1);
                    headerTitle.innerText = val;
                }
            });
            updateCardBadgeCount();
        }

        function updateCardHeaderTitle(input) {
            const item = input.closest('.card-item');
            const headerTitle = item.querySelector('.card-header-title');
            const idx = Array.from(document.querySelectorAll('#cards-container .card-item')).indexOf(item) + 1;
            if (headerTitle) {
                headerTitle.innerText = input.value.trim() ? input.value.trim() : 'Kartu ' + idx;
            }
        }

        function toggleCardAccordion(trigger) {
            const item = trigger.closest('.card-item');
            const body = item.querySelector('.card-body');
            const icon = item.querySelector('.card-accordion-icon');

            if (body.classList.contains('hidden')) {
                body.classList.remove('hidden');
                if (icon) icon.classList.remove('-rotate-90');
            } else {
                body.classList.add('hidden');
                if (icon) icon.classList.add('-rotate-90');
            }
        }

        function collapseAllCards() {
            document.querySelectorAll('#cards-container .card-item').forEach(item => {
                item.querySelector('.card-body').classList.add('hidden');
                const icon = item.querySelector('.card-accordion-icon');
                if (icon) icon.classList.add('-rotate-90');
            });
        }

        function expandAllCards() {
            document.querySelectorAll('#cards-container .card-item').forEach(item => {
                item.querySelector('.card-body').classList.remove('hidden');
                const icon = item.querySelector('.card-accordion-icon');
                if (icon) icon.classList.remove('-rotate-90');
            });
        }

        function addNewCardItem() {
            const container = document.getElementById('cards-container');
            const currentCount = container.querySelectorAll('.card-item').length;
            const newNum = currentCount + 1;
            const index = cardIndexCounter++;

            const cardHtml = `
            <div class="card-item rounded-xl border border-slate-200 bg-slate-50/40 overflow-hidden transition-all shadow-2xs" data-index="${index}">
                <div class="p-3.5 bg-slate-100/70 border-b border-slate-200/70 flex items-center justify-between cursor-pointer" onclick="toggleCardAccordion(this)">
                    <div class="flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center card-badge-num">${newNum}</span>
                        <span class="card-header-title text-xs font-bold text-slate-800">Kartu ${newNum}</span>
                    </div>
                    <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                        <button type="button" onclick="removeCardItem(this)" title="Hapus Kartu" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                        <button type="button" onclick="toggleCardAccordion(this.parentElement)" class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg transition-colors">
                            <svg class="w-4 h-4 card-accordion-icon transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="card-body p-4 space-y-4 bg-white">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Judul Kartu Kegiatan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               name="cards[${index}][title]"
                               required
                               placeholder="Contoh: Pemberdayaan Petani Lokal"
                               oninput="updateCardHeaderTitle(this)"
                               class="card-title-input w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                    </div>

                    <!-- Icon Selection -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Ikon Kartu (Pilihan)
                        </label>
                        <input type="hidden" name="cards[${index}][icon_name]" class="card-icon-name-input" value="">
                        <input type="hidden" name="cards[${index}][remove_icon_image]" value="0" class="card-remove-icon-flag">
                        <div class="flex items-start gap-3">
                            <!-- Lucide Picker Button -->
                            <div class="flex-1">
                                <button type="button" onclick="openIconPicker(this)"
                                    class="icon-picker-trigger w-full flex items-center gap-2.5 px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-600 hover:border-emerald-400 hover:bg-emerald-50/30 transition-all cursor-pointer">
                                    <span class="icon-picker-preview w-5 h-5 text-slate-400 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </span>
                                    <span class="icon-picker-label flex-1 text-left">Pilih Ikon...</span>
                                    <span class="icon-picker-clear hidden text-rose-400 hover:text-rose-600 p-0.5" onclick="event.stopPropagation(); clearSelectedIcon(this)">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </span>
                                </button>
                            </div>
                            <!-- Upload Custom Icon -->
                            <div class="flex-1">
                                <div class="icon-upload-zone border border-dashed border-gray-200 hover:border-emerald-400 rounded-xl px-3.5 py-2.5 text-center cursor-pointer transition-all bg-gray-50/50 hover:bg-emerald-50/30"
                                     onclick="this.querySelector('.card-icon-image-input').click()">
                                    <input type="file" name="cards[${index}][icon_image]"
                                           accept="image/png,image/jpeg,image/jpg,image/webp,image/svg+xml"
                                           onchange="handleIconImagePreview(this)"
                                           class="card-icon-image-input hidden">
                                    <div class="icon-upload-preview hidden flex items-center gap-2">
                                        <img src="#" alt="Icon Preview" class="icon-upload-preview-img w-6 h-6 object-contain rounded">
                                        <span class="text-xs text-slate-700 font-medium truncate flex-1">Ikon Sendiri</span>
                                        <button type="button" onclick="event.stopPropagation(); removeIconImage(this)" class="text-rose-400 hover:text-rose-600 p-0.5 shrink-0">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                    <div class="icon-upload-placeholder flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        <span class="text-xs text-slate-500">Unggah Ikon Sendiri</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">Pilih ikon dari daftar atau unggah file gambar Anda sendiri (PNG, SVG, maks 512 KB).</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Penjelasan Singkat <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="cards[${index}][description]"
                                  rows="3"
                                  required
                                  placeholder="Jelaskan secara ringkas kegiatan, fokus, atau manfaat pada poin ini..."
                                  class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600"></textarea>
                    </div>
                </div>
            </div>
        `;

            container.insertAdjacentHTML('beforeend', cardHtml);
            reindexCards();

            const newCard = container.lastElementChild;
            newCard.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        function removeCardItem(btn) {
            const container = document.getElementById('cards-container');
            const items = container.querySelectorAll('.card-item');
            if (items.length <= 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Minimal harus ada 1 kartu kegiatan di dalam modul Tentang Kami.',
                    confirmButtonColor: '#10b981',
                    confirmButtonText: 'Mengerti'
                });
                return;
            }

            const item = btn.closest('.card-item');
            item.style.opacity = '0';
            item.style.transform = 'scale(0.95)';
            setTimeout(() => {
                item.remove();
                reindexCards();
            }, 150);
        }

    </script>
@endpush
