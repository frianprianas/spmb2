# Login Admin - SPMB SMK Bakti Nusantara 666

## Akses Admin Panel

### URL Login Admin
```
http://localhost:4200/admin/login
```

### Kredensial Default Admin

**Username:** `admin`  
**Password:** `password`

---

## Fitur Admin Panel

### 1. **Dashboard Admin**
- **URL:** `http://localhost:4200/admin/dashboard`
- **Fitur:**
  - 📊 Statistik real-time:
    - Total pendaftar
    - Pendaftar baru hari ini
    - Jumlah yang sudah bayar
    - Jumlah formulir lengkap
  - 📈 Data pendaftar per jurusan
  - ⚡ Quick actions ke menu lain

### 2. **Kelola Calon Siswa**
- **URL:** `http://localhost:4200/admin/calon-siswa`
- **Fitur:**
  - 📋 Tabel lengkap semua pendaftar
  - 🔍 Pencarian (nama, email, no. pendaftaran)
  - 🎯 Filter by:
    - Jurusan
    - Status pembayaran
    - Status formulir
  - 📄 Pagination
  - 👁️ Lihat detail siswa
  - 🗑️ Hapus data siswa

### 3. **Verifikasi Pembayaran**
- **URL:** `http://localhost:4200/admin/pembayaran`
- **Fitur:**
  - ✅ Approve pembayaran
  - ❌ Reject pembayaran
  - 📝 Tambah catatan admin
  - 🖼️ Lihat bukti transfer

### 4. **Kelola Jurusan**
- **URL:** `http://localhost:4200/admin/jurusan`
- **Fitur:**
  - ➕ Tambah jurusan baru
  - ✏️ Edit jurusan
  - 🗑️ Hapus jurusan

---

## API Endpoints Admin

### Authentication
```
POST /api/admin/login
Body: { username, password }

POST /api/admin/logout
Header: Authorization: Bearer {token}

GET /api/admin/me
Header: Authorization: Bearer {token}
```

### Dashboard
```
GET /api/admin/dashboard/stats
Response: {
  total_calon_siswa: number,
  pendaftar_baru: number,
  sudah_bayar: number,
  sudah_lengkap: number,
  per_jurusan: Array
}
```

### Calon Siswa Management
```
GET /api/admin/calon-siswa?page=1&search=&jurusan=&status_pembayaran=&status_formulir=
GET /api/admin/calon-siswa/{id}
DELETE /api/admin/calon-siswa/{id}
```

### Pembayaran Verification
```
GET /api/admin/pembayaran/pending
POST /api/admin/pembayaran/{id}/verifikasi
Body: { status: 'verified'|'rejected', catatan: string }
```

---

## Design Features

### Professional Sidebar Layout
- ✨ Modern gradient sidebar (dark blue)
- 🎨 Material Icons
- 📱 Responsive (collapsible on mobile)
- 🔄 Smooth animations
- 🎯 Active route highlighting

### Dashboard Components
- 📊 Beautiful stat cards with gradients
- 🎨 Color-coded badges (success, warning, info)
- 📈 Data visualization
- 🚀 Quick action cards

### Data Tables
- 📋 Professional table design
- 🔍 Advanced filters
- 📄 Server-side pagination
- 🎯 Action buttons (view, delete)
- 📱 Responsive table scroll

---

## Security

- 🔐 JWT Token Authentication (separate dari user)
- 🔒 Protected routes dengan `adminGuard`
- 🛡️ Token stored in localStorage
- 🚫 Auto redirect jika belum login

---

## Database Schema - Admin Table

```sql
CREATE TABLE admin (
    id SERIAL PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,  -- bcrypt hashed
    nama VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Default Admin:**
- Username: `admin`
- Password: `password` (hashed dengan bcrypt)
- Nama: Administrator
- Email: admin@smkbaktinusantara666.sch.id

---

## Cara Mengganti Password Admin

### Option 1: Langsung di Database
```sql
-- Generate password baru (gunakan Laravel Tinker atau bcrypt online)
UPDATE admin 
SET password = '$2y$10$...' -- password ter-hash
WHERE username = 'admin';
```

### Option 2: Via Laravel Tinker
```bash
cd backend
php artisan tinker

>>> use App\Models\Admin;
>>> $admin = Admin::where('username', 'admin')->first();
>>> $admin->password = bcrypt('password_baru');
>>> $admin->save();
```

---

## Testing Admin Panel

1. **Jalankan Backend:**
```bash
cd backend
php artisan serve
```

2. **Jalankan Frontend:**
```bash
cd frontend
ng serve
```

3. **Login Admin:**
- Buka: http://localhost:4200/admin/login
- Username: `admin`
- Password: `password`

4. **Test Fitur:**
- ✅ Dashboard stats
- ✅ Lihat daftar calon siswa
- ✅ Filter dan search
- ✅ Verifikasi pembayaran
- ✅ Kelola data

---

## Troubleshooting

### Admin tidak bisa login
```bash
# Check apakah tabel admin ada
psql -U postgres -d spmb_smk
SELECT * FROM admin;

# Re-create admin jika perlu
cd backend
psql -U postgres -d spmb_smk -f setup_admin.sql
```

### Token expired atau invalid
- Logout dan login ulang
- Clear localStorage browser
- Restart backend server

---

## Color Scheme

- **Primary:** #667eea (Purple Blue)
- **Success:** #10b981 (Green)
- **Warning:** #f59e0b (Orange)
- **Danger:** #ef4444 (Red)
- **Sidebar:** #1e293b → #0f172a (Dark gradient)

---

Selamat menggunakan Admin Panel SPMB! 🎓
