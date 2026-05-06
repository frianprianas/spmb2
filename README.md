# SPMB System - Laravel 8 + Inertia.js + Vue 3

Sistem Penerimaan Mahasiswa Baru (SPMB) menggunakan Laravel 8, Inertia.js, dan Vue 3.

## 🚀 Quick Start

### Development Mode
```bash
# Double click:
start-dev.bat

# Atau manual:
cd backend
php artisan serve      # Terminal 1
npm run dev            # Terminal 2
```

### URLs
- Admin: http://127.0.0.1:8000/admin/login
- Keuangan: http://127.0.0.1:8000/keuangan/login
- Siswa: http://127.0.0.1:8000/siswa/register

## 👥 Login Credentials

**Admin:** `admin@smkbaktinusantara666.sch.id` / `password`  
**Keuangan:** `keuangan@smkbaktinusantara666.sch.id` / `password`

## 🎨 Menambah UI Baru

**Baca:** [INERTIA_UI_GUIDE.md](INERTIA_UI_GUIDE.md)

**Steps:**
1. Buat `.vue` di `backend/resources/js/Pages/`
2. Buat Controller di `backend/app/Http/Controllers/Web/`
3. Tambah route di `backend/routes/web.php`
4. Build: `npm run build`

## 📁 Struktur
```
backend/
├── resources/js/
│   ├── Layouts/     # AdminLayout, KeuanganLayout, StudentLayout
│   └── Pages/       # Vue components per role
├── routes/web.php   # Inertia routes
└── vite.config.js   # Build config
```

## 🛠 Tech Stack
- Laravel 8 + PostgreSQL
- Inertia.js v1.3 + Vue 3
- Vite 7 + Tailwind CSS
- Session-based auth (no tokens!)

## ✅ Features
- Admin: Dashboard, CRUD Jurusan, Lihat Siswa
- Keuangan: Verifikasi Pembayaran
- Siswa: Register, Dashboard

## 🗑️ Angular Dihapus
Folder `/frontend` (Angular 17) sudah tidak dipakai.  
Semuanya sekarang di `/backend/resources/js`.

---
**No more 401 errors!** 🎉
