# 🎓 Pengabdian Dosen — Landing Page CMS & RESTful API Backend

> Sistem backend **Content Management System (CMS)** dan **RESTful API** untuk landing page, dibangun sebagai bagian dari program **Pengabdian Kepada Masyarakat Dosen** di **Desa Jeruklegi**. Aplikasi ini menyediakan Admin Portal berbasis web modern untuk mengelola seluruh konten landing page secara terpusat, serta RESTful API publik berkinerja tinggi yang siap dikonsumsi oleh frontend (Web / Mobile App).

---

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [Arsitektur Sistem](#-arsitektur-sistem)
- [Prasyarat](#-prasyarat)
- [Instalasi & Setup](#-instalasi--setup)
- [Akun Default](#-akun-default-seeder)
- [Menjalankan Aplikasi](#-menjalankan-aplikasi)
- [Dokumentasi Lengkap API (v1)](#-dokumentasi-lengkap-api-v1)
  - [Spesifikasi Umum](#spesifikasi-umum)
  - [Daftar Endpoint](#daftar-endpoint-api)
  - [1. Beranda (Home / Hero Section)](#1-beranda-home--hero-section)
  - [2. Tentang Kami (About Section)](#2-tentang-kami-about-section)
  - [3. Katalog Produk (Product Section)](#3-katalog-produk-product-section)
  - [4. Cara Pemesanan (How to Order)](#4-cara-pemesanan-how-to-order)
  - [5. Testimoni & Statistik (Testimonials)](#5-testimoni--statistik-testimonials)
  - [6. Kontak & Lokasi (Contact Section)](#6-kontak--lokasi-contact-section)
  - [Status Code & Error Handling](#status-code--error-handling)
  - [Contoh Integrasi Frontend](#contoh-integrasi-frontend-javascript--typescript)
- [Admin Portal & Role Permission](#-admin-portal--role-permission)
- [Pengujian & Standar Kode](#-pengujian--standar-kode)
- [Lisensi](#-lisensi)

---

## ✨ Fitur Utama

### 🛠️ Admin Portal (Web CMS)
- **Executive Dashboard** — KPI cards, status kesiapan seluruh 6 modul publik, aktivitas pembaruan terakhir, dan ringkasan katalog.
- **Manajemen Beranda (Home Section)** — Pengaturan hero headline, sub-headline, gambar ilustrasi banner, dan 2 tombol CTA kustom.
- **Manajemen Tentang Kami (About Section)** — Profil inisiatif, kartu pilar informasi dinamis (dengan ikon dan langkah), serta daftar poin keunggulan.
- **Manajemen Produk (Product Section)** — Pengaturan katalog produk UMKM, harga, deskripsi, manfaat (*benefit*), gambar produk, dan direct CTA nomor WhatsApp pemesanan.
- **Manajemen Cara Pesan (How to Order)** — Panduan tahapan pemesanan step-by-step terurut dengan ikon grafis dan tombol aksi.
- **Manajemen Testimoni & Statistik** — Hub manajemen testimoni pelanggan, kutipan ulasan, asal pelanggan, serta metrik statistik pencapaian.
- **Manajemen Kontak (Contact Section)** — Pengaturan alamat kantor/lokasi, email resmi, WhatsApp, peta/koordinat, serta kanal media sosial kustom.
- **Role-Based Access Control (RBAC)** — Integrasi Spatie Permission dengan pembagian hak akses **Super Admin** dan **Admin Modul**.
- **Manajemen Pengguna (User Management)** — Super Admin dapat menambah admin baru, menetapkan permission spesifik per modul, me-reset password, dan toggle status aktif akun.
- **Profil & Keamanan Akun** — Setiap admin dapat memperbarui nama, email, dan password secara mandiri.
- **Toggle Publikasi Instan** — Menampilkan atau menyembunyikan modul landing page secara instan via sakelar toggle tanpa menghapus data.

### 🔌 RESTful API (v1)
- **Publik & Bebas Otentikasi** — Endpoint *read-only* yang dioptimasi untuk dikonsumsi langsung oleh client-side SPA (React, Vue, Next.js, Nuxt) maupun aplikasi mobile (Flutter, React Native).
- **Format Respons Standar** — Menggunakan Eloquent API Resource dengan struktur JSON konsisten (`data` wrapper).
- **Penyaringan Otomatis** — API secara ketat hanya menyajikan data yang berstatus aktif (`is_active = true`).
- **Asset URL Resolver** — URL gambar dan ikon di-generate otomatis secara absolut (`asset(Storage::url(...))`) agar langsung dapat dirender di frontend.

---

## 🧰 Tech Stack

| Kategori | Teknologi | Versi | Kegunaan |
| :--- | :--- | :--- | :--- |
| **Backend Core** | **PHP** | ^8.3 | Bahasa pemrograman utama |
| | **Laravel** | ^13.17 | Framework PHP full-stack & API |
| | **PostgreSQL** | 14+ | Database relasional utama |
| **Authorization** | **Spatie Laravel Permission** | ^8.3 | Role & Permission management (RBAC) |
| **Authentication** | **Laravel Sanctum / Session** | ^4.0 | Autentikasi sesi & token |
| **Frontend Admin**| **Blade Templates** | - | Server-rendered UI engine |
| | **Tailwind CSS** | ^4.0 | Utility-first CSS modern |
| | **Vite** | ^8.0 | Bundler & build tool frontend |
| **Testing & QA**  | **PHPUnit** | ^12.5 | Automated feature & unit testing |
| | **Laravel Pint** | ^1.27 | Code style enforcement (PSR-12) |
| | **Faker** | ^1.23 | Test dummy data generation |

---

## 🏗️ Arsitektur Sistem

```
┌─────────────────────────────────────────────────────────────┐
│                 Client Applications                         │
│       (Next.js / Nuxt / React / Vue / Flutter App)          │
└──────────────────────────────┬──────────────────────────────┘
                               │ HTTP GET (JSON)
                               ▼
┌─────────────────────────────────────────────────────────────┐
│                   RESTful API Engine (v1)                   │
│           Base URL: https://domain-anda.com/api/v1          │
│                                                             │
│   ├── /home          ├── /about          ├── /products      │
│   ├── /how-to-orders ├── /testimonials   └── /contact(s)    │
└──────────────────────────────┬──────────────────────────────┘
                               │
┌──────────────────────────────┴──────────────────────────────┐
│                    Laravel 13 Application                   │
│  ┌────────────────────────┐    ┌─────────────────────────┐  │
│  │   Eloquent Resources   │    │  API & Admin Controllers│  │
│  │  (Clean JSON Mapping)  │    │  (Role & Perm Checked)  │  │
│  └───────────┬────────────┘    └────────────┬────────────┘  │
│              │                              │               │
│  ┌───────────▼────────────┐    ┌────────────▼────────────┐  │
│  │      Eloquent ORM      │    │  Admin Portal UI        │  │
│  │ (Relationships/Casts)  │    │  (Tailwind 4 + Blade)   │  │
│  └───────────┬────────────┘    └─────────────────────────┘  │
└──────────────┼──────────────────────────────────────────────┘
               ▼
┌──────────────────────────────┐
│     PostgreSQL Database      │
└──────────────────────────────┘
```

---

## 📌 Prasyarat

Pastikan lingkungan server / komputer pengembangan Anda telah memiliki:
- **PHP** 8.3 atau lebih baru
- **Composer** 2.x
- **Node.js** 18.x atau lebih baru & **NPM**
- **PostgreSQL** 14+ (ekstensi PHP: `pdo_pgsql`, `pgsql`, `mbstring`, `curl`, `gd`, `zip`, `xml`)
- **Git**

---

## 🚀 Instalasi & Setup

### 1. Clone Repositori
```bash
git clone https://github.com/afiffaizin/be-landing-page.git
cd be-landing-page
```

### 2. Install Dependensi Backend (Composer)
```bash
composer install
```

### 3. Install Dependensi Frontend (NPM)
```bash
npm install
```

### 4. Konfigurasi Environment (`.env`)
Salin file template `.env.example` menjadi `.env`:
```bash
cp .env.example .env
php artisan key:generate
```

Sesuaikan kredensial database PostgreSQL pada file `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=pengabdian_dosen
DB_USERNAME=postgres
DB_PASSWORD=secret
```

> **Catatan:** Buat database terlebih dahulu di PostgreSQL:
> ```sql
> CREATE DATABASE pengabdian_dosen;
> ```

### 5. Jalankan Migrasi & Database Seeder
```bash
php artisan migrate --seed
```

Perintah di atas akan mengeksekusi migrasi tabel dan menjalankan seeder:
- Role & Permission Spatie (`super_admin` & `admin`).
- Akun default Super Admin.
- Data konten contoh untuk Beranda, Tentang Kami, dan Kontak.

### 6. Generate Storage Link
Buat symlink folder `storage/app/public` ke `public/storage` agar file upload (gambar banner, katalog produk, ikon) dapat diakses publik:
```bash
php artisan storage:link
```

### 7. Kompilasi Asset Frontend
```bash
# Untuk mode development (dengan Hot Module Replacement)
npm run dev

# ATAU build untuk production
npm run build
```

---

## 🔑 Akun Default (Seeder)

Setelah menjalankan `php artisan migrate --seed`, akun awal berikut siap digunakan untuk login ke Admin Portal:

| Role | Email | Password | Hak Akses |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `superadmin@admin.com` | `admin123` | Akses penuh seluruh modul & Manajemen Akun User |

---

## ▶️ Menjalankan Aplikasi

Jalankan server aplikasi Laravel di terminal:
```bash
php artisan serve
```

Aplikasi dapat diakses melalui:
- **Admin Portal**: [http://localhost:8000/login](http://localhost:8000/login) &rarr; dialihkan ke [http://localhost:8000/admin/dashboard](http://localhost:8000/admin/dashboard)
- **API Base URL**: [http://localhost:8000/api/v1](http://localhost:8000/api/v1)

---

## 🔌 Dokumentasi Lengkap API (v1)

### Spesifikasi Umum

- **Base URL:** `http://localhost:8000/api/v1` (atau `https://domain-anda.com/api/v1`)
- **Protokol:** HTTP/1.1 atau HTTP/2
- **Format:** `JSON`
- **Request Headers:**
  ```http
  Accept: application/json
  ```
- **Autentikasi:** **Tidak Diperlukan (Publik & Read-Only)**. Seluruh endpoint dapat diakses langsung oleh aplikasi client.
- **Logika Penyaringan:** Endpoint hanya mengembalikan data yang memiliki status **`is_active = true`**. Data yang dinonaktifkan dari admin tidak akan muncul di API.

---

### Daftar Endpoint API

| No | Modul | HTTP Method | Endpoint Path | Tipe Data Response |
| :---: | :--- | :---: | :--- | :--- |
| 1 | **Beranda** | `GET` | `/api/v1/home` | Array (Daftar Hero Section Aktif) |
| | | `GET` | `/api/v1/home/{id}` | Objek Tunggal (Detail Hero Section) |
| 2 | **Tentang Kami** | `GET` | `/api/v1/about` | Array (Daftar Section + Cards & Points) |
| | | `GET` | `/api/v1/about/{id}` | Objek Tunggal (Detail Section) |
| 3 | **Produk** | `GET` | `/api/v1/products` | Array (Section Produk + Item Katalog) |
| | | `GET` | `/api/v1/products/{id}` | Objek Tunggal (Detail Section Produk) |
| 4 | **Cara Pesan** | `GET` | `/api/v1/how-to-orders` | Objek Tunggal (Alur Langkah Pemesanan) |
| 5 | **Testimoni** | `GET` | `/api/v1/testimonials` | Objek Tunggal (Statistik + Ulasan Pelanggan) |
| 6 | **Kontak** | `GET` | `/api/v1/contact` *(alias: `/contacts`)* | Objek Tunggal (Informasi Kontak & Lokasi) |

---

### 1. Beranda (Home / Hero Section)

Mengambil data hero banner utama pada bagian atas landing page.

#### A. Daftar Hero Banner Aktif
```http
GET /api/v1/home
```

#### B. Detail Hero Banner
```http
GET /api/v1/home/{id}
```

#### Format JSON Response:
```json
{
  "data": [
    {
      "id": 1,
      "title": "Inovasi Eco-Enzyme Jeruklegi untuk Lingkungan & Kesehatan",
      "description": "Program pemberdayaan masyarakat dan pengelolaan limbah organik menjadi produk bermanfaat bernilai ekonomis tinggi.",
      "image_url": "http://localhost:8000/storage/home-sections/banner-utama.webp",
      "buttons": {
        "button_one": {
          "text": "Beli Produk Sekarang",
          "link": "https://wa.me/6288802457102?text=Halo%20saya%20tertarik%20produk%20Eco-Enzyme"
        },
        "button_two": {
          "text": "Pelajari Inisiatif Kami",
          "link": "#tentang-kami"
        }
      },
      "is_active": true,
      "created_at": "2026-09-20T08:00:00.000000Z",
      "updated_at": "2026-09-20T08:30:00.000000Z"
    }
  ]
}
```

#### Penjelasan Field:
| Field | Tipe | Deskripsi |
| :--- | :--- | :--- |
| `id` | Integer | ID unik hero section. |
| `title` | String | Judul headline utama banner. |
| `description` | String / HTML | Deskripsi / subheadline banner. |
| `image_url` | String (URL) / Null | URL absolut file ilustrasi banner. |
| `buttons.button_one.text` | String / Null | Teks label tombol CTA primer (contoh: "Pesan Sekarang"). |
| `buttons.button_one.link` | String (URL) / Null | Tautan target tombol primer (misal link WhatsApp). |
| `buttons.button_two.text` | String / Null | Teks label tombol CTA sekunder (contoh: "Pelajari Lebih Lanjut"). |
| `buttons.button_two.link` | String (URL) / Null | Tautan target tombol sekunder. |
| `is_active` | Boolean | Status publikasi (`true` = tampil). |

---

### 2. Tentang Kami (About Section)

Mengambil informasi profil program/organisasi, kartu pilar informasi, serta poin-poin keunggulan.

#### A. Daftar About Section Aktif
```http
GET /api/v1/about
```

#### B. Detail About Section
```http
GET /api/v1/about/{id}
```

#### Format JSON Response:
```json
{
  "data": [
    {
      "id": 1,
      "title": "Mengenal Program Eco-Enzyme Desa Jeruklegi",
      "description": "Kami mengedukasi warga dalam mengolah limbah kulit buah dan sayuran menjadi cairan serbaguna ramah lingkungan.",
      "image_url": "http://localhost:8000/storage/about-sections/about-hero.jpg",
      "cards": [
        {
          "id": 1,
          "title": "Ramah Lingkungan",
          "description": "Mengurangi beban timbunan sampah organik di tempat pembuangan akhir.",
          "icon_name": "sparkles",
          "icon_image": null,
          "icon_image_url": null,
          "steps": 1
        }
      ],
      "points": [
        {
          "number": "01",
          "title": "Bahan Alami 100%",
          "description": "Dibuat tanpa bahan kimia tambahan dan aman untuk pemakaian harian."
        },
        {
          "number": "02",
          "title": "Pemberdayaan Masyarakat",
          "description": "Melibatkan ibu-ibu PKK dan kelompok tani Desa Jeruklegi."
        }
      ],
      "is_active": true,
      "created_at": "2026-09-20T08:00:00+00:00",
      "updated_at": "2026-09-20T08:30:00+00:00"
    }
  ]
}
```

#### Penjelasan Field:
| Field | Tipe | Deskripsi |
| :--- | :--- | :--- |
| `cards` | Array of Objects | Kartu informasi / pilar pendukung. |
| `cards[].icon_name` | String / Null | Nama icon identifier (misal `sparkles`, `shield-check`, `leaf`). |
| `cards[].icon_image` | String / Null | Path penyimpanan file icon bila diunggah. |
| `cards[].icon_image_url` | String (URL) / Null | URL publik absolut icon custom bila diunggah. |
| `cards[].steps` | Integer | Nomor urutan tampilan card. |
| `points` | Array of Objects | Poin keunggulan bernomor urut (`number`, `title`, `description`). |

---

### 3. Katalog Produk (Product Section)

Mengambil informasi section produk beserta seluruh item katalog produk aktif di dalamnya.

#### A. Daftar Section Produk Aktif
```http
GET /api/v1/products
```

#### B. Detail Section Produk
```http
GET /api/v1/products/{id}
```

#### Format JSON Response:
```json
{
  "data": [
    {
      "id": 1,
      "title": "Produk Eco-Enzyme Asli Desa Jeruklegi",
      "description": "Pilihan produk olahan fermentasi alami untuk kebutuhan pembersih rumah tangga, pupuk tanaman, dan sanitasi.",
      "whatsapp_number": "6288802457102",
      "is_active": true,
      "products": [
        {
          "id": 1,
          "product_section_id": 1,
          "name": "Eco-Enzyme Multiguna 500ml",
          "description": "Cairan pembersih lantai, pencuci piring, dan penyegar udara alami.",
          "benefit": "Membunuh bakteri, menghilangkan bau amis, serta ramah untuk kulit sensitif.",
          "detail": "Komposisi: 100% fermentasi kulit buah & molase alami. Netto: 500ml. Petunjuk: Campurkan 1 tutup botol ke dalam 1 liter air.",
          "price": "25000",
          "image_url": "http://localhost:8000/storage/products/eco-500ml.webp",
          "order": 1,
          "created_at": "2026-09-20T08:00:00.000000Z",
          "updated_at": "2026-09-20T08:15:00.000000Z"
        },
        {
          "id": 2,
          "product_section_id": 1,
          "name": "Pupuk Cair Organik Fermentasi 1 Liter",
          "description": "Nutrisi alami tanaman untuk menyuburkan tanah dan mempercepat pertumbuhan tunas.",
          "benefit": "Memperbaiki mikroorganisme tanah dan meningkatkan hasil panen.",
          "detail": "Komposisi: Ekstrak fermentasi organik kaya unsur hara makro & mikro. Netto: 1 Liter. Cara Pakai: Semprotkan pada daun atau siramkan ke perakaran seminggu sekali.",
          "price": "45000",
          "image_url": "http://localhost:8000/storage/products/pupuk-1l.webp",
          "order": 2,
          "created_at": "2026-09-20T08:00:00.000000Z",
          "updated_at": "2026-09-20T08:15:00.000000Z"
        }
      ],
      "created_at": "2026-09-20T08:00:00.000000Z",
      "updated_at": "2026-09-20T08:30:00.000000Z"
    }
  ]
}
```

#### Penjelasan Field:
| Field | Tipe | Deskripsi |
| :--- | :--- | :--- |
| `whatsapp_number` | String | Nomor WhatsApp default pemesanan (format internasional: `628...`). |
| `products` | Array of Objects | Daftar varian produk yang terdaftar pada section ini. |
| `products[].price` | String / Decimal | Harga produk dalam Rupiah (contoh: `"25000"`). |
| `products[].benefit` | String / Null | Manfaat / keunggulan spesifik produk. |
| `products[].detail` | String / Null | Rincian detail produk (spesifikasi, komposisi, netto, aturan pakai, izin edar). |
| `products[].order` | Integer | Nomor urutan tampilan produk di frontend. |

---

### 4. Cara Pemesanan (How to Order)

Mengambil petunjuk dan tahapan alur pemesanan produk secara runtut.

```http
GET /api/v1/how-to-orders
```

#### Format JSON Response:
```json
{
  "data": {
    "id": 1,
    "title": "Cara Mudah Memesan Produk Kami",
    "description": "Ikuti 4 langkah sederhana berikut untuk memesan produk asli Desa Jeruklegi langsung melalui WhatsApp.",
    "button_text": "Mulai Pesan Sekarang",
    "button_link": "https://wa.me/6288802457102",
    "is_active": true,
    "steps": [
      {
        "id": 1,
        "how_to_order_section_id": 1,
        "title": "Pilih Produk",
        "description": "Tentukan produk dan ukuran kemasan yang Anda butuhkan pada katalog.",
        "icon_name": "shopping-bag",
        "icon_image": null,
        "icon_image_url": null,
        "step_order": 1
      },
      {
        "id": 2,
        "how_to_order_section_id": 1,
        "title": "Hubungi via WhatsApp",
        "description": "Klik tombol pesan untuk terhubung langsung dengan admin kami.",
        "icon_name": "message-circle",
        "icon_image": null,
        "icon_image_url": null,
        "step_order": 2
      },
      {
        "id": 3,
        "how_to_order_section_id": 1,
        "title": "Konfirmasi & Pembayaran",
        "description": "Kirimkan alamat pengiriman dan lakukan transfer pembayaran.",
        "icon_name": "credit-card",
        "icon_image": null,
        "icon_image_url": null,
        "step_order": 3
      },
      {
        "id": 4,
        "how_to_order_section_id": 1,
        "title": "Pengiriman Sampai ke Rumah",
        "description": "Pesanan dikemas rapi dan dikirim langsung ke tujuan Anda.",
        "icon_name": "truck",
        "icon_image": null,
        "icon_image_url": null,
        "step_order": 4
      }
    ],
    "created_at": "2026-09-20T08:00:00.000000Z",
    "updated_at": "2026-09-20T08:20:00.000000Z"
  }
}
```

> **Catatan:** Bila belum ada data Cara Pesan yang berstatus aktif, respons adalah:
> ```json
> { "data": null }
> ```

---

### 5. Testimoni & Statistik (Testimonials)

Mengambil ulasan kepuasan pelanggan serta angka metrik statistik pencapaian program.

```http
GET /api/v1/testimonials
```

#### Format JSON Response:
```json
{
  "data": {
    "id": 1,
    "title": "Apa Kata Mereka Tentang Eco-Enzyme Jeruklegi?",
    "statistics": [
      {
        "id": 1,
        "value": "1.200+ Liter",
        "description": "Cairan Eco-Enzyme Diproduksi"
      },
      {
        "id": 2,
        "value": "450+ KK",
        "description": "Warga Terlibat & Terlatih"
      },
      {
        "id": 3,
        "value": "98%",
        "description": "Tingkat Kepuasan Pengguna"
      }
    ],
    "testimonials": [
      {
        "id": 1,
        "quote": "Lantai dapur jadi kesat tanpa bau amis dan baunya sangat segar alami. Sangat puas dengan kualitasnya!",
        "name": "Ibu Siti Rahayu",
        "location": "Warga Jeruklegi Wetan"
      },
      {
        "id": 2,
        "quote": "Tanaman cabai dan tomat di pekarangan rumah tumbuh jauh lebih subur setelah rutin disemprot larutan eco-enzyme.",
        "name": "Pak Bambang S.",
        "location": "Kelompok Tani Makmur"
      }
    ]
  }
}
```

> **Catatan:** Bila belum ada data Testimoni yang berstatus aktif, respons adalah:
> ```json
> { "data": null }
> ```

---

### 6. Kontak & Lokasi (Contact Section)

Mengambil informasi alamat, email, WhatsApp, dan daftar kanal komunikasi kustom (media sosial, jam operasional, peta).

```http
GET /api/v1/contact
```
*(Tersedia pula endpoint sinonim: `GET /api/v1/contacts`)*

#### Format JSON Response:
```json
{
  "data": {
    "id": 1,
    "title": "Ada Pertanyaan? Kami Siap Membantu.",
    "description": "Ingin tahu lebih banyak tentang produk, pelatihan pembuatan, atau peluang kemitraan dengan Desa Jeruklegi?",
    "is_active": true,
    "location": "Balai Desa Jeruklegi, Kec. Jeruklegi, Cilacap, Jawa Tengah 53274",
    "email": "halo@ecoenzyme-jeruklegi.id",
    "whatsapp": "+62 888 0245 7102",
    "items": [
      {
        "id": 1,
        "type": "location",
        "label": "LOKASI KAMI",
        "value": "Balai Desa Jeruklegi, Kec. Jeruklegi, Cilacap, Jawa Tengah 53274",
        "icon_name": "map-pin",
        "icon_image": null,
        "icon_image_url": null,
        "order": 1
      },
      {
        "id": 2,
        "type": "email",
        "label": "EMAIL RESMI",
        "value": "halo@ecoenzyme-jeruklegi.id",
        "icon_name": "mail",
        "icon_image": null,
        "icon_image_url": null,
        "order": 2
      },
      {
        "id": 3,
        "type": "whatsapp",
        "label": "WHATSAPP KONSULTASI",
        "value": "+62 888 0245 7102",
        "icon_name": "phone",
        "icon_image": null,
        "icon_image_url": null,
        "order": 3
      },
      {
        "id": 4,
        "type": "custom",
        "label": "INSTAGRAM",
        "value": "@ecoenzyme_jeruklegi",
        "icon_name": "instagram",
        "icon_image": null,
        "icon_image_url": null,
        "order": 4
      }
    ],
    "contacts": [
      {
        "id": 1,
        "type": "location",
        "label": "LOKASI KAMI",
        "value": "Balai Desa Jeruklegi, Kec. Jeruklegi, Cilacap, Jawa Tengah 53274",
        "icon_name": "map-pin",
        "icon_image": null,
        "icon_image_url": null,
        "order": 1
      }
    ],
    "created_at": "2026-09-20T08:00:00.000000Z",
    "updated_at": "2026-09-20T08:30:00.000000Z"
  }
}
```

#### Keunggulan Struktur Kontak:
- **Shortcut Properties**: `location`, `email`, dan `whatsapp` otomatis diekstrak pada level teratas agar frontend dapat langsung merender info vital tanpa melakukan looping array.
- **Dynamic Items / Contacts**: Menyediakan seluruh item kontak termasuk channel custom (Instagram, Jam Layanan, dll) terurut berdasarkan field `order`.

---

### Status Code & Error Handling

| HTTP Code | Situasi | Penjelasan |
| :---: | :--- | :--- |
| **`200 OK`** | Permintaan Berhasil | Data ditemukan dan dikembalikan dalam format JSON. |
| **`404 Not Found`** | Data Tidak Ditemukan | Terjadi saat memanggil detail `{id}` yang tidak ada di database. |
| **`500 Internal Error`** | Kesalahan Server | Terjadi kendala internal pada server atau koneksi database. |

Bila data kosong / belum ada yang aktif pada endpoint singleton (`/how-to-orders`, `/testimonials`, `/contact`), API mengembalikan `200 OK` dengan payload:
```json
{
  "data": null
}
```

---

### Contoh Integrasi Frontend (JavaScript / TypeScript)

#### Menggunakan Native `fetch`:
```javascript
const API_BASE_URL = 'http://localhost:8000/api/v1';

async function loadLandingPageData() {
  try {
    const [homeRes, aboutRes, productsRes, howToOrderRes, testimonialRes, contactRes] = await Promise.all([
      fetch(`${API_BASE_URL}/home`),
      fetch(`${API_BASE_URL}/about`),
      fetch(`${API_BASE_URL}/products`),
      fetch(`${API_BASE_URL}/how-to-orders`),
      fetch(`${API_BASE_URL}/testimonials`),
      fetch(`${API_BASE_URL}/contact`)
    ]);

    const home = await homeRes.json();
    const about = await aboutRes.json();
    const products = await productsRes.json();
    const howToOrder = await howToOrderRes.json();
    const testimonials = await testimonialRes.json();
    const contact = await contactRes.json();

    console.log('Hero Banner:', home.data[0]);
    console.log('Katalog Produk:', products.data[0]?.products);
  } catch (error) {
    console.error('Gagal memuat data landing page:', error);
  }
}

loadLandingPageData();
```

#### Menggunakan `axios` (misal di React / Next.js / Vue):
```typescript
import axios from 'axios';

export const apiClient = axios.create({
  baseURL: process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8000/api/v1',
  headers: {
    Accept: 'application/json',
  },
});

export const getKatalogProduk = async () => {
  const response = await apiClient.get('/products');
  return response.data.data;
};
```

---

## 🛡️ Admin Portal & Role Permission

Sistem otorisasi dibangun menggunakan pustaka **Spatie Laravel Permission** dengan dua tingkatan peran (*role*):

### 1. Peran Pengguna (Roles)
- **Super Admin (`super_admin`)**:
  - Memiliki akses mutlak ke seluruh fitur sistem.
  - Mengelola akun pengguna (tambah admin, edit hak akses, reset password, suspend akun).
  - Mengelola seluruh 6 modul konten landing page.
- **Admin Modul (`admin`)**:
  - Hanya dapat mengakses modul konten yang secara eksplisit diberikan izinnya (*permissions*) oleh Super Admin.
  - Tidak memiliki akses ke menu **Manajemen Pengguna**.
  - Dapat memperbarui profil dan password sendiri.

### 2. Daftar Permissions Modul
| Permission Name | Modul Target | Menu Sidebar |
| :--- | :--- | :--- |
| `manage_home_sections` | Beranda (Hero Section) | `/admin/home-sections` |
| `manage_about_sections` | Tentang Kami | `/admin/about-sections` |
| `manage_product_sections` | Produk UMKM | `/admin/product-sections` |
| `manage_how_to_order` | Cara Pemesanan | `/admin/how-to-orders` |
| `manage_testimonials` | Testimoni & Statistik | `/admin/testimonials` |
| `manage_contact_sections` | Informasi Kontak | `/admin/contact-sections` |

---

## 🧪 Pengujian & Standar Kode

### 1. Menjalankan Automated Tests (PHPUnit)
Proyek ini dilengkapi dengan 85 skenario automated feature test dengan 330+ assertion yang mencakup otentikasi, proteksi hak akses Spatie, operasi CRUD admin, dan respon API publik:
```bash
# Menjalankan seluruh pengujian dalam format ringkas
php artisan test --compact

# Menjalankan pengujian spesifik
php artisan test --filter=ContactSectionTest
php artisan test --filter=RolePermissionTest
```

### 2. Standar Format Kode (Laravel Pint)
Proyek ini mematuhi standar PSR-12 dan konvensi Laravel. Jalankan Pint sebelum melakukan commit:
```bash
vendor/bin/pint
```

---

## 📄 Lisensi

Aplikasi ini bersifat *open-source* dan dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).

---

<p align="center">
  Dikembangkan dengan dedikasi untuk program <strong>Pengabdian Kepada Masyarakat Dosen</strong><br>
  Mendukung Transformasi Digital UMKM & Lingkungan <strong>Desa Jeruklegi</strong>
</p>
