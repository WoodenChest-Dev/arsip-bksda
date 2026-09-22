# PRODUCT REQUIREMENT DOCUMENT (PRD)

## 1. JUDUL SYSTEM & OVERVIEW
- **Nama Sistem**: Sistem Informasi Manajemen & Autoparsing Arsip Laporan Digital (SIM-ARSIP BALAI KSDA)
- **Tujuan**: Mempermudah pencatatan, ekstraksi otomatis (PDF/Excel), pencarian multi-kategori, visualisasi statistik, dan ekspor kustom arsip laporan resmi agar efisien dan ramah pengguna awam.
- **Isolasi Data**: Multi-User Data Isolation (Setiap akun user hanya dapat melihat dan mengelola data miliknya sendiri).

---

## 2. SKEMA DATABASE & METADATA (Berdasarkan Standar Arsip BKSDA)
Seluruh tabel menggunakan Bahasa Indonesia dengan *Primary Key* terisolasi `user_id`.

### A. Tabel Utama: `laporan`
- `id` (Primary Key)
- `user_id` (Foreign Key -> users.id, Isolasi Akun)
- `nomor_arsip` (String, e.g., "UM/KSDA DKI/2001")
- `kode_klasifikasi` (String, e.g., "KSA 2.2")
- `index_arsip` (String, e.g., "Rencana Kerja Tahunan CV. FALCON")
- `ringkasan_jenis_arsip` (Text, Hasil Parsing/Rangkuman Algoritma Ringkas)
- `tingkat_perkembangan` (Enum/String, e.g., "Asli", "Copy")
- `kurun_waktu` (String/Year, e.g., "2001", "2005 - 2007")
- `jumlah_satuan` (Integer/String, e.g., "1 Jilid")
- `kondisi` (String, e.g., "Baik", "Rusak")
- `lokasi_box` (String, e.g., "Box 203/Ruang Arsip BKSDA Jakarta")
- `keterangan_nasib_akhir` (String, e.g., "MUSNAH", "PERMANEN")
- `kategori_id` (Foreign Key -> kategori_laporan.id)
- `sub_kategori_id` (Foreign Key -> sub_kategori_laporan.id)
- `tanggal_dokumen` (Date, Display Format: `DD-MM-YYYY`)
- `file_path` (String, Path Dokumen Asli PDF/Excel)
- `deleted_at` (Timestamp, Nullable - Soft Deletes Support)

### B. Tabel Dynamic Category: `kategori_laporan` & `sub_kategori_laporan`
- `id`, `user_id`, `nama_kategori`
- `id`, `user_id`, `kategori_id`, `nama_sub_kategori` (Termasuk user_id untuk Isolasi Akun)

### C. Tabel Pengaturan Instansi: `pengaturan_instansi`
- `id`, `user_id`, `nama_instansi`, `alamat`, `nomor_telepon`, `logo_path`

---

## 3. SPESIFIKASI FITUR & USER EXPERIENCE (UX)

### X. Tema Warna & Tipografi (Brand Identity Balai KSDA)

Seluruh UI/UX harus konsisten dengan panduan visual berikut sebagai representasi identitas visual resmi Balai KSDA.

### Y. Spesifikasi Layout & Wireframe Visual (Global UI)

#### 1. Halaman Login (`/admin/login`) — Split-Screen Modern Layout
- **Layout Structure**: Split-Screen 2 Kolom (Responsif Desktop & Mobile).
- **Kolom Kiri (Brand & Info Section)**:
  - Background: Foto balai KSDA jakarta (nanti minta aja ke saya fotonya). warna di pergelap dan blur tipis
  - Elemen: Logo Balai KSDA (Besar) + Judul Utama (`ARSIP BALAI KSDA`) + Penjelasan Ringkas Sistem (1–2 kalimat singkat mengenai fungsi aplikasi).
- **Kolom Kanan (Form Input Section)**:
  - Background: Clean White (`#FFFFFF`) / Soft Neutral (`#F8FAFC`).
  - Elemen: Form Header (`Login Ke Akun Anda`), Field Email, Field Password (dengan toggle eye show/hide), Checkbox `Ingat Saya`, dan Tombol Submit `MASUK`.
- **Mobile Behavior**: Pada layar HP, kolom kiri secara otomatis ciut/menjadi header ringkas di atas form login.

#### 2. Main Layout Dashboard (`/admin`) — Fixed Sidebar & Top Navbar
- **Header Top Navbar**:
  - Sisi Kiri: Logo Balai KSDA (35px) + Teks Branding `ARSIP BALAI KSDA` (Font: Plus Jakarta Sans, Bold 16px).
  - Sisi Kanan: Icon Notifikasi Bell & Quick Profile / Theme Mode Switcher.
- **Left Sidebar Navigation**:
  - Grouping Menu: Dashboard Analytics, Data Laporan, Kategori & Sub, Auto-Parsing (PDF/Excel), Trash, Activity Logs, Pengaturan Instansi.
  - Bottom Sidebar Section: Tombol Logout terisolasi di bagian paling bawah sidebar.
- **Main Workspace Area (Dashboard View)**:
  - Layout Grid 2 Kolom (Kiri & Kanan).
  - Kolom Kiri (Widget Card Stats): 3 Buah Card Stacked Vertikal untuk menampilkan statistik cepat (Total Laporan, Total Musnah, Total Permanen).
  - Kolom Kanan (Recent Data / Analytics): Tabel preview 5-10 laporan terbaru atau Chart Grafik Distribusi Arsip.

#### 1. Konsep Tampilan
- **Clean & Minimalist**: Dominan putih/neutral agar tampilan rapi, profesional, dan tidak melelahkan mata untuk penggunaan sehari-hari.
- Tidak ada elemen dekoratif berlebihan — fokus pada kejelasan konten dan kemudahan navigasi.

#### 2. Palet Warna (Brand Logo Balai KSDA)
| Kategori | Warna | Kode | Penggunaan |
|---|---|---|---|
| **Primary** | Forest Green | `#008A3C` | Tombol utama, link aktif, aksen sidebar, highlight navigasi |
| **Secondary / Accent** | Earth Gold | `#A87B18` | Badge status, label kategori, elemen sekunder |
| **Background Light** | Clean White | `#FFFFFF` | Background utama panel/form |
| **Background Light** | Soft Neutral | `#F8FAFC` / `#F4F7F5` | Background card, sidebar, tabel alternatif |
| **Background Dark** | Dark Jungle | `#0F172A` / `#1B2A20` | Background dark mode (opsional) |
| **Text Primary** | Charcoal | `#1E293B` | Teks utama, judul, label form |
| **Text Secondary** | Slate | `#64748B` | Teks deskripsi, placeholder, helper text |
| **Border / Divider** | Light Gray | `#E2E8F0` | Garis pemisah, border tabel, card |

> **Catatan Penting**: Semua warna harus diterapkan via Filament Panel Theme Configuration dan Tailwind CSS custom config — **bukan inline style** — agar konsisten di seluruh halaman dan mendukung responsive layout.

#### 3. Tipografi
| Elemen | Font | Bobot | Ukuran (default) |
|---|---|---|---|
| **Heading (H1–H3)** | Plus Jakarta Sans | 700 (Bold) | H1: 24px, H2: 20px, H3: 16px |
| **Body Text** | Plus Jakarta Sans | 400 (Regular) | 14px |
| **Label / Caption** | Plus Jakarta Sans | 500 (Medium) | 12px |
| **Button / Badge** | Plus Jakarta Sans | 600 (SemiBold) | 14px |

- **Sumber**: Google Fonts (`https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap`)
- **Fallback stack**: `'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, sans-serif`

> **Filament Integration**: Font dikonfigurasi melalui `->font()` di `AdminPanelProvider` dan CSS custom Tailwind, sehingga otomatis diterapkan ke seluruh komponen Filament (forms, tables, navigation, widgets).

---

### A. Modul Upload & Auto-Parsing Excel (Flexible Sheet Reader)
1. **Multi-Sheet Reading**: System membaca seluruh *Sheet* pada file `.xlsx` / `.xls` yang di-upload.
2. **Flexible Mapping Preview**:
   - Tampil halaman *Preview Data & Column Mapping Table* sebelum simpan DB.
   - User dapat mencocokkan/mengoreksi kolom Excel ke metadata database.

### B. Modul Upload & Auto-Parsing PDF (Native Text Parser)
1. **Strict Text Only**: Hanya menerima PDF berbasis teks (bukan scan image PDF).
2. **Pattern & Code Extraction (Regex)**: Ekstrak otomatis nomor arsip/kode unik berformat dinamis (e.g., `4/skw/23-dl/2006` atau `S. 673 /K.13/TU/TSL/05/2021`).
3. **Algoritma Ringkasan Teks**: Meringkas dokumen panjang menjadi 1–2 kalimat standar kantor.

### C. Modul Duplicate Checker (Validasi Berkas Ganda)
1. **Real-time Alert**: Sistem mengecek `nomor_arsip` dan `kode_klasifikasi` saat upload/parsing.
2. **Warning System**: Menampilkan peringatan jika menemukan data ganda agar user memilih skip, update, atau tetap simpan.

### D. Modul Filter & Search (Modal Bubble Filter UX)
1. **Global Flexible Search Bar**: Mencari bebas pada `nomor_arsip`, `index_arsip`, `ringkasan_jenis_arsip`, atau `kode_klasifikasi`.
2. **Pop-Up Bubble Filter**: Tombol/bubble **"Filter Arsip"** memicu modal filter (Multi-Kategori, Rentang Kurun Waktu, Kondisi, Lokasi Box).

### E. Modul Custom Export (Dynamic Multi-Select PDF & Excel)
1. **Checkbox Selection**: Memilih daftar laporan spesifik yang ingin di-export.
2. **Column Selector Modal**: Memilih kolom spesifik untuk dimasukkan ke file export.
3. **Official Kop Surat Header**: File export dilengkapi header instansi dinamis di bagian atas tabel.

### F. Modul Dashboard Analytics & Statistik
1. **Visual Widget Cards**: Statistik Total Laporan, Total Musnah, Total Permanen, Dokumen Bulan Ini.
2. **Charts**: Diagram distribusi arsip per kategori & tren pembuatan laporan per kurun waktu.

### G. Modul Bulk Action, Trash & Activity Logs
1. **Soft Deletes & Trash**: Laporan terhapus masuk folder Tong Sampah dan dapat di-restore.
2. **Activity Logs**: Mencatat log aktivitas user (Upload, Edit, Delete, Export).
3. **Pengaturan Instansi**: Form kustomisasi Logo, Nama Instansi, & Alamat untuk Kop Surat.

---

## 4. FLOW PENGEMBANGAN SOFTWARE (MODULAR & INCREMENTAL)

#### TAHAP 1: Database Migration & Multi-User Isolation Schema
- **Target File**: `database/migrations/*`
- **Spesifikasi Migration**:
  1. `users`: Standard Auth Laravel (`id`, `name`, `email`, `password`, `created_at`).
  2. `pengaturan_instansi`: `id`, `user_id` (FK, Unique), `nama_instansi`, `alamat`, `nomor_telepon`, `logo_path`.
  3. `kategori_laporan`: `id`, `user_id` (FK), `nama_kategori`.
  4. `sub_kategori_laporan`: `id`, `user_id` (FK), `kategori_id` (FK), `nama_sub_kategori`.
  5. `laporan`: `id`, `user_id` (FK), `kategori_id` (FK), `sub_kategori_id` (FK), `nomor_arsip`, `kode_klasifikasi`, `index_arsip`, `ringkasan_jenis_arsip` (Text), `tingkat_perkembangan` (Enum: Asli/Copy), `kurun_waktu`, `jumlah_satuan`, `kondisi`, `lokasi_box`, `keterangan_nasib_akhir`, `tanggal_dokumen` (Date), `file_path`, `deleted_at` (SoftDeletes).
- **Aturan Guardrails**: Seluruh Foreign Key (`user_id`) wajib `onDelete('cascade')`. Dilarang menggunakan `migrate:fresh`.

---

#### TAHAP 2: Setup Admin Dashboard Filament UI, Layout Responsive, & Auth Isolation
- **Target File**: `app/Providers/Filament/AdminPanelProvider.php`, Custom Login Class, Theme Config.
- **Visual & Layout Implementation**:
  - Halaman Login: Split-Screen Layout (Sisi Kiri: Branding Green `#008A3C` + Logo + Teks Info; Sisi Kanan: Form Input White `#FFFFFF`).
  - Top Navbar: Logo Balai KSDA (35px) + Teks Branding `ARSIP BALAI KSDA` (Plus Jakarta Sans, Bold).
  - Main Workspace Dashboard: Layout Grid (3 Widget Cards Stacked di Kiri, Recent Reports Table / Chart di Kanan).
  - Left Sidebar: Menu Navigasi Rapi + Tombol Logout terpisah di bagian paling bawah sidebar.
  - Color Palette: Primary `#008A3C`, Secondary `#A87B18`, Font `Plus Jakarta Sans`.
- **Aturan Isolation**: Mengaktifkan Tenant/User Isolation berbasis `auth()->id()`. Dual Theme (Light/Dark Mode).

---

#### TAHAP 3: Fitur Upload & Preview Parser (Excel Multi-Sheet & PDF Text Extractor)
- **Target File**: `app/Filament/Resources/LaporanResource/Pages/*`, Custom Parser Services.
- **Fitur Upload & Parsing**:
  - **Excel Reader**: Mampu membaca seluruh sheet pada file `.xlsx` / `.xls`.
  - **PDF Text Reader**: Meringkas dokumen PDF berbasis teks menjadi 1–2 kalimat rangkuman standar kantor dan mengekstrak pattern nomor/kode unik via Regex.
  - **Mapping & Preview Table**: Menampilkan modal/halaman preview data hasil ekstraksi sebelum disimpan resmi ke database MySQL.

---

#### TAHAP 4: Modul Duplicate Checker (Validasi Berkas Ganda)
- **Target File**: Custom Validation Rule / Observer pada Modul Upload.
- **Spesifikasi Logic**:
  - Real-time Alert/Check saat proses parsing atau input manual jika ditemukan kecocokan `nomor_arsip` dan `kode_klasifikasi` milik `user_id` yang sama.
  - Pilihan Aksi: User dapat memilih **Skip (Abaikan)**, **Overwrite/Update Data Lama**, atau **Simpan Sebagai Duplikat**.

---

#### TAHAP 5: UI Global Search Bar & Modal Bubble Filter
- **Target File**: `app/Filament/Resources/LaporanResource.php` (Table Actions & Filters).
- **Spesifikasi Search & Filter**:
  - **Global Search Bar**: Pencarian cepat multi-kolom (`nomor_arsip`, `index_arsip`, `ringkasan_jenis_arsip`, `kode_klasifikasi`).
  - **Modal Bubble Filter**: Pop-up modal filter rapi untuk memilih Kategori, Sub-Kategori, Rentang Kurun Waktu, Kondisi Berkas, dan Lokasi Box.

---

#### TAHAP 6: Selection Checkbox & Custom Column Export (PDF Kop Surat & Excel)
- **Target File**: Filament Bulk Actions, Export Service.
- **Spesifikasi Export**:
  - Checkbox selection pada tabel laporan untuk memilih data tertentu yang ingin di-export.
  - Modal pemilih kolom: User bisa mencentang kolom apa saja yang mau dicetak.
  - Fitur Export PDF dilengkapi Header **Kop Surat Resmi Instansi** dinamis dari tabel `pengaturan_instansi`.
  - Fitur Export Excel berformat `.xlsx` terstruktur rapi.

---

#### TAHAP 7: Dashboard Analytics & Visual Charts Widget
- **Target File**: `app/Filament/Widgets/*`
- **Spesifikasi Visual**:
  - 3 Buah Widget Cards Stacked di Kiri: Total Arsip, Total Berkas Musnah, Total Berkas Permanen.
  - Interactive Chart (Bar/Pie Chart): Distribusi Laporan per Kategori & Tren Arsip per Kurun Waktu.

---

#### TAHAP 8: Tong Sampah (Soft Deletes) & Pembersihan Massal (Bulk Actions)
- **Target File**: `app/Filament/Resources/LaporanResource/Pages/ListLaporan.php` (Trashed Filter).
- **Spesifikasi Trash**:
  - Filter khusus untuk melihat data di Tong Sampah (`onlyTrashed`).
  - Fitur Restore Data (Mengembalikan data terhapus) & Permanent Delete.
  - Bulk Actions: Hapus massal / Restore massal menggunakan checkbox.

---

#### TAHAP 9: Activity Logs (Riwayat Aktivitas User)
- **Target File**: Spatie Activitylog Integration / Custom Log Resource.
- **Spesifikasi Logs**:
  - Mencatat riwayat aksi user (`CREATE`, `UPDATE`, `DELETE`, `PARSING`, `EXPORT`).
  - Menampilkan nama user, jenis aksi, timestamp, dan detail berkas yang disentuh.

---

#### TAHAP 10: Halaman Pengaturan Instansi & Logo Kop Surat Dinamis
- **Target File**: `app/Filament/Pages/PengaturanInstansi.php`
- **Spesifikasi Form**:
  - Form khusus mengelola Identitas Instansi (Nama Instansi, Alamat Lengkap, Nomor Telepon).
  - File Upload Logo Instansi (PNG/JPG) yang otomatis terintegrasi ke Kop Surat PDF Export dan Header Dashboard.