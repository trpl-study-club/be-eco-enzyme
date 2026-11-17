@extends('layouts.admin')

@section('title', 'Informasi Kontak')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900 transition-colors">Halaman Utama</a>
    <span>/</span>
    <span class="text-slate-800 font-semibold">Informasi Kontak</span>
@endsection

@section('page_title', 'Informasi Kontak Desa')

@section('header_actions')
    <button type="button" onclick="openAddContactModal()"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-150 cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        <span>Tambah Saluran Kontak</span>
    </button>
@endsection

@section('page_headline', 'Kelola Informasi Kontak')
@section('page_subtitle', 'Atur judul pengantar serta daftar saluran komunikasi resmi desa yang tampil di halaman depan website.')

@section('status_badge')
    <span
        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $section->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-amber-50 text-amber-700 border border-amber-200/60' }}">
        <span class="w-1.5 h-1.5 rounded-full {{ $section->is_active ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
        {{ $section->is_active ? 'Bagian Aktif di Website' : 'Draf (Belum Tampil)' }} &bull; {{ $section->items->count() }} Saluran Kontak
    </span>
@endsection

@section('content')
    <div class="space-y-6">

        <!-- ================================================================= -->
        <!-- 1. TOP OVERVIEW CARD: JUDUL PENGANTAR & STATUS TAYANG             -->
        <!-- ================================================================= -->
        <div
            class="relative overflow-hidden bg-linear-to-br from-emerald-900/5 via-white to-white p-5 sm:p-6 rounded-2xl border border-emerald-100 shadow-xs">
            <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4">
                <div class="space-y-1.5 max-w-2xl min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <span
                            class="px-2.5 py-0.5 rounded-md text-[11px] font-bold tracking-wide uppercase bg-emerald-100 text-emerald-800">
                            Pengaturan Tampilan
                        </span>
                        <span class="text-[11px] text-slate-400">
                            Diperbarui {{ $section->updated_at->diffForHumans() }}
                        </span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                            {{ $section->title ?: 'Hubungi Kami' }}
                        </h2>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                            {{ $section->description ?: 'Belum ada kalimat pengantar untuk bagian kontak di halaman depan website.' }}
                        </p>
                    </div>
                </div>

                <div class="shrink-0 flex flex-wrap items-center gap-2.5">
                    <!-- Toggle Active / Inactive -->
                    <form action="{{ route('admin.contact-sections.toggle-hub-status') }}" method="POST"
                        class="inline-flex items-center gap-3 px-3.5 py-2 bg-white border border-slate-200 rounded-xl shadow-2xs">
                        @csrf
                        @method('PATCH')
                        <div class="flex items-center gap-2">
                            <span
                                class="w-2 h-2 rounded-full {{ $section->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                            <span
                                class="text-xs font-semibold {{ $section->is_active ? 'text-emerald-700' : 'text-slate-600' }}">
                                {{ $section->is_active ? 'Aktif di Website' : 'Draf (Belum Tampil)' }}
                            </span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer"
                            title="{{ $section->is_active ? 'Klik untuk simpan sebagai draf (sembunyikan dari website)' : 'Klik untuk tampilkan bagian kontak di website' }}">
                            <input type="checkbox" {{ $section->is_active ? 'checked' : '' }} onchange="this.form.submit()"
                                class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600">
                            </div>
                        </label>
                    </form>

                    <!-- Button Edit Header -->
                    <button type="button" onclick="openHeaderModal()"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-xs font-semibold rounded-xl shadow-2xs hover:border-slate-300 transition-all cursor-pointer">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        <span>Ubah Judul & Pengantar</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- ================================================================= -->
        <!-- 2. HEADER DAFTAR SALURAN & PENCARIAN KONDISIONAL                  -->
        <!-- ================================================================= -->
        @if ($section->items->count() > 6 || request('search') || request('type'))
            <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs">
                <form action="{{ route('admin.contact-sections.index') }}" method="GET"
                    class="flex flex-col sm:flex-row items-center gap-3 w-full">
                    <div class="relative flex-1 w-full">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau isi saluran kontak..."
                            class="w-full pl-10 pr-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 w-full sm:w-auto shrink-0">
                        <button type="submit"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold rounded-xl shadow-sm transition-all cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <span>Cari</span>
                        </button>

                        @if (request('search') || request('type'))
                            <a href="{{ route('admin.contact-sections.index') }}"
                                class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-semibold rounded-xl transition-all"
                                title="Atur Ulang Pencarian">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span>Reset</span>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        @endif

        <!-- ================================================================= -->
        <!-- 3. GRID KARTU SALURAN KONTAK INDIVIDUAL                          -->
        <!-- ================================================================= -->
        @if ($contactItems->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($contactItems as $item)
                    @php
                        $rawType = strtolower(trim($item->type ?: ''));
                        $rawLabel = strtolower(trim($item->label ?: ''));
                        $resolvedKey = $rawType !== '' ? $rawType : $rawLabel;

                        $isWhatsapp = in_array($resolvedKey, ['whatsapp', 'wa', 'phone', 'telepon'], true)
                            || str_contains($resolvedKey, 'whatsapp')
                            || str_contains($resolvedKey, 'phone')
                            || str_contains($resolvedKey, 'telepon')
                            || (bool) preg_match('/\bwa\b/', $resolvedKey);
                        $isEmail = in_array($resolvedKey, ['email', 'mail'], true)
                            || str_contains($resolvedKey, 'email')
                            || str_contains($resolvedKey, 'mail');
                        $isLocation = in_array($resolvedKey, ['location', 'lokasi', 'alamat', 'map'], true)
                            || str_contains($resolvedKey, 'location')
                            || str_contains($resolvedKey, 'lokasi')
                            || str_contains($resolvedKey, 'alamat')
                            || str_contains($resolvedKey, 'map');
                        $isSocial = in_array($resolvedKey, ['instagram', 'ig', 'social', 'sosmed'], true)
                            || str_contains($resolvedKey, 'instagram')
                            || str_contains($resolvedKey, 'sosmed')
                            || str_contains($resolvedKey, 'social')
                            || (bool) preg_match('/\big\b/', $resolvedKey);
                        $isHours = in_array($resolvedKey, ['hours', 'jam', 'operasional', 'jadwal'], true)
                            || str_contains($resolvedKey, 'hour')
                            || str_contains($resolvedKey, 'jam')
                            || str_contains($resolvedKey, 'operasional')
                            || str_contains($resolvedKey, 'jadwal');

                        $theme = match (true) {
                            $isWhatsapp => [
                                'icon_bg' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                'default_icon' => 'phone',
                            ],
                            $isEmail => [
                                'icon_bg' => 'bg-sky-50 text-sky-600 border-sky-100',
                                'default_icon' => 'mail',
                            ],
                            $isLocation => [
                                'icon_bg' => 'bg-amber-50 text-amber-600 border-amber-100',
                                'default_icon' => 'map-pin',
                            ],
                            $isSocial => [
                                'icon_bg' => 'bg-pink-50 text-pink-600 border-pink-100',
                                'default_icon' => 'instagram',
                            ],
                            $isHours => [
                                'icon_bg' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                'default_icon' => 'clock',
                            ],
                            default => [
                                'icon_bg' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                'default_icon' => 'message-circle',
                            ],
                        };
                        $iconName = $item->icon_name ?: $theme['default_icon'];
                        $iconImageUrl = $item->icon_image ? asset('storage/' . $item->icon_image) : null;
                    @endphp

                    <div
                        class="bg-white rounded-2xl border border-gray-200/80 hover:border-emerald-300 shadow-xs hover:shadow-md transition-all duration-200 p-5 flex flex-col justify-between gap-4 h-full">

                        <div class="space-y-3.5">
                            <!-- Card Header: Icon + Name -->
                            <div class="flex items-center gap-3 min-w-0">
                                @if ($iconImageUrl)
                                    <div
                                        class="w-11 h-11 rounded-xl border border-gray-200 bg-gray-50 overflow-hidden shrink-0">
                                        <img src="{{ $iconImageUrl }}" alt="{{ $item->label }}"
                                            class="w-full h-full object-cover object-center">
                                    </div>
                                @else
                                    <div
                                        class="w-11 h-11 rounded-xl border flex items-center justify-center shrink-0 {{ $theme['icon_bg'] }}">
                                        <i data-lucide="{{ $iconName }}" class="w-5 h-5"></i>
                                    </div>
                                @endif

                                <h3 class="text-base font-bold text-slate-900 truncate" title="{{ $item->label }}">
                                    {{ $item->label }}
                                </h3>
                            </div>

                            <!-- Contact Value -->
                            <p class="text-xs sm:text-sm text-slate-600 break-words leading-relaxed">
                                {{ $item->value }}
                            </p>
                        </div>

                        <!-- Card Actions Footer (Consistent with Product Cards) -->
                        <div class="pt-3.5 border-t border-gray-100 flex items-center justify-end gap-1.5">
                            <button type="button"
                                onclick="openEditContactModal({{ $item->id }}, @js($item->label), @js($item->value), @js($item->icon_name ?? ''), @js($iconImageUrl ?? ''))"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:text-emerald-700 bg-gray-50 hover:bg-emerald-50 border border-gray-200/80 hover:border-emerald-200 rounded-xl transition-colors cursor-pointer"
                                title="Edit Saluran Kontak">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                <span>Edit</span>
                            </button>

                            <form id="delete-contact-form-{{ $item->id }}"
                                action="{{ route('admin.contact-sections.items.destroy', $item) }}" method="POST"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    onclick="confirmDelete(document.getElementById('delete-contact-form-{{ $item->id }}'))"
                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-semibold text-rose-600 hover:text-rose-700 bg-rose-50/70 hover:bg-rose-100 border border-rose-200/60 rounded-xl transition-colors cursor-pointer"
                                    title="Hapus Saluran Kontak">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif (request('search') || request('type'))
            <!-- Search Empty State -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs py-16 px-6 text-center">
                <div
                    class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-500 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                        </path>
                    </svg>
                </div>
                <h4 class="text-sm font-bold text-slate-800">Saluran Kontak Tidak Ditemukan</h4>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    Tidak ada saluran kontak yang cocok dengan kata kunci pencarian Anda.
                </p>
                <a href="{{ route('admin.contact-sections.index') }}"
                    class="inline-flex items-center gap-2 mt-4 px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold rounded-xl shadow-sm transition-all">
                    <span>Tampilkan Semua Saluran</span>
                </a>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs py-16 px-6 text-center">
                <div
                    class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <h4 class="text-sm font-bold text-slate-800">Belum Ada Saluran Kontak</h4>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    Tambahkan saluran komunikasi desa seperti WhatsApp, Email, atau Alamat Lokasi agar pengunjung mudah menghubungi pengelola.
                </p>
                <button type="button" onclick="openAddContactModal()"
                    class="inline-flex items-center gap-2 mt-4 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-150 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Saluran Kontak</span>
                </button>
            </div>
        @endif

    </div>

    <!-- ================================================================= -->
    <!-- MODAL 1: UBAH JUDUL & PENGANTAR KONTAK                            -->
    <!-- ================================================================= -->
    <div id="headerModal" onclick="if(event.target === this) closeHeaderModal()"
        class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto hidden">
        <div
            class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-gray-100 flex flex-col overflow-hidden my-auto">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-slate-50/60 shrink-0">
                <div class="flex items-center gap-3">
                    <div
                        class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Ubah Judul & Pengantar</h3>
                        <p class="text-xs text-slate-500">Atur kalimat sapaan pada bagian kontak website.</p>
                    </div>
                </div>
                <button type="button" onclick="closeHeaderModal()"
                    class="p-2 text-slate-400 hover:text-slate-600 hover:bg-gray-100 rounded-xl transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form action="{{ route('admin.contact-sections.update-header') }}" method="POST"
                class="flex flex-col flex-1 overflow-hidden">
                @csrf
                <div class="p-6 space-y-4">
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="header-title" class="block text-xs font-semibold text-slate-700">
                                Judul Bagian Kontak <span class="text-rose-500">*</span>
                            </label>
                            <span id="header-title-counter" class="text-[11px] text-slate-400 font-mono">
                                {{ strlen(old('title', $section->title ?? '')) }} / 255
                            </span>
                        </div>
                        <input type="text" id="header-title" name="title"
                            value="{{ old('title', $section->title) }}" required maxlength="255"
                            oninput="document.getElementById('header-title-counter').textContent = this.value.length + ' / 255'"
                            placeholder="Contoh: Ada Pertanyaan? Kami Siap Membantu."
                            class="w-full px-3.5 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all font-semibold">
                    </div>

                    <div>
                        <label for="header-description" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Kalimat Pengantar <span class="text-slate-400 font-normal">(Boleh Kosong)</span>
                        </label>
                        <textarea id="header-description" name="description" rows="3"
                            placeholder="Contoh: Ingin tahu lebih banyak tentang produk atau peluang kolaborasi? Jangan ragu menghubungi kami."
                            class="w-full px-3.5 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 leading-relaxed transition-all">{{ old('description', $section->description) }}</textarea>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-2 shrink-0">
                    <button type="button" onclick="closeHeaderModal()"
                        class="px-4 py-2.5 bg-white hover:bg-gray-100 border border-gray-200 text-slate-700 text-xs font-semibold rounded-xl transition-all cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all cursor-pointer">
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- MODAL 2: TAMBAH / EDIT SALURAN KONTAK (NAMA, ISI, IKON/GAMBAR)    -->
    <!-- ================================================================= -->
    <div id="contactItemModal" onclick="if(event.target === this) closeContactModal()"
        class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto hidden">
        <div
            class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-gray-100 flex flex-col max-h-[92vh] overflow-hidden my-auto">

            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-slate-50/60 shrink-0">
                <div class="flex items-center gap-3">
                    <div id="contact-modal-icon-box"
                        class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 id="contact-modal-title" class="text-base font-bold text-slate-900">Tambah Saluran Kontak</h3>
                        <p class="text-xs text-slate-500">Masukkan nama, isi kontak, serta pilih ikon atau gambar.</p>
                    </div>
                </div>
                <button type="button" onclick="closeContactModal()"
                    class="p-2 text-slate-400 hover:text-slate-600 hover:bg-gray-100 rounded-xl transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Modal Form -->
            <form id="contact-item-form" action="{{ route('admin.contact-sections.items.store') }}" method="POST"
                enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
                @csrf
                <input type="hidden" name="_method" id="contact-form-method" value="POST">

                <div class="flex-1 overflow-y-auto p-6 space-y-4">
                    <div>
                        <label for="item-label" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Nama Kontak <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="item-label" name="label" required maxlength="255"
                            placeholder="Contoh: WhatsApp, Email, Alamat Kantor"
                            class="w-full px-3.5 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                    </div>

                    <div>
                        <label for="item-value" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Isi Kontak <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="item-value" name="value" required
                            placeholder="Contoh: +62 812 3456 7890 atau Desa Jeruklegi, Jawa Tengah"
                            class="w-full px-3.5 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                    </div>

                    <!-- Icon or Image Picker -->
                    <div id="modal-icon-picker-wrapper">
                        <x-form.icon-picker name="icon_name" :value="null"
                            label="Ikon atau Gambar" :with-upload="true"
                            upload-name="icon_image" remove-name="remove_icon_image"
                            hint="Pilih ikon Lucide atau unggah gambar kustom (PNG/SVG, maks 512KB)." />
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-2 shrink-0">
                    <button type="button" onclick="closeContactModal()"
                        class="px-4 py-2.5 bg-white hover:bg-gray-100 border border-gray-200 text-slate-700 text-xs font-semibold rounded-xl transition-all cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all cursor-pointer">
                        <span id="contact-modal-submit-text">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            if (typeof window.closeIconPicker === 'function') {
                const origCloseIconPicker = window.closeIconPicker;
                window.closeIconPicker = function() {
                    origCloseIconPicker();
                    const contactModal = document.getElementById('contactItemModal');
                    const headerModal = document.getElementById('headerModal');
                    if ((contactModal && !contactModal.classList.contains('hidden')) ||
                        (headerModal && !headerModal.classList.contains('hidden'))) {
                        document.body.classList.add('overflow-hidden');
                    }
                };
            }

            document.addEventListener('keydown', function(e) {
                if (e.key !== 'Escape') return;
                const iconModal = document.getElementById('icon-picker-modal');
                if (iconModal && !iconModal.classList.contains('hidden')) {
                    return;
                }
                closeHeaderModal();
                closeContactModal();
            }, true);
        });

        function openHeaderModal() {
            document.getElementById('headerModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeHeaderModal() {
            document.getElementById('headerModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function setModalIconPickerValue(iconName, iconImageUrl) {
            const wrapper = document.getElementById('modal-icon-picker-wrapper');
            if (!wrapper) return;

            const iconInput = wrapper.querySelector('.icon-picker-input');
            const previewSpan = wrapper.querySelector('.icon-picker-preview');
            const labelSpan = wrapper.querySelector('.icon-picker-label');
            const clearBtn = wrapper.querySelector('.icon-picker-clear');
            const fileInput = wrapper.querySelector('.icon-image-input');
            const removeFlag = wrapper.querySelector('.icon-remove-flag');
            const uploadPreview = wrapper.querySelector('.icon-upload-preview');
            const uploadPreviewImg = wrapper.querySelector('.icon-upload-preview-img');
            const uploadPlaceholder = wrapper.querySelector('.icon-upload-placeholder');

            if (fileInput) fileInput.value = '';
            if (removeFlag) removeFlag.value = '0';

            if (iconName) {
                iconInput.value = iconName;
                previewSpan.innerHTML = `<i data-lucide="${iconName}" class="w-4 h-4 text-emerald-600"></i>`;
                labelSpan.textContent = iconName;
                labelSpan.classList.remove('text-slate-600');
                labelSpan.classList.add('text-slate-900', 'font-semibold');
                clearBtn.classList.remove('hidden');
            } else {
                iconInput.value = '';
                previewSpan.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>`;
                labelSpan.textContent = 'Pilih Icon Lucide...';
                labelSpan.classList.remove('text-slate-900', 'font-semibold');
                labelSpan.classList.add('text-slate-600');
                clearBtn.classList.add('hidden');
            }

            if (iconImageUrl) {
                uploadPreviewImg.src = iconImageUrl;
                uploadPreview.classList.remove('hidden');
                uploadPlaceholder.classList.add('hidden');
            } else {
                uploadPreviewImg.src = '#';
                uploadPreview.classList.add('hidden');
                uploadPlaceholder.classList.remove('hidden');
            }

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }

        function openAddContactModal() {
            const form = document.getElementById('contact-item-form');
            form.action = @js(route('admin.contact-sections.items.store'));
            document.getElementById('contact-form-method').value = 'POST';
            document.getElementById('contact-modal-title').textContent = 'Tambah Saluran Kontak';
            document.getElementById('contact-modal-submit-text').textContent = 'Simpan';

            document.getElementById('item-label').value = '';
            document.getElementById('item-value').value = '';
            setModalIconPickerValue('', '');

            document.getElementById('contactItemModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function openEditContactModal(id, label, value, iconName, iconImageUrl) {
            const form = document.getElementById('contact-item-form');
            const baseUrl = @js(url('/admin/contact-sections/items'));
            form.action = `${baseUrl}/${id}`;
            document.getElementById('contact-form-method').value = 'PUT';
            document.getElementById('contact-modal-title').textContent = 'Edit Saluran Kontak';
            document.getElementById('contact-modal-submit-text').textContent = 'Simpan Perubahan';

            document.getElementById('item-label').value = label || '';
            document.getElementById('item-value').value = value || '';
            setModalIconPickerValue(iconName || '', iconImageUrl || '');

            document.getElementById('contactItemModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeContactModal() {
            document.getElementById('contactItemModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    </script>
@endpush
