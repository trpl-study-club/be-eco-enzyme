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
  - [1. Katalog Produk (`products`)](#1-katalog-produk-products)
  - [2. Testimoni & Statistik (`testimonials`)](#2-testimoni--statistik-testimonials)
  - [3. Kontak & Lokasi (`contact`)](#3-kontak--lokasi-contact)
  - [Status Code & Error Handling](#status-code--error-handling)
  - [Contoh Integrasi Frontend](#contoh-integrasi-frontend-javascript--typescript)
- [Admin Portal & Role Permission](#-admin-portal--role-permission)
- [Pengujian & Standar Kode](#-pengujian--standar-kode)
- [Lisensi](#-lisensi)

---

## ✨ Fitur Utama

### 🛠️ Admin Portal (Web CMS)
- **Executive Dashboard** — KPI cards, status kesiapan modul aktif, aktivitas pembaruan terakhir, dan ringkasan katalog.
- **Manajemen Katalog Produk** — Pengaturan item produk eco-enzyme, deskripsi/detail produk, harga (terformat Rupiah), urutan tampil, gambar utama + galeri detail, dan toggle status aktif per produk.
- **Manajemen Testimoni & Statistik** — Hub manajemen judul section, metrik statistik pencapaian, kutipan ulasan pelanggan, serta toggle publikasi header/statistik (ulasan pelanggan tetap tampil di API meski toggle header nonaktif).
- **Manajemen Kontak (Contact Hub)** — Pengaturan header kontak dan daftar kanal komunikasi (lokasi, email, WhatsApp, serta kanal kustom) lengkap dengan ikon Lucide/upload gambar dan toggle `is_active` per kartu kontak.
- **Role-Based Access Control (RBAC)** — Integrasi Spatie Permission dengan pembagian hak akses **Super Admin** dan **Admin Modul**.
- **Manajemen Pengguna (User Management)** — Super Admin dapat menambah admin baru, menetapkan permission spesifik per modul, me-reset password, dan toggle status aktif akun.
- **Profil & Keamanan Akun** — Setiap admin dapat memperbarui nama, email, dan password secara mandiri.
- **Toggle Publikasi Instan** — Menampilkan atau menyembunyikan modul/item landing page secara instan via sakelar toggle tanpa menghapus data.

> **Catatan Modul Nonaktif:** Rute modul `home`, `about`, dan `how-to-orders` saat ini dinonaktifkan sementara (*commented out*) di `routes/web.php` dan `routes/api.php`.

### 🔌 RESTful API (v1) & OpenAPI / Swagger
- **Publik & Bebas Otentikasi** — Endpoint *read-only* yang dioptimasi untuk dikonsumsi langsung oleh client-side SPA (React, Vue, Next.js, Nuxt) maupun aplikasi mobile (Flutter, React Native).
- **Dokumentasi Interaktif Swagger UI** — Tersedia di `/api/documentation` dengan spesifikasi OpenAPI JSON di `/docs` melalui paket `darkaonline/l5-swagger`.
- **Format Respons Standar** — Menggunakan Eloquent API Resource dengan struktur JSON bersih dan konsisten (`data` wrapper).
- **Penyaringan Otomatis** — API menyaring data berdasarkan status aktif (`is_active = true`), dengan pengecualian khusus pada `/api/v1/testimonials` di mana daftar ulasan pelanggan tetap dikembalikan walau toggle header & statistik dinonaktifkan.
- **Asset URL Resolver** — URL gambar produk dan ikon kontak di-generate otomatis secara absolut (`asset(Storage::url(...))`) agar langsung dapat dirender di frontend.

---

## 🧰 Tech Stack

| Kategori | Teknologi | Versi | Kegunaan |
| :--- | :--- | :--- | :--- |
| **Backend Core** | **PHP** | ^8.3 | Bahasa pemrograman utama |
| | **Laravel** | ^13.17 | Framework PHP full-stack & API |
| | **PostgreSQL** | 14+ | Database relasional utama |
| **API Docs** | **L5-Swagger** | ^11.1 | OpenAPI 3.0 & Swagger UI interaktif |
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
│             Base URL: http://localhost:8000/api/v1          │
│         Swagger UI: http://localhost:8000/api/documentation │
│                                                             │
│   ├── /products      ├── /testimonials   └── /contact(s)    │
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
- Akun default Super Admin (`superadmin@admin.com`).
- Data konten contoh untuk modul Kontak (`ContactSectionSeeder`).

### 6. Generate Storage Link
Buat symlink folder `storage/app/public` ke `public/storage` agar file upload (gambar produk, ikon kontak) dapat diakses publik:
```bash
php artisan storage:link
```

### 7. Kompilasi Asset Frontend & Generate Dokumentasi Swagger
```bash
# Untuk mode development (dengan Hot Module Replacement)
npm run dev

# ATAU build untuk production
npm run build

# Regenerate spesifikasi OpenAPI / Swagger JSON
php artisan l5-swagger:generate
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
- **Admin Portal**: http://localhost:8000/login &rarr; dialihkan ke http://localhost:8000/admin/dashboard
- **API Base URL**: http://localhost:8000/api/v1
- **Dokumentasi API (Swagger UI)**: http://localhost:8000/api/documentation
- **OpenAPI JSON Specification**: http://localhost:8000/docs

---

## 🔌 Dokumentasi Lengkap API (v1)

### Spesifikasi Umum

- **Base URL:** `http://localhost:8000/api/v1` (atau `https://domain-anda.com/api/v1`)
- **Swagger UI:** http://localhost:8000/api/documentation
- **OpenAPI Spec (JSON):** http://localhost:8000/docs
- **Protokol:** HTTP/1.1 atau HTTP/2
- **Format:** `JSON`
- **Request Headers:**
  ```http
  Accept: application/json
  ```
- **Autentikasi:** **Tidak Diperlukan (Publik & Read-Only)**. Seluruh endpoint dapat diakses langsung oleh aplikasi client, dan dokumentasi Swagger UI bersifat publik tanpa middleware login.
- **Logika Penyaringan:**
  - `/api/v1/products`: hanya mengembalikan produk berstatus `is_active = true`, diurutkan berdasarkan `order` lalu `id`.
  - `/api/v1/testimonials`: jika section berstatus `is_active = false`, field `title` bernilai `null` dan `statistics` bernilai `[]`, sedangkan daftar `testimonials` pelanggan tetap dikembalikan.
  - `/api/v1/contact`: hanya mengembalikan section kontak yang `is_active = true` beserta `items` yang juga berstatus `is_active = true`, diurutkan berdasarkan `order` lalu `id`.

---

### Daftar Endpoint API

| No | Modul | HTTP Method | Endpoint Path | Tipe Data Response |
| :---: | :--- | :---: | :--- | :--- |
| 1 | **Katalog Produk** | `GET` | `/api/v1/products` | Array (Daftar Produk Aktif beserta Galeri Gambar) |
| 2 | **Testimoni** | `GET` | `/api/v1/testimonials` | Objek Tunggal (Header, Statistik & Ulasan Pelanggan) |
| 3 | **Kontak** | `GET` | `/api/v1/contact` *(alias: `/contacts`)* | Objek Tunggal (Header & Daftar Item Kontak Aktif) |

> **Catatan:** Endpoint `home`, `about`, dan `how-to-orders` saat ini dinonaktifkan sementara (*commented out*) pada `routes/api.php`.

---

### 1. Katalog Produk (`products`)

Mengambil daftar seluruh produk eco-enzyme yang berstatus aktif (`is_active = true`), terurut berdasarkan `order` lalu `id`.

```http
GET /api/v1/products
```

#### Format JSON Response:
```json
{
  "data": [
    {
      "id": 1,
      "name": "Sabun Batang Eco-Enzyme",
      "detail": "Lembut di kulit, wangi alami dari enzim buah.",
      "price": "Rp 11.000",
      "order": 1,
      "images": [
        "http://localhost:8000/storage/product-images/sabun-batang-1.webp",
        "http://localhost:8000/storage/product-detail-images/sabun-batang-2.webp"
      ],
      "is_active": true
    }
  ]
}
```

#### Penjelasan Field:
| Field | Tipe | Deskripsi |
| :--- | :--- | :--- |
| `id` | Integer | ID unik produk. |
| `name` | String | Nama produk. |
| `detail` | String / Null | Rincian detail produk (fallback ke `description` bila `detail` kosong). |
| `price` | String / Null | Harga produk terformat Rupiah (contoh: `"Rp 11.000"`). |
| `order` | Integer | Nomor urutan tampilan produk. |
| `images` | Array of Strings (URL) | Daftar URL absolut gambar utama diikuti gambar detail produk. |
| `is_active` | Boolean | Status publikasi produk (`true` = aktif). |

---

### 2. Testimoni & Statistik (`testimonials`)

Mengambil judul section testimoni, daftar statistik pencapaian, serta ulasan pelanggan.

```http
GET /api/v1/testimonials
```

#### Format JSON Response:
```json
{
  "data": {
    "id": 1,
    "title": "Apa Kata Mereka?",
    "is_active": true,
    "statistics": [
      {
        "id": 1,
        "value": "500+",
        "description": "Pelanggan Puas"
      }
    ],
    "testimonials": [
      {
        "id": 1,
        "quote": "Produknya sangat berkualitas dan ramah lingkungan!",
        "name": "Budi Santoso",
        "location": "Surabaya, Jawa Timur"
      }
    ]
  }
}
```

> **Catatan Toggle Status (`is_active = false`):** Jika status section testimoni dinonaktifkan di Admin Portal, `title` bernilai `null` dan `statistics` bernilai `[]`, namun array `testimonials` (data pelanggan yang memberi ulasan) **tetap ditampilkan**. Bila belum ada data section sama sekali, respons adalah:
> ```json
> { "data": null }
> ```

---

### 3. Kontak & Lokasi (`contact`)

Mengambil informasi header kontak dan daftar kanal komunikasi aktif (lokasi, email, WhatsApp, media sosial, dll.) dengan struktur payload yang bersih dan terurut berdasarkan `order`.

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
    "description": "Ingin tahu lebih banyak tentang produk, cara pembuatan, atau peluang kolaborasi?\nJangan ragu untuk menghubungi kami.",
    "is_active": true,
    "items": [
      {
        "id": 101,
        "type": "location",
        "label": "LOKASI",
        "value": "Desa Jeruklegi, Jawa Tengah",
        "icon_name": "map-pin",
        "icon_image_url": null,
        "order": 1
      },
      {
        "id": 192,
        "type": "email",
        "label": "EMAIL",
        "value": "halo@ecoenzyme-jeruklegi.id",
        "icon_name": "mail",
        "icon_image_url": null,
        "order": 2
      }
    ]
  }
}
```

#### Penjelasan Field:
| Field | Tipe | Deskripsi |
| :--- | :--- | :--- |
| `id` | Integer | ID unik section kontak. |
| `title` | String | Judul heading section kontak. |
| `description` | String / Null | Deskripsi singkat pada section kontak. |
| `is_active` | Boolean | Status publikasi section kontak (`true` = tampil). |
| `items` | Array of Objects | Daftar item kontak yang berstatus `is_active = true`, terurut berdasarkan `order` lalu `id`. |
| `items[].type` | String | Tipe item kontak (`location`, `email`, `whatsapp`, `custom`). |
| `items[].label` | String | Label tampilan kartu kontak. |
| `items[].value` | String | Nilai/isi kontak (alamat, email, nomor WhatsApp, handle/tautan). |
| `items[].icon_name` | String / Null | Nama ikon Lucide (contoh: `map-pin`, `mail`, `phone`). |
| `items[].icon_image_url` | String (URL) / Null | URL publik absolut gambar ikon kustom bila diunggah. |
| `items[].order` | Integer | Urutan tampilan kartu kontak. |

> **Catatan:** Bila section kontak dinonaktifkan atau belum tersedia, respons adalah `{ "data": null }`. Item kontak individu yang di-toggle nonaktif di Admin Portal otomatis disaring dari array `items`.

---

### Status Code & Error Handling

| HTTP Code | Situasi | Penjelasan |
| :---: | :--- | :--- |
| **`200 OK`** | Permintaan Berhasil | Data ditemukan dan dikembalikan dalam format JSON. |
| **`404 Not Found`** | Route / Data Tidak Ditemukan | Endpoint tidak tersedia atau URL salah. |
| **`500 Internal Error`** | Kesalahan Server | Terjadi kendala internal pada server atau koneksi database. |

Bila data kosong / belum ada yang aktif pada endpoint singleton (`/testimonials`, `/contact`), API mengembalikan `200 OK` dengan payload:
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
    const [productsRes, testimonialRes, contactRes] = await Promise.all([
      fetch(`${API_BASE_URL}/products`),
      fetch(`${API_BASE_URL}/testimonials`),
      fetch(`${API_BASE_URL}/contact`)
    ]);

    const products = await productsRes.json();
    const testimonials = await testimonialRes.json();
    const contact = await contactRes.json();

    console.log('Katalog Produk:', products.data);
    console.log('Testimoni:', testimonials.data);
    console.log('Kontak:', contact.data?.items);
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
  - Mengelola seluruh modul konten landing page yang aktif.
- **Admin Modul (`admin`)**:
  - Hanya dapat mengakses modul konten yang secara eksplisit diberikan izinnya (*permissions*) oleh Super Admin.
  - Tidak memiliki akses ke menu **Manajemen Pengguna**.
  - Dapat memperbarui profil dan password sendiri.

### 2. Daftar Permissions Modul Aktif
| Permission Name | Modul Target | Menu Sidebar |
| :--- | :--- | :--- |
| `manage_product_sections` | Katalog Produk | `/admin/product-sections` |
| `manage_testimonials` | Ulasan & Testimoni | `/admin/testimonials` |
| `manage_contact_sections` | Informasi Kontak | `/admin/contact-sections` |

> *(Permission `manage_home_sections`, `manage_about_sections`, dan `manage_how_to_order` saat ini dinonaktifkan pada `RolePermissionSeeder`.)*

---

## 🧪 Pengujian & Standar Kode

### 1. Menjalankan Automated Tests (PHPUnit)
```bash
# Menjalankan pengujian untuk modul aktif (Produk, Testimoni, Kontak)
php artisan test --compact tests/Feature/ProductSectionTest.php tests/Feature/TestimonialHubTest.php tests/Feature/ContactSectionTest.php

# Menjalankan seluruh test suite
php artisan test --compact
```

### 2. Standar Format Kode (Laravel Pint) & Dokumentasi OpenAPI
Proyek ini mematuhi standar PSR-12 dan konvensi Laravel. Jalankan Pint dan regenerate Swagger docs bila ada perubahan API:
```bash
vendor/bin/pint
php artisan l5-swagger:generate
```

---

## 📄 Lisensi

Aplikasi ini bersifat *open-source* dan dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).

---

<p align="center">
  Dikembangkan dengan dedikasi untuk program <strong>Pengabdian Kepada Masyarakat Dosen</strong><br>
  Mendukung Transformasi Digital UMKM & Lingkungan <strong>Desa Jeruklegi</strong>
</p>
