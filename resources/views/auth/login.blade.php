<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="min-h-screen bg-slate-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk ke Panel Pengelola - Eco-Enzyme Desa Jeruklegi</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body
    class="min-h-screen flex flex-col items-center justify-center p-4 sm:p-6 lg:p-8 antialiased text-slate-800 relative bg-slate-50">
    <!-- Subtle Background Ambient Accents -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-200/50 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-teal-200/50 rounded-full blur-3xl"></div>
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-100/40 rounded-full blur-3xl">
        </div>
    </div>

    <div class="w-full max-w-md relative z-10 my-auto py-4">
        <!-- Logo & Header -->
        <div class="text-center mb-6 sm:mb-8">
            <div class="inline-block p-1.5 rounded-2xl bg-white shadow-sm border border-gray-100 mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Eco-Enzyme Desa Jeruklegi"
                    class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl object-cover">
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Eco-Enzyme</h1>
            <p class="mt-1 text-sm sm:text-base text-slate-700 font-semibold">Halaman Masuk Pengelola Desa</p>
            <p class="mt-1 text-xs text-slate-500 max-w-xs mx-auto">Silakan masukkan email dan kata sandi Anda untuk
                mengelola konten website Desa Jeruklegi.</p>
        </div>

        <!-- Login Card -->
        <div
            class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-xl shadow-slate-200/60 border border-white p-6 sm:p-8 md:p-10">
            @if (session('success'))
                <div
                    class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div
                    class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-medium flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6" autocomplete="off">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-bold text-slate-800 mb-2">
                        Alamat Email Masuk
                    </label>
                    <div class="relative group">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            autofocus autocomplete="off" placeholder="Contoh: pengelola@desa.id"
                            class="w-full pl-4 pr-11 py-3.5 bg-gray-50/70 border border-gray-300 rounded-xl text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 focus:bg-white transition-all">
                        <div
                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-sm font-bold text-slate-800">
                            Kata Sandi
                        </label>
                    </div>
                    <div class="relative group">
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            placeholder="Ketik kata sandi Anda di sini"
                            class="w-full pl-4 pr-11 py-3.5 bg-gray-50/70 border border-gray-300 rounded-xl text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 focus:bg-white transition-all">
                        <button type="button" id="togglePasswordBtn" onclick="togglePasswordVisibility()"
                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-emerald-600 focus:outline-none focus:text-emerald-600 transition-colors cursor-pointer"
                            aria-label="Tampilkan kata sandi"
                            title="Klik untuk melihat atau menyembunyikan kata sandi Anda">
                            <!-- Eye-slash icon (when password is closed/hidden) -->
                            <svg id="eyeSlashIcon" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                            <!-- Eye icon (when password is open/visible) -->
                            <svg id="eyeOpenIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>

                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2.5 cursor-pointer select-none group">
                        <div class="relative flex items-center justify-center">
                            <input type="checkbox" name="remember" class="peer sr-only">
                            <div
                                class="w-5 h-5 border-2 border-slate-300 rounded peer-checked:bg-emerald-600 peer-checked:border-emerald-600 transition-all">
                            </div>
                            <svg class="absolute w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span
                            class="text-sm font-medium text-slate-700 group-hover:text-slate-900 transition-colors">Tetap
                            masuk di perangkat ini (Ingat saya)</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full py-3.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-base rounded-xl shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/40 transition-all flex items-center justify-center gap-2 cursor-pointer transform hover:-translate-y-0.5">
                    <span>Masuk ke Halaman Pengelola</span>
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>
            </form>
        </div>

        <p class="text-center text-xs font-medium text-slate-500 mt-8 leading-relaxed">
            &copy; {{ date('Y') }} Program Pengabdian Kepada Masyarakat, Desa Jeruklegi.<br>Seluruh hak cipta
            dilindungi.
        </p>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeOpenIcon = document.getElementById('eyeOpenIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');
            const toggleBtn = document.getElementById('togglePasswordBtn');

            if (!passwordInput) return;

            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

            if (eyeOpenIcon && eyeSlashIcon) {
                eyeOpenIcon.classList.toggle('hidden', !isPassword);
                eyeSlashIcon.classList.toggle('hidden', isPassword);
            }

            if (toggleBtn) {
                const label = isPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi';
                toggleBtn.setAttribute('aria-label', label);
                toggleBtn.setAttribute('title', label);
            }
        }
    </script>
</body>

</html>
