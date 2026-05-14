# Dapurloka

Platform berbasis web untuk eksplorasi resep masakan dan menemukan restoran lokal.
Dibangun dari nol dengan **Laravel 13 + Tailwind CSS v4 + Phosphor Icons**, mengikuti
gaya visual **Notion-esque** (minimalis, banyak whitespace, border tipis).

Dilengkapi fitur **"Dapur AI"** — saran resep & restoran berbasis kondisi pengguna,
ditenagai Laravel AI SDK + Gemini.

> Project UAS Praktikum Pengembangan Web.

---

## Daftar Isi

- [Stack & Konvensi](#stack--konvensi)
- [Cara Menjalankan](#cara-menjalankan)
- [Struktur Aplikasi](#struktur-aplikasi)
- [Fitur yang Sudah Ada](#fitur-yang-sudah-ada)
- [Yang Belum Dibuat](#yang-belum-dibuat-buat-tim-lanjutan)
- [Panduan Coding](#panduan-coding)
- [Cara Menambah Halaman Baru](#cara-menambah-halaman-baru-quick-recipe)
- [AI Agent (Dapur AI)](#ai-agent-dapur-ai)
- [Troubleshooting](#troubleshooting)

---

## Stack & Konvensi

| Aspek | Pilihan |
| --- | --- |
| Framework | Laravel 13 (PHP 8.3+) |
| DB | MySQL — schema di `database/migrations/` |
| Frontend | Blade + Tailwind CSS v4 (Vite) |
| Icons | Phosphor Icons (`@phosphor-icons/web`) |
| Package manager (PHP) | Composer |
| Package manager (JS) | **pnpm** (wajib, bukan npm/yarn) |
| Auth | **Manual** (`AuthController` + `Auth::attempt()`) — tanpa Breeze/Jetstream/Fortify |
| Authorization | **Laravel Gates** di `AppServiceProvider`, dipanggil via `Gate::authorize()` di controller dan `@can` di Blade — tanpa custom middleware |
| AI SDK | `laravel/ai` + Gemini provider |
| Image storage | `storage/app/public/{recipes,restaurants}` (DB hanya simpan path) |

### Aturan visual penting

- Semua warna **wajib RGB**. Dilarang CMYK.
- Style Notion: `bg-white`, `border border-[#E9E9E7]`, `rounded-md`, hindari `shadow-lg`.
- Palette di `resources/css/app.css` (lihat `@theme`).
- Empty state pakai pola: ikon Phosphor `ph-duotone` + teks italic abu-abu.

---

## Cara Menjalankan

### Prasyarat

- PHP 8.3+ dengan ekstensi `pdo_mysql`, `mbstring`, `fileinfo`
- Composer
- Node 18+
- pnpm (`npm install -g pnpm` jika belum ada) — **wajib**, jangan pakai npm/yarn
- MySQL berjalan di `127.0.0.1:3306`

> ⚠️ **Kenapa harus pnpm?** Sudah jadi keputusan tim sejak awal (lihat
> `docs/technical.md`). Repo ini punya `pnpm-lock.yaml`. Kalau pakai
> `npm install`, npm akan ignore lockfile dan generate `package-lock.json`
> baru → versi dependency bisa drift, dan dua lockfile akan bentrok di repo.
> Plus pnpm 2-3x lebih ringan untuk HDD karena pakai symlink.
> Cukup install sekali: `npm install -g pnpm`, selanjutnya pakai `pnpm install`.

### Setup awal (sekali saja)

```bash
# 1. Install dependencies
composer install
pnpm install atau npm install

# 2. Copy env dan generate key
copy .env.example .env
php artisan key:generate

# 3. Buat database "dapur_loka" di MySQL kamu, lalu:
php artisan migrate:fresh --seed

# 4. Symlink storage publik (untuk gambar resep/restoran)
php artisan storage:link
```

### Jalankan dev server

Buka 2 terminal:

```bash
# Terminal 1 — Laravel
php artisan serve

# Terminal 2 — Vite (Tailwind hot reload)
pnpm run dev
```

Buka <http://127.0.0.1:8000>.

### Akun seed

| Role | Email | Password |
| --- | --- | --- |
| Admin | `admin@dapurloka.test` | `password` |
| User | `user@dapurloka.test` | `password` |

Plus 5 flavor master, 5 resep approved, dan 4 restoran sudah otomatis ter-seed.

---

## Struktur Aplikasi

```
app/
├─ Ai/
│  └─ Agents/CulinaryAgent.php          ← AI agent untuk hero "Saran AI"
├─ Http/
│  ├─ Controllers/
│  │  ├─ AuthController.php             ← Login/Register/Logout manual
│  │  ├─ HomeController.php             ← Landing + AI suggest
│  │  ├─ DashboardController.php        ← Branch admin/user dashboard
│  │  ├─ AdminController.php            ← CRUD flavor/restoran + approval resep
│  │  └─ UserRecipeController.php       ← My recipes & my reviews
│  └─ Requests/                         ← Form requests untuk validasi
└─ Models/                              ← User, Recipe, Restaurant, Flavor, dst.

resources/views/
├─ layouts/
│  ├─ main.blade.php                    ← Layout publik (navbar + footer)
│  ├─ dashboard.blade.php               ← Layout workspace (sidebar)
│  └─ auth.blade.php                    ← Layout login/register (two-pane)
├─ components/
│  ├─ card-recipe.blade.php             ← <x-card-recipe :recipe="$r" />
│  ├─ card-restaurant.blade.php         ← <x-card-restaurant :restaurant="$r" />
│  ├─ status-badge.blade.php            ← <x-status-badge :status="..." />
│  ├─ star-rating.blade.php             ← <x-star-rating :rating="4.2" />
│  ├─ flavor-tag.blade.php              ← <x-flavor-tag :name="..." />
│  └─ page-header.blade.php             ← Judul halaman + slot untuk action
├─ auth/                                ← login, register
├─ admin/                               ← dashboard, flavors/, restaurants/, recipes/, approvals/
├─ user/                                ← dashboard, my-recipes/, my-reviews/
└─ public/                              ← home, ai-result
```

---

## Fitur yang Sudah Ada

### Publik

- ✅ Landing page (`/`) — hero AI dengan wordmark "Dapurloka", input prompt,
  daftar Featured Recipes & Top Restaurants
- ✅ AI suggestion (`POST /ai/suggest`) — Dapur AI memilih max 3 resep + 3
  restoran dari database, ditampilkan sebagai card

### Auth (manual)

- ✅ Login (`/login`)
- ✅ Register (`/register`) — otomatis role `user`
- ✅ Logout (`POST /logout`)

### Admin (`role = 'admin'`)

- ✅ Dashboard (`/dashboard`) — stat tiles + antrean pending
- ✅ Persetujuan Resep (`/admin/approvals`) — approve / reject submission
- ✅ Kelola Restoran (`/admin/restaurants`) — CRUD + image upload
- ✅ Master Flavor (`/admin/flavors`) — CRUD
- ✅ Daftar Resep (`/admin/recipes`) — filter status

### User (`role = 'user'`)

- ✅ Dashboard (`/dashboard`) — stat tiles + recent recipes
- ✅ Submit Resep (`/my/recipes/create`) — image upload, status default `pending`
- ✅ Resep Saya (`/my/recipes`) — edit / delete (edit kembalikan status ke `pending`)
- ✅ Riwayat Ulasan (`/my/reviews`) — list review yang pernah dibuat

---

## Yang Belum Dibuat (buat tim lanjutan)

Ini scope yang **belum** saya garap — silakan kerjakan:

### A. Halaman publik untuk listing & detail

| Halaman | Route yang disarankan | Catatan |
| --- | --- | --- |
| Listing semua resep approved | `GET /recipes` → `RecipeController@index` | Pakai `<x-card-recipe>` yang sudah ada. Eager load: `with(['user','flavors','reviews'])`. Tambah pencarian + filter flavor. |
| Detail satu resep | `GET /recipes/{recipe}` → `RecipeController@show` | Tampilkan title, gambar, bahan, langkah, flavors, dan list review. Eager load: `with(['user','flavors','reviews.user'])`. |
| Listing semua restoran | `GET /restaurants` → `RestaurantController@index` | Pakai `<x-card-restaurant>`. Eager load: `with(['flavors','reviews'])`. |
| Detail satu restoran | `GET /restaurants/{restaurant}` → `RestaurantController@show` | Mirip detail resep, plus alamat & telepon. |

### B. Sistem ulasan (reviews)

Model `RecipeReview` dan `RestaurantReview` sudah ada — tinggal bikin:

- Form post review di halaman detail (rating 1–5 + comment opsional).
- Authorization: hanya user login (`@auth`), tidak boleh review resep miliknya
  sendiri (cek `$recipe->user_id !== auth()->id()`).
- Komponen `<x-star-rating :rating="..." />` sudah ada untuk render bintang.

### C. Profil user

Layout dashboard sudah punya menu "Profil" (lihat `layout.md`) tapi belum
dibuat. Form sederhana untuk update nama + password.

### D. AI deskripsi resep di halaman detail

Saya sudah siapkan pola di `app/Ai/Agents/CulinaryAgent.php`. Untuk fitur AI lain
(misal generate deskripsi resep), bikin agent **baru terpisah**. Contoh:

```php
// app/Ai/Agents/RecipeDescriptionAgent.php
namespace App\Ai\Agents;

use Laravel\Ai\Attributes\{Model, Provider};
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;
use Stringable;

#[Provider('gemini')]
#[Model('gemini-3.1-flash-lite')]
class RecipeDescriptionAgent implements Agent
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return 'Kamu adalah koki Indonesia. Tulis deskripsi resep singkat (3-4 kalimat) yang menggugah selera.';
    }
}
```

Pakai di controller (pola sama persis dengan `aiSuggest`):

```php
$response = RecipeDescriptionAgent::make()->prompt(
    "Tulis deskripsi untuk resep '{$recipe->title}' dengan bahan: {$recipe->ingredients}"
);
return view('public.recipes.show', ['recipe' => $recipe, 'aiDescription' => $response->text]);
```

### E. Polish opsional

- Pagination di listing publik
- Bookmark/favorite resep
- Search bar di navbar publik (saat ini cuma placeholder)

---

## Panduan Coding

### KISS Principle

Tulis kode yang lurus dan to-the-point. Hindari Repository Pattern, Service Layer,
abstract base class — kecuali memang menghemat duplikasi nyata. Logika bisnis di
controller saja.

### Eager Loading WAJIB

Setiap query yang ada relasi **harus** pakai `with()` untuk hindari N+1.
Kita di HDD, jadi disk I/O mahal.

```php
// ✅ Benar
Recipe::approved()->with(['user', 'flavors', 'reviews'])->latest()->get();

// ❌ Salah — akan trigger N+1 saat card render
Recipe::approved()->latest()->get();
```

### Authorization

Pakai Gate (sudah didefinisikan di `app/Providers/AppServiceProvider.php`):

```php
// Di controller
public function someAdminAction()
{
    Gate::authorize('admin');
    // ...
}

// Di Blade
@can('admin')
    <a href="...">Admin only link</a>
@endcan
```

Jangan bikin custom middleware file.

### Mass Assignment

Selalu definisikan `$fillable` di Model (sudah ada untuk semua model existing).

### File Upload

- Form butuh `enctype="multipart/form-data"`
- Validasi: `'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048']`
- Simpan: `$path = $request->file('image')->store('recipes', 'public');`
- Hapus saat update/delete: `Storage::disk('public')->delete($oldPath);`
- Tampilkan: `asset('storage/' . $recipe->image)`

### Form Request

Validasi panjang dipindah ke `app/Http/Requests/`. Lihat
`StoreRecipeRequest`, `StoreRestaurantRequest`, `StoreFlavorRequest` sebagai contoh.

---

## Cara Menambah Halaman Baru (Quick Recipe)

Misal kamu mau bikin halaman listing resep publik di `/recipes`:

### 1. Bikin controller

```php
// app/Http/Controllers/RecipeController.php
namespace App\Http\Controllers;

use App\Models\Recipe;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::approved()
            ->with(['user', 'flavors', 'reviews'])
            ->latest()
            ->paginate(12);

        return view('public.recipes.index', compact('recipes'));
    }
}
```

### 2. Tambahkan route

```php
// routes/web.php (di section Public Routes)
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
```

### 3. Bikin view

```blade
{{-- resources/views/public/recipes/index.blade.php --}}
@extends('layouts.main')

@section('title', 'Semua Resep')

@section('content')
    <x-page-header title="Semua Resep"
                   description="Resep dari komunitas Dapurloka."
                   icon="ph-fill ph-bowl-food"
                   iconBg="#FBE4E4" iconFg="#BE4D52" />

    @if ($recipes->isEmpty())
        <div class="flex flex-col items-center justify-center py-12 text-[#73726E] text-sm">
            <i class="ph-duotone ph-bowl-food text-4xl text-[#E9E9E7] mb-2"></i>
            <p class="italic">Belum ada resep.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($recipes as $recipe)
                <x-card-recipe :recipe="$recipe" :href="route('recipes.show', $recipe)" />
            @endforeach
        </div>
        <div class="mt-6">{{ $recipes->links() }}</div>
    @endif
@endsection
```

Done. Page-header + card components sudah handle styling Notion.

---

## AI Agent (Dapur AI)

### Setup

`.env` sudah punya:

```env
GEMINI_API_KEY=...
```

Default provider untuk text di `config/ai.php` masih `openai`. Kita override per-agent
pakai attribute:

```php
#[Provider('gemini')]
#[Model('gemini-3.1-flash-lite')]
class CulinaryAgent implements Agent, HasStructuredOutput { ... }
```

### Cara kerja `aiSuggest`

1. Controller ambil 20 resep approved + 20 restoran (dengan eager loading).
2. Compose prompt: kondisi user + daftar `id | judul | flavor` masing-masing.
3. Agent return JSON terstruktur: `{intro, recipe_ids, restaurant_ids, closing}`.
4. Controller filter collection berdasarkan ID yang dipilih AI.
5. View render `<x-card-recipe>` dan `<x-card-restaurant>` dari hasil filter.

### Best practice

- Satu agent = satu use case. Jangan mix-in.
- Untuk fitur AI baru, bikin file baru di `app/Ai/Agents/`.
- Selalu wrap call agent dengan `try/catch` — Gemini free tier kadang return
  "overloaded".

---

## Troubleshooting

### `pnpm install` gagal di Windows

Pastikan pakai pnpm 10+. Update via `npm install -g pnpm@latest`.

### Bisakah pakai `npm install` saja?

**Tidak disarankan.** Lihat catatan di section [Prasyarat](#prasyarat). Aturan
project ini wajib pnpm. Kalau terlanjur jalan `npm install`, hapus
`package-lock.json` dan folder `node_modules`, lalu jalankan `pnpm install`.

### Build Vite error tentang Phosphor

Path import harus pakai exports map:
`@import '@phosphor-icons/web/regular';` (bukan `/src/regular/style.css`).

### Login bouncing kembali ke `/login`

Cek `SESSION_DRIVER=database` di `.env` dan tabel `sessions` sudah ada (otomatis
dibuat oleh migrasi awal).

### Gambar tidak muncul

Pastikan sudah jalan `php artisan storage:link`. Symlink akan dibuat di
`public/storage` → `storage/app/public`.

### Static analyzer error di file `vendor/laravel/ai/...`

False positive (PHP analyzer tidak resolve magic methods dari trait).
`.vscode/settings.json` sudah saya konfigurasi untuk skip folder vendor.
Reload window: `Ctrl+Shift+P` → `Developer: Reload Window`.

### "AI provider [gemini] is overloaded"

Free-tier Gemini overloaded. Tunggu sebentar dan coba lagi. Sudah ada
`try/catch` — user akan melihat banner error sopan, bukan crash.

---

## Dokumen rancangan

Detail spesifikasi ada di folder `docs/`:

- `prd.md` — Product Requirements Document
- `database.md` — Schema & ERD
- `technical.md` — Standar coding & batasan teknis
- `design.md` — Visual & UI guidelines
- `layout.md` — Struktur layout & komponen Blade

Selamat melanjutkan! 🍳
