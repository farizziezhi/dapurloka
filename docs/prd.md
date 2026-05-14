# Product Requirements Document (PRD) - Dapurloka

## 1. Ringkasan Proyek
Dapurloka adalah sebuah platform berbasis web untuk mengeksplorasi resep masakan dan menemukan restoran. Sistem ini memfasilitasi interaksi komunitas melalui pengiriman resep (User Generated Content) dan sistem ulasan (review) spesifik untuk resep dan restoran. Aplikasi ini dibangun dari awal (from scratch) menggunakan Laravel 13 dan Tailwind CSS, mengikuti standar operasional pengembangan manual tanpa *starter kit*.

## 2. Aktor & Hak Akses (Roles & Permissions)
Sistem memiliki 3 jenis peran dengan batasan yang diatur secara ketat melalui Custom Middleware:

### Admin
* Memiliki hak penuh untuk CRUD (Create, Read, Update, Delete) semua data restoran.
* Memiliki hak penuh untuk CRUD master data *flavors* (kategori rasa).
* Memiliki hak penuh untuk CRUD resep.
* Bertugas melakukan *Approve* (menyetujui) atau menolak resep yang disubmit oleh pengguna biasa sebelum tayang di halaman publik.

### User Biasa (Authenticated User)
* Dapat melihat daftar resep yang sudah berstatus *approved* dan daftar restoran.
* Dapat melakukan submit resep baru (status otomatis *pending*).
* Dapat mengubah (Update) atau menghapus (Delete) resep miliknya sendiri.
* Dapat memberikan ulasan dan rating pada resep milik orang lain.
* Dapat memberikan ulasan dan rating pada restoran (opsional).

### Guest (Unauthenticated User)
* Hanya dapat melihat daftar resep berstatus *approved* dan daftar restoran.
* Tidak memiliki hak untuk berinteraksi, submit data, atau memberikan ulasan sebelum melakukan proses login.

## 3. Fitur Utama & Alur Kerja
* **Autentikasi Manual:** Proses Login dan Register wajib dibuat secara manual menggunakan `AuthController` dan `Auth::attempt()`.
* **Proteksi Rute:** Pengaturan hak akses (Admin vs User) wajib menggunakan Custom Middleware (misal: `CekRole`).
* **Alur Publikasi Resep:** Resep yang disubmit oleh User Biasa tidak langsung tayang. Resep masuk ke antrean Admin dengan status `pending` dan baru bisa dilihat publik setelah diubah menjadi `approved`.
* **Sistem Tagging (Flavors):** Menggunakan relasi *Many-to-Many*. Satu entitas (resep atau restoran) dapat memiliki banyak tag rasa, dan sebaliknya.
* **Sistem Ulasan Terpisah:** Untuk menjaga integritas data relasional, tabel ulasan dipecah menjadi dua yaitu `recipe_reviews` dan `restaurant_reviews`.

## 4. Batasan Teknis (Constraints & Environment)
AI Agent wajib mematuhi aturan berikut selama penulisan kode:

* **Larangan Starter Kit:** Dilarang keras menggunakan Laravel Breeze, Jetstream, Fortify, atau *package* autentikasi instan sejenisnya.
* **Manajemen Paket:** Wajib menggunakan `pnpm` untuk instalasi *dependency* Node.js. Jangan gunakan `npm` atau `yarn`.
* **Lingkungan Penyimpanan:** Pengembangan dilakukan pada perangkat dengan HDD. Hindari *script* kompilasi atau operasi I/O yang terlalu agresif untuk menjaga performa disk.
* **Frontend & Styling:** Gunakan Laravel Blade sebagai *templating engine* utama dengan gaya desain Tailwind CSS (via Vite).
* **Profil Warna Visual:** Semua aset desain, gambar, dan kode warna wajib menggunakan format **RGB**. Dilarang menggunakan profil warna CMYK.
* **Manajemen Gambar:** Gambar yang diunggah harus disimpan melalui fasilitas Storage Laravel (`storage/app/public`), sedangkan database hanya menyimpan *string path* lokasinya.