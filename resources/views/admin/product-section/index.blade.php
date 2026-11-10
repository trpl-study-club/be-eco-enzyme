@extends('layouts.admin')

@section('title', 'Kelola Produk')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900">Bagian Website</a>
    <span>/</span>
    <span class="text-slate-800 font-semibold">Kelola Produk</span>
@endsection

@section('page_title', 'Kelola Katalog Produk')

@section('header_actions')
    <a href="{{ route('admin.product-sections.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-150">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        <span>Tambah Produk</span>
    </a>
@endsection

@section('page_headline', 'Daftar Produk Desa')
@section('page_subtitle', 'Kelola setiap produk secara individual, atur harga, deskripsi singkat, foto, serta status tampil (Aktif/Nonaktif) di halaman depan website.')
@section('status_badge')
    @php
        $activeCount = $activeCount ?? \App\Models\Product::where('is_active', true)->count();
        $inactiveCount = $inactiveCount ?? \App\Models\Product::where('is_active', false)->count();
    @endphp
    <div class="flex flex-wrap items-center gap-2">
        <span
            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
            {{ $activeCount }} Produk Aktif
        </span>
        <span
            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/80">
            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
            {{ $inactiveCount }} Nonaktif
        </span>
    </div>
@endsection

@section('content')
    <div class="space-y-6">

        <!-- Search & Filter Bar -->
        <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs">
            <form action="{{ route('admin.product-sections.index') }}" method="GET"
                class="flex flex-col sm:flex-row items-center gap-3 w-full">
                <div class="relative flex-1 w-full">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama produk, deskripsi singkat, atau harga..."
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
                        <option value="">Semua Status Produk</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif (Tampil di Website)</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif (Disembunyikan)</option>
                    </select>

                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <button type="submit"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold rounded-xl shadow-sm transition-all cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <span>Cari</span>
                        </button>

                        @if (request('search') || request('status'))
                            <a href="{{ route('admin.product-sections.index') }}"
                                class="flex-1 sm:flex-none inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-semibold rounded-xl transition-all cursor-pointer"
                                title="Hapus Filter Pencarian">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span>Reset</span>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Product Grid -->
        @if ($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($products as $product)
                    @php
                        $primaryImage = $product->image ?: $product->detailImages->first()?->image;
                        $totalImages = ($product->image ? 1 : 0) + $product->detailImages->count();
                        $shortText = $product->detail ?? $product->description;
                    @endphp
                    <div
                        class="bg-white rounded-2xl border {{ $product->is_active ? 'border-gray-200/80 hover:border-emerald-300' : 'border-gray-200/70 bg-gray-50/40' }} shadow-xs hover:shadow-md transition-all duration-200 flex flex-col overflow-hidden group">

                        <!-- Product Image Area -->
                        <div class="relative w-full h-48 sm:h-52 bg-slate-100 overflow-hidden border-b border-gray-100 shrink-0">
                            @if ($primaryImage)
                                <img src="{{ asset('storage/' . $primaryImage) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 {{ $product->is_active ? '' : 'opacity-65 grayscale-25' }}">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-emerald-50/60 text-emerald-600/70">
                                    <svg class="w-10 h-10 mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span class="text-[11px] font-semibold text-slate-400">Belum Ada Foto</span>
                                </div>
                            @endif

                            <!-- Top Left: Photo Count Badge -->
                            @if ($totalImages > 1)
                                <div class="absolute top-3 left-3">
                                    <span
                                        class="px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-white/90 text-slate-700 border border-gray-200/60 backdrop-blur-xs shadow-2xs">
                                        {{ $totalImages }} Foto
                                    </span>
                                </div>
                            @endif

                            <!-- Top Right: Status Badge -->
                            <div class="absolute top-3 right-3">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold shadow-2xs backdrop-blur-xs {{ $product->is_active ? 'bg-emerald-500 text-white' : 'bg-slate-800/80 text-slate-200' }}">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full {{ $product->is_active ? 'bg-white' : 'bg-slate-400' }}"></span>
                                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                        </div>

                        <!-- Product Details Body -->
                        <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                            <div class="space-y-2">
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="text-base font-bold text-slate-900 leading-snug line-clamp-1"
                                        title="{{ $product->name }}">
                                        {{ $product->name }}
                                    </h3>
                                </div>

                                <div class="text-sm font-extrabold text-emerald-700">
                                    {{ $product->price ?: 'Hubungi Petugas' }}
                                </div>

                                <p class="text-xs text-slate-600 leading-relaxed line-clamp-2 min-h-9">
                                    {{ $shortText ?: 'Belum ada deskripsi singkat untuk produk ini.' }}
                                </p>
                            </div>

                            <!-- Card Actions Footer -->
                            <div class="pt-3.5 border-t border-gray-100 flex items-center justify-between gap-2">
                                <!-- Toggle Active / Inactive -->
                                <form action="{{ route('admin.product-sections.toggle-status', $product) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        title="{{ $product->is_active ? 'Klik untuk menonaktifkan produk dari website' : 'Klik untuk mengaktifkan produk di website' }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold transition-all cursor-pointer {{ $product->is_active ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200/80' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-200' }}">
                                        <span
                                            class="w-2 h-2 rounded-full {{ $product->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                        <span>{{ $product->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                    </button>
                                </form>

                                <!-- Edit & Delete Buttons -->
                                <div class="flex items-center gap-1.5">
                                    <a href="{{ route('admin.product-sections.edit', $product) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:text-emerald-700 bg-gray-50 hover:bg-emerald-50 border border-gray-200/80 hover:border-emerald-200 rounded-xl transition-colors"
                                        title="Edit Produk">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                        <span>Edit</span>
                                    </a>

                                    <form id="delete-form-{{ $product->id }}"
                                        action="{{ route('admin.product-sections.destroy', $product) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="confirmDelete(document.getElementById('delete-form-{{ $product->id }}'))"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-semibold text-rose-600 hover:text-rose-700 bg-rose-50/70 hover:bg-rose-100 border border-rose-200/60 rounded-xl transition-colors cursor-pointer"
                                            title="Hapus Produk">
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
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($products->hasPages())
                <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-xs">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs py-16 px-6 text-center">
                <div
                    class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h4 class="text-sm font-bold text-slate-800">Belum Ada Produk</h4>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    Tambahkan produk baru untuk ditampilkan pada halaman depan website desa.
                </p>
                <a href="{{ route('admin.product-sections.create') }}"
                    class="inline-flex items-center gap-2 mt-4 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-150 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Produk</span>
                </a>
            </div>
        @endif

    </div>
@endsection
