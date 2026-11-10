@extends('layouts.admin')

@section('title', 'Edit Section Kontak')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900">Halaman Depan</a>
    <span>/</span>
    <a href="{{ route('admin.contact-sections.index') }}" class="text-slate-500 hover:text-slate-900">Bagian Kontak</a>
    <span>/</span>
    <span class="text-slate-800">Ubah</span>
@endsection

@section('page_title', 'Kelola Bagian Kontak')

@section('header_actions')
    <div class="hidden sm:flex items-center gap-2.5">
        <a href="{{ route('admin.contact-sections.index') }}"
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

@section('page_headline', 'Edit Section Kontak')
@section('page_subtitle', 'Perbarui judul, penjelasan, dan daftar saluran kontak yang tampil pada website.')

@section('status_badge')
    <span
        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $contactSection->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-slate-100 text-slate-700 border border-slate-200/60' }}">
        <span class="w-2 h-2 rounded-full {{ $contactSection->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
        Status: {{ $contactSection->is_active ? 'Aktif di Landing Page' : 'Draf (Nonaktif)' }}
    </span>
@endsection

@section('content')
    <form id="contact-section-form" action="{{ route('admin.contact-sections.update', $contactSection) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="action" id="form-action" value="{{ $contactSection->is_active ? 'publish' : 'draft' }}">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- KOLOM KIRI (8 Kolom): Konten Utama & Daftar Items -->
            <div class="lg:col-span-8 space-y-6">

                <!-- CARD 1: Konten Utama Section -->
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
                            <h3 class="text-base font-bold text-slate-900">Konten Utama Section</h3>
                            <p class="text-xs text-slate-500">Kelola judul utama dan kalimat pengantar bagian kontak.</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <!-- Judul Field -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="title" class="block text-xs font-bold text-slate-700">
                                    Judul Bagian Kontak <span class="text-rose-500">*</span>
                                </label>
                                <span id="title-counter"
                                    class="text-[11px] text-slate-400 font-mono">{{ strlen(old('title', $contactSection->title ?? '')) }}
                                    / 255 Karakter</span>
                            </div>
                            <input type="text" id="title" name="title"
                                value="{{ old('title', $contactSection->title ?? '') }}" required maxlength="255"
                                placeholder="Contoh: Ada Pertanyaan? Kami Siap Membantu"
                                oninput="document.getElementById('title-counter').innerText = this.value.length + ' / 255 Karakter'"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            @error('title')
                                <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                            @enderror
                            <p class="text-[11px] text-slate-400 mt-1.5">
                                Gunakan kalimat judul yang sopan dan jelas untuk pengunjung website.
                            </p>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="description" class="block text-xs font-bold text-slate-700 mb-2">
                                Kalimat Pengantar <span class="text-slate-400 font-normal">(Boleh Kosong)</span>
                            </label>
                            <textarea id="description" name="description" rows="3"
                                placeholder="Contoh: Ingin tahu lebih banyak tentang produk kami atau ingin memesan? Jangan ragu untuk menghubungi kami."
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all leading-relaxed">{{ old('description', $contactSection->description ?? '') }}</textarea>
                            @error('description')
                                <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                            @enderror
                            <p class="text-[11px] text-slate-400 mt-1.5">
                                Tuliskan pesan singkat yang ramah untuk mengarahkan pengunjung website.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: Daftar Item Kontak (Multiple) -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                    <div class="flex items-center justify-between pb-5 border-b border-gray-100 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900">Daftar Saluran Kontak</h3>
                                <p class="text-xs text-slate-500">Setiap saluran berisi nama kontak, nomor atau alamat, serta simbol/gambar.</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 text-xs font-medium">
                            <button type="button" onclick="collapseAllCards()"
                                class="text-slate-500 hover:text-slate-900 underline cursor-pointer">Tutup Semua</button>
                            <span class="text-slate-300">|</span>
                            <button type="button" onclick="expandAllCards()"
                                class="text-slate-500 hover:text-slate-900 underline cursor-pointer">Buka Semua</button>
                        </div>
                    </div>

                    <!-- Items Container (Repeater) -->
                    <div id="contacts-container" class="space-y-4">
                        @forelse($contactSection->items as $idx => $item)
                            <div class="contact-card-item rounded-xl border border-slate-200 bg-slate-50/40 overflow-hidden transition-all shadow-2xs"
                                data-index="{{ $idx }}">
                                <input type="hidden" name="items[{{ $idx }}][id]" value="{{ $item->id }}">

                                <!-- Item Header Accordion -->
                                <div class="p-3.5 bg-slate-100/70 border-b border-slate-200/70 flex items-center justify-between cursor-pointer"
                                    onclick="toggleCardAccordion(this)">
                                    <div class="flex items-center gap-2.5">
                                        <span
                                            class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center contact-badge-num">{{ $idx + 1 }}</span>
                                        <span
                                            class="contact-header-title text-xs font-bold text-slate-800">{{ $item->label ?: 'Saluran Kontak ' . ($idx + 1) }}</span>
                                    </div>
                                    <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                                        <button type="button" onclick="removeContactItem(this)" title="Hapus Saluran Kontak"
                                            class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                        <button type="button" onclick="toggleCardAccordion(this.parentElement)"
                                            class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg transition-colors cursor-pointer">
                                            <svg class="w-4 h-4 contact-accordion-icon transform transition-transform"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Item Body -->
                                <div class="contact-card-body p-4 space-y-4 bg-white">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1">
                                                Nama Saluran / Label Kontak <span class="text-rose-500">*</span>
                                            </label>
                                            <input type="text" name="items[{{ $idx }}][label]"
                                                value="{{ old('items.' . $idx . '.label', $item->label) }}" required
                                                placeholder="Contoh: WhatsApp Kami, Alamat Kantor, Email Resmi"
                                                oninput="updateContactHeaderTitle(this)"
                                                class="contact-label-input w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1">
                                                Jenis Kontak (Boleh Kosong)
                                            </label>
                                            <input type="text" name="items[{{ $idx }}][type]"
                                                value="{{ old('items.' . $idx . '.type', $item->type) }}"
                                                placeholder="Contoh: whatsapp, lokasi, email"
                                                class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                                            Isi Kontak / Nomor / Alamat <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" name="items[{{ $idx }}][value]"
                                            value="{{ old('items.' . $idx . '.value', $item->value) }}" required
                                            placeholder="Contoh: 081234567890 atau Desa Jeruklegi, Jawa Tengah"
                                            class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                                    </div>

                                    <!-- Icon Picker Component (Lucide + Upload) -->
                                    <x-form.icon-picker
                                        name="items[{{ $idx }}][icon_name]"
                                        :value="old('items.' . $idx . '.icon_name', $item->icon_name)"
                                        label="Ikon Kontak (Pilih Simbol atau Unggah Gambar)"
                                        :with-upload="true"
                                        upload-name="items[{{ $idx }}][icon_image]"
                                        :upload-value="$item->icon_image_url"
                                        remove-name="items[{{ $idx }}][remove_icon_image]"
                                    />
                                </div>
                            </div>
                        @empty
                            <div class="contact-card-item rounded-xl border border-slate-200 bg-slate-50/40 overflow-hidden transition-all shadow-2xs"
                                data-index="0">
                                <div class="p-3.5 bg-slate-100/70 border-b border-slate-200/70 flex items-center justify-between cursor-pointer"
                                    onclick="toggleCardAccordion(this)">
                                    <div class="flex items-center gap-2.5">
                                        <span
                                            class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center contact-badge-num">1</span>
                                        <span class="contact-header-title text-xs font-bold text-slate-800">Saluran Kontak 1</span>
                                    </div>
                                    <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                                        <button type="button" onclick="removeContactItem(this)" title="Hapus Saluran Kontak"
                                            class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                        <button type="button" onclick="toggleCardAccordion(this.parentElement)"
                                            class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg transition-colors cursor-pointer">
                                            <svg class="w-4 h-4 contact-accordion-icon transform transition-transform"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="contact-card-body p-4 space-y-4 bg-white">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1">
                                                Nama Saluran / Label Kontak <span class="text-rose-500">*</span>
                                            </label>
                                            <input type="text" name="items[0][label]" value="" required
                                                placeholder="Contoh: WhatsApp Kami, Alamat Kantor, Email Resmi"
                                                oninput="updateContactHeaderTitle(this)"
                                                class="contact-label-input w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1">
                                                Jenis Kontak (Boleh Kosong)
                                            </label>
                                            <input type="text" name="items[0][type]" value=""
                                                placeholder="Contoh: whatsapp, lokasi, email"
                                                class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                                            Isi Kontak / Nomor / Alamat <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" name="items[0][value]" value="" required
                                            placeholder="Contoh: 081234567890 atau Desa Jeruklegi, Jawa Tengah"
                                            class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                                    </div>

                                    <x-form.icon-picker
                                        name="items[0][icon_name]"
                                        label="Ikon Kontak (Pilih Simbol atau Unggah Gambar)"
                                        :with-upload="true"
                                        upload-name="items[0][icon_image]"
                                        remove-name="items[0][remove_icon_image]"
                                    />
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Button Tambah Item -->
                    <button type="button" onclick="addContactCard()"
                        class="mt-5 w-full py-3 border-2 border-dashed border-emerald-300 hover:border-emerald-500 bg-emerald-50/30 hover:bg-emerald-50/80 rounded-xl text-xs font-bold text-emerald-800 hover:text-emerald-900 transition-all flex items-center justify-center gap-2 cursor-pointer shadow-2xs">
                        <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Tambah Saluran Kontak</span>
                    </button>
                </div>
            </div>

            <!-- KOLOM KANAN (4 Kolom): Status & Aksi -->
            <div class="lg:col-span-4 space-y-6">

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
                            <p class="text-xs text-slate-500">Pilih apakah informasi kontak ini langsung tampil atau disimpan sebagai draf.</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-2">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-800">Tayangkan di Website?</span>
                                <span id="status-badge"
                                    class="px-2 py-0.5 rounded text-[10px] font-bold {{ $contactSection->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-200 text-slate-700' }}">
                                    {{ $contactSection->is_active ? 'Aktif di Website' : 'Disimpan Sebagai Draf' }}
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-400 mt-0.5">Jika aktif, pengunjung langsung dapat melihat nomor WhatsApp, email, dan alamat desa.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" id="is_active_toggle" value="1"
                                {{ old('is_active', $contactSection->is_active) ? 'checked' : '' }}
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
                                <span class="font-bold block text-emerald-900">Kebijakan 1 Informasi Kontak Aktif</span>
                                <p class="text-[11px] text-emerald-700/90 mt-0.5">Halaman depan hanya menampilkan 1 data kontak aktif. Jika bagian ini diaktifkan, data kontak lama otomatis dijadikan <strong>Draf</strong>.</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 space-y-2 text-xs">
                        <div class="flex justify-between items-start text-slate-500">
                            <span>Terakhir Diperbarui:</span>
                            <div class="text-right">
                                <span class="text-slate-700 font-medium">{{ $contactSection->updated_at->translatedFormat('d M Y, H:i') }} WIB</span>
                                <span class="text-[11px] text-slate-400 block">({{ $contactSection->updated_at->diffForHumans() }})</span>
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
            <a href="{{ route('admin.contact-sections.index') }}"
                class="w-full inline-flex items-center justify-center py-2.5 px-4 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors">
                Batal & Kembali
            </a>
        </div>
    </form>

    {{-- Modal Lucide Icon Picker --}}
    @once('lucide-icon-picker-modal-instance')
        <x-form.icon-picker-modal />
    @endonce
@endsection

@push('scripts')
<script>
    function submitWithAction(action) {
        const formAction = document.getElementById('form-action');
        const toggle = document.getElementById('is_active_toggle');
        if (formAction) formAction.value = action;
        if (toggle) toggle.checked = (action === 'publish');
        const form = document.getElementById('contact-section-form');
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

    function toggleCardAccordion(headerEl) {
        const itemEl = headerEl.closest('.contact-card-item');
        const bodyEl = itemEl.querySelector('.contact-card-body');
        const iconEl = itemEl.querySelector('.contact-accordion-icon');

        if (bodyEl.style.display === 'none') {
            bodyEl.style.display = 'block';
            if (iconEl) iconEl.style.transform = 'rotate(0deg)';
        } else {
            bodyEl.style.display = 'none';
            if (iconEl) iconEl.style.transform = 'rotate(180deg)';
        }
    }

    function collapseAllCards() {
        document.querySelectorAll('.contact-card-item').forEach(card => {
            const body = card.querySelector('.contact-card-body');
            const icon = card.querySelector('.contact-accordion-icon');
            if (body) body.style.display = 'none';
            if (icon) icon.style.transform = 'rotate(180deg)';
        });
    }

    function expandAllCards() {
        document.querySelectorAll('.contact-card-item').forEach(card => {
            const body = card.querySelector('.contact-card-body');
            const icon = card.querySelector('.contact-accordion-icon');
            if (body) body.style.display = 'block';
            if (icon) icon.style.transform = 'rotate(0deg)';
        });
    }

    function updateContactHeaderTitle(input) {
        const itemEl = input.closest('.contact-card-item');
        const titleEl = itemEl.querySelector('.contact-header-title');
        const index = parseInt(itemEl.getAttribute('data-index') || '0', 10) + 1;
        titleEl.textContent = input.value.trim() ? input.value.trim() : 'Saluran Kontak ' + index;
    }

    function removeContactItem(btn) {
        const container = document.getElementById('contacts-container');
        const items = container.querySelectorAll('.contact-card-item');
        if (items.length <= 1) {
            alert('Minimal harus ada 1 saluran kontak.');
            return;
        }
        btn.closest('.contact-card-item').remove();
        reindexContactCards();
    }

    function reindexContactCards() {
        const container = document.getElementById('contacts-container');
        const cards = container.querySelectorAll('.contact-card-item');
        cards.forEach((card, index) => {
            card.setAttribute('data-index', index);
            card.querySelector('.contact-badge-num').textContent = index + 1;

            const labelInput = card.querySelector('input[name*="[label]"]');
            if (labelInput) {
                labelInput.name = `items[${index}][label]`;
                const titleEl = card.querySelector('.contact-header-title');
                titleEl.textContent = labelInput.value.trim() ? labelInput.value.trim() : `Saluran Kontak ${index + 1}`;
            }

            const idInput = card.querySelector('input[name*="[id]"]');
            if (idInput) idInput.name = `items[${index}][id]`;

            const typeInput = card.querySelector('input[name*="[type]"]');
            if (typeInput) typeInput.name = `items[${index}][type]`;

            const valInput = card.querySelector('input[name*="[value]"]');
            if (valInput) valInput.name = `items[${index}][value]`;

            const iconInput = card.querySelector('input[name*="[icon_name]"]');
            if (iconInput) iconInput.name = `items[${index}][icon_name]`;

            const fileInput = card.querySelector('input[type="file"]');
            if (fileInput) fileInput.name = `items[${index}][icon_image]`;

            const removeIconInput = card.querySelector('input[name*="[remove_icon_image]"]');
            if (removeIconInput) removeIconInput.name = `items[${index}][remove_icon_image]`;
        });
    }

    function addContactCard() {
        const container = document.getElementById('contacts-container');
        const newIndex = container.querySelectorAll('.contact-card-item').length;

        const cardHtml = `
            <div class="contact-card-item rounded-xl border border-slate-200 bg-slate-50/40 overflow-hidden transition-all shadow-2xs"
                data-index="${newIndex}">
                <div class="p-3.5 bg-slate-100/70 border-b border-slate-200/70 flex items-center justify-between cursor-pointer"
                    onclick="toggleCardAccordion(this)">
                    <div class="flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center contact-badge-num">${newIndex + 1}</span>
                        <span class="contact-header-title text-xs font-bold text-slate-800">Saluran Kontak ${newIndex + 1}</span>
                    </div>
                    <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                        <button type="button" onclick="removeContactItem(this)" title="Hapus Saluran Kontak"
                            class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </button>
                        <button type="button" onclick="toggleCardAccordion(this.parentElement)"
                            class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg transition-colors cursor-pointer">
                            <svg class="w-4 h-4 contact-accordion-icon transform transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="contact-card-body p-4 space-y-4 bg-white">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">
                                Nama Saluran / Label Kontak <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="items[${newIndex}][label]" value="" required
                                placeholder="Contoh: WhatsApp Kami, Alamat Kantor, Email Resmi"
                                oninput="updateContactHeaderTitle(this)"
                                class="contact-label-input w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">
                                Jenis Kontak (Boleh Kosong)
                            </label>
                            <input type="text" name="items[${newIndex}][type]" value=""
                                placeholder="Contoh: whatsapp, lokasi, email"
                                class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Isi Kontak / Nomor / Alamat <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="items[${newIndex}][value]" value="" required
                            placeholder="Contoh: 081234567890 atau Desa Jeruklegi, Jawa Tengah"
                            class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                    </div>

                    <!-- Icon Picker Component (Lucide + Upload) -->
                    <div class="icon-picker-component">
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Ikon Kontak (Pilih Simbol atau Unggah Gambar)
                        </label>
                        <input type="hidden" name="items[${newIndex}][icon_name]" class="icon-picker-input card-icon-name-input" value="">
                        <input type="hidden" name="items[${newIndex}][remove_icon_image]" value="0" class="icon-remove-flag card-remove-icon-flag">
                        <div class="flex items-start gap-3">
                            <!-- Lucide Picker Trigger Button -->
                            <div class="flex-1">
                                <button type="button" onclick="openIconPicker(this)" data-placeholder="Pilih Icon Lucide..."
                                    class="icon-picker-trigger w-full flex items-center gap-2.5 px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-600 hover:border-emerald-400 hover:bg-emerald-50/30 transition-all cursor-pointer">
                                    <span class="icon-picker-preview w-5 h-5 text-slate-400 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </span>
                                    <span class="icon-picker-label flex-1 text-left truncate text-slate-600">
                                        Pilih Icon Lucide...
                                    </span>
                                    <span class="icon-picker-clear hidden text-rose-400 hover:text-rose-600 p-0.5 rounded transition-colors"
                                          onclick="event.stopPropagation(); clearSelectedIcon(this)" title="Hapus Icon">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>

                            <!-- Upload Custom Icon / Image Zone -->
                            <div class="flex-1">
                                <div class="icon-upload-zone border border-dashed border-gray-200 hover:border-emerald-400 rounded-xl px-3.5 py-2.5 text-center cursor-pointer transition-all bg-gray-50/50 hover:bg-emerald-50/30"
                                     onclick="this.querySelector('.card-icon-image-input, .icon-image-input').click()">
                                    <input type="file" name="items[${newIndex}][icon_image]"
                                           accept="image/png,image/jpeg,image/jpg,image/webp,image/svg+xml"
                                           onchange="handleIconImagePreview(this)"
                                           class="card-icon-image-input icon-image-input hidden">
                                    <div class="icon-upload-preview hidden flex items-center gap-2">
                                        <img src="#" alt="Icon Preview" class="icon-upload-preview-img w-6 h-6 object-contain rounded">
                                        <span class="text-xs text-slate-700 font-medium truncate flex-1">Custom Icon</span>
                                        <button type="button" onclick="event.stopPropagation(); removeIconImage(this)" class="text-rose-400 hover:text-rose-600 p-0.5 shrink-0" title="Hapus Custom Image">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="icon-upload-placeholder flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                        </svg>
                                        <span class="text-xs text-slate-500 truncate">Upload Custom</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">Pilih icon Lucide atau upload gambar custom (PNG, SVG, maks 512KB).</p>
                    </div>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', cardHtml);
        if (window.lucide) {
            window.lucide.createIcons();
        }
    }
</script>
@endpush
