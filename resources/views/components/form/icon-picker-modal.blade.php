{{-- Reusable Lucide Icon Picker Modal --}}
<div id="icon-picker-modal" class="fixed inset-0 z-[9999] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeIconPicker()"></div>

    <!-- Modal Content -->
    <div class="fixed inset-0 flex items-center justify-center p-3 sm:p-4 pointer-events-none">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-200/80 w-full max-w-2xl max-h-[85vh] flex flex-col pointer-events-auto transform transition-all overflow-hidden">
            <!-- Modal Header -->
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between shrink-0 bg-white">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900" id="modal-title">Pilih Icon Lucide</h3>
                        <p class="text-[11px] text-slate-500" id="icon-counter">Memuat koleksi 1.800+ icon...</p>
                    </div>
                </div>
                <button type="button" onclick="closeIconPicker()" class="p-1.5 text-slate-400 hover:text-slate-700 hover:bg-gray-100 rounded-lg transition-colors cursor-pointer" title="Tutup (Esc)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Search Bar -->
            <div class="px-5 py-3 border-b border-gray-100 shrink-0 bg-slate-50/50">
                <div class="relative">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="icon-search-input" placeholder="Cari icon... (contoh: heart, user, arrow, coffee, book, check)" oninput="debouncedFilterIcons(this.value)"
                        class="w-full pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-600 transition-all shadow-2xs">
                </div>
            </div>

            <!-- Category Tabs -->
            <div class="px-5 py-2 border-b border-gray-100 shrink-0 overflow-x-auto bg-white" id="icon-category-tabs">
                <div class="flex gap-1.5 min-w-max pb-0.5">
                    <button type="button" onclick="filterByCategory('all')" data-cat="all"
                        class="icon-cat-btn active px-3 py-1.5 text-[11px] font-medium rounded-lg transition-all bg-emerald-100 text-emerald-700">
                        Semua (1.800+)
                    </button>
                    <button type="button" onclick="filterByCategory('popular')" data-cat="popular"
                        class="icon-cat-btn px-3 py-1.5 text-[11px] font-medium rounded-lg transition-all bg-gray-100 text-slate-500 hover:bg-gray-200">
                        ⭐ Populer
                    </button>
                    <button type="button" onclick="filterByCategory('arrows')" data-cat="arrows"
                        class="icon-cat-btn px-3 py-1.5 text-[11px] font-medium rounded-lg transition-all bg-gray-100 text-slate-500 hover:bg-gray-200">
                        ↗ Panah
                    </button>
                    <button type="button" onclick="filterByCategory('communication')" data-cat="communication"
                        class="icon-cat-btn px-3 py-1.5 text-[11px] font-medium rounded-lg transition-all bg-gray-100 text-slate-500 hover:bg-gray-200">
                        💬 Komunikasi
                    </button>
                    <button type="button" onclick="filterByCategory('media')" data-cat="media"
                        class="icon-cat-btn px-3 py-1.5 text-[11px] font-medium rounded-lg transition-all bg-gray-100 text-slate-500 hover:bg-gray-200">
                        🎵 Media & Foto
                    </button>
                    <button type="button" onclick="filterByCategory('devices')" data-cat="devices"
                        class="icon-cat-btn px-3 py-1.5 text-[11px] font-medium rounded-lg transition-all bg-gray-100 text-slate-500 hover:bg-gray-200">
                        💻 Perangkat
                    </button>
                    <button type="button" onclick="filterByCategory('files')" data-cat="files"
                        class="icon-cat-btn px-3 py-1.5 text-[11px] font-medium rounded-lg transition-all bg-gray-100 text-slate-500 hover:bg-gray-200">
                        📁 Berkas & Dokumen
                    </button>
                    <button type="button" onclick="filterByCategory('commerce')" data-cat="commerce"
                        class="icon-cat-btn px-3 py-1.5 text-[11px] font-medium rounded-lg transition-all bg-gray-100 text-slate-500 hover:bg-gray-200">
                        🛒 Belanja & Finansial
                    </button>
                    <button type="button" onclick="filterByCategory('nature')" data-cat="nature"
                        class="icon-cat-btn px-3 py-1.5 text-[11px] font-medium rounded-lg transition-all bg-gray-100 text-slate-500 hover:bg-gray-200">
                        🌿 Alam & Hewan
                    </button>
                    <button type="button" onclick="filterByCategory('weather')" data-cat="weather"
                        class="icon-cat-btn px-3 py-1.5 text-[11px] font-medium rounded-lg transition-all bg-gray-100 text-slate-500 hover:bg-gray-200">
                        🌤 Cuaca
                    </button>
                    <button type="button" onclick="filterByCategory('food')" data-cat="food"
                        class="icon-cat-btn px-3 py-1.5 text-[11px] font-medium rounded-lg transition-all bg-gray-100 text-slate-500 hover:bg-gray-200">
                        🍕 Makanan
                    </button>
                    <button type="button" onclick="filterByCategory('health')" data-cat="health"
                        class="icon-cat-btn px-3 py-1.5 text-[11px] font-medium rounded-lg transition-all bg-gray-100 text-slate-500 hover:bg-gray-200">
                        🏥 Kesehatan
                    </button>
                    <button type="button" onclick="filterByCategory('transport')" data-cat="transport"
                        class="icon-cat-btn px-3 py-1.5 text-[11px] font-medium rounded-lg transition-all bg-gray-100 text-slate-500 hover:bg-gray-200">
                        🚗 Transportasi
                    </button>
                    <button type="button" onclick="filterByCategory('buildings')" data-cat="buildings"
                        class="icon-cat-btn px-3 py-1.5 text-[11px] font-medium rounded-lg transition-all bg-gray-100 text-slate-500 hover:bg-gray-200">
                        🏢 Bangunan
                    </button>
                    <button type="button" onclick="filterByCategory('charts')" data-cat="charts"
                        class="icon-cat-btn px-3 py-1.5 text-[11px] font-medium rounded-lg transition-all bg-gray-100 text-slate-500 hover:bg-gray-200">
                        📊 Statistik
                    </button>
                    <button type="button" onclick="filterByCategory('shapes')" data-cat="shapes"
                        class="icon-cat-btn px-3 py-1.5 text-[11px] font-medium rounded-lg transition-all bg-gray-100 text-slate-500 hover:bg-gray-200">
                        🔷 Bentuk
                    </button>
                    <button type="button" onclick="filterByCategory('dev')" data-cat="dev"
                        class="icon-cat-btn px-3 py-1.5 text-[11px] font-medium rounded-lg transition-all bg-gray-100 text-slate-500 hover:bg-gray-200">
                        ⚙️ Dev & Sistem
                    </button>
                </div>
            </div>

            <!-- Icon Grid Container -->
            <div class="flex-1 overflow-y-auto p-4 sm:p-5 bg-slate-50/30" id="icon-grid-container">
                <div id="icon-grid" class="grid grid-cols-6 sm:grid-cols-8 md:grid-cols-9 gap-1.5 sm:gap-2">
                    {{-- Virtual batch populated via JavaScript --}}
                </div>

                <!-- Sentinel for Infinite Virtual Scroll -->
                <div id="icon-scroll-sentinel" class="h-6 flex items-center justify-center"></div>

                <!-- No Results State -->
                <div id="icon-no-results" class="hidden text-center py-12">
                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <p class="text-xs font-semibold text-slate-700">Tidak ada icon yang cocok</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">Coba kata kunci lain atau pilih tab kategori di atas.</p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-5 py-2.5 border-t border-gray-100 bg-white flex items-center justify-between shrink-0 text-[11px] text-slate-400">
                <span>Tekan <kbd class="px-1.5 py-0.5 bg-gray-100 border border-gray-200 rounded text-[10px] font-mono text-slate-600">Esc</kbd> untuk menutup</span>
                <span class="text-emerald-700 font-medium">1.800+ Lucide Icons v1.0+</span>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    #icon-grid svg {
        width: 1.25rem;
        height: 1.25rem;
        stroke-width: 2;
    }
    .icon-picker-preview svg {
        width: 1rem;
        height: 1rem;
        stroke-width: 2;
    }
</style>
@endpush

@push('scripts')
    <script src="{{ asset('js/lucide.min.js') }}"></script>
    <script src="{{ asset('js/lucide-picker.js') }}"></script>
@endpush
