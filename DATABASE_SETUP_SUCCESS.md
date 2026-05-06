# ✅ Database SPMB Berhasil Dibuat!

## Status Setup Database

✅ **Database `spmb_smk` berhasil dibuat dan disetup!**

### Yang Sudah Selesai:
- ✅ Database `spmb_smk` dibuat
- ✅ Tabel `jurusan` dengan 5 kompetensi keahlian
- ✅ Tabel `calon_siswa` untuk data pendaftaran
- ✅ Tabel `pembayaran` untuk data pembayaran
- ✅ Tabel `formulir_lengkap` untuk data lengkap siswa
- ✅ Tabel `personal_access_tokens` untuk Laravel Sanctum

### Data Jurusan yang Tersedia:
1. **RPL** - Rekayasa Perangkat Lunak (Kuota: 36)
2. **DKV** - Desain Komunikasi Visual (Kuota: 36)
3. **ANM** - Animasi (Kuota: 36)
4. **AKT** - Akuntansi dan Keuangan Lembaga (Kuota: 36)
5. **PM** - Pemasaran (Kuota: 36)

---

## ⚠️ PENTING - Tentang PHP Version

**Masalah:** PHP 8.0.30 yang terinstall di XAMPP tidak support Laravel 10/11 yang membutuhkan PHP 8.1+

**Solusi Ada 2 Pilihan:**

### Pilihan 1: Update PHP (RECOMMENDED)
Download dan install PHP 8.2 atau 8.3:
- **PHP 8.2:** https://windows.php.net/download#php-8.2
- **PHP 8.3:** https://windows.php.net/download#php-8.3

Setelah install, update PATH Windows untuk menggunakan PHP baru.

### Pilihan 2: Gunakan Backend Sederhana (Workaround)
Karena database sudah jadi, Anda bisa:
1. Tetap gunakan struktur database yang sudah ada
2. Buat API sederhana dengan PHP native atau framework lain yang support PHP 8.0
3. Atau gunakan Laravel 9 (sudah saya setup di composer.json)

---

## 🚀 Cara Menjalankan Aplikasi

### Backend (API)

Karena Laravel artisan tidak bisa jalan di PHP 8.0, gunakan cara manual:

1. **Setup .env file:**
   File sudah ada di `backend/.env` dengan config:
   ```
   DB_CONNECTION=pgsql
   DB_DATABASE=spmb_smk
   DB_USERNAME=postgres
   DB_PASSWORD=buhun666
   ```

2. **Generate APP_KEY manually:**
   Buka `backend/.env` dan isi APP_KEY dengan random string base64:
   ```
   APP_KEY=base64:abcd1234xyz... (32 karakter random)
   ```
   
   Atau generate online di: https://generate-random.org/laravel-key-generator

3. **Jalankan server:**
   ```bash
   cd backend
   php -S localhost:8000 -t public
   ```

### Frontend (Angular)

Frontend bisa langsung dijalankan:

```bash
cd frontend
npm install
npm start
```

Frontend akan berjalan di: **http://localhost:4200**

---

## 🔧 Testing Database

Untuk mengecek database sudah benar:

```powershell
$env:PGPASSWORD="buhun666"
& "C:\Program Files\PostgreSQL\18\bin\psql.exe" -U postgres -d spmb_smk

# Di psql prompt:
\dt                    # Lihat semua tabel
SELECT * FROM jurusan; # Lihat data jurusan
\q                     # Keluar
```

---

## 📋 Struktur Database

### Tables:
1. **jurusan** - 5 kompetensi keahlian ✅
2. **calon_siswa** - Data pendaftaran siswa
3. **pembayaran** - Data pembayaran
4. **formulir_lengkap** - Data lengkap siswa
5. **personal_access_tokens** - Auth tokens (Laravel Sanctum)

---

## 🔑 Konfigurasi

### Database PostgreSQL:
- **Host:** 127.0.0.1
- **Port:** 5432
- **Database:** spmb_smk
- **Username:** postgres
- **Password:** buhun666

### API Endpoint (akan berjalan di):
- http://localhost:8000

### Frontend (Angular):
- http://localhost:4200

---

## 💡 Next Steps

1. **Generate APP_KEY** untuk Laravel (bisa manual atau online generator)
2. **Install PHP 8.2+** jika ingin full Laravel features
3. **Test backend API** dengan Postman atau browser
4. **Jalankan frontend** dan test aplikasi

---

## 📞 Troubleshooting

### Jika error "Could not open input file: artisan"
- Gunakan `php -S localhost:8000 -t public` instead

### Jika error koneksi database
- Pastikan PostgreSQL running
- Cek password di .env (buhun666)
- Test koneksi dengan psql command

### Jika CORS error di browser
- Pastikan backend di port 8000
- Pastikan frontend di port 4200
- Config CORS sudah ada di `backend/config/cors.php`

---

**Database sudah siap digunakan! 🎉**

Sekarang tinggal:
1. Generate APP_KEY di .env
2. Jalankan backend: `php -S localhost:8000 -t public`
3. Jalankan frontend: `npm start`
4. Buka: http://localhost:4200
