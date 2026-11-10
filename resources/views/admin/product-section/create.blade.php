@extends('layouts.admin')

@section('title', 'Buat Produk Baru')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-slate-900">Bagian Website</a>
    <span>/</span>
    <a href="{{ route('admin.product-sections.index') }}" class="text-slate-500 hover:text-slate-900">Katalog Produk</a>
    <span>/</span>
    <span class="text-slate-800 font-semibold">Buat Baru</span>
@endsection

@section('page_title', 'Kelola Produk')

@section('header_actions')
    <div class="hidden sm:flex items-center gap-2.5">
        <a href="{{ route('admin.product-sections.index') }}"
            class="px-4 py-2 text-xs font-semibold text-slate-700 hover:text-slate-900 bg-white border border-gray-200 rounded-xl hover:bg-slate-50 transition-colors shrink-0">
            Batalkan & Kembali
        </a>
        <button type="button" onclick="submitWithAction('draft')"
            class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-gray-50 text-slate-700 text-xs font-semibold rounded-xl border border-gray-200 shadow-2xs hover:border-gray-300 transition-all duration-150 cursor-pointer shrink-0">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
            </svg>
            <span>Simpan Sebagai Draf</span>
        </button>
        <button type="button" onclick="submitWithAction('publish')"
            class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all duration-150 cursor-pointer shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>Simpan & Tampilkan di Website</span>
        </button>
    </div>
@endsection

@section('page_headline', 'Buat Section Produk')
@section('page_subtitle', 'Kelola informasi judul katalog, penjelasan singkat, nomor WhatsApp pemesanan, serta daftar rincian produk desa.')
@section('status_badge')
    <span
        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
        Mode Pengisian Baru
    </span>
@endsection

@section('content')
    <form id="product-section-form" action="{{ route('admin.product-sections.store') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="action" id="form-action" value="publish">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- KOLOM KIRI (8 Kolom): Konten Utama & Daftar Produk -->
            <div class="lg:col-span-8 space-y-6">

                <!-- KARTU 1: Konten Utama & Deskripsi -->
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
                            <h3 class="text-base font-bold text-slate-900">Konten Utama Katalog Produk</h3>
                            <p class="text-xs text-slate-500">Kelola judul katalog dan narasi pengantar produk desa di halaman depan.</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <!-- Judul Field -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="title" class="block text-sm font-bold text-slate-800">
                                    Judul Katalog Produk <span class="text-rose-500">*</span>
                                </label>
                                <span id="title-counter" class="text-[11px] text-slate-400 font-mono">0 / 255 Karakter</span>
                            </div>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                maxlength="255" placeholder="Contoh: Produk Unggulan & Hasil Olahan Warga Desa"
                                oninput="document.getElementById('title-counter').innerText = this.value.length + ' / 255 Karakter'"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            <p class="text-[11px] text-slate-500 mt-1.5">
                                Gunakan judul yang menarik perhatian pembeli dan mencerminkan kualitas produk desa.
                            </p>
                        </div>

                        <!-- Nomor WhatsApp Field -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="whatsapp_number" class="block text-sm font-bold text-slate-800">
                                    Nomor WhatsApp Pemesanan
                                </label>
                            </div>
                            <input type="text" id="whatsapp_number" name="whatsapp_number"
                                value="{{ old('whatsapp_number') }}" placeholder="Contoh: 081234567890 atau 6281234567890"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            <p class="text-[11px] text-slate-500 mt-1.5">
                                Nomor WhatsApp petugas yang akan dihubungi pembeli saat menekan tombol pesan. Berlaku untuk seluruh produk di bawah ini.
                            </p>
                        </div>

                        <!-- Deskripsi Rich Editor -->
                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-2">
                                Deskripsi Singkat / Pengantar Produk <span class="text-rose-500">*</span>
                            </label>
                            <x-form.rich-editor name="description" :value="old('description')"
                                placeholder="Tuliskan pengantar singkat tentang produk-produk berkualitas hasil karya kelompok warga desa kami..." />
                            <p class="text-[11px] text-slate-500 mt-1.5">
                                Tuliskan pengantar yang ramah dan mengajak pembeli untuk memesan produk desa.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- KARTU 2: Daftar Produk / Katalog (Repeater) -->
                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6">
                    <div class="flex items-center justify-between pb-5 border-b border-gray-100 mb-5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-base font-bold text-slate-900">Daftar Produk / Katalog</h3>
                                </div>
                                <p class="text-xs text-slate-500">Setiap produk berisi nama produk, harga, keunggulan, deskripsi singkat, rincian lengkap, dan foto produk.</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 text-xs font-semibold">
                            <button type="button" onclick="collapseAllproducts()"
                                class="text-slate-600 hover:text-emerald-700 hover:underline cursor-pointer">Tutup Semua Rincian</button>
                            <span class="text-slate-300">|</span>
                            <button type="button" onclick="expandAllproducts()"
                                class="text-slate-600 hover:text-emerald-700 hover:underline cursor-pointer">Buka Semua Rincian</button>
                        </div>
                    </div>

                    <!-- products Container (Repeater) -->
                    <div id="products-container" class="space-y-4">
                        <!-- Default Initial product -->
                        <div class="product-item rounded-xl border border-slate-200 bg-slate-50/40 overflow-hidden transition-all shadow-2xs"
                            data-index="0">
                            <!-- product Item Header -->
                            <div class="p-3.5 bg-slate-100/70 border-b border-slate-200/70 flex items-center justify-between cursor-pointer"
                                onclick="toggleproductAccordion(this)">
                                <div class="flex items-center gap-2.5">
                                    <span
                                        class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center product-badge-num">1</span>
                                    <span class="product-header-title text-xs font-bold text-slate-800">Produk 1</span>
                                    <span
                                        class="product-header-price text-[11px] font-medium text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100/80 hidden"></span>
                                </div>
                                <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                                    <button type="button" onclick="removeproductItem(this)" title="Hapus Produk"
                                        class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                    <button type="button" onclick="toggleproductAccordion(this.parentElement)"
                                        class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg transition-colors">
                                        <svg class="w-4 h-4 product-accordion-icon transform transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- product Item Body -->
                            <div class="product-body p-4 sm:p-5 space-y-4 bg-white">
                                <!-- Grid Judul & Harga Produk -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <!-- Judul product -->
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                            Nama / Judul Produk <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" name="products[0][name]"
                                            value="{{ old('products.0.name') }}" required
                                            placeholder="Contoh: Sabun Batang Eco-Enzyme"
                                            oninput="updateproductHeaderTitle(this)"
                                            class="product-title-input w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                                    </div>

                                    <!-- Harga product -->
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                            Harga Produk <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" name="products[0][price]"
                                            value="{{ old('products.0.price') }}" required
                                            placeholder="Contoh: Rp 15.000 / batang"
                                            oninput="updateproductHeaderPrice(this)"
                                            class="product-price-input w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                                    </div>
                                </div>

                                <!-- Benefit / Keunggulan Utama Produk -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Benefit / Keunggulan Utama <span
                                            class="text-[11px] font-normal text-slate-400">(Opsional)</span>
                                    </label>
                                    <input type="text" name="products[0][benefit]"
                                        value="{{ old('products.0.benefit') }}"
                                        placeholder="Contoh: Aman untuk kulit sensitif anak-anak & 100% alami"
                                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                                    <p class="text-[11px] text-slate-400 mt-1">
                                        Pernyataan manfaat/keunggulan utama produk yang langsung dirasakan oleh pelanggan.
                                    </p>
                                </div>

                                <!-- Deskripsi Singkat Produk -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Deskripsi Singkat Produk <span class="text-rose-500">*</span>
                                    </label>
                                    <textarea name="products[0][description]" rows="2" required
                                        placeholder="Jelaskan secara ringkas karakteristik, bahan, atau kegunaan produk untuk kartu katalog..."
                                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all leading-relaxed">{{ old('products.0.description') }}</textarea>
                                    <p class="text-[11px] text-slate-400 mt-1">
                                        Ringkasan singkat yang ditampilkan pada kartu katalog produk di landing page.
                                    </p>
                                </div>

                                <!-- Detail Produk -->
                                <div>
                                    <div class="flex items-center justify-between mb-1.5">
                                        <label class="block text-xs font-semibold text-slate-700">
                                            Detail Produk (Spesifikasi & Rincian) <span
                                                class="text-[11px] font-normal text-slate-400">(Opsional)</span>
                                        </label>
                                        <span class="text-[11px] text-slate-400">Rincian Lengkap Produk</span>
                                    </div>
                                    <textarea name="products[0][detail]" rows="4" placeholder="Masukan detail produk anda"
                                        class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all leading-relaxed">{{ old('products.0.detail') }}</textarea>
                                    <p class="text-[11px] text-slate-400 mt-1">
                                        Cantumkan informasi detail seperti spesifikasi teknis, komposisi/bahan, netto, izin
                                        edar, aturan pakai, atau petunjuk penyimpanan.
                                    </p>
                                </div>

                                <!-- Spesifikasi Produk (Specs) -->
                                <div class="pt-4 border-t border-slate-100 space-y-4">
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-800">Spesifikasi Produk (Specs)</h4>
                                        <p class="text-[11px] text-slate-400 mt-0.5">Isi rincian spesifikasi produk untuk ditampilkan secara terstruktur pada katalog.</p>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Berat Bersih (Netto)</label>
                                            <input type="text" name="products[0][specs][netto]" value="{{ old('products.0.specs.netto') }}" placeholder="Contoh: 100 gr"
                                                class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kemasan (Packaging)</label>
                                            <input type="text" name="products[0][specs][packaging]" value="{{ old('products.0.specs.packaging') }}" placeholder="Contoh: Kertas Kraft Daur Ulang"
                                                class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Bentuk / Tekstur (Shape)</label>
                                            <input type="text" name="products[0][specs][shape]" value="{{ old('products.0.specs.shape') }}" placeholder="Contoh: Batang Padat (Bunga, Hexagonal)"
                                                class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kecocokan Kulit / Penggunaan (Suitability)</label>
                                            <input type="text" name="products[0][specs][suitability]" value="{{ old('products.0.specs.suitability') }}" placeholder="Contoh: Semua Jenis Kulit & Balita"
                                                class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Status Stok (Stock)</label>
                                            <input type="text" name="products[0][specs][stock]" value="{{ old('products.0.specs.stock') }}" placeholder="Contoh: Tersedia (Ready Stock)"
                                                class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Klaim / Sertifikasi (Certification)</label>
                                            <input type="text" name="products[0][specs][certification]" value="{{ old('products.0.specs.certification') }}" placeholder="Contoh: 100% Organik & Biodegradable"
                                                class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Komposisi / Bahan (Ingredients)</label>
                                        <textarea name="products[0][specs][ingredients]" rows="2" placeholder="Contoh: Minyak kelapa murni, fermentasi eco-enzyme buah..."
                                            class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all leading-relaxed">{{ old('products.0.specs.ingredients') }}</textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Cara Pemakaian (Usage)</label>
                                        <textarea name="products[0][specs][usage]" rows="2" placeholder="Contoh: Busakan dengan air, usapkan lembut ke seluruh tubuh..."
                                            class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all leading-relaxed">{{ old('products.0.specs.usage') }}</textarea>
                                    </div>
                                </div>

                                <!-- Gambar Utama Produk Upload -->
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                        Gambar Utama Produk <span
                                            class="text-[11px] font-normal text-slate-400">(Opsional)</span>
                                    </label>
                                    <div class="product-image-dropzone border-2 border-dashed border-gray-200 hover:border-emerald-400 rounded-xl p-4 text-center cursor-pointer transition-all bg-gray-50/50 hover:bg-emerald-50/30"
                                        onclick="this.querySelector('.product-image-input').click()">
                                        <input type="file" name="products[0][image]"
                                            accept="image/png,image/jpeg,image/jpg,image/webp"
                                            onchange="handleproductImagePreview(this)" class="product-image-input hidden">

                                        <!-- Preview Image -->
                                        <div class="product-preview-wrapper hidden mb-2">
                                            <div
                                                class="w-full sm:max-w-xs mx-auto aspect-square bg-gray-50 rounded-lg border border-slate-200 shadow-2xs mb-2 flex items-center justify-center overflow-hidden">
                                                <img src="#" alt="Preview"
                                                    class="product-preview-img max-w-full max-h-full object-contain">
                                            </div>
                                            <button type="button"
                                                onclick="event.stopPropagation(); removeproductselectedImage(this)"
                                                class="text-xs text-rose-600 hover:text-rose-800 font-semibold underline cursor-pointer">
                                                Hapus / Ganti Gambar
                                            </button>
                                        </div>

                                        <!-- Dropzone Placeholder Content -->
                                        <div class="product-dropzone-content">
                                            <svg class="w-8 h-8 text-slate-400 mx-auto mb-1.5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <p class="text-xs font-medium text-slate-700">
                                                Klik atau seret gambar utama untuk produk ini
                                            </p>
                                            <p class="text-[10px] text-slate-400 mt-0.5">
                                                Format: PNG, JPG, WEBP • Maks 2MB
                                            </p>
                                            <p class="text-[10px] text-emerald-600 font-medium mt-1">
                                                 Rekomendasi rasio: 1:1 (800 × 800 px)
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detail Gambar Produk Upload (Maks. 5 Gambar) -->
                                <div class="pt-4 border-t border-slate-100">
                                    <div class="flex items-center justify-between mb-2">
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700">
                                                Detail Gambar Produk <span class="text-[11px] font-normal text-slate-400">(Maksimal 5 Gambar)</span>
                                            </label>
                                            <p class="text-[11px] text-slate-400 mt-0.5">
                                                Unggah foto detail, varian, atau rincian tambahan untuk produk ini.
                                            </p>
                                        </div>
                                        <span class="product-detail-images-counter text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                                            0 / 5 Gambar
                                        </span>
                                    </div>

                                    <!-- Grid Preview Detail Images -->
                                    <div class="product-detail-images-grid grid grid-cols-2 sm:grid-cols-5 gap-3 mb-3"></div>

                                    <!-- File input for detail images -->
                                    <input type="file"
                                           name="products[0][detail_images][]"
                                           multiple
                                           accept="image/png,image/jpeg,image/jpg,image/webp"
                                           onchange="handleDetailImagesSelected(this)"
                                           class="product-detail-images-input hidden">

                                    <!-- Add button trigger -->
                                    <button type="button"
                                            onclick="triggerDetailImageUpload(this)"
                                            class="product-detail-images-add-trigger w-full py-2.5 px-3 border border-dashed border-gray-300 hover:border-emerald-500 rounded-xl bg-gray-50/60 hover:bg-emerald-50/40 text-slate-600 hover:text-emerald-700 text-xs font-semibold flex items-center justify-center gap-2 transition-all cursor-pointer">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        <span>Tambah Detail Gambar</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Button -->
                    <button type="button" onclick="addNewproductItem()"
                        class="mt-5 w-full py-3.5 border-2 border-dashed border-emerald-400 hover:border-emerald-600 bg-emerald-50/50 hover:bg-emerald-100/80 rounded-xl text-sm font-bold text-emerald-800 hover:text-emerald-900 transition-all flex items-center justify-center gap-2 cursor-pointer shadow-2xs">
                        <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        <span>Tambah Produk Baru ke Daftar</span>
                    </button>
                </div>

            </div>

            <!-- KOLOM KANAN (4 Kolom): Status & Aksi -->
            <div class="lg:col-span-4 space-y-6">

                <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs p-6 space-y-4">
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
                            <p class="text-xs text-slate-500">Pilih apakah katalog produk ini langsung tampil atau disimpan sebagai draf.</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-2">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-800">Tayangkan di Website?</span>
                                <span id="status-badge"
                                    class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">Aktif di Website</span>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-0.5">Jika aktif, pengunjung langsung dapat melihat katalog produk ini.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" id="is_active_toggle" value="1" checked
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
                                <span class="font-bold block text-emerald-900">Kebijakan 1 Katalog Aktif</span>
                                <p class="text-[11px] text-emerald-800 mt-0.5">Halaman depan hanya menampilkan 1 katalog produk utama. Jika katalog ini diaktifkan, katalog lama yang sebelumnya aktif otomatis dijadikan <strong>Draf</strong>.</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 space-y-2 text-xs">
                        <div class="flex justify-between items-start text-slate-500">
                            <span>Terakhir Diperbarui:</span>
                            <div class="text-right">
                                <span class="text-slate-700 font-medium">{{ now()->translatedFormat('d M Y, H:i') }} WIB</span>
                                <span class="text-[11px] text-emerald-600 font-medium block">Saat disimpan (Baru)</span>
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
                    <span>Simpan Sebagai Draf</span>
                </button>
                <button type="button" onclick="submitWithAction('publish')"
                    class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm shadow-emerald-500/20 transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Simpan & Tampilkan</span>
                </button>
            </div>
            <a href="{{ route('admin.product-sections.index') }}"
                class="w-full inline-flex items-center justify-center py-2.5 px-4 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors">
                Batalkan & Kembali
            </a>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Set initial counter
            const titleInput = document.getElementById('title');
            if (titleInput) {
                document.getElementById('title-counter').innerText = titleInput.value.length + ' / 255 Karakter';
            }
        });

        function submitWithAction(action) {
            document.getElementById('form-action').value = action;
            const toggle = document.getElementById('is_active_toggle');
            const badge = document.getElementById('status-badge');
            if (action === 'draft') {
                if (toggle) toggle.checked = false;
                if (badge) {
                    badge.className = 'px-2 py-0.5 rounded text-[10px] font-bold bg-gray-200 text-slate-700';
                    badge.innerText = 'Draf (Belum Tampil)';
                }
            } else if (action === 'publish') {
                if (toggle) toggle.checked = true;
                if (badge) {
                    badge.className = 'px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800';
                    badge.innerText = 'Aktif di Website';
                }
            }

            const form = document.getElementById('product-section-form');
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

        // ─── products Repeater Scripts ──────────────────────────────────────────
        let productIndexCounter = 1;

        function updateproductBadgeCount() {
            const count = document.querySelectorAll('#products-container .product-item').length;
            const badge = document.getElementById('product-count-badge');
            if (badge) {
                badge.innerText = count + ' Produk';
            }
        }

        function reindexproducts() {
            const items = document.querySelectorAll('#products-container .product-item');
            items.forEach((item, idx) => {
                const badge = item.querySelector('.product-badge-num');
                if (badge) badge.innerText = idx + 1;

                const headerTitle = item.querySelector('.product-header-title');
                const titleInput = item.querySelector('.product-title-input');
                if (headerTitle) {
                    const val = titleInput && titleInput.value.trim() ? titleInput.value.trim() : 'Produk ' + (idx +
                        1);
                    headerTitle.innerText = val;
                }

                const headerPrice = item.querySelector('.product-header-price');
                const priceInput = item.querySelector('.product-price-input');
                if (headerPrice) {
                    if (priceInput && priceInput.value.trim()) {
                        headerPrice.innerText = priceInput.value.trim();
                        headerPrice.classList.remove('hidden');
                    } else {
                        headerPrice.innerText = '';
                        headerPrice.classList.add('hidden');
                    }
                }
            });
            updateproductBadgeCount();
        }

        function updateproductHeaderTitle(input) {
            const item = input.closest('.product-item');
            const headerTitle = item.querySelector('.product-header-title');
            const idx = Array.from(document.querySelectorAll('#products-container .product-item')).indexOf(item) + 1;
            if (headerTitle) {
                headerTitle.innerText = input.value.trim() ? input.value.trim() : 'Produk ' + idx;
            }
        }

        function updateproductHeaderPrice(input) {
            const item = input.closest('.product-item');
            const headerPrice = item.querySelector('.product-header-price');
            if (headerPrice) {
                if (input.value.trim()) {
                    headerPrice.innerText = input.value.trim();
                    headerPrice.classList.remove('hidden');
                } else {
                    headerPrice.innerText = '';
                    headerPrice.classList.add('hidden');
                }
            }
        }

        function toggleproductAccordion(trigger) {
            const item = trigger.closest('.product-item');
            const body = item.querySelector('.product-body');
            const icon = item.querySelector('.product-accordion-icon');

            if (body.classList.contains('hidden')) {
                body.classList.remove('hidden');
                if (icon) icon.classList.remove('-rotate-90');
            } else {
                body.classList.add('hidden');
                if (icon) icon.classList.add('-rotate-90');
            }
        }

        function collapseAllproducts() {
            document.querySelectorAll('#products-container .product-item').forEach(item => {
                item.querySelector('.product-body').classList.add('hidden');
                const icon = item.querySelector('.product-accordion-icon');
                if (icon) icon.classList.add('-rotate-90');
            });
        }

        function expandAllproducts() {
            document.querySelectorAll('#products-container .product-item').forEach(item => {
                item.querySelector('.product-body').classList.remove('hidden');
                const icon = item.querySelector('.product-accordion-icon');
                if (icon) icon.classList.remove('-rotate-90');
            });
        }

        function addNewproductItem() {
            const container = document.getElementById('products-container');
            const currentCount = container.querySelectorAll('.product-item').length;
            const newNum = currentCount + 1;
            const index = productIndexCounter++;

            const productHtml = `
            <div class="product-item rounded-xl border border-slate-200 bg-slate-50/40 overflow-hidden transition-all shadow-2xs" data-index="${index}">
                <div class="p-3.5 bg-slate-100/70 border-b border-slate-200/70 flex items-center justify-between cursor-pointer" onclick="toggleproductAccordion(this)">
                    <div class="flex items-center gap-2.5">
                        <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center product-badge-num">${newNum}</span>
                        <span class="product-header-title text-xs font-bold text-slate-800">Produk ${newNum}</span>
                        <span class="product-header-price text-[11px] font-medium text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100/80 hidden"></span>
                    </div>
                    <div class="flex items-center gap-2" onclick="event.stopPropagation()">
                        <button type="button" onclick="removeproductItem(this)" title="Hapus Produk" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                        <button type="button" onclick="toggleproductAccordion(this.parentElement)" class="p-1.5 text-slate-400 hover:text-slate-700 rounded-lg transition-colors">
                            <svg class="w-4 h-4 product-accordion-icon transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="product-body p-4 sm:p-5 space-y-4 bg-white">
                    <!-- Grid Judul & Harga Produk -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Nama / Judul Produk <span class="text-rose-500">*</span>
                            </label>
                            <input type="text"
                                   name="products[${index}][name]"
                                   required
                                   placeholder="Contoh: Sabun Batang Eco-Enzyme"
                                   oninput="updateproductHeaderTitle(this)"
                                   class="product-title-input w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Harga Produk <span class="text-rose-500">*</span>
                            </label>
                            <input type="text"
                                   name="products[${index}][price]"
                                   required
                                   placeholder="Contoh: Rp 15.000 / batang"
                                   oninput="updateproductHeaderPrice(this)"
                                   class="product-price-input w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                        </div>
                    </div>

                    <!-- Benefit / Keunggulan Utama Produk -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Benefit / Keunggulan Utama <span class="text-[11px] font-normal text-slate-400">(Opsional)</span>
                        </label>
                        <input type="text"
                               name="products[${index}][benefit]"
                               placeholder="Contoh: Aman untuk kulit sensitif anak-anak & 100% alami"
                               class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                        <p class="text-[11px] text-slate-400 mt-1">
                            Pernyataan manfaat/keunggulan utama produk yang langsung dirasakan oleh pelanggan.
                        </p>
                    </div>

                    <!-- Deskripsi Singkat Produk -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Deskripsi Singkat Produk <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="products[${index}][description]"
                                  rows="2"
                                  required
                                  placeholder="Jelaskan secara ringkas karakteristik, bahan, atau kegunaan produk untuk kartu katalog..."
                                  class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all leading-relaxed"></textarea>
                        <p class="text-[11px] text-slate-400 mt-1">
                            Ringkasan singkat yang ditampilkan pada kartu katalog produk di landing page.
                        </p>
                    </div>

                    <!-- Detail Produk -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-semibold text-slate-700">
                                Detail Produk (Spesifikasi & Rincian) <span class="text-[11px] font-normal text-slate-400">(Opsional)</span>
                            </label>
                            <span class="text-[11px] text-slate-400">Rincian Lengkap Produk</span>
                        </div>
                        <textarea name="products[${index}][detail]"
                                  rows="4"
                                  placeholder="Masukan detail produk anda"
                                  class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all leading-relaxed"></textarea>
                        <p class="text-[11px] text-slate-400 mt-1">
                            Cantumkan informasi detail seperti spesifikasi teknis, komposisi/bahan, netto, izin edar, aturan pakai, atau petunjuk penyimpanan.
                        </p>
                    </div>

                    <!-- Spesifikasi Produk (Specs) -->
                    <div class="pt-4 border-t border-slate-100 space-y-4">
                        <div>
                            <h4 class="text-xs font-bold text-slate-800">Spesifikasi Produk (Specs)</h4>
                            <p class="text-[11px] text-slate-400 mt-0.5">Isi rincian spesifikasi produk untuk ditampilkan secara terstruktur pada katalog.</p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Berat Bersih (Netto)</label>
                                <input type="text" name="products[${index}][specs][netto]" placeholder="Contoh: 100 gr"
                                    class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kemasan (Packaging)</label>
                                <input type="text" name="products[${index}][specs][packaging]" placeholder="Contoh: Kertas Kraft Daur Ulang"
                                    class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Bentuk / Tekstur (Shape)</label>
                                <input type="text" name="products[${index}][specs][shape]" placeholder="Contoh: Batang Padat (Bunga, Hexagonal)"
                                    class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kecocokan Kulit / Penggunaan (Suitability)</label>
                                <input type="text" name="products[${index}][specs][suitability]" placeholder="Contoh: Semua Jenis Kulit & Balita"
                                    class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Status Stok (Stock)</label>
                                <input type="text" name="products[${index}][specs][stock]" placeholder="Contoh: Tersedia (Ready Stock)"
                                    class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Klaim / Sertifikasi (Certification)</label>
                                <input type="text" name="products[${index}][specs][certification]" placeholder="Contoh: 100% Organik & Biodegradable"
                                    class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Komposisi / Bahan (Ingredients)</label>
                            <textarea name="products[${index}][specs][ingredients]" rows="2" placeholder="Contoh: Minyak kelapa murni, fermentasi eco-enzyme buah..."
                                class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all leading-relaxed"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Cara Pemakaian (Usage)</label>
                            <textarea name="products[${index}][specs][usage]" rows="2" placeholder="Contoh: Busakan dengan air, usapkan lembut ke seluruh tubuh..."
                                class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all leading-relaxed"></textarea>
                        </div>
                    </div>

                    <!-- Gambar Utama Produk Upload -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Gambar Utama Produk <span class="text-[11px] font-normal text-slate-400">(Opsional)</span>
                        </label>
                        <div class="product-image-dropzone border-2 border-dashed border-gray-200 hover:border-emerald-400 rounded-xl p-4 text-center cursor-pointer transition-all bg-gray-50/50 hover:bg-emerald-50/30"
                             onclick="this.querySelector('.product-image-input').click()">
                            <input type="file"
                                   name="products[${index}][image]"
                                   accept="image/png,image/jpeg,image/jpg,image/webp"
                                   onchange="handleproductImagePreview(this)"
                                   class="product-image-input hidden">
                            <div class="product-preview-wrapper hidden mb-2">
                                <div class="w-full sm:max-w-xs mx-auto aspect-square bg-gray-50 rounded-lg border border-slate-200 shadow-2xs mb-2 flex items-center justify-center overflow-hidden">
                                    <img src="#" alt="Preview" class="product-preview-img max-w-full max-h-full object-contain">
                                </div>
                                <button type="button" onclick="event.stopPropagation(); removeproductselectedImage(this)" class="text-xs text-rose-600 hover:text-rose-800 font-semibold underline cursor-pointer">
                                    Hapus / Ganti Gambar
                                </button>
                            </div>
                            <div class="product-dropzone-content">
                                <svg class="w-8 h-8 text-slate-400 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-xs font-medium text-slate-700">Klik atau seret gambar utama untuk produk ini</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">Format: PNG, JPG, WEBP • Maks 2MB</p>
                                <p class="text-[10px] text-emerald-600 font-medium mt-1">✦ Rekomendasi ukuran: 1:1 (800×800 px)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Gambar Produk Upload (Maks. 5 Gambar) -->
                    <div class="pt-4 border-t border-slate-100">
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700">
                                    Detail Gambar Produk <span class="text-[11px] font-normal text-slate-400">(Maksimal 5 Gambar)</span>
                                </label>
                                <p class="text-[11px] text-slate-400 mt-0.5">
                                    Unggah foto detail, varian, atau rincian tambahan untuk produk ini.
                                </p>
                            </div>
                            <span class="product-detail-images-counter text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                                0 / 5 Gambar
                            </span>
                        </div>

                        <!-- Grid Preview Detail Images -->
                        <div class="product-detail-images-grid grid grid-cols-2 sm:grid-cols-5 gap-3 mb-3"></div>

                        <!-- File input for detail images -->
                        <input type="file"
                               name="products[${index}][detail_images][]"
                               multiple
                               accept="image/png,image/jpeg,image/jpg,image/webp"
                               onchange="handleDetailImagesSelected(this)"
                               class="product-detail-images-input hidden">

                        <!-- Add button trigger -->
                        <button type="button"
                                onclick="triggerDetailImageUpload(this)"
                                class="product-detail-images-add-trigger w-full py-2.5 px-3 border border-dashed border-gray-300 hover:border-emerald-500 rounded-xl bg-gray-50/60 hover:bg-emerald-50/40 text-slate-600 hover:text-emerald-700 text-xs font-semibold flex items-center justify-center gap-2 transition-all cursor-pointer">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Tambah Detail Gambar</span>
                        </button>
                    </div>
                </div>
            </div>
        `;

            container.insertAdjacentHTML('beforeend', productHtml);
            reindexproducts();

            // Scroll smoothly to newly added product
            const newproduct = container.lastElementChild;
            newproduct.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        function removeproductItem(btn) {
            const container = document.getElementById('products-container');
            const items = container.querySelectorAll('.product-item');
            if (items.length <= 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Minimal harus ada 1 produk di dalam katalog.',
                    confirmButtonColor: '#10b981',
                    confirmButtonText: 'Mengerti'
                });
                return;
            }

            const item = btn.closest('.product-item');
            const pIndex = item.getAttribute('data-index');
            delete productDetailFilesMap[pIndex];

            item.style.opacity = '0';
            item.style.transform = 'scale(0.95)';
            setTimeout(() => {
                item.remove();
                reindexproducts();
            }, 150);
        }

        // ─── Image Preview Handlers ──────────────────────────────────────────
        function handleproductImagePreview(input) {
            const file = input.files[0];
            if (!file) return;

            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran Foto Terlalu Besar',
                    text: 'Ukuran foto produk maksimal adalah 2 MB.',
                    confirmButtonColor: '#e11d48',
                    confirmButtonText: 'Tutup'
                });
                input.value = '';
                return;
            }

            const dropzone = input.closest('.product-image-dropzone');
            const previewWrapper = dropzone.querySelector('.product-preview-wrapper');
            const previewImg = dropzone.querySelector('.product-preview-img');
            const dropzoneContent = dropzone.querySelector('.product-dropzone-content');

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewWrapper.classList.remove('hidden');
                dropzoneContent.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }

        function removeproductselectedImage(btn) {
            const dropzone = btn.closest('.product-image-dropzone');
            const input = dropzone.querySelector('.product-image-input');
            const previewWrapper = dropzone.querySelector('.product-preview-wrapper');
            const previewImg = dropzone.querySelector('.product-preview-img');
            const dropzoneContent = dropzone.querySelector('.product-dropzone-content');

            input.value = '';
            previewImg.src = '#';
            previewWrapper.classList.add('hidden');
            dropzoneContent.classList.remove('hidden');
        }

        // ─── Detail Images Handlers ──────────────────────────────────────────
        const productDetailFilesMap = {};

        function triggerDetailImageUpload(btn) {
            const productItem = btn.closest('.product-item');
            const input = productItem.querySelector('.product-detail-images-input');
            if (input) {
                input.click();
            }
        }

        function handleDetailImagesSelected(input) {
            const productItem = input.closest('.product-item');
            const pIndex = productItem.getAttribute('data-index');

            if (!productDetailFilesMap[pIndex]) {
                productDetailFilesMap[pIndex] = [];
            }

            const existingCount = productItem.querySelectorAll('.product-detail-images-grid .existing-detail-image').length;
            const currentSelectedCount = productDetailFilesMap[pIndex].length;
            const remainingSlots = 5 - (existingCount + currentSelectedCount);

            if (remainingSlots <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Maksimal 5 Foto',
                    text: 'Setiap produk maksimal memiliki 5 foto rincian tambahan.',
                    confirmButtonColor: '#10b981',
                    confirmButtonText: 'Mengerti'
                });
                input.value = '';
                return;
            }

            const files = Array.from(input.files);
            let addedCount = 0;
            let invalidSize = false;
            let exceeded = false;

            for (let file of files) {
                if (file.size > 2 * 1024 * 1024) {
                    invalidSize = true;
                    continue;
                }

                if (existingCount + productDetailFilesMap[pIndex].length >= 5) {
                    exceeded = true;
                    break;
                }

                productDetailFilesMap[pIndex].push(file);
                addedCount++;
            }

            if (invalidSize) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran Foto Terlalu Besar',
                    text: 'Beberapa foto melebihi ukuran maksimal 2 MB dan tidak dapat ditambahkan.',
                    confirmButtonColor: '#e11d48',
                    confirmButtonText: 'Tutup'
                });
            }

            if (exceeded) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Batas Maksimal',
                    text: 'Maksimal 5 detail gambar tercapai. Sisa gambar diabaikan.',
                    confirmButtonColor: '#10b981'
                });
            }

            syncProductDetailInput(productItem, pIndex);
            renderDetailImagesGrid(productItem, pIndex);
            input.value = '';
        }

        function syncProductDetailInput(productItem, pIndex) {
            const input = productItem.querySelector('.product-detail-images-input');
            const files = productDetailFilesMap[pIndex] || [];
            const dt = new DataTransfer();
            files.forEach(f => dt.items.add(f));
            input.files = dt.files;
        }

        function renderDetailImagesGrid(productItem, pIndex) {
            const grid = productItem.querySelector('.product-detail-images-grid');
            const newPreviews = grid.querySelectorAll('.new-detail-image-preview');
            newPreviews.forEach(el => el.remove());

            const files = productDetailFilesMap[pIndex] || [];
            const existingCount = grid.querySelectorAll('.existing-detail-image').length;

            files.forEach((file, fIdx) => {
                const itemDiv = document.createElement('div');
                itemDiv.className = 'new-detail-image-preview relative group aspect-square rounded-xl border border-slate-200 bg-slate-50 overflow-hidden shadow-2xs flex items-center justify-center';
                itemDiv.setAttribute('data-fidx', fIdx);

                const img = document.createElement('img');
                img.className = 'w-full h-full object-cover';
                img.src = URL.createObjectURL(file);

                const overlay = document.createElement('div');
                overlay.className = 'absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-1.5';

                const delBtn = document.createElement('button');
                delBtn.type = 'button';
                delBtn.className = 'p-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-lg shadow-sm transition-transform transform hover:scale-110 cursor-pointer';
                delBtn.title = 'Hapus Foto';
                delBtn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>`;
                delBtn.onclick = function(e) {
                    e.stopPropagation();
                    removeNewDetailImage(productItem, pIndex, fIdx);
                };

                const badge = document.createElement('span');
                badge.className = 'absolute top-1 left-1 px-1.5 py-0.5 rounded text-[9px] font-bold bg-black/60 text-white backdrop-blur-xs';
                badge.innerText = 'Foto ' + (existingCount + fIdx + 1);

                overlay.appendChild(delBtn);
                itemDiv.appendChild(img);
                itemDiv.appendChild(overlay);
                itemDiv.appendChild(badge);
                grid.appendChild(itemDiv);
            });

            updateDetailImagesCounter(productItem, pIndex);
        }

        function removeNewDetailImage(productItem, pIndex, fIdx) {
            if (productDetailFilesMap[pIndex]) {
                productDetailFilesMap[pIndex].splice(fIdx, 1);
                syncProductDetailInput(productItem, pIndex);
                renderDetailImagesGrid(productItem, pIndex);
            }
        }

        function updateDetailImagesCounter(productItem, pIndex) {
            const existingCount = productItem.querySelectorAll('.product-detail-images-grid .existing-detail-image').length;
            const newCount = (productDetailFilesMap[pIndex] || []).length;
            const total = existingCount + newCount;

            const counter = productItem.querySelector('.product-detail-images-counter');
            if (counter) {
                counter.innerText = total + ' / 5 Gambar';
                if (total >= 5) {
                    counter.className = 'product-detail-images-counter text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200';
                } else {
                    counter.className = 'product-detail-images-counter text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200';
                }
            }

            const trigger = productItem.querySelector('.product-detail-images-add-trigger');
            if (trigger) {
                if (total >= 5) {
                    trigger.classList.add('hidden');
                } else {
                    trigger.classList.remove('hidden');
                }
            }
        }
    </script>
@endpush
