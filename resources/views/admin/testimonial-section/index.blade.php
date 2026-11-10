@extends('layouts.admin')

@section('title', 'Testimonial Pelanggan')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900 transition-colors">Halaman Utama</a>
    <span>/</span>
    <span class="text-slate-800 font-medium">Ulasan & Testimoni</span>
@endsection

@section('page_title', 'Testimonial Pelanggan')

@section('header_actions')
    <button type="button" onclick="openBatchModal()"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-150 cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        <span>Tambah Ulasan Sekarang</span>
    </button>
@endsection

@section('page_headline', 'Kelola Ulasan Pelanggan')
@section('page_subtitle',
    'Kelola daftar ulasan kepuasan dan ringkasan angka dampak secara langsung tanpa pindah
    halaman.')

@section('status_badge')
    <span
        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $section->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-amber-50 text-amber-700 border border-amber-200/60' }}">
        <span class="w-1.5 h-1.5 rounded-full {{ $section->is_active ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
        {{ $section->is_active ? 'Bagian Aktif di Website' : 'Draf (Belum Tampil)' }} &bull; {{ $testimonials->total() }}
        Total Ulasan
    </span>
@endsection

@section('content')
    <div class="space-y-6">

        <!-- Top Overview Card: Judul Section & Statistik Dampak -->
        <div
            class="relative overflow-hidden bg-gradient-to-br from-emerald-900/5 via-white to-white p-5 sm:p-6 rounded-2xl border border-emerald-100 shadow-xs space-y-4">
            <!-- Header Row: Info Judul & Action Button -->
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 pb-4 border-b border-emerald-100/70">
                <div class="space-y-1.5">
                    <div class="flex items-center gap-2">
                        <span
                            class="px-2.5 py-0.5 rounded-md text-[11px] font-bold tracking-wide uppercase bg-emerald-100 text-emerald-800">
                            Pengaturan Tampilan
                        </span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                            "{{ $section->title }}"
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Judul ulasan pembeli yang tampil di halaman depan website.
                        </p>
                    </div>
                </div>

                <div class="shrink-0 flex flex-wrap items-center gap-2.5">
                    <form action="{{ route('admin.testimonials.toggle-status') }}" method="POST"
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
                            title="{{ $section->is_active ? 'Klik untuk simpan sebagai draf (sembunyikan dari website)' : 'Klik untuk tampilkan bagian testimoni di website' }}">
                            <input type="checkbox" {{ $section->is_active ? 'checked' : '' }} onchange="this.form.submit()"
                                class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600">
                            </div>
                        </label>
                    </form>

                    <button type="button" onclick="openHeaderModal()"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-xs font-semibold rounded-xl shadow-2xs hover:border-slate-300 transition-all cursor-pointer">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        <span>Kelola Judul & Statistik</span>
                    </button>
                </div>
            </div>

            <!-- Statistics Grid Section -->
            <div class="space-y-2.5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-slate-700">Angka Statistik & Dampak</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                            {{ $section->statistics->count() }}
                        </span>
                    </div>
                </div>

                @if ($section->statistics->isNotEmpty())
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-2.5">
                        @foreach ($section->statistics as $stat)
                            <div
                                class="bg-white/95 border border-emerald-100 hover:border-emerald-300 rounded-xl p-3 shadow-2xs transition-all flex flex-col justify-center min-w-0 group hover:shadow-xs">
                                <div class="text-sm sm:text-base font-black text-emerald-700 tracking-tight truncate"
                                    title="{{ $stat->value }}">
                                    {{ $stat->value }}
                                </div>
                                <div class="text-[11px] text-slate-600 font-medium line-clamp-2 mt-0.5 leading-snug break-all"
                                    title="{{ $stat->description }}">
                                    {{ $stat->description }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-4 px-3 text-center border border-dashed border-emerald-200/80 rounded-xl bg-white/50">
                        <span class="text-xs text-slate-400 italic">Belum ada angka statistik dampak yang
                            ditambahkan.</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Search & Filter Bar -->
        <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs">
            <form action="{{ route('admin.testimonials.index') }}" method="GET"
                class="flex flex-col sm:flex-row items-center gap-3 w-full">
                <div class="relative flex-1 w-full">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari berdasarkan nama, lokasi, atau isi ulasan..."
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

                    @if (request('search'))
                        <a href="{{ route('admin.testimonials.index') }}"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-semibold rounded-xl transition-all"
                            title="Atur Ulang Pencarian">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Atur Ulang</span>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Testimonial Table Card -->
        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-gray-50/80 border-b border-gray-200/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="py-3.5 px-5">Nama Pelanggan & Asal</th>
                            <th class="py-3.5 px-5">Isi Ulasan Pelanggan</th>
                            <th class="py-3.5 px-5">Tanggal Dibuat</th>
                            <th class="py-3.5 px-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        @forelse($testimonials as $item)
                            @php
                                $colors = [
                                    'bg-emerald-100 text-emerald-700',
                                    'bg-blue-100 text-blue-700',
                                    'bg-indigo-100 text-indigo-700',
                                    'bg-amber-100 text-amber-700',
                                    'bg-rose-100 text-rose-700',
                                    'bg-purple-100 text-purple-700',
                                    'bg-teal-100 text-teal-700',
                                ];
                                $colorClass = $colors[abs(crc32($item->name)) % count($colors)];
                                $initials = strtoupper(substr($item->name, 0, 2));
                            @endphp
                            <tr class="hover:bg-gray-50/60 transition-colors">
                                <td class="py-3.5 px-5 align-top">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-xs shrink-0 {{ $colorClass }}">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900 text-sm">{{ $item->name }}</div>
                                            <div class="text-[11px] text-slate-500 font-medium">
                                                {{ $item->location ?: 'Indonesia' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-5 align-top max-w-md">
                                    <div class="text-slate-700 text-xs leading-relaxed italic line-clamp-3">
                                        "{{ $item->quote }}"
                                    </div>
                                </td>
                                <td class="py-3.5 px-5 whitespace-nowrap align-top text-slate-500">
                                    <span
                                        class="font-medium text-slate-700">{{ $item->created_at->format('d M Y') }}</span>
                                    <div class="text-[11px] text-slate-400">{{ $item->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="py-3.5 px-5 whitespace-nowrap text-right align-top">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button type="button"
                                            onclick="openEditModal({{ $item->id }}, @js($item->name), @js($item->location ?? ''), @js($item->quote))"
                                            class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors cursor-pointer"
                                            title="Ubah Ulasan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>

                                        <form id="delete-form-{{ $item->id }}"
                                            action="{{ route('admin.testimonials.destroy-item', $item) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                onclick="confirmDelete(document.getElementById('delete-form-{{ $item->id }}'))"
                                                class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer"
                                                title="Hapus Ulasan">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center">
                                    <div
                                        class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-slate-800">Belum Ada Ulasan Pelanggan</h3>
                                    <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">
                                        Tambahkan ulasan kepuasan dari pembeli produk atau warga desa. Anda bisa menambahkan
                                        beberapa ulasan sekaligus dengan mudah.
                                    </p>
                                    <button type="button" onclick="openBatchModal()"
                                        class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        <span>Tambah Ulasan Sekarang</span>
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($testimonials->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $testimonials->links() }}
                </div>
            @endif
        </div>

    </div>

    <!-- ================================================================= -->
    <!-- 1. QUICK BATCH MODAL (Opsi A ⭐ - Tambah Sekaligus Tanpa Pindah Halaman) -->
    <!-- ================================================================= -->
    <div id="batchModal"
        class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto hidden">
        <div
            class="bg-white rounded-3xl max-w-3xl w-full shadow-2xl border border-gray-100 flex flex-col max-h-[90vh] my-auto overflow-hidden animate-in fade-in zoom-in-95 duration-200">

            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-slate-50/60 shrink-0">
                <div class="flex items-center gap-3">
                    <div
                        class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Tambah Beberapa Ulasan Sekaligus</h3>
                        <p class="text-xs text-slate-500">Tulis beberapa ulasan dari pelanggan sekaligus di formulir ini.
                        </p>
                    </div>
                </div>
                <button type="button" onclick="closeBatchModal()"
                    class="p-2 text-slate-400 hover:text-slate-600 hover:bg-gray-100 rounded-xl transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Modal Form Body -->
            <form action="{{ route('admin.testimonials.batch-store') }}" method="POST" id="batchForm"
                class="flex flex-col flex-1 overflow-hidden">
                @csrf

                <div class="flex-1 overflow-y-auto p-6 space-y-4" id="batchRowsContainer">
                    <!-- Dynamic rows will be rendered here by JavaScript -->
                </div>

                <!-- Action Bar to Add More Rows -->
                <div
                    class="px-6 py-3 bg-emerald-50/50 border-t border-emerald-100 flex items-center justify-between shrink-0">
                    <button type="button" onclick="addBatchRow()"
                        class="inline-flex items-center gap-2 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-xs transition-all cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        <span>Tambah Baris Ulasan Baru</span>
                    </button>
                    <span id="batchCountBadge"
                        class="text-xs font-medium text-emerald-800 bg-emerald-100 px-2.5 py-1 rounded-lg">
                        1 ulasan
                    </span>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-2 shrink-0">
                    <button type="button" onclick="closeBatchModal()"
                        class="px-4 py-2.5 bg-white hover:bg-gray-100 border border-gray-200 text-slate-700 text-xs font-semibold rounded-xl transition-all cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        <span>Simpan Semua Ulasan</span>
                    </button>
                </div>
            </form>

        </div>
    </div>


    <!-- ================================================================= -->
    <!-- 2. SINGLE ITEM EDIT MODAL (Edit Cepat Tanpa Reload Halaman) -->
    <!-- ================================================================= -->
    <div id="editItemModal"
        class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto hidden">
        <div
            class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-gray-100 overflow-hidden my-auto animate-in fade-in zoom-in-95 duration-200">

            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-slate-50/60">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Ubah Ulasan Pelanggan</h3>
                        <p class="text-xs text-slate-500">Perbarui nama, asal wilayah, atau kutipan ulasan pelanggan.</p>
                    </div>
                </div>
                <button type="button" onclick="closeEditModal()"
                    class="p-2 text-slate-400 hover:text-slate-600 hover:bg-gray-100 rounded-xl transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form id="editItemForm" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Pelanggan <span
                            class="text-rose-500">*</span></label>
                    <input type="text" id="editItemName" name="name" required
                        placeholder="Contoh: Ibu Endang Rahayu"
                        class="w-full px-3.5 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kota / Asal Warga <span
                            class="text-slate-400 font-normal">(Boleh Kosong)</span></label>
                    <input type="text" id="editItemLocation" name="location" placeholder="Contoh: Cilacap / Banyumas"
                        class="w-full px-3.5 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Isi Ulasan / Pengalaman <span
                            class="text-rose-500">*</span></label>
                    <textarea id="editItemQuote" name="quote" rows="4" required
                        placeholder="Contoh: Aromanya sangat segar alami, lantai jadi bersih kesat..."
                        class="w-full px-3.5 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all leading-relaxed"></textarea>
                </div>

                <div class="pt-3 border-t border-gray-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeEditModal()"
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
    <!-- 3. HEADER & STATISTIK MODAL (Kelola Judul & Statistik Dampak) -->
    <!-- ================================================================= -->
    <div id="headerModal"
        class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto hidden">
        <div
            class="bg-white rounded-3xl max-w-2xl w-full shadow-2xl border border-gray-100 overflow-hidden my-auto max-h-[90vh] flex flex-col animate-in fade-in zoom-in-95 duration-200">

            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-slate-50/60 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Pengaturan Judul & Statistik</h3>
                        <p class="text-xs text-slate-500">Atur judul bagian testimoni serta angka-angka pencapaian program.
                        </p>
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

            <form action="{{ route('admin.testimonials.update-header') }}" method="POST"
                class="flex flex-col flex-1 overflow-hidden">
                @csrf

                <div class="flex-1 overflow-y-auto p-6 space-y-6">
                    <!-- Judul Section -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Judul Bagian Testimoni <span
                                class="text-rose-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $section->title) }}" required
                            placeholder="Contoh: Apa Kata Warga & Pembeli Kami"
                            class="w-full px-3.5 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all font-semibold">
                    </div>

                    <!-- Status Penayangan Section -->
                    {{-- <div class="p-4 bg-gray-50/80 border border-gray-200/80 rounded-xl flex items-center justify-between">
                        <input type="hidden" name="has_is_active_toggle" value="1">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-800">Tayangkan di Website?</span>
                                <span id="headerStatusBadge"
                                    class="px-2 py-0.5 rounded text-[10px] font-bold {{ $section->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-200 text-slate-700' }}">
                                    {{ $section->is_active ? 'Aktif di Website' : 'Draf (Belum Tampil)' }}
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-0.5">Jika aktif, bagian testimoni ini akan tampil di halaman depan website.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" id="headerIsActiveToggle" value="1"
                                {{ old('is_active', $section->is_active) ? 'checked' : '' }}
                                onchange="const b = document.getElementById('headerStatusBadge'); b.textContent = this.checked ? 'Aktif di Website' : 'Draf (Belum Tampil)'; b.className = 'px-2 py-0.5 rounded text-[10px] font-bold ' + (this.checked ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-200 text-slate-700');"
                                class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600">
                            </div>
                        </label>
                    </div> --}}

                    <!-- Repeater Statistik Dampak -->
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="text-xs font-bold text-slate-800">Angka Statistik & Pencapaian</label>
                                <p class="text-[11px] text-slate-500">Contoh: "350+ Kg", "100+ Botol Terjual"</p>
                            </div>
                            <button type="button" onclick="addStatRow()"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-lg transition-colors cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span>Tambah Angka</span>
                            </button>
                        </div>

                        <div id="statsRowsContainer" class="max-h-64 overflow-y-auto pr-1 space-y-2.5">
                            @foreach ($section->statistics as $idx => $stat)
                                <div
                                    class="stat-row p-3 bg-gray-50/80 border border-gray-200/80 rounded-xl flex items-center gap-3">
                                    <input type="hidden" name="statistics[{{ $idx }}][id]"
                                        value="{{ $stat->id }}">
                                    <div class="w-1/3">
                                        <input type="text" name="statistics[{{ $idx }}][value]"
                                            value="{{ $stat->value }}" placeholder="Contoh: 350+ Kg"
                                            class="w-full px-3 py-2 text-xs bg-white border border-gray-200 rounded-lg text-slate-900 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                                    </div>
                                    <div class="flex-1">
                                        <input type="text" name="statistics[{{ $idx }}][description]"
                                            value="{{ $stat->description }}"
                                            placeholder="Contoh: Sampah dapur berhasil diolah"
                                            class="w-full px-3 py-2 text-xs bg-white border border-gray-200 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                                    </div>
                                    <button type="button" onclick="removeStatRow(this)"
                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors shrink-0 cursor-pointer"
                                        title="Hapus baris statistik">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
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
    <!-- JAVASCRIPT LOGIC                                                  -->
    <!-- ================================================================= -->
    <script>
        // -------------------------------------------------------------
        // Batch Modal (Opsi A) Logic
        // -------------------------------------------------------------
        let batchIndex = 0;

        function openBatchModal() {
            const container = document.getElementById('batchRowsContainer');
            // If container is empty, populate with 2 initial blank rows
            if (container.children.length === 0) {
                batchIndex = 0;
                addBatchRow();
                addBatchRow();
            }
            document.getElementById('batchModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeBatchModal() {
            document.getElementById('batchModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function addBatchRow() {
            const container = document.getElementById('batchRowsContainer');
            const currentIndex = batchIndex++;
            const displayNum = container.children.length + 1;

            const rowDiv = document.createElement('div');
            rowDiv.className =
                'batch-row bg-slate-50/90 border border-slate-200/80 rounded-2xl p-4 space-y-3 relative transition-all duration-200 hover:border-emerald-200';
            rowDiv.innerHTML = `
                <div class="flex items-center justify-between">
                    <span class="row-num text-xs font-bold text-slate-700 flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-extrabold flex items-center justify-center">${displayNum}</span>
                        Ulasan #${displayNum}
                    </span>
                    <button type="button"
                        onclick="removeBatchRow(this)"
                        class="delete-row-btn p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer"
                        title="Hapus Baris Ini">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-1">Nama Pelanggan <span class="text-rose-500">*</span></label>
                        <input type="text"
                               name="items[${currentIndex}][name]"
                               placeholder="Contoh: Ibu Siti Rahmawati"
                               required
                               class="w-full px-3 py-2 text-xs bg-white border border-gray-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-1">Kota / Asal Warga <span class="text-slate-400 font-normal">(Boleh Kosong)</span></label>
                        <input type="text"
                               name="items[${currentIndex}][location]"
                               placeholder="Contoh: Cilacap"
                               class="w-full px-3 py-2 text-xs bg-white border border-gray-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Isi Ulasan / Pengalaman <span class="text-rose-500">*</span></label>
                    <textarea name="items[${currentIndex}][quote]"
                              rows="2"
                              placeholder="Tuliskan pengalaman atau tanggapan pelanggan..."
                              required
                              class="w-full px-3 py-2 text-xs bg-white border border-gray-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600"></textarea>
                </div>
            `;

            container.appendChild(rowDiv);
            updateBatchBadges();

            // Focus on the first input of the new row
            const firstInput = rowDiv.querySelector('input');
            if (firstInput) {
                firstInput.focus();
            }
        }

        function removeBatchRow(button) {
            const container = document.getElementById('batchRowsContainer');
            if (container.children.length <= 1) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Perhatian',
                        text: 'Setidaknya harus ada satu baris testimoni untuk disimpan.',
                        confirmButtonColor: '#059669',
                    });
                } else {
                    alert('Setidaknya harus ada satu baris testimoni.');
                }
                return;
            }
            button.closest('.batch-row').remove();
            renumberBatchRows();
            updateBatchBadges();
        }

        function renumberBatchRows() {
            const container = document.getElementById('batchRowsContainer');
            Array.from(container.children).forEach((row, index) => {
                const num = index + 1;
                const rowNum = row.querySelector('.row-num');
                if (rowNum) {
                    rowNum.innerHTML = `
                        <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-extrabold flex items-center justify-center">${num}</span>
                        Ulasan #${num}
                    `;
                }
            });
        }

        function updateBatchBadges() {
            const container = document.getElementById('batchRowsContainer');
            const count = container.children.length;
            const badge = document.getElementById('batchCountBadge');
            if (badge) {
                badge.textContent = `${count} ulasan`;
            }
        }

        // -------------------------------------------------------------
        // Single Edit Modal Logic
        // -------------------------------------------------------------
        function openEditModal(id, name, location, quote) {
            const form = document.getElementById('editItemForm');
            form.action = "{{ url('admin/testimonials/items') }}/" + id;
            document.getElementById('editItemName').value = name;
            document.getElementById('editItemLocation').value = location || '';
            document.getElementById('editItemQuote').value = quote;

            document.getElementById('editItemModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeEditModal() {
            document.getElementById('editItemModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // -------------------------------------------------------------
        // Header & Statistics Modal Logic
        // -------------------------------------------------------------
        let statIndex = {{ $section->statistics->count() }};

        function openHeaderModal() {
            document.getElementById('headerModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeHeaderModal() {
            document.getElementById('headerModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function addStatRow() {
            const container = document.getElementById('statsRowsContainer');
            const currentIndex = statIndex++;

            const rowDiv = document.createElement('div');
            rowDiv.className =
                'stat-row p-3 bg-gray-50/80 border border-gray-200/80 rounded-xl flex items-center gap-3 animate-in fade-in duration-150';
            rowDiv.innerHTML = `
                <div class="w-1/3">
                    <input type="text"
                           name="statistics[${currentIndex}][value]"
                           placeholder="Contoh: 350+ Kg"
                           class="w-full px-3 py-2 text-xs bg-white border border-gray-200 rounded-lg text-slate-900 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                </div>
                <div class="flex-1">
                    <input type="text"
                           name="statistics[${currentIndex}][description]"
                           placeholder="Contoh: Sampah dapur berhasil diolah"
                           class="w-full px-3 py-2 text-xs bg-white border border-gray-200 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600">
                </div>
                <button type="button"
                    onclick="removeStatRow(this)"
                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors shrink-0 cursor-pointer"
                    title="Hapus baris statistik">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            `;
            container.appendChild(rowDiv);
            const firstInput = rowDiv.querySelector('input');
            if (firstInput) firstInput.focus();
        }

        function removeStatRow(button) {
            button.closest('.stat-row').remove();
        }

        // Close on ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeBatchModal();
                closeEditModal();
                closeHeaderModal();
            }
        });

        // Close on backdrop click
        [document.getElementById('batchModal'), document.getElementById('editItemModal'), document.getElementById(
            'headerModal')].forEach(modal => {
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        closeBatchModal();
                        closeEditModal();
                        closeHeaderModal();
                    }
                });
            }
        });
    </script>
@endsection
