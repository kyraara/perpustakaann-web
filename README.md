<p align="center">
  <img src="https://img.icons8.com/3d-fluency/94/book-shelf.png" width="100" alt="Library Logo">
</p>

<h1 align="center">📚 Perpustakaan Web</h1>

<p align="center">
  <strong>Sistem Manajemen Perpustakaan Digital Modern</strong>
</p>

<p align="center">
  <a href="#"><img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel"></a>
  <a href="#"><img src="https://img.shields.io/badge/Tailwind_CSS-4.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS"></a>
  <a href="#"><img src="https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white" alt="Alpine.js"></a>
  <a href="#"><img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP"></a>
</p>

<p align="center">
  <a href="#-fitur">Fitur</a> •
  <a href="#-tech-stack">Tech Stack</a> •
  <a href="#-instalasi">Instalasi</a> •
  <a href="#-screenshot">Screenshot</a> •
  <a href="#-lisensi">Lisensi</a>
</p>

---

## ✨ Fitur

### 👨‍💼 Multi-Role User Management
- **Admin** - Kelola seluruh sistem perpustakaan
- **Kepala Sekolah** - Monitoring dan laporan
- **Siswa** - Peminjaman dan pengembalian buku

### 📖 Manajemen Buku
- ✅ CRUD Buku dengan kategori dan rak
- ✅ Upload cover buku
- ✅ Pencarian dan filter buku
- ✅ Stok dan ketersediaan buku

### 🔄 Sistem Peminjaman
- ✅ Peminjaman buku oleh siswa
- ✅ Tracking status peminjaman
- ✅ Notifikasi keterlambatan
- ✅ Riwayat peminjaman

### 📊 Laporan & Statistik
- ✅ Dashboard dengan statistik real-time
- ✅ Export laporan ke PDF & Excel
- ✅ Grafik peminjaman

### 🔐 Autentikasi
- ✅ Login dengan email/password
- ✅ Login dengan Google OAuth
- ✅ Multi-role authentication

---

## 🛠 Tech Stack

| Kategori | Teknologi |
|----------|-----------|
| **Backend** | Laravel 12, PHP 8.2+ |
| **Frontend** | Blade, Tailwind CSS 4, Alpine.js |
| **Database** | MySQL / MariaDB |
| **Authentication** | Laravel Breeze, Socialite (Google OAuth) |
| **PDF Export** | DomPDF |
| **Excel Export** | Maatwebsite Excel |
| **Build Tool** | Vite |

---

## 🚀 Instalasi

### Prerequisites

Pastikan sudah terinstall:
- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL / MariaDB

### Quick Start

```bash
# 1. Clone repository
git clone https://github.com/kyraara/perpustakaann-web.git
cd perpustakaann-web

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env
# DB_DATABASE=perpustakaan_db
# DB_USERNAME=root
# DB_PASSWORD=

# 5. (Optional) Konfigurasi Google OAuth di .env
# GOOGLE_CLIENT_ID=your_client_id
# GOOGLE_CLIENT_SECRET=your_client_secret
# GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

# 6. Migrasi database
php artisan migrate --seed

# 7. Build assets
npm run build

# 8. Jalankan server
php artisan serve
```

### Development Mode

```bash
# Jalankan server + vite + queue secara bersamaan
composer dev
```

---

## 📸 Screenshot

<details>
<summary>📱 Lihat Screenshot</summary>

| Halaman | Preview |
|---------|---------|
| **Homepage** | Coming soon |
| **Dashboard Admin** | Coming soon |
| **Manajemen Buku** | Coming soon |
| **Peminjaman** | Coming soon |

</details>

---

## 📁 Struktur Folder

```
perpustakaan/
├── app/
│   ├── Http/Controllers/    # Controllers
│   ├── Models/              # Eloquent Models
│   └── ...
├── resources/
│   ├── views/
│   │   ├── admin/           # Views untuk Admin
│   │   ├── siswa/           # Views untuk Siswa
│   │   ├── kepala-sekolah/  # Views untuk Kepala Sekolah
│   │   └── components/      # Blade Components
│   └── css/
├── routes/
│   └── web.php              # Web Routes
├── database/
│   ├── migrations/          # Database Migrations
│   └── seeders/             # Database Seeders
└── ...
```

---

## 🔧 Konfigurasi

### Environment Variables

| Variable | Deskripsi |
|----------|-----------|
| `APP_NAME` | Nama aplikasi |
| `DB_*` | Konfigurasi database |
| `GOOGLE_CLIENT_ID` | Google OAuth Client ID |
| `GOOGLE_CLIENT_SECRET` | Google OAuth Client Secret |
| `GOOGLE_REDIRECT_URI` | Google OAuth Redirect URI |

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan:

1. Fork repository ini
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

---

## 📝 Lisensi

Distributed under the MIT License. See `LICENSE` for more information.

---

<p align="center">
  Made with ❤️ using Laravel
</p>
