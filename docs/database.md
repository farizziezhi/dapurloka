# Database Schema & Relationships (ERD) - Dapurloka

## 1. Panduan Umum (General Guidelines)
* **Framework:** Laravel 13.
* **Konvensi:** Menggunakan standar penamaan Laravel (tabel jamak/plural, model tunggal/singular).
* **Integritas Data:** Semua *Foreign Key* wajib menggunakan `constrained()->cascadeOnDelete()` untuk menjamin kebersihan data dan memudahkan pemeliharaan database secara otomatis.
* **Optimasi HDD:** Pastikan indeks pada kolom *foreign key* terpasang dengan benar untuk mempercepat operasi pencarian data pada media penyimpanan HDD.
* **Media:** Kolom `image` pada tabel `recipes` dan `restaurants` hanya menyimpan *string path* (relatif), bukan file biner.

---

## 2. Struktur Tabel

### 2.1. Entitas Utama

#### `users`
Menyimpan informasi akun dan peran pengguna.
* `id` (PK)
* `name` (string)
* `email` (string, unique)
* `password` (string)
* `role` (enum/string: `'admin'`, `'user'`. Default: `'user'`)
* `timestamps`

#### `flavors`
Master data untuk sistem *tagging* rasa/kategori.
* `id` (PK)
* `name` (string, unique)
* `description` (string, nullable)
* `timestamps`

#### `restaurants`
Informasi detail restoran yang dikelola Admin.
* `id` (PK)
* `name` (string)
* `description` (text)
* `address` (text)
* `phone` (string, nullable)
* `image` (string, nullable) - Path file gambar (RGB)
* `timestamps`

#### `recipes`
Data resep masakan yang disubmit oleh pengguna.
* `id` (PK)
* `user_id` (FK ke `users.id`) - `constrained()->cascadeOnDelete()`
* `title` (string)
* `ingredients` (text)
* `steps` (text)
* `image` (string, nullable) - Path file gambar (RGB)
* `status` (enum: `'pending'`, `'approved'`, `'rejected'`. Default: `'pending'`)
* `timestamps`

---

### 2.2. Tabel Pivot (Many-to-Many)

#### `flavor_recipe`
Menghubungkan satu atau lebih flavor ke satu atau lebih resep.
* `recipe_id` (FK ke `recipes.id`) - `constrained()->cascadeOnDelete()`
* `flavor_id` (FK ke `flavors.id`) - `constrained()->cascadeOnDelete()`

#### `flavor_restaurant`
Menghubungkan satu atau lebih flavor ke satu atau lebih restoran.
* `restaurant_id` (FK ke `restaurants.id`) - `constrained()->cascadeOnDelete()`
* `flavor_id` (FK ke `flavors.id`) - `constrained()->cascadeOnDelete()`

---

### 2.3. Tabel Ulasan (Explicit Reviews)

#### `recipe_reviews`
Ulasan pengguna khusus untuk entitas resep.
* `id` (PK)
* `user_id` (FK ke `users.id`) - `constrained()->cascadeOnDelete()`
* `recipe_id` (FK ke `recipes.id`) - `constrained()->cascadeOnDelete()`
* `rating` (integer, skala 1-5)
* `comment` (text, nullable)
* `timestamps`

#### `restaurant_reviews`
Ulasan pengguna khusus untuk entitas restoran.
* `id` (PK)
* `user_id` (FK ke `users.id`) - `constrained()->cascadeOnDelete()`
* `restaurant_id` (FK ke `restaurants.id`) - `constrained()->cascadeOnDelete()`
* `rating` (integer, skala 1-5)
* `comment` (text, nullable)
* `timestamps`

---

## 3. Definisi Relasi Eloquent (Model)

AI Agent harus mengimplementasikan fungsi relasi berikut di dalam Model:

* **Model User:** `hasMany(Recipe)`, `hasMany(RecipeReview)`, `hasMany(RestaurantReview)`.
* **Model Recipe:** `belongsTo(User)`, `belongsToMany(Flavor)`, `hasMany(RecipeReview)`.
* **Model Restaurant:** `belongsToMany(Flavor)`, `hasMany(RestaurantReview)`.
* **Model Flavor:** `belongsToMany(Recipe)`, `belongsToMany(Restaurant)`.
* **Model RecipeReview:** `belongsTo(User)`, `belongsTo(Recipe)`.
* **Model RestaurantReview:** `belongsTo(User)`, `belongsTo(Restaurant)`.

## 4. Query & Performance
Gunakan **Eager Loading** (`::with()`) pada Controller untuk setiap pengambilan data yang memiliki relasi guna menghindari *N+1 Query Problem*, yang sangat krusial untuk performa pada perangkat penyimpanan HDD.