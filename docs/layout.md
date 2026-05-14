# Blade Layout & Structure - Dapurloka

## 1. Arsitektur Layout Utama (`resources/views/layouts/`)
Aplikasi dibagi menjadi tiga master layout utama untuk memisahkan konteks penggunaan secara jelas.

### 1.1. `main.blade.php` (Public Layout)
Digunakan untuk pengunjung umum (Guest) dan halaman eksplorasi publik.
* **Karakteristik:** Tanpa sidebar, menggunakan Navbar atas yang statis.
* **Lebar Konten:** `max-w-6xl mx-auto px-4`.
* **Elemen Wajib:** * Navigation Bar (Logo di kiri, Search di tengah, Auth Links di kanan).
    * Footer minimalis (Copyright, Links).
    * Penampung konten: `@yield('content')`.

### 1.2. `dashboard.blade.php` (Workspace Layout)
Digunakan oleh Admin dan User terautentikasi. Mengadopsi struktur sidebar vertikal khas Notion.
* **Sidebar (Sisi Kiri):** * Lebar: `w-64`.
    * Latar belakang: `#F7F7F5`.
    * Border kanan: `1px solid #E9E9E7`.
    * Berisi info profil singkat dan navigasi hierarkis.
* **Area Kerja (Sisi Kanan):** * `flex-1 bg-white min-h-screen`.
    * Header halaman dinamis (Judul & Tombol Aksi).
    * Penampung konten: `@yield('content')`.

### 1.3. `auth.blade.php` (Auth Layout)
Khusus untuk halaman Login dan Register.
* **Karakteristik:** Sangat minimalis, layout terpusat (*centered*).
* **Lebar Form:** `max-w-md w-full`.
* **Latar Belakang:** `#FFFFFF` dengan aksen border tipis pada form.

---

## 2. Detail Navigasi Sidebar (Dashboard)
Navigasi diatur menggunakan logika peran (Role) secara langsung di dalam file Blade:

### Menu untuk Semua User Terautentikasi:
* **Dashboard:** Ringkasan aktivitas.
* **Profil:** Pengaturan akun.

### Menu Khusus Admin (`@if($role == 'admin')`):
* **Persetujuan Resep:** Daftar resep status `pending` (dilengkapi badge jumlah).
* **Kelola Restoran:** CRUD data restoran.
* **Kelola Master Flavor:** CRUD data tag/rasa.
* **Daftar Resep:** Manajemen semua resep yang ada di sistem.

### Menu Khusus User Biasa (`@if($role == 'user')`):
* **Submit Resep:** Tombol aksi utama (Aksen Biru).
* **Resep Saya:** Daftar resep yang pernah dibuat beserta statusnya.
* **Riwayat Ulasan:** Daftar review yang pernah diberikan.

---

## 3. Komponen Blade Reusable (`resources/views/components/`)
Gunakan komponen Blade untuk elemen yang berulang guna menjaga kebersihan kode:

| Komponen | Kegunaan |
| :--- | :--- |
| `card-recipe.blade.php` | Menampilkan ringkasan resep di halaman eksplorasi. |
| `card-restaurant.blade.php` | Menampilkan ringkasan restoran. |
| `status-badge.blade.php` | Menampilkan label 'Pending', 'Approved', atau 'Rejected'. |
| `star-rating.blade.php` | Menampilkan deretan bintang (1-5) berdasarkan input nilai. |
| `flavor-tag.blade.php` | Label kecil untuk tag rasa/flavor. |
| `page-header.blade.php` | Menampilkan judul halaman dan tombol aksi (misal: "Tambah Resep"). |

---

## 4. Struktur Folder Views
AI Agent harus menyimpan file sesuai kategori berikut:
* `views/auth/`: `login.blade.php`, `register.blade.php`.
* `views/admin/`: `dashboard.blade.php`, `flavors/`, `approvals/`.
* `views/user/`: `dashboard.blade.php`, `my-recipes/`.
* `views/public/`: `home.blade.php`, `recipes/index.blade.php`, `recipes/show.blade.php`.

## 5. Standar Implementasi Blade
* **Eager Loading:** Pastikan data relasi dipanggil di Controller menggunakan `with()` sebelum dikirim ke view untuk menghindari *N+1 query* yang memberatkan HDD.
* **Empty State:** Setiap halaman daftar (list) wajib memiliki pengecekan `@if($items->isEmpty())` untuk menampilkan pesan "Belum ada data" yang rapi.
* **Keamanan:** Gunakan `@csrf` pada setiap form dan `@method` untuk operasi PUT/DELETE.
* **Kompilasi Aset:** Panggil aset melalui direktif `@vite(['resources/css/app.css', 'resources/js/app.js'])` hanya di master layout.