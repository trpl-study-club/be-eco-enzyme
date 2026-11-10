@extends('layouts.admin')

@section('title', 'Edit Profil')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900">Akun</a>
    <span>/</span>
    <span class="text-slate-800">Edit Profil</span>
@endsection

@section('page_title', 'Profil Saya')

@section('page_headline', 'Kelola Informasi Akun')
@section('page_subtitle', 'Ubah data profil dan kata sandi akun Anda.')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

    <!-- KOLOM KIRI: Profil & Kata Sandi -->
    <div class="lg:col-span-8 space-y-6">

        <!-- CARD 1: Informasi Profil -->
        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Informasi Profil</h3>
                        <p class="text-xs text-slate-500">Ubah nama dan email akun Anda.</p>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 mb-2">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required maxlength="255"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                    </div>
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 mb-2">
                            Email <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required maxlength="255"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                    </div>
                </div>

                <div class="mt-5 pt-5 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Simpan Profil</span>
                    </button>
                </div>
            </div>
        </form>

        <!-- CARD 2: Ubah Kata Sandi -->
        <form action="{{ route('admin.profile.update-password') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">Ubah Kata Sandi</h3>
                        <p class="text-xs text-slate-500">Ganti kata sandi secara berkala demi keamanan akun Anda. Gunakan minimal 8 karakter yang aman dan sulit ditebak orang lain.</p>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <label for="current_password" class="block text-xs font-bold text-slate-700 mb-2">
                            Kata Sandi Saat Ini <span class="text-rose-500">*</span>
                        </label>
                        <input type="password" id="current_password" name="current_password" required placeholder="Masukkan kata sandi Anda saat ini"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="new_password" class="block text-xs font-bold text-slate-700 mb-2">
                                Kata Sandi Baru <span class="text-rose-500">*</span>
                            </label>
                            <input type="password" id="new_password" name="new_password" required placeholder="Minimal 8 karakter"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                        </div>
                        <div>
                            <label for="new_password_confirmation" class="block text-xs font-bold text-slate-700 mb-2">
                                Ulangi Kata Sandi Baru <span class="text-rose-500">*</span>
                            </label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" required placeholder="Ketik ulang kata sandi baru Anda"
                                   class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                        </div>
                    </div>
                </div>

                <div class="mt-5 pt-5 border-t border-gray-100">
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold rounded-xl shadow-sm transition-all cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span>Simpan Kata Sandi Baru</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- KOLOM KANAN: Info Akun -->
    <div class="lg:col-span-4 space-y-6">

        <!-- Card: Akun Info -->
        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
            <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                <div class="w-12 h-12 rounded-full {{ $user->isSuperAdmin() ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700' }} font-bold flex items-center justify-center text-base">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">{{ $user->name }}</h3>
                    <p class="text-xs text-slate-500">{{ $user->email }}</p>
                </div>
            </div>

            <div class="space-y-3 text-xs">
                <div class="flex justify-between items-center text-slate-500">
                    <span>Peran Akun:</span>
                    @if($user->isSuperAdmin())
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200/60">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            Pengelola Utama
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                            Petugas Pengelola
                        </span>
                    @endif
                </div>
                <div class="flex justify-between items-center text-slate-500">
                    <span>Status:</span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $user->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-rose-50 text-rose-600 border border-rose-200/60' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $user->is_active ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <div class="flex justify-between items-center text-slate-500">
                    <span>Terdaftar:</span>
                    <span class="text-slate-700 font-medium">{{ $user->created_at->translatedFormat('d M Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Card: Hak Akses Modul Website -->
        <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
            <div class="flex items-center gap-3 pb-5 border-b border-gray-100 mb-5">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900">Hak Akses Modul Website</h3>
                    <p class="text-xs text-slate-500">Daftar bagian website desa yang dapat Anda kelola.</p>
                </div>
            </div>

            @if($user->isSuperAdmin())
                <div class="p-3 bg-amber-50/70 border border-amber-100 rounded-xl text-xs text-amber-800">
                    <span class="font-bold">Wewenang Penuh</span> — Anda memiliki wewenang penuh untuk mengatur seluruh website desa dan pengelolaan akun petugas.
                </div>
            @else
                <div class="space-y-2">
                    @php
                        $permissionLabels = [
                            'manage_home_sections' => 'Banner Beranda',
                            'manage_about_sections' => 'Tentang Kami',
                            'manage_product_sections' => 'Katalog Produk',
                            'manage_how_to_order' => 'Panduan Cara Pesan',
                            'manage_testimonials' => 'Ulasan & Testimoni',
                            'manage_contact_sections' => 'Informasi Kontak',
                        ];
                    @endphp
                    @forelse($user->getAllPermissions() as $perm)
                        <div class="flex items-center gap-2 text-xs text-slate-700">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ $permissionLabels[$perm->name] ?? $perm->name }}</span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400">Belum ada hak akses modul yang diberikan.</p>
                    @endforelse
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
