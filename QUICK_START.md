# 🚀 QUICK START - SPMB SMK Bakti Nusantara 666

## ✅ Database Sudah Ready!

Database PostgreSQL `spmb_smk` sudah berhasil dibuat dengan:
- ✅ 5 Tabel (jurusan, calon_siswa, pembayaran, formulir_lengkap, personal_access_tokens)
- ✅ Data 5 Jurusan (RPL, DKV, Animasi, AKT, Pemasaran)

---

## 🎯 Menjalankan Aplikasi

### 1. Jalankan Backend (Terminal/CMD 1)

```bash
cd backend
php -S localhost:8000 -t public
```

**Backend API akan running di:** `http://localhost:8000`

### 2. Jalankan Frontend (Terminal/CMD 2)

```bash
cd frontend
npm install   # Hanya sekali, skip jika sudah install
npm start
```

**Frontend akan running di:** `http://localhost:4200`

### 3. Buka Browser

Buka: **http://localhost:4200**

---

## 📱 Cara Menggunakan Aplikasi

### Untuk Calon Siswa:

1. **Registrasi**
   - Klik "Daftar di sini"
   - Isi form pendaftaran
   - Pilih jurusan (RPL/DKV/Animasi/AKT/Pemasaran)
   - Submit → Dapat nomor pendaftaran

2. **Login**
   - Login dengan email & password yang didaftarkan

3. **Dashboard**
   - Lihat status pendaftaran
   - Upload bukti pembayaran
   - Isi formulir lengkap (setelah bayar diverifikasi)

---

## 🔑 Informasi Database

**Koneksi Database:**
- Host: 127.0.0.1
- Port: 5432
- Database: `spmb_smk`
- Username: `postgres`
- Password: `buhun666`

**Test Koneksi:**
```powershell
$env:PGPASSWORD="buhun666"
& "C:\Program Files\PostgreSQL\18\bin\psql.exe" -U postgres -d spmb_smk -c "SELECT * FROM jurusan;"
```

---

## 📊 Data Jurusan yang Tersedia

| Kode | Nama Jurusan | Kuota |
|------|-------------|-------|
| RPL | Rekayasa Perangkat Lunak | 36 |
| DKV | Desain Komunikasi Visual | 36 |
| ANM | Animasi | 36 |
| AKT | Akuntansi dan Keuangan Lembaga | 36 |
| PM | Pemasaran | 36 |

---

## 🔧 Troubleshooting

### Backend tidak bisa start?
```bash
# Pastikan di folder backend
cd backend

# Cek PHP version
php -v

# Jalankan server
php -S localhost:8000 -t public
```

### Frontend error?
```bash
cd frontend

# Clear cache dan reinstall
rm -r node_modules
rm package-lock.json
npm install
npm start
```

### Database error?
- Pastikan PostgreSQL running
- Cek password di `backend/.env` = `buhun666`
- Test dengan psql command di atas

### CORS error?
- Backend harus di port 8000
- Frontend harus di port 4200
- Jangan ganti port

---

## ⚠️ Catatan Penting

### Tentang PHP Version:
- PHP 8.0.30 (XAMPP) **tidak support** Laravel Artisan
- Gunakan `php -S localhost:8000 -t public` sebagai workaround
- **Recommended:** Update ke PHP 8.2+ untuk full features

### Untuk Admin (Verifikasi Pembayaran):
Manual via database:
```sql
-- Update status pembayaran menjadi verified
UPDATE calon_siswa 
SET status_pembayaran = 'sudah_bayar' 
WHERE email = 'email_siswa@example.com';

UPDATE pembayaran 
SET status = 'verified', 
    tanggal_verifikasi = NOW() 
WHERE calon_siswa_id = 1;
```

---

## 📞 Support

Jika ada masalah:
1. Baca `DATABASE_SETUP_SUCCESS.md` untuk detail lengkap
2. Cek `INSTALL_GUIDE.md` untuk troubleshooting
3. Pastikan PostgreSQL running
4. Pastikan port 8000 & 4200 tidak dipakai aplikasi lain

---

**Selamat mencoba! 🎉**

Backend: http://localhost:8000
Frontend: http://localhost:4200
