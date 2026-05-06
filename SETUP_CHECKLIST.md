# ✅ Checklist Setup SPMB SMK Bakti Nusantara 666

## Prerequisites Check

- [ ] PostgreSQL terinstall dan running
- [ ] PHP 8.1+ terinstall
- [ ] Composer terinstall
- [ ] Node.js 18+ terinstall
- [ ] npm terinstall
- [ ] Git (optional, untuk version control)

## Database Setup

- [ ] PostgreSQL service running
- [ ] Database `spmb_smk` sudah dibuat
- [ ] Password PostgreSQL: `buhun666` (atau sesuaikan di .env)
- [ ] Test koneksi database berhasil

## Backend Setup (Laravel)

- [ ] File `backend/.env` ada dan sudah dikonfigurasi
- [ ] Composer dependencies terinstall (`composer install`)
- [ ] Application key sudah digenerate (`php artisan key:generate`)
- [ ] Migrations sudah dijalankan (`php artisan migrate`)
- [ ] Seeder jurusan sudah dijalankan (`php artisan db:seed --class=JurusanSeeder`)
- [ ] Storage link sudah dibuat (`php artisan storage:link`)
- [ ] Server Laravel bisa running (`php artisan serve`)
- [ ] API accessible di http://localhost:8000/api

## Frontend Setup (Angular)

- [ ] npm dependencies terinstall (`npm install`)
- [ ] File `frontend/src/environments/environment.ts` ada
- [ ] Development server bisa running (`npm start`)
- [ ] Frontend accessible di http://localhost:4200
- [ ] Tidak ada error di browser console

## Testing API Endpoints

Test dengan Postman atau browser:

### Public Endpoints
- [ ] GET http://localhost:8000 → Menampilkan info aplikasi
- [ ] GET http://localhost:8000/api/jurusan → Menampilkan 5 jurusan

### Protected Endpoints (setelah register/login)
- [ ] POST http://localhost:8000/api/register → Berhasil registrasi
- [ ] POST http://localhost:8000/api/login → Berhasil login & dapat token
- [ ] GET http://localhost:8000/api/me → Menampilkan data user (dengan token)

## Testing Frontend

- [ ] Buka http://localhost:4200 → Redirect ke /login
- [ ] Halaman login tampil dengan baik
- [ ] Link ke register berfungsi
- [ ] Form registrasi tampil lengkap
- [ ] Dropdown jurusan menampilkan 5 pilihan
- [ ] Registrasi berhasil → dapat nomor pendaftaran
- [ ] Redirect ke dashboard setelah registrasi
- [ ] Dashboard menampilkan data user
- [ ] Status pembayaran, formulir, pendaftaran tampil
- [ ] Logout berfungsi → redirect ke login

## Testing Full Flow

### Flow Pendaftaran Siswa Baru:

1. **Registrasi**
   - [ ] Siswa buka http://localhost:4200
   - [ ] Klik "Daftar di sini"
   - [ ] Isi form registrasi lengkap
   - [ ] Pilih salah satu jurusan
   - [ ] Klik "Daftar"
   - [ ] Muncul alert dengan nomor pendaftaran
   - [ ] Auto-login dan redirect ke dashboard

2. **Dashboard**
   - [ ] Nama siswa tampil
   - [ ] Nomor pendaftaran tampil
   - [ ] Data pendaftaran tampil (email, HP, SMP, jurusan)
   - [ ] Status pembayaran: "Belum Bayar"
   - [ ] Status formulir: "Belum Diisi"
   - [ ] Status pendaftaran: "Pending"
   - [ ] Step 1 aktif (Upload Bukti)
   - [ ] Step 2 & 3 disabled

3. **Upload Bukti Pembayaran** (Jika sudah dibuat componentnya)
   - [ ] Klik tombol "Upload Bukti"
   - [ ] Form upload tampil
   - [ ] Bisa pilih file gambar
   - [ ] Isi jumlah, metode, tanggal
   - [ ] Submit berhasil
   - [ ] Status berubah jadi "Menunggu Verifikasi"

4. **Verifikasi Pembayaran** (Manual di database)
   ```sql
   UPDATE calon_siswa 
   SET status_pembayaran = 'sudah_bayar' 
   WHERE id = 1;
   
   UPDATE pembayaran 
   SET status = 'verified', tanggal_verifikasi = NOW() 
   WHERE calon_siswa_id = 1;
   ```
   - [ ] Status di dashboard berubah jadi "Sudah Bayar"
   - [ ] Step 2 (Isi Formulir) jadi aktif

5. **Logout & Login Kembali**
   - [ ] Klik "Logout"
   - [ ] Redirect ke login
   - [ ] Login dengan email & password yang sama
   - [ ] Data tersimpan, status tetap ada

## File Structure Check

### Backend
- [ ] `backend/.env` ✓
- [ ] `backend/composer.json` ✓
- [ ] `backend/routes/api.php` ✓
- [ ] `backend/app/Models/` (4 models) ✓
- [ ] `backend/app/Http/Controllers/Api/` (4 controllers) ✓
- [ ] `backend/database/migrations/` (4 migrations) ✓
- [ ] `backend/database/seeders/JurusanSeeder.php` ✓

### Frontend
- [ ] `frontend/package.json` ✓
- [ ] `frontend/angular.json` ✓
- [ ] `frontend/src/app/app.routes.ts` ✓
- [ ] `frontend/src/app/components/` (3 components) ✓
- [ ] `frontend/src/app/services/` (4 services) ✓
- [ ] `frontend/src/app/guards/auth.guard.ts` ✓
- [ ] `frontend/src/app/interceptors/auth.interceptor.ts` ✓

### Documentation
- [ ] `README.md` ✓
- [ ] `INSTALL_GUIDE.md` ✓
- [ ] `TECHNICAL_DOCS.md` ✓
- [ ] `PROJECT_SUMMARY.md` ✓

### Scripts
- [ ] `install.ps1` ✓
- [ ] `start.ps1` ✓

## Database Data Check

Cek di PostgreSQL:

```sql
-- Check jurusan
SELECT * FROM jurusan;
-- Harus ada 5 records (RPL, DKV, ANM, AKT, PM)

-- Check calon_siswa (setelah registrasi)
SELECT * FROM calon_siswa;
-- Harus ada data siswa yang baru registrasi

-- Check pembayaran (setelah upload)
SELECT * FROM pembayaran;

-- Check formulir_lengkap (setelah isi formulir)
SELECT * FROM formulir_lengkap;
```

## Common Issues & Solutions

### Issue: "SQLSTATE[08006] [7] could not connect"
- [ ] PostgreSQL service running? → `services.msc` cari PostgreSQL
- [ ] Password benar? → Cek di `backend/.env`
- [ ] Database `spmb_smk` sudah dibuat?

### Issue: "Cross-Origin Request Blocked"
- [ ] Backend running di port 8000?
- [ ] Frontend running di port 4200?
- [ ] File `backend/config/cors.php` sudah benar?

### Issue: "npm ERR! code ENOENT"
- [ ] Sudah cd ke folder frontend?
- [ ] Hapus node_modules dan package-lock.json
- [ ] npm install lagi

### Issue: "Class not found" di Laravel
- [ ] Sudah `composer install`?
- [ ] File `.env` ada?
- [ ] Sudah `php artisan key:generate`?

## Performance Check

- [ ] Backend API response time < 500ms
- [ ] Frontend load time < 3 detik
- [ ] No console errors di browser
- [ ] No warnings di Laravel log

## Security Check

- [ ] Password di-hash di database (bukan plain text)
- [ ] Token authentication berfungsi
- [ ] AuthGuard mencegah akses tanpa login
- [ ] File upload validasi berfungsi (max 2MB)

## Final Verification

- [ ] Bisa registrasi user baru
- [ ] Bisa login dengan user yang dibuat
- [ ] Dashboard menampilkan data dengan benar
- [ ] Logout berfungsi
- [ ] Login kembali dengan user yang sama
- [ ] Data tersimpan dengan benar di database

---

## ✅ Jika Semua Checklist Tercentang:

**SELAMAT! 🎉**

Aplikasi SPMB SMK Bakti Nusantara 666 sudah siap digunakan!

### Next Steps:
1. ✅ Setup production server (jika deploy)
2. ✅ Buat admin panel (untuk verifikasi)
3. ✅ Add email notifications
4. ✅ Backup database secara berkala

---

**Date:** _____________
**Checked by:** _____________
**Status:** ☐ PASS  ☐ FAIL (with notes)
**Notes:**
_______________________________________
_______________________________________
_______________________________________
