@extends('layouts.admin')

@section('title', 'Halaman Utama Pengelola')

@section('breadcrumbs')
    <span class="text-slate-800 font-semibold">Halaman Utama Pengelola</span>
@endsection

@section('page_title', 'Halaman Utama')

@section('header_actions')
    <div class="flex items-center gap-2.5">
        <a href="{{ config('app.frontend_url', 'https://sanitasihijau.com/') }}" target="_blank" rel="noopener noreferrer"
            class="inline-flex items-center gap-2 px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-xl border border-gray-200 shadow-2xs transition-all duration-150"
            title="Buka halaman website yang dilihat oleh warga">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
            </svg>
            <span>Lihat Website Publik</span>
        </a>

        @if (auth()->user()?->hasRole('super_admin') || auth()->user()?->hasPermissionTo('manage_home_sections'))
            <a href="{{ route('admin.home-sections.create') }}"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Tambah Banner Beranda Baru</span>
            </a>
        @endif
    </div>
@endsection

@section('page_headline', 'Selamat Datang di Panel Pengelola Eco-Enzyme')
@section('page_subtitle', 'Kelola seluruh informasi dan isi halaman website desa secara terpusat dan mudah.')

@section('content')
    <div class="space-y-7">

        <!-- Hero / Welcome Banner -->
        <div class="relative bg-white rounded-3xl border border-gray-200/80 shadow-xs p-6 sm:p-7 overflow-hidden">
            <!-- Top Accent Border -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-linear-to-r from-emerald-500 via-teal-500 to-emerald-400">
            </div>

            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="space-y-3 max-w-2xl">
                    <div class="flex flex-wrap items-center gap-2">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200/70">
                            Peran: {{ auth()->user()->hasRole('super_admin') ? 'Pengelola Utama' : 'Petugas Pengelola' }}
                        </span>
                    </div>

                    <div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                            Halo, {{ auth()->user()->name }}
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 mt-1 leading-relaxed">
                            Kelola seluruh informasi dan isi website desa secara terpusat. Saat ini <strong
                                class="text-emerald-700 font-bold">{{ $liveModulesCount }} dari 6 bagian informasi</strong> utama
                            telah aktif dan siap dilihat oleh warga di website publik.
                        </p>
                    </div>
                </div>

                <div
                    class="shrink-0 flex flex-col sm:flex-row lg:flex-col items-start lg:items-end gap-3 pt-4 lg:pt-0 border-t lg:border-t-0 border-gray-100">
                    <div class="text-left lg:text-right">
                        <p class="text-[11px] uppercase tracking-wider text-slate-500 font-bold">Pembaruan Terakhir</p>
                        <p class="text-xs sm:text-sm font-semibold text-slate-700 mt-0.5">
                            {{ $lastUpdated ? \Carbon\Carbon::parse($lastUpdated)->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') . ' WIB' : 'Belum Ada Pembaruan' }}
                        </p>
                    </div>
                    <a href="{{ config('app.frontend_url', 'https://sanitasihijau.com/') }}" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm shadow-emerald-500/20 hover:shadow-md transition-all duration-150 cursor-pointer">
                        <span>Lihat Halaman Utama</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Metric Cards Grid (KPI Overview) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Card 1: Bagian Konten Aktif -->
            <div
                class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs hover:border-emerald-200 hover:shadow-sm transition-all duration-200">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-600 uppercase tracking-wider">Bagian Konten Aktif</span>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-2">
                    <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $liveModulesCount }} <span
                            class="text-sm font-semibold text-slate-400">/ 6 Bagian</span></h3>
                    <p class="text-xs text-emerald-600 font-semibold mt-1 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Tampil di Website Publik
                    </p>
                </div>
            </div>

            <!-- Card 2: Katalog Produk Desa -->
            <div
                class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs hover:border-emerald-200 hover:shadow-sm transition-all duration-200">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-600 uppercase tracking-wider">Katalog Produk Desa</span>
                    <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-2">
                    <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $totalProducts }} <span
                            class="text-sm font-semibold text-slate-400">Jenis Produk</span></h3>
                    <p class="text-xs text-slate-600 font-medium mt-1">Dapat dipesan warga via WhatsApp</p>
                </div>
            </div>

            <!-- Card 3: Ulasan & Testimoni Warga -->
            <div
                class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs hover:border-emerald-200 hover:shadow-sm transition-all duration-200">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-600 uppercase tracking-wider">Ulasan & Testimoni</span>
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-2">
                    <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $totalTestimonials }} <span
                            class="text-sm font-semibold text-slate-400">Ulasan Warga</span></h3>
                    <p class="text-xs text-slate-600 font-medium mt-1">Penilaian dari warga & pembeli</p>
                </div>
            </div>

            <!-- Card 4: Kontak & Saluran Bantuan -->
            <div
                class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-xs hover:border-emerald-200 hover:shadow-sm transition-all duration-200">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-600 uppercase tracking-wider">Kontak & Bantuan</span>
                    <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-2">
                    <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $totalContactItems }} <span
                            class="text-sm font-semibold text-slate-400">Jalur Kontak</span></h3>
                    <p class="text-xs text-slate-600 font-medium mt-1">Nomor WhatsApp, Email & Alamat</p>
                </div>
            </div>
        </div>

        <!-- Status Kesiapan 6 Bagian Informasi Landing Page (Health Check) -->
        <div class="bg-white rounded-3xl border border-gray-200/80 shadow-xs p-6 sm:p-7">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-5 border-b border-gray-100 gap-3">
                <div>
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        <span>Status Kesiapan Konten Website Warga</span>
                    </h3>
                    <p class="text-xs text-slate-600 mt-0.5">Periksa kesiapan dan kelengkapan 6 bagian informasi utama sebelum ditampilkan kepada warga dan pengunjung website.</p>
                </div>
                <div class="flex items-center gap-2">
                    <span
                        class="px-3 py-1 rounded-full text-xs font-semibold {{ $liveModulesCount === 6 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-amber-50 text-amber-700 border border-amber-200/60' }}">
                        {{ $liveModulesCount }} / 6 Bagian Siap Tampil
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 pt-5">
                @foreach ($modulesStatus as $key => $mod)
                    @php
                        $canAccess =
                            auth()->user()?->hasRole('super_admin') ||
                            auth()->user()?->hasPermissionTo($mod['permission']);
                    @endphp
                    <div
                        class="p-4 rounded-2xl border transition-all duration-150 {{ $mod['is_ready'] ? 'bg-slate-50/50 border-gray-200 hover:border-emerald-300 hover:bg-emerald-50/20' : 'bg-amber-50/30 border-amber-200/70 hover:border-amber-300' }}">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wide uppercase {{ $mod['is_ready'] ? 'bg-emerald-100/70 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full {{ $mod['is_ready'] ? 'bg-emerald-600' : 'bg-amber-600' }}"></span>
                                    {{ $mod['is_ready'] ? 'Tampil di Website' : 'Belum Diisi' }}
                                </span>
                                <h4 class="text-sm font-bold text-slate-900 mt-2">{{ $mod['name'] }}</h4>
                                <p class="text-xs text-slate-600 mt-0.5">{{ $mod['description'] }}</p>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-gray-200/60 flex items-center justify-between">
                            <span
                                class="text-xs font-semibold {{ $mod['is_ready'] ? 'text-slate-700' : 'text-amber-700' }}">
                                {{ $mod['count_label'] }}
                            </span>
                            @if ($canAccess)
                                <a href="{{ route($mod['route']) }}"
                                    class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1 group"
                                    title="Klik untuk membuka dan mengatur isi bagian ini">
                                    <span>Atur Konten Ini</span>
                                    <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @else
                                <span class="text-[11px] text-slate-400 font-medium">Perlu Izin Khusus</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Preview Grid: Produk Unggulan & Ulasan Testimoni Terbaru -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Kolom Kiri: Katalog Produk Eco-Enzyme -->
            <div class="bg-white rounded-3xl border border-gray-200/80 shadow-xs p-6">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm sm:text-base font-bold text-slate-900">Daftar Produk Desa Terbaru</h4>
                            <p class="text-xs text-slate-500">Pratinjau produk Eco-Enzyme yang dapat dilihat dan dipesan oleh warga.</p>
                        </div>
                    </div>
                    @if (auth()->user()?->hasRole('super_admin') || auth()->user()?->hasPermissionTo('manage_product_sections'))
                        <a href="{{ route('admin.product-sections.index') }}"
                            class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 flex items-center gap-1 shrink-0">
                            <span>Lihat Semua Produk</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    @endif
                </div>

                <div class="mt-4 space-y-3">
                    @forelse($recentProducts as $prod)
                        <div
                            class="p-3 rounded-2xl bg-gray-50/70 border border-gray-100 flex items-center justify-between gap-3 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-3 min-w-0">
                                @if ($prod->image)
                                    <img src="{{ asset('storage/' . $prod->image) }}"
                                        class="w-12 h-12 rounded-xl object-cover border border-gray-200 shrink-0"
                                        alt="{{ $prod->name }}">
                                @else
                                    <div
                                        class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-sm shrink-0 border border-emerald-100">
                                        {{ strtoupper(substr($prod->name, 0, 2)) }}
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <h5 class="text-xs sm:text-sm font-bold text-slate-900 truncate">{{ $prod->name }}</h5>
                                    <p class="text-xs font-semibold text-emerald-600 mt-0.5">
                                        {{ $prod->price ?: 'Hubungi Petugas' }}</p>
                                </div>
                            </div>
                            <span
                                class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 border border-emerald-200 text-emerald-700 shrink-0">
                                Siap Dipesan
                            </span>
                        </div>
                    @empty
                        <div class="py-8 text-center">
                            <div
                                class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-xs font-semibold text-slate-700">Belum ada produk yang didaftarkan</p>
                            <p class="text-[11px] text-slate-500 mt-0.5">Tambahkan produk pertama melalui menu Katalog Produk Desa.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Kolom Kanan: Testimoni & Ulasan Warga Terbaru -->
            <div class="bg-white rounded-3xl border border-gray-200/80 shadow-xs p-6">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm sm:text-base font-bold text-slate-900">Ulasan Warga Terbaru</h4>
                            <p class="text-xs text-slate-500">Pendapat dan pengalaman warga tentang produk Eco-Enzyme Desa Jeruklegi.</p>
                        </div>
                    </div>
                    @if (auth()->user()?->hasRole('super_admin') || auth()->user()?->hasPermissionTo('manage_testimonials'))
                        <a href="{{ route('admin.testimonials.index') }}"
                            class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 flex items-center gap-1 shrink-0">
                            <span>Lihat Semua Ulasan</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    @endif
                </div>

                <div class="mt-4 space-y-3">
                    @forelse($recentTestimonials as $item)
                        <div
                            class="p-3.5 rounded-2xl bg-gray-50/70 border border-gray-100 space-y-2 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-xs flex items-center justify-center">
                                        {{ strtoupper(substr($item->name, 0, 1)) }}
                                    </span>
                                    <div>
                                        <h5 class="text-xs font-bold text-slate-900">{{ $item->name }}</h5>
                                        @if ($item->location)
                                            <p class="text-[11px] text-slate-500">{{ $item->location }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center text-amber-400">
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-xs text-slate-700 italic line-clamp-2">"{{ $item->quote }}"</p>
                        </div>
                    @empty
                        <div class="py-8 text-center">
                            <div
                                class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-xs font-semibold text-slate-700">Belum ada ulasan warga</p>
                            <p class="text-[11px] text-slate-500 mt-0.5">Tambahkan ulasan warga pertama melalui menu Ulasan & Testimoni.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Quick Shortcuts / Action Hub -->
        <div class="bg-linear-to-b from-white to-slate-50/60 rounded-3xl border border-gray-200/80 shadow-xs p-6 sm:p-7">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z">
                    </path>
                </svg>
                <span>Pintasan Menu Operasional Cepat</span>
            </h3>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3.5">
                @if (auth()->user()?->hasRole('super_admin') || auth()->user()?->hasPermissionTo('manage_home_sections'))
                    <a href="{{ route('admin.home-sections.create') }}"
                        class="p-4 rounded-2xl bg-white border border-gray-200/80 shadow-2xs hover:border-emerald-500 hover:shadow-md transition-all duration-200 flex flex-col items-center text-center group">
                        <div
                            class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors mb-2.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-slate-800">Ubah Banner Beranda</span>
                        <span class="text-[11px] text-slate-500 mt-0.5">Foto & Banner Depan</span>
                    </a>
                @endif

                @if (auth()->user()?->hasRole('super_admin') || auth()->user()?->hasPermissionTo('manage_product_sections'))
                    <a href="{{ route('admin.product-sections.index') }}"
                        class="p-4 rounded-2xl bg-white border border-gray-200/80 shadow-2xs hover:border-teal-500 hover:shadow-md transition-all duration-200 flex flex-col items-center text-center group">
                        <div
                            class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center group-hover:bg-teal-600 group-hover:text-white transition-colors mb-2.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-slate-800">Atur Katalog Produk</span>
                        <span class="text-[11px] text-slate-500 mt-0.5">Daftar Produk & Harga</span>
                    </a>
                @endif

                @if (auth()->user()?->hasRole('super_admin') || auth()->user()?->hasPermissionTo('manage_testimonials'))
                    <a href="{{ route('admin.testimonials.index') }}"
                        class="p-4 rounded-2xl bg-white border border-gray-200/80 shadow-2xs hover:border-amber-500 hover:shadow-md transition-all duration-200 flex flex-col items-center text-center group">
                        <div
                            class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-colors mb-2.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-slate-800">Tambah Ulasan Warga</span>
                        <span class="text-[11px] text-slate-500 mt-0.5">Pengalaman Pembeli</span>
                    </a>
                @endif

                @if (auth()->user()?->hasRole('super_admin') || auth()->user()?->hasPermissionTo('manage_contact_sections'))
                    <a href="{{ route('admin.contact-sections.index') }}"
                        class="p-4 rounded-2xl bg-white border border-gray-200/80 shadow-2xs hover:border-sky-500 hover:shadow-md transition-all duration-200 flex flex-col items-center text-center group">
                        <div
                            class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center group-hover:bg-sky-600 group-hover:text-white transition-colors mb-2.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-slate-800">Ubah Kontak Bantuan</span>
                        <span class="text-[11px] text-slate-500 mt-0.5">Nomor WhatsApp & Email</span>
                    </a>
                @endif

                @if (auth()->user()?->hasRole('super_admin'))
                    <a href="{{ route('admin.users.index') }}"
                        class="p-4 rounded-2xl bg-white border border-gray-200/80 shadow-2xs hover:border-purple-500 hover:shadow-md transition-all duration-200 flex flex-col items-center text-center group">
                        <div
                            class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-colors mb-2.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-slate-800">Kelola Petugas</span>
                        <span class="text-[11px] text-slate-500 mt-0.5">{{ $totalUsers }} Petugas Aktif</span>
                    </a>
                @else
                    <a href="{{ route('admin.profile.edit') }}"
                        class="p-4 rounded-2xl bg-white border border-gray-200/80 shadow-2xs hover:border-emerald-500 hover:shadow-md transition-all duration-200 flex flex-col items-center text-center group">
                        <div
                            class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors mb-2.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-slate-800">Ubah Profil Saya</span>
                        <span class="text-[11px] text-slate-500 mt-0.5">Kelola Akun Pribadi</span>
                    </a>
                @endif
            </div>
        </div>


    </div>
@endsection
