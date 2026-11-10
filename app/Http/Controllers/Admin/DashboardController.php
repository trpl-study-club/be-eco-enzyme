<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use App\Models\AboutSectionCard;
use App\Models\ContactItem;
use App\Models\ContactSection;
use App\Models\HomeSection;
use App\Models\HowToOrderSection;
use App\Models\HowToOrderStep;
use App\Models\Product;
use App\Models\ProductSection;
use App\Models\TestimonialItem;
use App\Models\TestimonialSection;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard overview.
     */
    public function index(): View
    {
        // Beranda (Home)
        $totalHome = HomeSection::count();
        $activeHome = HomeSection::where('is_active', true)->count();
        $recentHome = HomeSection::latest('updated_at')->take(3)->get();

        // Tentang Kami (About)
        $totalAbout = AboutSection::count();
        $activeAbout = AboutSection::where('is_active', true)->count();
        $activeAboutSection = AboutSection::with('cards')->where('is_active', true)->first();
        if ($activeAboutSection) {
            $totalCards = $activeAboutSection->cards->count();
            if ($totalCards === 0 && is_array($activeAboutSection->points)) {
                $totalCards = count($activeAboutSection->points);
            }
        } else {
            $totalCards = AboutSectionCard::count();
        }
        $totalPoints = $totalCards;
        $recentAbout = AboutSection::latest('updated_at')->take(3)->get();

        // Produk (Products)
        $activeProductSection = ProductSection::where('is_active', true)->first();
        $totalProducts = Product::count();
        $recentProducts = Product::latest('updated_at')->take(4)->get();

        // Cara Pesan (How to Order)
        $activeHowToOrder = HowToOrderSection::where('is_active', true)->first();
        $totalSteps = HowToOrderStep::count();

        // Testimoni (Testimonials)
        $activeTestimonialSection = TestimonialSection::where('is_active', true)->first();
        $totalTestimonials = TestimonialItem::count();
        $recentTestimonials = TestimonialItem::latest('updated_at')->take(3)->get();

        // Kontak (Contact)
        $activeContactSection = ContactSection::with('items')->where('is_active', true)->first();
        $totalContactItems = ContactItem::count();

        // Pengguna (Users)
        $totalUsers = User::where('is_active', true)->count();

        // Status Kesiapan 6 Modul Landing Page
        $modulesStatus = [
            'home' => [
                'name' => 'Beranda',
                'description' => 'Banner utama dan heading hero',
                'is_ready' => $activeHome > 0,
                'count_label' => $activeHome > 0 ? '1 Banner Aktif' : 'Belum Ada Banner Aktif',
                'route' => 'admin.home-sections.index',
                'permission' => 'manage_home_sections',
            ],
            'about' => [
                'name' => 'Tentang Kami',
                'description' => 'Latar belakang & poin pilar program',
                'is_ready' => $activeAbout > 0,
                'count_label' => $activeAbout > 0 ? $totalPoints.' Poin Pilar' : 'Belum Ada Konten Aktif',
                'route' => 'admin.about-sections.index',
                'permission' => 'manage_about_sections',
            ],
            'product' => [
                'name' => 'Produk',
                'description' => 'Katalog produk & rincian harga',
                'is_ready' => $activeProductSection !== null && $totalProducts > 0,
                'count_label' => $totalProducts > 0 ? $totalProducts.' Produk Terdaftar' : 'Belum Ada Produk',
                'route' => 'admin.product-sections.index',
                'permission' => 'manage_product_sections',
            ],
            'how_to_order' => [
                'name' => 'Cara Pesan',
                'description' => 'Panduan alur pemesanan publik',
                'is_ready' => $activeHowToOrder !== null && $totalSteps > 0,
                'count_label' => $totalSteps > 0 ? $totalSteps.' Langkah Panduan' : 'Belum Ada Langkah',
                'route' => 'admin.how-to-orders.index',
                'permission' => 'manage_how_to_order',
            ],
            'testimonial' => [
                'name' => 'Testimoni',
                'description' => 'Ulasan kepuasan & testimoni warga',
                'is_ready' => $activeTestimonialSection !== null && $totalTestimonials > 0,
                'count_label' => $totalTestimonials > 0 ? $totalTestimonials.' Ulasan Terbit' : 'Belum Ada Ulasan',
                'route' => 'admin.testimonials.index',
                'permission' => 'manage_testimonials',
            ],
            'contact' => [
                'name' => 'Kontak',
                'description' => 'Saluran WhatsApp, email & lokasi',
                'is_ready' => $activeContactSection !== null && $totalContactItems > 0,
                'count_label' => $totalContactItems > 0 ? $totalContactItems.' Saluran Komunikasi' : 'Belum Ada Kontak',
                'route' => 'admin.contact-sections.index',
                'permission' => 'manage_contact_sections',
            ],
        ];

        $liveModulesCount = collect($modulesStatus)->where('is_ready', true)->count();

        // Waktu Pembaruan Terakhir
        $lastUpdateTimes = array_filter([
            HomeSection::max('updated_at'),
            AboutSection::max('updated_at'),
            AboutSectionCard::max('updated_at'),
            ProductSection::max('updated_at'),
            Product::max('updated_at'),
            HowToOrderSection::max('updated_at'),
            TestimonialSection::max('updated_at'),
            ContactSection::max('updated_at'),
        ]);

        $lastUpdated = ! empty($lastUpdateTimes) ? max($lastUpdateTimes) : null;

        return view('admin.dashboard', compact(
            'totalHome',
            'activeHome',
            'totalAbout',
            'activeAbout',
            'totalPoints',
            'totalCards',
            'recentHome',
            'recentAbout',
            'totalProducts',
            'recentProducts',
            'totalSteps',
            'totalTestimonials',
            'recentTestimonials',
            'totalContactItems',
            'activeContactSection',
            'totalUsers',
            'modulesStatus',
            'liveModulesCount',
            'lastUpdated'
        ));
    }
}
