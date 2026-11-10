@extends('layouts.admin')

@section('title', 'Kelola Banner Beranda')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900">Halaman Depan</a>
    <span>/</span>
    <span class="text-slate-800">Banner Beranda</span>
@endsection

@section('page_title', 'Kelola Banner Beranda')

@section('header_actions')
    <a href="{{ route('admin.home-sections.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-150">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        <span>Buat Banner Baru</span>
    </a>
@endsection

@section('page_headline', 'Daftar Banner Beranda')
@section('page_subtitle', 'Kelola banner utama di bagian paling atas halaman depan website. Anda dapat menentukan 1
    banner aktif untuk ditampilkan kepada pengunjung.')
@section('status_badge')
    @php
        $activeCount = $activeCount ?? \App\Models\HomeSection::where('is_active', true)->count();
    @endphp
    @if ($activeCount > 0)
        <span
            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
            {{ $activeCount }} Banner Aktif Utama
        </span>
    @else
        <span
            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/60">
            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
            Belum Ada Banner Aktif
        </span>
    @endif
@endsection

@section('content')
    <div class="space-y-5">

        <!-- Kolom Pencarian & Penyaring Status -->
        <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs">
            <form action="{{ route('admin.home-sections.index') }}" method="GET"
                class="flex flex-col sm:flex-row items-center gap-3 w-full">
                <div class="relative flex-1 w-full">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari berdasarkan judul atau deskripsi banner..."
                        class="w-full pl-10 pr-4 py-2.5 text-xs bg-gray-50 border border-gray-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto shrink-0">
                    <select name="status" onchange="this.form.submit()"
                        class="w-full sm:w-auto py-2.5 px-3 pr-8 text-xs bg-gray-50 border border-gray-200 rounded-xl text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif di Website
                        </option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Draf (Belum
                            Tampil)</option>
                    </select>

                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <button type="submit"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold rounded-xl shadow-sm transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <span>Cari</span>
                        </button>

                        @if (request('search') || request('status'))
                            <a href="{{ route('admin.home-sections.index') }}"
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
                </div>
            </form>
        </div>

        <!-- Tabel Daftar Banner -->
        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-gray-50/80 border-b border-gray-200/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="py-3.5 px-5">Gambar Banner</th>
                            <th class="py-3.5 px-5">Judul Banner</th>
                            <th class="py-3.5 px-5">Tombol Utama</th>
                            <th class="py-3.5 px-5">Tombol Kedua</th>
                            <th class="py-3.5 px-5 text-center">Status Tayang</th>
                            <th class="py-3.5 px-5">Waktu Diperbarui</th>
                            <th class="py-3.5 px-5 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        @forelse($homeSections as $section)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-3.5 px-5 whitespace-nowrap">
                                    @if ($section->image)
                                        <img src="{{ Storage::disk('public')->url($section->image) }}"
                                            alt="{{ $section->title }}"
                                            class="w-12 h-12 object-cover rounded-xl border border-gray-200 shadow-xs">
                                    @else
                                        <div
                                            class="w-12 h-12 rounded-xl bg-gray-100 border border-gray-200 flex items-center justify-center text-slate-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3.5 px-5">
                                    <div class="font-bold text-slate-900 text-sm max-w-xs">{{ $section->title }}</div>
                                    <div class="text-slate-500 line-clamp-1 max-w-sm mt-0.5">{!! strip_tags($section->description) !!}</div>
                                </td>
                                <td class="py-3.5 px-5 whitespace-nowrap">
                                    @if ($section->button_one_text)
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 font-medium text-[11px] border border-emerald-200/80">
                                            {{ $section->button_one_text }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-5 whitespace-nowrap">
                                    @if ($section->button_two_text)
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-gray-100 text-slate-700 font-medium text-[11px] border border-gray-200">
                                            {{ $section->button_two_text }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-5 whitespace-nowrap text-center">
                                    <form action="{{ route('admin.home-sections.toggle-status', $section) }}"
                                        method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            title="{{ $section->is_active ? 'Klik untuk simpan sebagai draf (sembunyikan dari website)' : 'Klik untuk jadikan banner utama di website' }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold transition-all cursor-pointer {{ $section->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-gray-100 text-slate-600 border border-gray-200 hover:bg-gray-200' }}">
                                            <span
                                                class="w-1.5 h-1.5 rounded-full {{ $section->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                            {{ $section->is_active ? 'Aktif di Website' : 'Draf' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="py-3.5 px-5 whitespace-nowrap text-slate-500 text-[11px]"
                                    title="{{ $section->updated_at->diffForHumans() }}">
                                    <div class="font-medium text-slate-700">
                                        {{ $section->updated_at->translatedFormat('d M Y, H:i') }} WIB</div>
                                    <div class="text-[10px] text-slate-400">{{ $section->updated_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="py-3.5 px-5 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.home-sections.edit', $section) }}"
                                            class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors"
                                            title="Ubah Banner">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>
                                        <form id="delete-form-{{ $section->id }}"
                                            action="{{ route('admin.home-sections.destroy', $section) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                onclick="confirmDelete(document.getElementById('delete-form-{{ $section->id }}'))"
                                                class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                                title="Hapus Banner">
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
                                <td colspan="7" class="py-16 text-center">
                                    <div
                                        class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-400 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-800">Belum Ada Banner Beranda</h4>
                                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                                        Tambahkan banner beranda pertama Anda untuk ditampilkan di halaman depan website.
                                    </p>
                                    <a href="{{ route('admin.home-sections.create') }}"
                                        class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-150">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        <span>Buat Banner Baru</span>
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($homeSections->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $homeSections->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
