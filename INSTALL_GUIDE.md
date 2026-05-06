# 🚀 Panduan Instalasi Cepat SPMB SMK Bakti Nusantara 666

## ⚡ Cara Tercepat (Menggunakan Script Otomatis)

### 1. Pastikan Prerequisites Terinstall:
- ✅ PostgreSQL (dengan password: buhun666)
- ✅ PHP 8.1+ & Composer
- ✅ Node.js 18+

### 2. Buat Database PostgreSQL

Buka Command Prompt atau PowerShell dan jalankan:
```bash
psql -U postgres -c "CREATE DATABASE spmb_smk;"
```

Masukkan password PostgreSQL Anda ketika diminta.

### 3. Jalankan Script Instalasi

Buka PowerShell di folder project, lalu jalankan:
```powershell
.\install.ps1
```

Script ini akan otomatis:
- Install semua dependencies (Composer & npm)
- Setup Laravel (key generate, migrate, seed)
- Setup Angular

### 4. Jalankan Aplikasi

Setelah instalasi selesai, jalankan:
```powershell
.\start.ps1
```

Atau manual di 2 terminal terpisah:

**Terminal 1 (Backend):**
```bash
cd backend
php artisan serve
```

**Terminal 2 (Frontend):**
```bash
cd frontend
npm start
```

### 5. Buka Browser

Buka: **http://localhost:4200**

---

## 📋 Instalasi Manual (Step by Step)

### Backend Setup

```bash
# 1. Masuk ke folder backend
cd backend

# 2. Install dependencies
composer install

# 3. Generate key
php artisan key:generate

# 4. Buat database (jalankan di psql)
psql -U postgres -c "CREATE DATABASE spmb_smk;"

# 5. Jalankan migrasi
php artisan migrate

# 6. Seed data jurusan
php artisan db:seed --class=JurusanSeeder

# 7. Buat storage link
php artisan storage:link

# 8. Jalankan server
php artisan serve
```

### Frontend Setup

```bash
# 1. Masuk ke folder frontend
cd frontend

# 2. Install dependencies
npm install

# 3. Jalankan development server
npm start
```

---

## 🎓 Data Jurusan yang Tersedia

Setelah seeding, akan ada 5 kompetensi keahlian:

1. **RPL** - Rekayasa Perangkat Lunak
2. **DKV** - Desain Komunikasi Visual
3. **ANM** - Animasi
4. **AKT** - Akuntansi dan Keuangan Lembaga
5. **PM** - Pemasaran

---

## 🔧 Troubleshooting

### Error: "SQLSTATE[08006] [7] could not connect"
**Solusi:** 
- Pastikan PostgreSQL berjalan
- Cek password di file `.env` (default: buhun666)
- Pastikan database `spmb_smk` sudah dibuat

### Error: "Cross-Origin Request Blocked"
**Solusi:**
- Pastikan backend berjalan di port 8000
- Pastikan frontend berjalan di port 4200
- CORS sudah dikonfigurasi otomatis

### Error: "npm ERR! code ENOENT"
**Solusi:**
- Hapus folder `node_modules` dan file `package-lock.json`
- Jalankan `npm install` lagi

### Error: "composer: command not found"
**Solusi:**
- Install Composer dari: https://getcomposer.org/download/
- Restart terminal setelah instalasi

---

## 📱 Cara Menggunakan Aplikasi

### Untuk Calon Siswa:

1. **Registrasi**
   - Buka http://localhost:4200
   - Klik "Daftar di sini"
   - Isi form registrasi
   - Catat nomor pendaftaran yang diberikan

2. **Login**
   - Login dengan email dan password yang didaftarkan

3. **Upload Bukti Pembayaran**
   - Di dashboard, klik "Upload Bukti"
   - Upload foto/scan bukti transfer
   - Tunggu verifikasi admin

4. **Isi Formulir Lengkap**
   - Setelah pembayaran terverifikasi
   - Klik "Isi Formulir"
   - Lengkapi semua data
   - Upload dokumen yang diperlukan

5. **Cek Status**
   - Monitor status di dashboard
   - Tunggu pengumuman

---

## 🔑 Default Configuration

### Database
- Host: 127.0.0.1
- Port: 5432
- Database: spmb_smk
- Username: postgres
- Password: buhun666

### Backend API
- URL: http://localhost:8000
- API Endpoint: http://localhost:8000/api

### Frontend
- URL: http://localhost:4200

---

## 📞 Support

Jika mengalami masalah, pastikan:
1. Semua prerequisites sudah terinstall
2. PostgreSQL service sudah running
3. Port 8000 dan 4200 tidak digunakan aplikasi lain
4. File `.env` di backend sudah sesuai

---

**Selamat menggunakan SPMB SMK Bakti Nusantara 666! 🎉**
