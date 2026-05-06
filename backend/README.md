# SPMB SMK Bakti Nusantara 666 - Backend

## Instalasi

1. Install dependencies:
```bash
composer install
```

2. Copy .env file (sudah tersedia)

3. Generate application key:
```bash
php artisan key:generate
```

4. Buat database PostgreSQL:
```sql
CREATE DATABASE spmb_smk;
```

5. Jalankan migrasi dan seeder:
```bash
php artisan migrate
php artisan db:seed --class=JurusanSeeder
```

6. Buat symbolic link untuk storage:
```bash
php artisan storage:link
```

7. Jalankan server:
```bash
php artisan serve
```

## API Endpoints

### Public Endpoints

#### Register
- **POST** `/api/register`
- Body:
```json
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
```

#### Login
- **POST** `/api/login`
- Body:
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

#### Get All Jurusan
- **GET** `/api/jurusan`

### Protected Endpoints (Require Bearer Token)

#### Get Current User
- **GET** `/api/me`

#### Upload Bukti Pembayaran
- **POST** `/api/pembayaran`
- Headers: `Authorization: Bearer {token}`
- Body (form-data):
  - jumlah: number
  - metode_pembayaran: transfer|cash|virtual_account
  - bukti_pembayaran: file (image)
  - tanggal_bayar: date

#### Check Payment Status
- **GET** `/api/pembayaran/check/status`

#### Submit/Update Formulir Lengkap
- **POST** `/api/formulir`
- Headers: `Authorization: Bearer {token}`
- Body (form-data): All form fields + dokumen files

#### Get Formulir
- **GET** `/api/formulir`

## Database Structure

### Tables:
1. **jurusan** - Program keahlian (RPL, DKV, Animasi, AKT, Pemasaran)
2. **calon_siswa** - Data pendaftaran awal siswa
3. **pembayaran** - Data pembayaran dan bukti
4. **formulir_lengkap** - Data lengkap siswa setelah bayar

## Tech Stack
- Laravel 10
- PostgreSQL
- Laravel Sanctum (Authentication)
