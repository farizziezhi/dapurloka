# Visual & UI Design Guidelines (design.md) - Dapurloka

## 1. Filosofi Desain (Notion-esque Style)
Antarmuka Dapurloka mengadopsi gaya visual ala **Notion**: minimalis, bersih, berfokus pada tipografi, dan banyak menggunakan ruang kosong (*whitespace*). Desain harus terasa ringan dan terstruktur seperti sebuah dokumen modern, meminimalisir elemen dekoratif yang tidak perlu.

## 2. Palet Warna (Strict: RGB Only)
**ATURAN MUTLAK:** Semua kode warna dan pengolahan aset visual (termasuk logo) **wajib menggunakan profil RGB**. Dilarang keras menggunakan profil warna CMYK. 

Gunakan referensi warna (Custom HEX di Tailwind) berikut untuk menjaga konsistensi gaya Notion:
* **Background Utama:** `#FFFFFF` (Putih murni untuk area konten).
* **Background Sidebar/Sekunder:** `#F7F7F5` (Off-white/krem sangat terang).
* **Teks Utama (Primary Text):** `#37352F` (Abu-abu sangat gelap, jangan gunakan hitam `#000000` murni).
* **Teks Sekunder (Muted/Placeholder):** `#73726E`.
* **Borders/Dividers:** `#E9E9E7` (Abu-abu terang untuk garis pemisah yang halus).
* **Aksen (Links & Primary Action):** `#2383E2` (Biru bersih).
* **Rating Star (Filled):** `#EAB308` (Kuning keemasan yang solid namun tidak menyilaukan).
* **Status Approved (Success):** `#0F7B6C` (Hijau gelap).
* **Status Pending (Warning):** `#D9730D` (Oranye).
* **Status Rejected (Danger):** `#EB5757` (Merah).

## 3. Tipografi & Spasi
* **Font Family:** Gunakan sans-serif bawaan Tailwind (`font-sans`), yang otomatis merender Inter, sistem UI font Apple, atau Segoe UI.
* **Hierarki Teks:**
    * Judul Halaman (H1): `text-2xl font-bold text-[#37352F] tracking-tight`.
    * Sub-judul (H2/H3): `text-lg font-semibold text-[#37352F]`.
    * Body Text: `text-sm` atau `text-base` dengan `leading-relaxed` atau `leading-6`.
* **Whitespace:** Maksimalkan penggunaan `gap-x`, `gap-y`, dan `p-x` di Tailwind. Beri ruang agar elemen tidak terlihat menumpuk.

## 4. Panduan Komponen UI (Tailwind Classes)
AI Agent wajib mengikuti panduan gaya elemen berikut:

### 4.1. Cards (Resep & Restoran)
* Hindari penggunaan bayangan tebal (`shadow-lg`, `shadow-xl`).
* Gaya Notion mengandalkan border tipis.
* **Class:** `bg-white border border-[#E9E9E7] rounded-md p-4 hover:bg-[#F7F7F5] transition-colors`.

### 4.2. Buttons (Tombol)
* Sudut tidak terlalu membulat (gunakan `rounded-md`, bukan `rounded-full`).
* **Primary Button:** `bg-[#2383E2] text-white px-3 py-1.5 rounded-md text-sm font-medium hover:bg-blue-600 transition-colors`.
* **Secondary Button:** `bg-white border border-[#E9E9E7] text-[#37352F] px-3 py-1.5 rounded-md text-sm font-medium hover:bg-[#F7F7F5] transition-colors`.
* **Danger Button (Delete/Reject):** `text-[#EB5757] hover:bg-red-50 px-3 py-1.5 rounded-md text-sm font-medium transition-colors`.

### 4.3. Form Inputs
* Input harus terlihat menyatu dengan background saat tidak aktif, dan memiliki *highlight* saat fokus.
* **Class:** `w-full border border-[#E9E9E7] rounded-md px-3 py-2 text-sm text-[#37352F] placeholder-[#73726E] focus:outline-none focus:border-[#2383E2] focus:ring-1 focus:ring-[#2383E2] transition-all`.

### 4.4. Badges / Tags (Untuk Flavors)
* Bentuk kapsul kecil atau kotak sudut tumpul untuk menampilkan tag "Pedas", "Manis", dll.
* **Class:** `inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-[#F7F7F5] text-[#73726E] border border-[#E9E9E7]`.

### 4.5. Empty States (Keadaan Kosong)
* Jika tidak ada resep atau ulasan, tampilkan teks simpel di tengah area.
* **Class:** `flex flex-col items-center justify-center py-12 text-[#73726E] text-sm italic`.

### 4.6. Rating Stars (Ulasan)
* Gunakan SVG inline berukuran kecil (`w-4 h-4` atau `w-5 h-5`).
* Susun menggunakan flexbox dengan *gap* kecil.
* **Bintang Terisi (Filled):** `text-[#EAB308] w-4 h-4 fill-current`.
* **Bintang Kosong (Empty):** `text-[#E9E9E7] w-4 h-4 fill-current`.
* **Container:** `flex items-center gap-0.5`.

## 5. Optimasi Aset Visual (Hardware Constraint)
Karena *environment development* menggunakan **HDD**, semua elemen visual tambahan harus sangat dioptimalkan:
* **Icons:** Gunakan SVG *inline* (seperti Lucide Icons atau Heroicons) dengan ukuran *file* yang kecil. Dilarang mengimpor *library icon font* yang berat.
* **Images:** Tampilkan gambar resep/restoran dengan *tag* `<img>` yang memiliki atribut `loading="lazy"` agar *browser* tidak memaksa *disk* membaca semua gambar sekaligus saat halaman dimuat. Berikan juga *class* `object-cover` agar gambar rapi di dalam *container*-nya.