# Technical Guidelines & Standards - Dapurloka

## 1. Lingkungan Pengembangan & Perkakas (Environment & Tooling)
* **Framework:** Laravel 13 (PHP 8.2+).
* **Package Manager:** Wajib menggunakan **pnpm**. Dilarang menggunakan `npm` atau `yarn` untuk menjaga efisiensi I/O.
* **Hardware Constraints:** Pengembangan dilakukan pada perangkat dengan media penyimpanan **HDD**.
  * Hindari eksekusi *script* atau operasi *disk* I/O masif secara bersamaan.
  * Pastikan kompilasi aset oleh Vite berjalan optimal tanpa *file polling* yang memberatkan *disk*.

## 2. Arsitektur & Standar Kode (Coding Standards)
* **KISS Principle:** Tulis kode yang sederhana dan *straightforward*.
* **Controller-Centric:** Letakkan logika bisnis utama di dalam Controller. Hindari arsitektur kompleks seperti *Repository Pattern* atau *Service Layer* agar sejalan dengan gaya pengkodean manual.
* **Autentikasi Manual (Strict Rule):** Dilarang keras menggunakan *starter kit* autentikasi seperti Laravel Breeze, Jetstream, atau Fortify. Sistem registrasi dan *login* **wajib** dibangun dari awal menggunakan `AuthController` dan *facade* `Auth::attempt()`.
* **Otorisasi Berbasis Peran:** Gunakan *Custom Middleware* (contoh: `CekRole`) pada definisi *route* untuk membatasi hak akses antara `admin` dan `user`.

## 3. Frontend & Antarmuka
* **Arsitektur:** Monolith menggunakan **Laravel Blade**.
* **Styling Framework:** **Tailwind CSS**. Dilarang menggunakan Bootstrap atau *framework* CSS lainnya.
* **Asset Bundling:** Diintegrasikan menggunakan Vite (`pnpm run dev`).

## 4. Penanganan Media & Aset Visual
* **Profil Warna (Strict Rule):** Semua pengolahan warna pada kode CSS (HEX/RGB) maupun aset gambar yang digunakan di dalam proyek **WAJIB menggunakan format RGB**. Dilarang keras memproses atau menggunakan aset dengan profil warna **CMYK**.
* **Manajemen File (Storage):**
  * Wajib mengeksekusi `php artisan storage:link`.
  * Simpan gambar unggahan pengguna (resep/restoran) di dalam disk lokal: `storage/app/public/recipes` atau `storage/app/public/restaurants`.
  * Database tidak memuat *blob* gambar, melainkan hanya *string path* (contoh: `recipes/nasi-goreng.jpg`).

## 5. Keamanan & Validasi
* **Otorisasi Berbasis Peran (Strict Rule):** Dilarang membuat file *Custom Middleware* sendiri. Implementasikan **Laravel Gates** (didefinisikan di dalam `AppServiceProvider`) untuk membatasi hak akses antara `admin` dan `user` sesuai dengan standar Modul 6. Gunakan direktif `@can` dan `@cannot` di dalam file Blade, serta `Gate::authorize()` di dalam Controller.
* **Validasi Input:** Gunakan *Form Request* bawaan Laravel (`php artisan make:request`) untuk menjaga Controller tetap bersih dari logika validasi panjang.
* **Mass Assignment:** Definisikan atribut `$fillable` secara eksplisit pada setiap Model Eloquent untuk mencegah kerentanan pengisian data secara massal.