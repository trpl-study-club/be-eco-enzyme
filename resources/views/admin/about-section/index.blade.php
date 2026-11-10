@extends('layouts.admin')

@section('title', 'Kelola Tentang Kami')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900">Halaman Depan</a>
    <span>/</span>
    <span class="text-slate-800">Tentang Kami</span>
@endsection

@section('page_title', 'Kelola Tentang Kami')

@section('header_actions')
    <a href="{{ route('admin.about-sections.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-150">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        <span>Buat Konten Baru</span>
    </a>
@endsection

@section('page_headline', 'Daftar Konten Tentang Kami')
@section('page_subtitle', 'Kelola informasi pengenalan dan kartu kegiatan program di halaman depan website. Anda dapat
    mengaktifkan 1 konten untuk ditampilkan kepada pengunjung.')
@section('status_badge')
    @php
        $activeCount = $activeCount ?? \App\Models\AboutSection::where('is_active', true)->count();
    @endphp
    @if ($activeCount > 0)
        <span
            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
            {{ $activeCount }} Konten Aktif di Website
        </span>
    @else
        <span
            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/60">
            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
            Belum Ada Konten Aktif
        </span>
    @endif
@endsection

@section('content')
    <div class="space-y-5">

        <!-- Kolom Pencarian & Penyaring Status -->
        <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs">
            <form action="{{ route('admin.about-sections.index') }}" method="GET"
                class="flex flex-col sm:flex-row items-center gap-3 w-full">
                <div class="relative flex-1 w-full">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari judul atau isi penjelasan..."
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
                            <a href="{{ route('admin.about-sections.index') }}"
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

        <!-- Tabel Daftar Konten -->
        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-gray-50/80 border-b border-gray-200/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                            <th class="py-3.5 px-5">Judul Konten</th>
                            <th class="py-3.5 px-5">Kartu Kegiatan</th>
                            <th class="py-3.5 px-5 text-center">Status Tayang</th>
                            <th class="py-3.5 px-5">Waktu Diperbarui</th>
                            <th class="py-3.5 px-5 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        @forelse($aboutSections as $section)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-3.5 px-5">
                                    <div class="font-bold text-slate-900 text-sm max-w-xs">{{ $section->title }}</div>
                                    <div class="text-slate-500 line-clamp-1 max-w-sm mt-0.5">{!! strip_tags($section->description) !!}</div>
                                </td>
                                <td class="py-3.5 px-5 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/80">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                            </path>
                                        </svg>
                                        {{ $section->cards->count() }} Kartu Kegiatan
                                    </span>
                                </td>
                                <td class="py-3.5 px-5 whitespace-nowrap text-center">
                                    <form action="{{ route('admin.about-sections.toggle-status', $section) }}"
                                        method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            title="{{ $section->is_active ? 'Klik untuk simpan sebagai draf (sembunyikan dari website)' : 'Klik untuk jadikan konten aktif di website' }}"
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
                                        <a href="{{ route('admin.about-sections.edit', $section) }}"
                                            class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors"
                                            title="Ubah Konten">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>
                                        <form id="delete-form-{{ $section->id }}"
                                            action="{{ route('admin.about-sections.destroy', $section) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                onclick="confirmDelete(document.getElementById('delete-form-{{ $section->id }}'))"
                                                class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                                title="Hapus Konten">
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
                                <td colspan="5" class="py-16 text-center">
                                    <div
                                        class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-400 flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-800">Belum Ada Konten Tentang Kami</h4>
                                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                                        Tambahkan penjelasan tentang program atau kegiatan untuk ditampilkan di halaman
                                        depan website.
                                    </p>
                                    <a href="{{ route('admin.about-sections.create') }}"
                                        class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-150">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        <span>Buat Konten Baru</span>
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($aboutSections->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $aboutSections->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
