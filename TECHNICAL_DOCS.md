# 📚 Dokumentasi Teknis SPMB SMK Bakti Nusantara 666

## 📋 Daftar Isi
1. [Arsitektur Sistem](#arsitektur-sistem)
2. [Database Schema](#database-schema)
3. [API Documentation](#api-documentation)
4. [Frontend Structure](#frontend-structure)
5. [Security](#security)
6. [Deployment](#deployment)

---

## 🏗️ Arsitektur Sistem

### Tech Stack
```
┌─────────────────────────────────────────┐
│           Browser (Client)              │
└──────────────┬──────────────────────────┘
               │ HTTP/HTTPS
               ▼
┌─────────────────────────────────────────┐
│      Angular 17 Frontend                │
│  - Standalone Components                │
│  - TypeScript                           │
│  - Reactive Forms                       │
│  - HTTP Client                          │
└──────────────┬──────────────────────────┘
               │ REST API
               ▼
┌─────────────────────────────────────────┐
│      Laravel 10 Backend                 │
│  - API Controllers                      │
│  - Laravel Sanctum (Auth)               │
│  - Eloquent ORM                         │
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│        PostgreSQL Database              │
│  - Tables: jurusan, calon_siswa,        │
│    pembayaran, formulir_lengkap         │
└─────────────────────────────────────────┘
```

---

## 🗄️ Database Schema

### ERD (Entity Relationship Diagram)

```
┌──────────────┐         ┌──────────────────┐
│   jurusan    │────┐    │   calon_siswa    │
├──────────────┤    │    ├──────────────────┤
│ id (PK)      │    └───<│ id (PK)          │
│ kode_jurusan │         │ no_pendaftaran   │
│ nama_jurusan │         │ nama             │
│ deskripsi    │         │ jurusan_id (FK)  │
│ kuota        │         │ email            │
│ is_active    │         │ status_*         │
└──────────────┘         └────┬─────────┬───┘
                              │         │
                              │         │
                    ┌─────────┘         └─────────┐
                    │                              │
                    ▼                              ▼
           ┌─────────────────┐        ┌──────────────────────┐
           │   pembayaran    │        │  formulir_lengkap    │
           ├─────────────────┤        ├──────────────────────┤
           │ id (PK)         │        │ id (PK)              │
           │ calon_siswa_id  │        │ calon_siswa_id (FK)  │
           │ no_pembayaran   │        │ nik, nisn            │
           │ jumlah          │        │ data_pribadi         │
           │ bukti_pembayaran│        │ data_orangtua        │
           │ status          │        │ dokumen              │
           └─────────────────┘        └──────────────────────┘
```

### Table Details

#### 1. jurusan
```sql
- id: BIGINT PRIMARY KEY
- kode_jurusan: VARCHAR(10) UNIQUE
- nama_jurusan: VARCHAR(100)
- deskripsi: TEXT
- kuota: INTEGER
- is_active: BOOLEAN
- created_at, updated_at: TIMESTAMP
```

**Data:**
- RPL - Rekayasa Perangkat Lunak
- DKV - Desain Komunikasi Visual
- ANM - Animasi
- AKT - Akuntansi dan Keuangan Lembaga
- PM - Pemasaran

#### 2. calon_siswa
```sql
- id: BIGINT PRIMARY KEY
- no_pendaftaran: VARCHAR(20) UNIQUE (Format: SPMB2024XXXX)
- nama: VARCHAR(100)
- alamat: TEXT
- jenis_kelamin: ENUM('L','P')
- asal_smp: VARCHAR(100)
- jurusan_id: BIGINT FK -> jurusan(id)
- email: VARCHAR(100) UNIQUE
- no_hp: VARCHAR(20)
- status_pembayaran: ENUM('belum_bayar','verifikasi','sudah_bayar')
- status_formulir: ENUM('belum_isi','sudah_isi','lengkap')
- status_pendaftaran: ENUM('pending','diterima','ditolak')
- password: VARCHAR(255) HASHED
- created_at, updated_at: TIMESTAMP
```

#### 3. pembayaran
```sql
- id: BIGINT PRIMARY KEY
- calon_siswa_id: BIGINT FK -> calon_siswa(id)
- no_pembayaran: VARCHAR(50) UNIQUE (Format: PAY202401XXXX)
- jumlah: DECIMAL(15,2)
- metode_pembayaran: ENUM('transfer','cash','virtual_account')
- bukti_pembayaran: VARCHAR(255) (file path)
- status: ENUM('pending','verified','rejected')
- tanggal_bayar: TIMESTAMP
- tanggal_verifikasi: TIMESTAMP NULLABLE
- catatan: TEXT NULLABLE
- created_at, updated_at: TIMESTAMP
```

#### 4. formulir_lengkap
```sql
- id: BIGINT PRIMARY KEY
- calon_siswa_id: BIGINT FK -> calon_siswa(id)

# Data Pribadi
- nik: VARCHAR(16)
- nisn: VARCHAR(10)
- tempat_lahir: VARCHAR(50)
- tanggal_lahir: DATE
- agama: ENUM('Islam','Kristen','Katolik','Hindu','Buddha','Konghucu')
- kewarganegaraan: VARCHAR(20)
- anak_ke: INTEGER
- jumlah_saudara: INTEGER
- no_hp_siswa: VARCHAR(20)
- email_siswa: VARCHAR(100)

# Alamat
- alamat_lengkap: TEXT
- rt, rw: VARCHAR(5)
- kelurahan, kecamatan, kota, provinsi: VARCHAR(50)
- kode_pos: VARCHAR(10)

# Orang Tua
- nama_ayah, nama_ibu: VARCHAR(100)
- nik_ayah, nik_ibu: VARCHAR(16)
- pekerjaan_ayah, pekerjaan_ibu: VARCHAR(50)
- pendidikan_ayah, pendidikan_ibu: VARCHAR(30)
- penghasilan_ayah, penghasilan_ibu: DECIMAL(15,2)
- no_hp_ayah, no_hp_ibu: VARCHAR(20)

# Wali (Optional)
- nama_wali, hubungan_wali, pekerjaan_wali: VARCHAR
- no_hp_wali: VARCHAR(20)
- alamat_wali: TEXT

# Sekolah Asal
- npsn_smp: VARCHAR(20)
- alamat_smp: TEXT
- tahun_lulus: INTEGER
- nilai_un: DECIMAL(5,2)

# Dokumen
- foto, scan_kk, scan_akta, scan_ijazah: VARCHAR(255)

# Tambahan
- prestasi, info_tambahan: TEXT

- created_at, updated_at: TIMESTAMP
```

---

## 🔌 API Documentation

### Base URL
```
http://localhost:8000/api
```

### Authentication
Menggunakan **Laravel Sanctum** (Token-based)

Header untuk request yang memerlukan autentikasi:
```
Authorization: Bearer {token}
```

### Endpoints

#### 1. Authentication

##### Register
```http
POST /register
Content-Type: application/json

Request Body:
{
  "nama": "John Doe",
  "alamat": "Jl. Example No. 123",
  "jenis_kelamin": "L",
  "asal_smp": "SMP Negeri 1",
  "jurusan_id": 1,
  "email": "john@example.com",
  "no_hp": "081234567890",
  "password": "password123",
  "password_confirmation": "password123"
}

Response (201):
{
  "success": true,
  "message": "Pendaftaran berhasil!",
  "data": {
    "calon_siswa": {
      "id": 1,
      "no_pendaftaran": "SPMB20240001",
      "nama": "John Doe",
      ...
    },
    "token": "1|abc123def456..."
  }
}
```

##### Login
```http
POST /login
Content-Type: application/json

Request Body:
{
  "email": "john@example.com",
  "password": "password123"
}

Response (200):
{
  "success": true,
  "message": "Login berhasil!",
  "data": {
    "calon_siswa": {...},
    "token": "2|xyz789..."
  }
}
```

##### Logout
```http
POST /logout
Authorization: Bearer {token}

Response (200):
{
  "success": true,
  "message": "Logout berhasil!"
}
```

##### Get Current User
```http
GET /me
Authorization: Bearer {token}

Response (200):
{
  "success": true,
  "data": {
    "id": 1,
    "no_pendaftaran": "SPMB20240001",
    "nama": "John Doe",
    "jurusan": {...},
    "pembayaran": [...],
    "formulirLengkap": {...}
  }
}
```

#### 2. Jurusan

##### Get All Jurusan
```http
GET /jurusan

Response (200):
{
  "success": true,
  "data": [
    {
      "id": 1,
      "kode_jurusan": "RPL",
      "nama_jurusan": "Rekayasa Perangkat Lunak",
      "deskripsi": "...",
      "kuota": 36,
      "is_active": true
    },
    ...
  ]
}
```

#### 3. Pembayaran

##### Upload Bukti Pembayaran
```http
POST /pembayaran
Authorization: Bearer {token}
Content-Type: multipart/form-data

Form Data:
- jumlah: 500000
- metode_pembayaran: transfer
- bukti_pembayaran: [file]
- tanggal_bayar: 2024-01-19

Response (201):
{
  "success": true,
  "message": "Bukti pembayaran berhasil diupload.",
  "data": {
    "id": 1,
    "no_pembayaran": "PAY202401XXXX",
    "status": "pending",
    ...
  }
}
```

##### Check Payment Status
```http
GET /pembayaran/check/status
Authorization: Bearer {token}

Response (200):
{
  "success": true,
  "data": {
    "status_pembayaran": "verifikasi",
    "latest_payment": {...},
    "can_fill_form": false
  }
}
```

#### 4. Formulir

##### Submit Formulir
```http
POST /formulir
Authorization: Bearer {token}
Content-Type: multipart/form-data

Form Data:
- nik: 3201234567890123
- tempat_lahir: Jakarta
- tanggal_lahir: 2008-05-15
- agama: Islam
- [... semua field lainnya]
- foto: [file]
- scan_kk: [file]
- scan_akta: [file]
- scan_ijazah: [file]

Response (201):
{
  "success": true,
  "message": "Formulir berhasil disimpan!",
  "data": {...}
}
```

---

## 🎨 Frontend Structure

### Component Tree

```
App (Root)
│
├─ LoginComponent
│  └─ RouterLink to Register
│
├─ RegisterComponent
│  ├─ JurusanService (select options)
│  └─ RouterLink to Login
│
└─ DashboardComponent (Protected by AuthGuard)
   ├─ User Info Display
   ├─ Status Cards
   └─ Action Steps
      ├─ PembayaranComponent (route)
      └─ FormulirComponent (route)
```

### Services

#### AuthService
- `register(data)` - Registrasi user baru
- `login(data)` - Login user
- `logout()` - Logout user
- `me()` - Get current user
- `getToken()` - Get auth token
- `isLoggedIn()` - Check auth status

#### JurusanService
- `getAll()` - Get semua jurusan aktif
- `getById(id)` - Get detail jurusan

#### PembayaranService
- `upload(formData)` - Upload bukti pembayaran
- `checkStatus()` - Cek status pembayaran

#### FormulirService
- `submit(formData)` - Submit formulir lengkap
- `get()` - Get formulir yang sudah diisi

### Guards

#### AuthGuard
Melindungi route yang memerlukan autentikasi:
```typescript
{ 
  path: 'dashboard', 
  component: DashboardComponent,
  canActivate: [AuthGuard]
}
```

### Interceptors

#### AuthInterceptor
Menambahkan Bearer token ke setiap HTTP request secara otomatis.

---

## 🔒 Security

### Backend Security

1. **Password Hashing**
   - Menggunakan bcrypt via Laravel Hash facade
   - Minimum 6 karakter

2. **API Authentication**
   - Laravel Sanctum token-based auth
   - Token disimpan di localStorage (frontend)
   - Token expires sesuai config

3. **CORS Protection**
   - Hanya menerima request dari `http://localhost:4200`
   - Configured di `config/cors.php`

4. **Input Validation**
   - Server-side validation di Controller
   - Menggunakan Laravel Validator

5. **SQL Injection Protection**
   - Eloquent ORM dengan prepared statements

6. **File Upload Security**
   - Validasi tipe file (image, pdf)
   - Max size 2MB
   - Disimpan di storage/app/public

### Frontend Security

1. **XSS Protection**
   - Angular sanitization otomatis
   - No innerHTML usage

2. **CSRF Protection**
   - Handled by Laravel Sanctum

3. **Route Guards**
   - AuthGuard mencegah akses tanpa login

---

## 🚀 Deployment

### Production Checklist

#### Backend
```bash
# 1. Set environment ke production
APP_ENV=production
APP_DEBUG=false

# 2. Generate secure app key
php artisan key:generate

# 3. Cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. Optimize composer
composer install --optimize-autoloader --no-dev

# 5. Set permissions
chmod -R 755 storage bootstrap/cache
```

#### Frontend
```bash
# Build production
npm run build

# Output di dist/spmb-frontend/
# Deploy ke web server (nginx/apache)
```

#### Database
```sql
-- Backup database
pg_dump -U postgres spmb_smk > backup.sql

-- Restore
psql -U postgres -d spmb_smk < backup.sql
```

### Server Requirements

**Minimum:**
- PHP 8.1+
- PostgreSQL 12+
- Node.js 18+
- 2GB RAM
- 10GB Storage

**Recommended:**
- PHP 8.2+
- PostgreSQL 15+
- Node.js 20 LTS
- 4GB RAM
- 20GB Storage
- Nginx/Apache
- SSL Certificate

---

## 📊 Performance Optimization

### Backend
- Enable Redis cache untuk session
- Database indexing pada foreign keys
- Lazy loading relationships
- API response caching

### Frontend
- Lazy loading routes
- AOT compilation
- Image optimization
- Gzip compression

---

## 🧪 Testing

### Backend Testing
```bash
php artisan test
```

### Frontend Testing
```bash
npm test
```

---

## 📝 License

Private - SMK Bakti Nusantara 666

---

**Last Updated:** January 2026
