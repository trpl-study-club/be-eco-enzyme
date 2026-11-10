<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'Pengabdian Dosen - Landing Page API',
    description: 'API publik untuk mengambil data konten landing page Program Pengabdian Dosen. Semua endpoint bersifat read-only (GET) dan tidak memerlukan autentikasi.',
    contact: new OA\Contact(
        name: 'Admin',
        email: 'admin@pengabdiandosen.id'
    )
)]
#[OA\Server(
    url: '/api/v1',
    description: 'API v1 Server'
)]
#[OA\Tag(name: 'Home Section', description: 'Endpoint untuk konten section home / hero landing page')]
#[OA\Tag(name: 'About Section', description: 'Endpoint untuk konten section tentang program')]
#[OA\Tag(name: 'Product Section', description: 'Endpoint untuk konten section produk / katalog')]
#[OA\Tag(name: 'How To Order', description: 'Endpoint untuk konten section cara pemesanan')]
#[OA\Tag(name: 'Testimonial', description: 'Endpoint untuk konten section testimoni')]
#[OA\Tag(name: 'Contact', description: 'Endpoint untuk konten section kontak')]
abstract class Controller
{
    //
}
