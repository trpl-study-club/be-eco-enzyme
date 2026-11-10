<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa untuk Validasi (Bahasa Indonesia)
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut berisi pesan kesalahan standar yang digunakan oleh
    | kelas validator. Diformulasikan dengan bahasa Indonesia yang jelas,
    | sopan, dan mudah dipahami oleh pengguna awam maupun orang tua.
    |
    */

    'accepted' => ':attribute harus disetujui.',
    'accepted_if' => ':attribute harus disetujui ketika :other adalah :value.',
    'active_url' => ':attribute harus berupa tautan alamat web (URL) yang aktif dan valid.',
    'after' => ':attribute harus berupa tanggal setelah :date.',
    'after_or_equal' => ':attribute harus berupa tanggal setelah atau sama dengan :date.',
    'alpha' => ':attribute hanya boleh berisi huruf.',
    'alpha_dash' => ':attribute hanya boleh berisi huruf, angka, tanda hubung (-), dan garis bawah (_).',
    'alpha_num' => ':attribute hanya boleh berisi huruf dan angka.',
    'array' => ':attribute harus berupa daftar data (pilihan ganda).',
    'ascii' => ':attribute hanya boleh berisi karakter alfanumerik dan simbol byte tunggal.',
    'before' => ':attribute harus berupa tanggal sebelum :date.',
    'before_or_equal' => ':attribute harus berupa tanggal sebelum atau sama dengan :date.',
    'between' => [
        'array' => ':attribute harus memiliki antara :min sampai :max data.',
        'file' => 'Ukuran berkas :attribute harus antara :min sampai :max kilobyte (KB).',
        'numeric' => 'Nilai :attribute harus antara :min sampai :max.',
        'string' => 'Panjang :attribute harus antara :min sampai :max karakter.',
    ],
    'boolean' => ':attribute harus bernilai aktif (ya) atau tidak aktif (tidak).',
    'can' => ':attribute berisi nilai yang tidak diizinkan.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok atau tidak sama.',
    'current_password' => 'Kata sandi saat ini yang Anda masukkan salah.',
    'date' => ':attribute harus berupa tanggal yang valid.',
    'date_equals' => ':attribute harus berupa tanggal yang sama dengan :date.',
    'date_format' => ':attribute tidak sesuai dengan format tanggal :format.',
    'decimal' => ':attribute harus memiliki :decimal angka di belakang koma.',
    'declined' => ':attribute harus ditolak.',
    'declined_if' => ':attribute harus ditolak ketika :other adalah :value.',
    'different' => ':attribute dan :other harus berbeda.',
    'digits' => ':attribute harus berupa :digits digit angka.',
    'digits_between' => ':attribute harus memiliki panjang antara :min sampai :max digit angka.',
    'dimensions' => 'Dimensi gambar untuk :attribute tidak sesuai dengan ketentuan.',
    'distinct' => ':attribute memiliki nilai duplikat yang berulang.',
    'doesnt_end_with' => ':attribute tidak boleh diakhiri dengan salah satu dari: :values.',
    'doesnt_start_with' => ':attribute tidak boleh diawali dengan salah satu dari: :values.',
    'email' => ':attribute harus berupa alamat email yang valid dan aktif (contoh: nama@domain.com).',
    'ends_with' => ':attribute harus diakhiri dengan salah satu dari: :values.',
    'enum' => 'Pilihan :attribute yang dipilih tidak valid.',
    'exists' => 'Pilihan :attribute yang dipilih tidak ditemukan dalam sistem.',
    'extensions' => ':attribute harus memiliki salah satu ekstensi: :values.',
    'file' => ':attribute harus berupa berkas dokumen atau gambar.',
    'filled' => ':attribute wajib memiliki isi nilai.',
    'gt' => [
        'array' => ':attribute harus memiliki lebih dari :value data.',
        'file' => 'Ukuran berkas :attribute harus lebih besar dari :value kilobyte (KB).',
        'numeric' => 'Nilai :attribute harus lebih besar dari :value.',
        'string' => 'Panjang :attribute harus lebih dari :value karakter.',
    ],
    'gte' => [
        'array' => ':attribute harus memiliki minimal :value data atau lebih.',
        'file' => 'Ukuran berkas :attribute harus minimal :value kilobyte (KB).',
        'numeric' => 'Nilai :attribute harus minimal :value atau lebih besar.',
        'string' => 'Panjang :attribute harus minimal :value karakter atau lebih.',
    ],
    'hex_color' => ':attribute harus berupa kode warna hex yang valid (contoh: #10B981).',
    'image' => ':attribute harus berupa berkas foto atau gambar.',
    'in' => 'Pilihan :attribute yang dipilih tidak valid.',
    'in_array' => ':attribute harus ada di dalam pilihan :other.',
    'integer' => ':attribute harus berupa bilangan bulat.',
    'ip' => ':attribute harus berupa alamat IP yang valid.',
    'ipv4' => ':attribute harus berupa alamat IPv4 yang valid.',
    'ipv6' => ':attribute harus berupa alamat IPv6 yang valid.',
    'json' => ':attribute harus berupa format data JSON yang valid.',
    'list' => ':attribute harus berupa daftar data.',
    'lowercase' => ':attribute harus berupa huruf kecil semua.',
    'lt' => [
        'array' => ':attribute harus memiliki kurang dari :value data.',
        'file' => 'Ukuran berkas :attribute harus lebih kecil dari :value kilobyte (KB).',
        'numeric' => 'Nilai :attribute harus kurang dari :value.',
        'string' => 'Panjang :attribute harus kurang dari :value karakter.',
    ],
    'lte' => [
        'array' => ':attribute tidak boleh memiliki lebih dari :value data.',
        'file' => 'Ukuran berkas :attribute maksimal berukuran :value kilobyte (KB).',
        'numeric' => 'Nilai :attribute maksimal bernilai :value.',
        'string' => 'Panjang :attribute maksimal :value karakter.',
    ],
    'mac_address' => ':attribute harus berupa alamat MAC yang valid.',
    'max' => [
        'array' => ':attribute tidak boleh memiliki lebih dari :max data.',
        'file' => 'Ukuran berkas :attribute tidak boleh melebihi :max kilobyte (KB).',
        'numeric' => 'Nilai :attribute tidak boleh lebih besar dari :max.',
        'string' => 'Panjang :attribute tidak boleh melebihi :max karakter.',
    ],
    'max_digits' => ':attribute tidak boleh memiliki lebih dari :max digit angka.',
    'mimes' => ':attribute harus berupa berkas dengan format: :values.',
    'mimetypes' => ':attribute harus berupa berkas dengan tipe: :values.',
    'min' => [
        'array' => ':attribute harus memiliki minimal :min data.',
        'file' => 'Ukuran berkas :attribute minimal harus :min kilobyte (KB).',
        'numeric' => 'Nilai :attribute minimal harus :min.',
        'string' => 'Panjang :attribute minimal harus :min karakter.',
    ],
    'min_digits' => ':attribute harus memiliki minimal :min digit angka.',
    'missing' => 'Kolom :attribute tidak boleh ada.',
    'missing_if' => 'Kolom :attribute tidak boleh ada ketika :other adalah :value.',
    'missing_unless' => 'Kolom :attribute tidak boleh ada kecuali jika :other adalah :value.',
    'missing_with' => 'Kolom :attribute tidak boleh ada ketika :values ada.',
    'missing_with_all' => 'Kolom :attribute tidak boleh ada ketika :values semua ada.',
    'multiple_of' => ':attribute harus merupakan kelipatan dari :value.',
    'not_in' => 'Pilihan :attribute yang dipilih tidak valid.',
    'not_regex' => 'Format isian :attribute tidak valid.',
    'numeric' => ':attribute harus berupa angka.',
    'password' => [
        'letters' => ':attribute harus memuat setidaknya satu huruf.',
        'mixed' => ':attribute harus memuat kombinasi huruf besar dan huruf kecil.',
        'numbers' => ':attribute harus memuat setidaknya satu angka.',
        'symbols' => ':attribute harus memuat setidaknya satu simbol khusus.',
        'uncompromised' => ':attribute yang dimasukkan terindikasi tidak aman karena pernah bocor. Silakan gunakan kombinasi lain.',
    ],
    'present' => 'Kolom :attribute wajib dicantumkan.',
    'present_if' => 'Kolom :attribute wajib dicantumkan ketika :other bernilai :value.',
    'present_unless' => 'Kolom :attribute wajib dicantumkan kecuali jika :other bernilai :value.',
    'present_with' => 'Kolom :attribute wajib dicantumkan ketika :values terisi.',
    'present_with_all' => 'Kolom :attribute wajib dicantumkan ketika :values semua terisi.',
    'prohibited' => 'Kolom :attribute dilarang diisi.',
    'prohibited_if' => 'Kolom :attribute dilarang diisi ketika :other bernilai :value.',
    'prohibited_unless' => 'Kolom :attribute dilarang diisi kecuali jika :other bernilai :values.',
    'prohibits' => 'Kolom :attribute melarang kolom :other untuk diisi.',
    'regex' => 'Format isian :attribute tidak valid.',
    'required' => ':attribute wajib diisi.',
    'required_array_keys' => ':attribute harus memuat rincian untuk: :values.',
    'required_if' => ':attribute wajib diisi ketika :other adalah :value.',
    'required_if_accepted' => ':attribute wajib diisi ketika :other disetujui.',
    'required_if_declined' => ':attribute wajib diisi ketika :other ditolak.',
    'required_unless' => ':attribute wajib diisi kecuali jika :other berada dalam :values.',
    'required_with' => ':attribute wajib diisi ketika :values terisi.',
    'required_with_all' => ':attribute wajib diisi ketika :values semua terisi.',
    'required_without' => ':attribute wajib diisi ketika :values tidak diisi.',
    'required_without_all' => ':attribute wajib diisi ketika tidak ada satu pun dari :values yang diisi.',
    'same' => ':attribute dan :other harus sama persis.',
    'size' => [
        'array' => ':attribute harus memuat tepat :size data.',
        'file' => 'Ukuran berkas :attribute harus tepat berukuran :size kilobyte (KB).',
        'numeric' => 'Nilai :attribute harus tepat bernilai :size.',
        'string' => 'Panjang :attribute harus tepat :size karakter.',
    ],
    'starts_with' => ':attribute harus diawali dengan salah satu dari: :values.',
    'string' => ':attribute harus berupa teks / tulisan.',
    'timezone' => ':attribute harus berupa zona waktu yang valid.',
    'unique' => ':attribute ini sudah terdaftar sebelumnya. Silakan gunakan yang lain.',
    'uploaded' => 'Berkas :attribute gagal diunggah ke server.',
    'uppercase' => ':attribute harus berupa huruf kapital semua.',
    'url' => ':attribute harus berupa tautan alamat web (URL) yang valid (diawali http:// atau https://).',
    'ulid' => ':attribute harus berupa format ULID yang valid.',
    'uuid' => ':attribute harus berupa format UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Pesan Validasi Kustom Per Baris
    |--------------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan pesan validasi kustom untuk atribut tertentu.
    |
    */

    'custom' => [
        'email' => [
            'unique' => 'Alamat email ini sudah terdaftar di sistem. Silakan gunakan alamat email lain.',
        ],
        'password' => [
            'confirmed' => 'Ketik ulang kata sandi tidak cocok dengan kata sandi yang Anda buat di atas.',
        ],
        'current_password' => [
            'current_password' => 'Kata sandi saat ini yang Anda masukkan salah.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Penamaan Atribut Kustom (Bahasa Indonesia)
    |--------------------------------------------------------------------------
    |
    | Atribut berikut digunakan untuk menggantikan nama kolom teknis dalam bahasa
    | Inggris (seperti "email", "password", "title") menjadi istilah bahasa
    | Indonesia yang jelas dan ramah bagi orang tua / pengguna awam.
    |
    */

    'attributes' => [
        // Identitas & Pengguna
        'name' => 'Nama lengkap',
        'email' => 'Alamat email',
        'password' => 'Kata sandi',
        'password_confirmation' => 'Ulangi kata sandi',
        'current_password' => 'Kata sandi saat ini',
        'new_password' => 'Kata sandi baru',
        'new_password_confirmation' => 'Ulangi kata sandi baru',
        'role' => 'Peran akun pengelola',
        'permissions' => 'Hak akses modul',
        'is_active' => 'Status keaktifan',

        // Konten Umum & Banner
        'title' => 'Judul',
        'description' => 'Penjelasan / deskripsi',
        'image' => 'Foto / gambar',
        'button_one_text' => 'Teks tombol pertama',
        'button_one_link' => 'Tautan tombol pertama',
        'button_two_text' => 'Teks tombol kedua',
        'button_two_link' => 'Tautan tombol kedua',

        // Modul Produk
        'whatsapp_number' => 'Nomor WhatsApp pemesanan',
        'products' => 'Daftar produk',
        'products.*.name' => 'Nama produk',
        'products.*.price' => 'Harga produk',
        'products.*.description' => 'Deskripsi singkat produk',
        'products.*.benefit' => 'Manfaat / keunggulan produk',
        'products.*.detail' => 'Rincian detail produk',
        'products.*.image' => 'Foto utama produk',
        'products.*.detail_images' => 'Foto rincian produk',
        'products.*.detail_images.*' => 'Berkas foto rincian produk',

        // Modul Cara Pesan
        'button_text' => 'Teks tombol aksi',
        'button_link' => 'Tautan tombol aksi',
        'steps' => 'Daftar langkah pemesanan',
        'steps.*.title' => 'Judul langkah',
        'steps.*.description' => 'Penjelasan langkah',
        'steps.*.icon_name' => 'Gambar ikon langkah',

        // Modul Tentang Kami
        'cards' => 'Daftar kartu kegiatan',
        'cards.*.title' => 'Judul kartu',
        'cards.*.description' => 'Penjelasan kartu',
        'cards.*.icon_name' => 'Gambar ikon kartu',

        // Modul Kontak
        'items' => 'Daftar saluran kontak',
        'items.*.label' => 'Nama label kontak',
        'items.*.value' => 'Isi nomor / alamat kontak',
        'items.*.type' => 'Jenis saluran kontak',
        'items.*.icon_name' => 'Gambar ikon kontak',

        // Modul Testimoni
        'quote' => 'Isi ulasan testimoni',
        'location' => 'Kota / asal pelanggan',
        'testimonials' => 'Daftar ulasan testimoni',
        'testimonials.*.name' => 'Nama pemberi ulasan',
        'testimonials.*.quote' => 'Isi kalimat ulasan',
        'testimonials.*.location' => 'Asal pembeli / warga',
        'statistics' => 'Daftar angka statistik',
        'statistics.*.value' => 'Nilai angka statistik',
        'statistics.*.description' => 'Keterangan angka statistik',
    ],

];
