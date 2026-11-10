<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Halaman Utama') - Panel Pengelola Eco-Enzyme Desa Jeruklegi</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Quill.js WYSIWYG Editor CSS -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="{{ asset('css/sweetalert-custom.css') }}?v=3" rel="stylesheet">

    <!-- Scripts & Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #a7f3d0;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #6ee7b7;
        }
        /* Sidebar scrollbar */
        #sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
        #sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.15);
        }
        /* Quill custom styling */
        .ql-toolbar.ql-snow {
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
            border-color: #e2e8f0;
            background-color: #f8fafc;
        }
        .ql-container.ql-snow {
            border-bottom-left-radius: 0.75rem;
            border-bottom-right-radius: 0.75rem;
            border-color: #e2e8f0;
            font-family: inherit;
            font-size: 0.95rem;
        }
        .ql-editor {
            min-height: 140px;
        }

    </style>
    @stack('styles')
</head>
<body class="h-full antialiased text-slate-800 bg-gray-50 flex flex-col md:flex-row">

    <!-- Mobile Header / Nav Toggle -->
    <div class="md:hidden flex items-center justify-between bg-emerald-900 px-4 py-3 sticky top-0 z-40">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Eco-Enzyme Desa Jeruklegi" class="w-9 h-9 rounded-xl shadow-md shadow-emerald-500/30 object-cover shrink-0">
            <div>
                <h1 class="text-sm font-bold text-white leading-tight">Eco-Enzyme Desa Jeruklegi</h1>
                <p class="text-[11px] text-emerald-300 font-medium">Panel Pengelola Desa</p>
            </div>
        </div>
        <button type="button" onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full'); document.getElementById('sidebar-backdrop')?.classList.toggle('hidden')" class="p-2 rounded-lg text-emerald-300 hover:bg-emerald-800 focus:outline-none" aria-label="Buka Menu Navigasi" title="Buka Menu Navigasi">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>

    <!-- Mobile Sidebar Backdrop Overlay -->
    <div id="sidebar-backdrop" onclick="document.getElementById('sidebar').classList.add('-translate-x-full'); this.classList.add('hidden')" class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-xs hidden md:hidden transition-opacity"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-linear-to-b from-emerald-900 via-emerald-900 to-emerald-950 flex flex-col transition-transform duration-200 ease-in-out -translate-x-full md:translate-x-0 md:static md:h-screen md:shrink-0">
        <!-- Brand Header -->
        <div class="p-5 border-b border-emerald-700/50 flex items-center justify-between">
            <div class="flex items-center gap-3 min-w-0">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Eco-Enzyme Desa Jeruklegi" class="w-10 h-10 rounded-xl shadow-md shadow-emerald-500/30 object-cover shrink-0">
                <div class="min-w-0">
                    <span class="text-base font-bold text-white tracking-tight block truncate">Eco-Enzyme</span>
                    <span class="text-[11px] font-semibold text-emerald-300 bg-emerald-800/70 border border-emerald-600/40 px-2 py-0.5 rounded-md inline-block mt-0.5">Panel Pengelola</span>
                </div>
            </div>
            <!-- Mobile Close Button inside Sidebar -->
            <button type="button" onclick="document.getElementById('sidebar').classList.add('-translate-x-full'); document.getElementById('sidebar-backdrop')?.classList.add('hidden')" class="md:hidden p-1.5 rounded-lg text-emerald-300 hover:text-white hover:bg-emerald-800 transition-colors" aria-label="Tutup Menu Navigasi" title="Tutup Menu Navigasi">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto px-3.5 py-5 space-y-6">
            <!-- Main Navigation -->
            <div class="space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 text-white font-semibold shadow-sm' : 'text-emerald-200 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-emerald-300' : 'text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Halaman Utama</span>
                </a>
            </div>

            <!-- Group: Pengaturan Halaman Depan Web -->
            @php
                $user = Auth::user();
                $isSuperAdmin = $user?->hasRole('super_admin');
            @endphp

            @if($isSuperAdmin || $user?->hasAnyPermission(['manage_home_sections', 'manage_about_sections', 'manage_product_sections', 'manage_how_to_order', 'manage_testimonials', 'manage_contact_sections']))
            <div>
                <p class="px-3 text-[11px] font-bold text-emerald-400 uppercase tracking-wider mb-2">
                    Pengaturan Halaman Depan Web
                </p>
                <div class="space-y-1">
                    @if($isSuperAdmin || $user?->hasPermissionTo('manage_home_sections'))
                    <a href="{{ route('admin.home-sections.index') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.home-sections.*') ? 'bg-white/15 text-white font-semibold shadow-sm' : 'text-emerald-200 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.home-sections.*') ? 'text-emerald-300' : 'text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                            </svg>
                            <span>Banner Utama (Beranda)</span>
                        </div>
                        @if(request()->routeIs('admin.home-sections.*'))
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        @endif
                    </a>
                    @endif

                    @if($isSuperAdmin || $user?->hasPermissionTo('manage_about_sections'))
                    <a href="{{ route('admin.about-sections.index') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.about-sections.*') ? 'bg-white/15 text-white font-semibold shadow-sm' : 'text-emerald-200 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.about-sections.*') ? 'text-emerald-300' : 'text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Tentang Kami (Kegiatan)</span>
                        </div>
                        @if(request()->routeIs('admin.about-sections.*'))
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        @endif
                    </a>
                    @endif

                    @if($isSuperAdmin || $user?->hasPermissionTo('manage_product_sections'))
                    <a href="{{ route('admin.product-sections.index') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.product-sections.*') ? 'bg-white/15 text-white font-semibold shadow-sm' : 'text-emerald-200 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.product-sections.*') ? 'text-emerald-300' : 'text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <span>Katalog Produk Desa</span>
                        </div>
                        @if(request()->routeIs('admin.product-sections.*'))
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        @endif
                    </a>
                    @endif

                    @if($isSuperAdmin || $user?->hasPermissionTo('manage_how_to_order'))
                    <a href="{{ route('admin.how-to-orders.index') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.how-to-orders.*') ? 'bg-white/15 text-white font-semibold shadow-sm' : 'text-emerald-200 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.how-to-orders.*') ? 'text-emerald-300' : 'text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            <span>Panduan Cara Pesan</span>
                        </div>
                        @if(request()->routeIs('admin.how-to-orders.*'))
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        @endif
                    </a>
                    @endif

                    @if($isSuperAdmin || $user?->hasPermissionTo('manage_testimonials'))
                    <a href="{{ route('admin.testimonials.index') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.testimonials.*', 'admin.testimonial-sections.*') ? 'bg-white/15 text-white font-semibold shadow-sm' : 'text-emerald-200 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.testimonials.*', 'admin.testimonial-sections.*') ? 'text-emerald-300' : 'text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <span>Ulasan & Testimoni</span>
                        </div>
                        @if(request()->routeIs('admin.testimonials.*', 'admin.testimonial-sections.*'))
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        @endif
                    </a>
                    @endif

                    @if($isSuperAdmin || $user?->hasPermissionTo('manage_contact_sections'))
                    <a href="{{ route('admin.contact-sections.index') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.contact-sections.*', 'admin.contact-section.*') ? 'bg-white/15 text-white font-semibold shadow-sm' : 'text-emerald-200 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.contact-sections.*', 'admin.contact-section.*') ? 'text-emerald-300' : 'text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span>Informasi Kontak</span>
                        </div>
                        @if(request()->routeIs('admin.contact-sections.*', 'admin.contact-section.*'))
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        @endif
                    </a>
                    @endif
                </div>
            </div>
            @endif

            <!-- Group: Pengaturan Petugas Pengelola (Super Admin Only) -->
            @if($isSuperAdmin)
            <div>
                <p class="px-3 text-[11px] font-bold text-amber-400 uppercase tracking-wider mb-2">
                    Pengaturan Petugas Pengelola
                </p>
                <div class="space-y-1">
                    <a href="{{ route('admin.users.index') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.users.*') ? 'bg-white/15 text-white font-semibold shadow-sm' : 'text-emerald-200 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.users.*') ? 'text-amber-300' : 'text-amber-400/70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span>Daftar Petugas Pengelola</span>
                        </div>
                        @if(request()->routeIs('admin.users.*'))
                            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                        @endif
                    </a>
                </div>
            </div>
            @endif

            <!-- Group: Akun Saya -->
            <div>
                <p class="px-3 text-[11px] font-bold text-emerald-400 uppercase tracking-wider mb-2">
                    Akun Saya
                </p>
                <div class="space-y-1">
                    <a href="{{ route('admin.profile.edit') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ request()->routeIs('admin.profile.*') ? 'bg-white/15 text-white font-semibold shadow-sm' : 'text-emerald-200 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.profile.*') ? 'text-emerald-300' : 'text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Ubah Profil Saya</span>
                        </div>
                        @if(request()->routeIs('admin.profile.*'))
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        @endif
                    </a>
                </div>
            </div>
        </nav>

        <!-- User Profile & Logout Bottom Card -->
        <div class="p-3.5 border-t border-emerald-700/50 bg-emerald-950/60 space-y-2.5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full {{ Auth::user()?->hasRole('super_admin') ? 'bg-amber-600/90 text-amber-100 ring-2 ring-amber-400/40' : 'bg-emerald-700 text-emerald-100 ring-2 ring-emerald-500/40' }} font-bold flex items-center justify-center text-sm shrink-0">
                    {{ strtoupper(substr(Auth::user()->name ?? 'Pengelola', 0, 2)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-white truncate" title="{{ Auth::user()->name }}">{{ Auth::user()->name ?? 'Petugas Pengelola' }}</p>
                    <span class="inline-block text-[11px] font-medium px-2 py-0.5 rounded-md mt-0.5 {{ Auth::user()?->hasRole('super_admin') ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' }}">
                        {{ Auth::user()?->hasRole('super_admin') ? 'Pengelola Utama' : 'Petugas Pengelola' }}
                    </span>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold text-rose-200 bg-rose-950/40 hover:bg-rose-900/60 border border-rose-800/50 rounded-xl transition-all cursor-pointer" title="Keluar dari akun Anda">
                    <svg class="w-4 h-4 text-rose-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Keluar Akun</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 md:h-screen md:overflow-y-auto">
        <!-- Top App Header -->
        <header class="bg-white border-b border-gray-200 sticky top-0 z-30 px-4 sm:px-6 py-3.5 sm:py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
            <div>
                <!-- Breadcrumbs -->
                <nav class="flex items-center gap-1.5 text-xs font-medium text-slate-400 mb-1">
                    @yield('breadcrumbs')
                </nav>
                <!-- Page Title -->
                <h1 class="text-lg sm:text-xl font-bold text-slate-900 tracking-tight">
                    @yield('page_title', 'Halaman Utama')
                </h1>
            </div>

            <!-- Top Action Buttons Slot -->
            <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto justify-between sm:justify-end">
                @yield('header_actions')
            </div>
        </header>

        <!-- Subtitle & Mode Banner -->
        @hasSection('page_subtitle')
        <div class="bg-white border-b border-gray-200 px-6 py-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h2 class="text-sm font-semibold text-slate-800">@yield('page_headline')</h2>
                <p class="text-xs text-slate-500">@yield('page_subtitle')</p>
            </div>
            <div>
                @yield('status_badge')
            </div>
        </div>
        @endif

        <main class="flex-1 p-6 lg:p-8 max-w-7xl w-full mx-auto space-y-6">

            @if($errors->any())
                <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 shadow-xs">
                    <div class="flex items-center gap-2 mb-2 font-bold text-sm text-amber-900">
                        <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span>Mohon periksa kembali isian formulir Anda:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm space-y-1.5 text-amber-800 pl-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Quill.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // ─── SweetAlert2 Flash Messages (Toast) ──────────────────────────
        document.addEventListener('DOMContentLoaded', function () {
            const isMobile = window.innerWidth < 640;

            const Toast = Swal.mixin({
                toast: true,
                position: isMobile ? 'top' : 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                showClass: {
                    popup: 'swal2-show',
                    backdrop: 'swal2-backdrop-show'
                },
                hideClass: {
                    popup: 'swal2-hide',
                    backdrop: 'swal2-backdrop-hide'
                },
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            @if(session('success'))
                Toast.fire({
                    iconHtml: `
                        <div class="swal-toast-icon-wrapper swal-toast-success">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                            </svg>
                        </div>
                    `,
                    iconColor: 'transparent',
                    title: @json(session('success'))
                });
            @endif

            @if(session('error'))
                Toast.fire({
                    customClass: {
                        popup: 'swal-toast-error'
                    },
                    iconHtml: `
                        <div class="swal-toast-icon-wrapper swal-toast-error">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                    `,
                    iconColor: 'transparent',
                    title: @json(session('error'))
                });
            @endif
        });

        // ─── SweetAlert2 Delete Confirmation ─────────────────────────────
        function confirmDelete(formElement) {
            Swal.fire({
                iconHtml: `
                    <div class="swal-delete-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                        </svg>
                    </div>
                `,
                title: 'Apakah Anda yakin ingin menghapus data ini?',
                html: '<p class="swal-delete-text text-sm leading-relaxed">Data yang sudah dihapus akan hilang secara permanen dan tidak dapat dikembalikan. Pastikan data ini memang sudah tidak diperlukan.</p>',
                iconColor: 'transparent',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus Data',
                cancelButtonText: 'Batal (Kembali)',
                reverseButtons: true,
                focusCancel: true,
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    formElement.submit();
                }
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
