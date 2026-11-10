<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

/**
 * OpenAPI Schema definitions for all API resources.
 * Schemas are defined here to keep controllers clean.
 */

// ─── Home Section ────────────────────────────────────────────────────────────
/*
#[OA\Schema(
    schema: 'HomeSection',
    title: 'Home Section',
    description: 'Konten section hero / banner pada landing page',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'title', type: 'string', example: 'Selamat Datang di Program Pengabdian Dosen'),
        new OA\Property(property: 'description', type: 'string', example: '<p>Deskripsi program pengabdian...</p>'),
        new OA\Property(property: 'image_url', type: 'string', format: 'url', nullable: true, example: 'http://localhost:8000/storage/home-sections/hero.jpg'),
        new OA\Property(
            property: 'buttons',
            type: 'object',
            properties: [
                new OA\Property(
                    property: 'button_one',
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'text', type: 'string', nullable: true, example: 'Lihat Produk'),
                        new OA\Property(property: 'link', type: 'string', nullable: true, example: '#products'),
                    ]
                ),
                new OA\Property(
                    property: 'button_two',
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'text', type: 'string', nullable: true, example: 'Hubungi Kami'),
                        new OA\Property(property: 'link', type: 'string', nullable: true, example: '#contact'),
                    ]
                ),
            ]
        ),
        new OA\Property(property: 'is_active', type: 'boolean', example: true),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-01-15T08:30:00+07:00'),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-01-15T08:30:00+07:00'),
    ]
)]
*/

// ─── About Section ───────────────────────────────────────────────────────────
/*
#[OA\Schema(
    schema: 'AboutSection',
    title: 'About Section',
    description: 'Konten section tentang program pada landing page',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'title', type: 'string', example: 'Tentang Program Pengabdian'),
        new OA\Property(property: 'description', type: 'string', example: '<p>Deskripsi tentang program...</p>'),
        new OA\Property(property: 'image_url', type: 'string', format: 'url', nullable: true, example: 'http://localhost:8000/storage/about-sections/about.jpg'),
        new OA\Property(
            property: 'cards',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/AboutCard')
        ),
        new OA\Property(
            property: 'points',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/AboutPoint')
        ),
        new OA\Property(property: 'is_active', type: 'boolean', example: true),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
    ]
)]

#[OA\Schema(
    schema: 'AboutCard',
    title: 'About Card',
    description: 'Kartu fitur/keunggulan pada about section',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'title', type: 'string', example: 'Pemberdayaan Masyarakat'),
        new OA\Property(property: 'description', type: 'string', example: 'Membantu masyarakat mengembangkan potensi...'),
        new OA\Property(property: 'icon_name', type: 'string', nullable: true, example: 'users'),
        new OA\Property(property: 'icon_image', type: 'string', nullable: true, example: 'about-cards/icon.png'),
        new OA\Property(property: 'icon_image_url', type: 'string', format: 'url', nullable: true),
        new OA\Property(property: 'steps', type: 'array', nullable: true, items: new OA\Items(type: 'string')),
    ]
)]

#[OA\Schema(
    schema: 'AboutPoint',
    title: 'About Point',
    description: 'Poin statistik / pencapaian pada about section',
    properties: [
        new OA\Property(property: 'number', type: 'string', nullable: true, example: '500+'),
        new OA\Property(property: 'title', type: 'string', nullable: true, example: 'Masyarakat Terbantu'),
        new OA\Property(property: 'description', type: 'string', nullable: true, example: 'Telah membantu lebih dari 500 masyarakat'),
    ]
)]
*/

// ─── Product Section ─────────────────────────────────────────────────────────

#[OA\Schema(
    schema: 'ProductSection',
    title: 'Product Section',
    description: 'Konten section produk / katalog pada landing page',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'title', type: 'string', example: 'Produk Unggulan Kami'),
        new OA\Property(property: 'description', type: 'string', example: '<p>Berikut produk-produk hasil program...</p>'),
        new OA\Property(property: 'whatsapp_number', type: 'string', nullable: true, example: '6281234567890'),
        new OA\Property(property: 'is_active', type: 'boolean', example: true),
        new OA\Property(
            property: 'products',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/Product')
        ),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
    ]
)]

#[OA\Schema(
    schema: 'Product',
    title: 'Product',
    description: 'Detail produk individual',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'Sabun Batang'),
        new OA\Property(property: 'detail', type: 'string', nullable: true, example: 'Lembut di kulit, wangi alami dari enzim buah.'),
        new OA\Property(property: 'price', type: 'string', nullable: true, example: 'Rp 11.000'),
        new OA\Property(property: 'order', type: 'integer', example: 1),
        new OA\Property(
            property: 'images',
            type: 'array',
            items: new OA\Items(type: 'string', format: 'url'),
            example: [
                'https://sanitasihijau.com/storage/product-images/sabun-batang-1.webp',
                'https://sanitasihijau.com/storage/product-detail-images/sabun-batang-2.webp',
            ]
        ),
        new OA\Property(property: 'is_active', type: 'boolean', example: true),
    ]
)]

#[OA\Schema(
    schema: 'ProductDetailImage',
    title: 'Product Detail Image',
    description: 'Detail gambar / galeri foto produk (maksimal 5 foto per produk)',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'product_id', type: 'integer', example: 1),
        new OA\Property(property: 'image_url', type: 'string', format: 'url', example: 'http://localhost:8000/storage/product-detail-images/sabun-detail-1.jpg'),
        new OA\Property(property: 'order', type: 'integer', example: 1),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
    ]
)]

// ─── How To Order Section ────────────────────────────────────────────────────
/*
#[OA\Schema(
    schema: 'HowToOrderSection',
    title: 'How To Order Section',
    description: 'Konten section cara pemesanan pada landing page',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'title', type: 'string', example: 'Cara Memesan'),
        new OA\Property(property: 'description', type: 'string', nullable: true, example: 'Ikuti langkah berikut untuk memesan produk'),
        new OA\Property(property: 'button_text', type: 'string', nullable: true, example: 'Pesan Sekarang'),
        new OA\Property(property: 'button_link', type: 'string', nullable: true, example: 'https://wa.me/6281234567890'),
        new OA\Property(property: 'is_active', type: 'boolean', example: true),
        new OA\Property(
            property: 'steps',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/HowToOrderStep')
        ),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
    ]
)]

#[OA\Schema(
    schema: 'HowToOrderStep',
    title: 'How To Order Step',
    description: 'Langkah-langkah dalam cara pemesanan',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'how_to_order_section_id', type: 'integer', example: 1),
        new OA\Property(property: 'title', type: 'string', example: 'Pilih Produk'),
        new OA\Property(property: 'description', type: 'string', nullable: true, example: 'Pilih produk yang ingin Anda pesan dari katalog'),
        new OA\Property(property: 'icon_name', type: 'string', nullable: true, example: 'shopping-cart'),
        new OA\Property(property: 'icon_image', type: 'string', nullable: true),
        new OA\Property(property: 'icon_image_url', type: 'string', format: 'url', nullable: true),
        new OA\Property(property: 'step_order', type: 'integer', example: 1),
    ]
)]
*/

// ─── Testimonial Section ─────────────────────────────────────────────────────

#[OA\Schema(
    schema: 'TestimonialSection',
    title: 'Testimonial Section',
    description: 'Konten section testimoni pada landing page',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'title', type: 'string', example: 'Apa Kata Mereka?'),
        new OA\Property(property: 'is_active', type: 'boolean', example: true),
        new OA\Property(
            property: 'statistics',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/Statistic')
        ),
        new OA\Property(
            property: 'testimonials',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/Testimonial')
        ),
    ]
)]

#[OA\Schema(
    schema: 'Statistic',
    title: 'Statistic',
    description: 'Data statistik pada section testimoni',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'value', type: 'string', example: '500+'),
        new OA\Property(property: 'description', type: 'string', example: 'Pelanggan Puas'),
    ]
)]

#[OA\Schema(
    schema: 'Testimonial',
    title: 'Testimonial',
    description: 'Data testimoni pelanggan',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'quote', type: 'string', example: 'Produknya sangat berkualitas dan ramah lingkungan!'),
        new OA\Property(property: 'name', type: 'string', example: 'Budi Santoso'),
        new OA\Property(property: 'location', type: 'string', nullable: true, example: 'Surabaya, Jawa Timur'),
    ]
)]

// ─── Contact Section ─────────────────────────────────────────────────────────

#[OA\Schema(
    schema: 'ContactSection',
    title: 'Contact Section',
    description: 'Konten section kontak pada landing page',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'title', type: 'string', example: 'Hubungi Kami'),
        new OA\Property(property: 'description', type: 'string', nullable: true, example: 'Jangan ragu untuk menghubungi kami'),
        new OA\Property(property: 'is_active', type: 'boolean', example: true),
        new OA\Property(property: 'location', type: 'string', nullable: true, example: 'Jl. Contoh No. 123, Surabaya'),
        new OA\Property(property: 'email', type: 'string', nullable: true, example: 'info@pengabdiandosen.id'),
        new OA\Property(property: 'whatsapp', type: 'string', nullable: true, example: '6281234567890'),
        new OA\Property(
            property: 'items',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/ContactItem')
        ),
        new OA\Property(
            property: 'contacts',
            type: 'array',
            description: 'Alias dari items (data yang sama)',
            items: new OA\Items(ref: '#/components/schemas/ContactItem')
        ),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
    ]
)]

#[OA\Schema(
    schema: 'ContactItem',
    title: 'Contact Item',
    description: 'Item kontak individu (alamat, email, telepon, dll)',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'type', type: 'string', example: 'whatsapp'),
        new OA\Property(property: 'label', type: 'string', example: 'WhatsApp Kami'),
        new OA\Property(property: 'value', type: 'string', example: '6281234567890'),
        new OA\Property(property: 'icon_name', type: 'string', nullable: true, example: 'phone'),
        new OA\Property(property: 'icon_image', type: 'string', nullable: true),
        new OA\Property(property: 'icon_image_url', type: 'string', format: 'url', nullable: true),
        new OA\Property(property: 'order', type: 'integer', example: 1),
    ]
)]
class ApiSchemas
{
    // This class is used only to host OpenAPI schema definitions via PHP 8 Attributes.
    // No logic is needed here.
}
