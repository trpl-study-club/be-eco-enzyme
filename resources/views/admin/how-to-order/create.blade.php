@extends('layouts.admin')

@section('title', 'Tambah Panduan Cara Pesan')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900">Halaman Depan</a>
    <span>/</span>
    <a href="{{ route('admin.how-to-orders.index') }}" class="text-slate-500 hover:text-slate-900">Cara Pesan</a>
    <span>/</span>
    <span class="text-slate-800">Buat Baru</span>
@endsection

@section('page_title', 'Tambah Panduan Cara Pesan')

@section('header_actions')
    <div class="hidden sm:flex items-center gap-2.5">
        <a href="{{ route('admin.how-to-orders.index') }}"
            class="px-4 py-2 text-xs font-semibold text-slate-700 hover:text-slate-900 bg-white border border-gray-200 rounded-xl hover:bg-slate-50 transition-colors shrink-0">
            Batal
        </a>
        <button type="button" onclick="submitWithAction('draft')"
            class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-gray-50 text-slate-700 text-xs font-semibold rounded-xl border border-gray-200 shadow-2xs hover:border-gray-300 transition-all duration-150 cursor-pointer shrink-0">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
            </svg>
            <span>Simpan sebagai Draf</span>
        </button>
        <button type="button" onclick="submitWithAction('publish')"
            class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-150 cursor-pointer shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>Simpan & Tampilkan</span>
        </button>
    </div>
@endsection
@section('page_headline', 'Tambah Panduan Cara Pesan Baru')
@section('page_subtitle', 'Tuliskan langkah-langkah pemesanan yang jelas agar pembeli mudah berbelanja.')
@section('status_badge')
    <span
        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/60">
        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
        Status: Membuat Panduan Baru
    </span>
@endsection

@section('content')
    <form action="{{ route('admin.how-to-orders.store') }}" method="POST" id="howToOrderForm"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="action" id="formAction" value="publish">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 items-start">
            <!-- Kolom Kiri: Form Utama -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Data Utama Section -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden">
                    <div class="border-b border-gray-100 bg-gray-50/50 px-5 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h7">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="font-bold text-slate-800 text-sm">Informasi Utama Panduan</h3>
                        </div>
                    </div>

                    <div class="p-5 space-y-5">
                        <!-- Judul Field -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="title" class="block text-xs font-bold text-slate-700">
                                    Judul Panduan <span class="text-rose-500">*</span>
                                </label>
                                <span id="title-counter" class="text-[11px] text-slate-400 font-mono">0 / 255
                                    Karakter</span>
                            </div>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                maxlength="255" placeholder="Contoh: 3 Langkah Mudah Memesan Produk"
                                oninput="document.getElementById('title-counter').innerText = this.value.length + ' / 255 Karakter'"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            <p class="text-[11px] text-slate-400 mt-1.5">
                                Tulis judul yang jelas dan menarik untuk pembeli.
                            </p>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="description" class="block text-xs font-bold text-slate-700">
                                    Penjelasan Tambahan <span class="text-slate-400 font-normal">(Boleh Kosong)</span>
                                </label>
                            </div>
                            <textarea id="description" name="description" rows="3"
                                placeholder="Contoh: Ikuti langkah sederhana berikut untuk memesan produk kami langsung ke WhatsApp admin..."
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all leading-relaxed min-h-[76px] max-h-36 resize-y">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                            @enderror
                            <p class="text-[11px] text-slate-400 mt-1.5">
                                Berikan kalimat pengantar singkat mengenai alur pemesanan.
                            </p>
                        </div>

                        <hr class="border-gray-100">

                        <!-- Tombol CTA -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="button_text" class="block text-xs font-bold text-slate-700 mb-2">
                                    Tulisan pada Tombol (Pilihan)
                                </label>
                                <input type="text" id="button_text" name="button_text" value="{{ old('button_text') }}"
                                    placeholder="Contoh: Pesan Sekarang Lewat WhatsApp" maxlength="255"
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                                <p class="text-[11px] text-slate-400 mt-1.5">
                                    Kosongkan jika tidak ingin menampilkan tombol di bagian ini.
                                </p>
                            </div>
                            <div>
                                <label for="button_link" class="block text-xs font-bold text-slate-700 mb-2">
                                    Tautan Tombol (Link WhatsApp / Web)
                                </label>
                                <input type="text" id="button_link" name="button_link" value="{{ old('button_link') }}"
                                    placeholder="Contoh: https://wa.me/6281234567890" maxlength="255"
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Repeater Langkah (Steps) -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-sm">Daftar Langkah (Steps)</h3>
                                <p class="text-[11px] text-slate-500 mt-0.5">Urutan langkah akan tampil dari atas ke bawah
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 text-xs font-medium">
                            <button type="button" onclick="collapseAllSteps()"
                                class="text-slate-500 hover:text-slate-900 underline cursor-pointer">Tutup Semua</button>
                            <span class="text-slate-300">|</span>
                            <button type="button" onclick="expandAllSteps()"
                                class="text-slate-500 hover:text-slate-900 underline cursor-pointer">Buka Semua</button>
                        </div>
                    </div>

                    <div class="p-5">
                        <div id="steps-container" class="space-y-4">
                            @php
                                $oldSteps = old('steps', []);
                            @endphp

                            @if (count($oldSteps) > 0)
                                @foreach ($oldSteps as $idx => $step)
                                    <!-- Step Item -->
                                    <div class="step-item rounded-xl border border-slate-200 bg-slate-50/40 overflow-hidden transition-all shadow-2xs"
                                        data-index="{{ $idx }}">
                                        <!-- Step Item Header -->
                                        <div class="p-3.5 bg-slate-100/70 border-b border-slate-200/70 flex items-center justify-between cursor-pointer"
                                            onclick="toggleStepAccordion(this)">
                                            <div class="flex items-center gap-2.5">
                                                <span
                                                    class="step-number w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center">{{ $idx + 1 }}</span>
                                                <span
                                                    class="step-header-title text-xs font-bold text-slate-800">{{ $step['title'] ?? 'Langkah Baru' }}</span>
                                            </div>
                                            <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                                                <button type="button" onclick="removeStep(this)" title="Hapus Langkah"
                                                    class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                                <button type="button"
                                                    onclick="toggleStepAccordion(this.parentElement.parentElement)"
                                                    class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg transition-colors cursor-pointer">
                                                    <svg class="w-4 h-4 step-accordion-icon transform transition-transform"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Step Item Body -->
                                        <div class="step-body p-4 space-y-4 bg-white">
                                            <!-- Judul Step -->
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1">
                                                    Judul Langkah <span class="text-rose-500">*</span>
                                                </label>
                                                <input type="text" name="steps[{{ $idx }}][title]"
                                                    value="{{ $step['title'] ?? '' }}" required maxlength="255"
                                                    placeholder="Contoh: Pilih Produk dari Katalog"
                                                    oninput="updateStepHeaderTitle(this)"
                                                    class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                                            </div>

                                            <!-- Icon Selection -->
                                            <x-form.icon-picker name="steps[{{ $idx }}][icon_name]"
                                                :value="old(
                                                    'steps.' . $idx . '.icon_name',
                                                    $step['icon_name'] ?? null,
                                                )" label="Ikon Langkah (Pilih Ikon atau Unggah Sendiri)"
                                                :with-upload="true" upload-name="steps[{{ $idx }}][icon_image]"
                                                :upload-value="isset($step['icon_image_url'])
                                                    ? $step['icon_image_url']
                                                    : (isset($step['icon_image'])
                                                        ? \Illuminate\Support\Facades\Storage::disk('public')->url(
                                                            $step['icon_image'],
                                                        )
                                                        : null)"
                                                remove-name="steps[{{ $idx }}][remove_icon_image]" />

                                            <!-- Deskripsi Step -->
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1">
                                                    Penjelasan Langkah <span class="text-rose-500">*</span>
                                                </label>
                                                <textarea name="steps[{{ $idx }}][description]" rows="2" required
                                                    placeholder="Contoh: Lihat katalog produk kami dan pilih produk lele olahan yang Anda inginkan..."
                                                    class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">{{ $step['description'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <!-- Placeholder jika kosong -->
                        <div id="empty-steps"
                            class="{{ count($oldSteps) > 0 ? 'hidden' : 'flex' }} flex-col items-center justify-center py-10 px-4 text-center border-2 border-dashed border-gray-200 rounded-xl bg-gray-50/50">
                            <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <h4 class="text-sm font-bold text-slate-700">Belum Ada Langkah Pemesanan</h4>
                            <p class="text-[11px] text-slate-500 mt-1 max-w-xs mx-auto">Klik tombol "Tambah Langkah Baru"
                                di bawah
                                untuk mulai menyusun panduan pemesanan.</p>
                        </div>

                        <!-- Add Button -->
                        <button type="button" id="add-step-btn"
                            class="mt-5 w-full py-3 border-2 border-dashed border-emerald-300 hover:border-emerald-500 bg-emerald-50/30 hover:bg-emerald-50/80 rounded-xl text-xs font-bold text-emerald-800 hover:text-emerald-900 transition-all flex items-center justify-center gap-2 cursor-pointer shadow-2xs">
                            <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            <span>Tambah Langkah Baru</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Status & Aksi -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4 sticky top-24">
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
                            <p class="text-xs text-slate-500">Pilih apakah alur pemesanan ini langsung tampil atau disimpan sebagai draf.</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-2">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-800">Tayangkan di Website?</span>
                                <span id="status-badge"
                                    class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">Aktif di Website</span>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-0.5">Jika aktif, pengunjung langsung dapat melihat langkah-langkah pemesanan ini.</p>
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
                                <span class="font-bold block text-emerald-900">Kebijakan 1 Panduan Aktif</span>
                                <p class="text-[11px] text-emerald-700/90 mt-0.5">Halaman depan hanya menampilkan 1 panduan cara pesan. Jika panduan ini diaktifkan, panduan lama yang sebelumnya aktif otomatis dijadikan <strong>Draf</strong>.</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 space-y-2 text-xs">
                        <div class="flex justify-between items-start text-slate-500">
                            <span>Terakhir Diperbarui:</span>
                            <div class="text-right">
                                <span class="text-slate-700 font-medium">{{ now()->translatedFormat('d M Y, H:i') }}
                                    WIB</span>
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
                    <span>Simpan sebagai Draf</span>
                </button>
                <button type="button" onclick="submitWithAction('publish')"
                    class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Simpan & Tampilkan</span>
                </button>
            </div>
            <a href="{{ route('admin.how-to-orders.index') }}"
                class="w-full inline-flex items-center justify-center py-2.5 px-4 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors">
                Batal & Kembali
            </a>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        // ─── FORM SUBMIT ────────────────────────────────────────────────
        function submitWithAction(action) {
            document.getElementById('formAction').value = action;

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

            document.getElementById('howToOrderForm').submit();
        }

        function toggleStatusBadge(elem) {
            const badge = document.getElementById('status-badge');
            const formAction = document.getElementById('formAction');
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

        // ─── REPEATER STEPS ──────────────────────────────────────────────
        let stepIndex = {{ count($oldSteps) > 0 ? max(array_keys($oldSteps)) + 1 : 0 }};
        const stepsContainer = document.getElementById('steps-container');
        const emptySteps = document.getElementById('empty-steps');
        const addStepBtn = document.getElementById('add-step-btn');

        function updateStepNumbers() {
            const items = stepsContainer.querySelectorAll('.step-item');
            items.forEach((item, index) => {
                const numberEl = item.querySelector('.step-number');
                if (numberEl) numberEl.textContent = index + 1;
            });
            if (items.length > 0) {
                emptySteps.classList.add('hidden');
                emptySteps.classList.remove('flex');
            } else {
                emptySteps.classList.remove('hidden');
                emptySteps.classList.add('flex');
            }
        }

        function removeStep(button) {
            const item = button.closest('.step-item');
            item.style.transform = 'scale(0.95)';
            setTimeout(() => {
                item.remove();
                updateStepNumbers();
            }, 200);
        }

        function toggleStepAccordion(headerElem) {
            const item = headerElem.closest('.step-item');
            const body = item.querySelector('.step-body');
            const icon = item.querySelector('.step-accordion-icon');

            if (body.style.display === 'none') {
                body.style.display = 'block';
                icon.style.transform = 'rotate(0deg)';
            } else {
                body.style.display = 'none';
                icon.style.transform = 'rotate(180deg)';
            }
        }

        function collapseAllSteps() {
            document.querySelectorAll('.step-item').forEach(item => {
                const body = item.querySelector('.step-body');
                const icon = item.querySelector('.step-accordion-icon');
                if (body && icon) {
                    body.style.display = 'none';
                    icon.style.transform = 'rotate(180deg)';
                }
            });
        }

        function expandAllSteps() {
            document.querySelectorAll('.step-item').forEach(item => {
                const body = item.querySelector('.step-body');
                const icon = item.querySelector('.step-accordion-icon');
                if (body && icon) {
                    body.style.display = 'block';
                    icon.style.transform = 'rotate(0deg)';
                }
            });
        }

        function updateStepHeaderTitle(input) {
            const item = input.closest('.step-item');
            if (item) {
                const headerTitle = item.querySelector('.step-header-title');
                if (headerTitle) {
                    headerTitle.textContent = input.value || 'Langkah Baru';
                }
            }
        }

        addStepBtn.addEventListener('click', () => {
            const template = `
                <div class="step-item rounded-xl border border-slate-200 bg-slate-50/40 overflow-hidden transition-all shadow-2xs" data-index="${stepIndex}" style="opacity:0; transform:translateY(10px);">
                    <div class="p-3.5 bg-slate-100/70 border-b border-slate-200/70 flex items-center justify-between cursor-pointer" onclick="toggleStepAccordion(this)">
                        <div class="flex items-center gap-2.5">
                            <span class="step-number w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center">#</span>
                            <span class="step-header-title text-xs font-bold text-slate-800">Langkah Baru</span>
                        </div>
                        <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                            <button type="button" onclick="removeStep(this)" title="Hapus Langkah" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                            <button type="button" onclick="toggleStepAccordion(this.parentElement.parentElement)" class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg transition-colors cursor-pointer">
                                <svg class="w-4 h-4 step-accordion-icon transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="step-body p-4 space-y-4 bg-white">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Langkah <span class="text-rose-500">*</span></label>
                            <input type="text" name="steps[${stepIndex}][title]" required maxlength="255" placeholder="Contoh: Pilih Produk dari Katalog" oninput="updateStepHeaderTitle(this)" class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                        </div>

                        <!-- Icon Selection -->
                        <div class="icon-picker-component">
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Ikon Langkah (Pilihan)
                            </label>
                            <input type="hidden" name="steps[${stepIndex}][icon_name]" class="icon-picker-input card-icon-name-input" value="">
                            <input type="hidden" name="steps[${stepIndex}][remove_icon_image]" value="0" class="icon-remove-flag card-remove-icon-flag">
                            <div class="flex items-start gap-3">
                                <!-- Lucide Picker Button -->
                                <div class="flex-1">
                                    <button type="button" onclick="openIconPicker(this)" data-placeholder="Pilih Ikon..."
                                        class="icon-picker-trigger w-full flex items-center gap-2.5 px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-600 hover:border-emerald-400 hover:bg-emerald-50/30 transition-all cursor-pointer">
                                        <span class="icon-picker-preview w-5 h-5 text-slate-400 flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </span>
                                        <span class="icon-picker-label flex-1 text-left truncate text-slate-600">Pilih Ikon...</span>
                                        <span class="icon-picker-clear hidden text-rose-400 hover:text-rose-600 p-0.5 rounded transition-colors" onclick="event.stopPropagation(); clearSelectedIcon(this)" title="Hapus Ikon">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </span>
                                    </button>
                                </div>
                                <!-- Upload Custom Icon -->
                                <div class="flex-1">
                                    <div class="icon-upload-zone border border-dashed border-gray-200 hover:border-emerald-400 rounded-xl px-3.5 py-2.5 text-center cursor-pointer transition-all bg-gray-50/50 hover:bg-emerald-50/30"
                                         onclick="this.querySelector('.card-icon-image-input, .icon-image-input').click()">
                                        <input type="file" name="steps[${stepIndex}][icon_image]"
                                               accept="image/png,image/jpeg,image/jpg,image/webp,image/svg+xml"
                                               onchange="handleIconImagePreview(this)"
                                               class="card-icon-image-input icon-image-input hidden">
                                        <div class="icon-upload-preview hidden flex items-center gap-2">
                                            <img src="#" alt="Icon Preview" class="icon-upload-preview-img w-6 h-6 object-contain rounded">
                                            <span class="text-xs text-slate-700 font-medium truncate flex-1">Ikon Sendiri</span>
                                            <button type="button" onclick="event.stopPropagation(); removeIconImage(this)" class="text-rose-400 hover:text-rose-600 p-0.5 shrink-0" title="Hapus Gambar Sendiri">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                        <div class="icon-upload-placeholder flex items-center gap-2">
                                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                            <span class="text-xs text-slate-500 truncate">Unggah Ikon Sendiri</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-1">Pilih ikon dari daftar atau unggah file gambar Anda sendiri (PNG, SVG, maks 512 KB).</p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Penjelasan Langkah <span class="text-rose-500">*</span></label>
                            <textarea name="steps[${stepIndex}][description]" rows="2" required placeholder="Contoh: Lihat katalog produk kami dan pilih produk lele olahan yang Anda inginkan..." class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600"></textarea>
                        </div>
                    </div>
                </div>
            `;

            stepsContainer.insertAdjacentHTML('beforeend', template);
            const newItem = stepsContainer.lastElementChild;

            // Trigger reflow for animation
            void newItem.offsetWidth;
            newItem.style.opacity = '1';
            newItem.style.transform = 'translateY(0)';

            stepIndex++;
            updateStepNumbers();
        });

        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
@endpush

@once('lucide-icon-picker-modal-instance')
    <x-form.icon-picker-modal />
@endonce
