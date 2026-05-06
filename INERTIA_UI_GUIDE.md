# Panduan Menambahkan UI Baru - Inertia.js + Vue 3

## 📁 Struktur File

```
backend/
├── resources/
│   ├── js/
│   │   ├── app.js                 # Entry point
│   │   ├── Layouts/               # Layout components
│   │   │   ├── AdminLayout.vue
│   │   │   ├── KeuanganLayout.vue
│   │   │   ├── StudentLayout.vue
│   │   │   └── GuestLayout.vue
│   │   └── Pages/                 # Page components
│   │       ├── Admin/
│   │       │   ├── Login.vue
│   │       │   ├── Dashboard.vue
│   │       │   └── Jurusan/
│   │       │       └── Index.vue
│   │       ├── Keuangan/
│   │       │   ├── Login.vue
│   │       │   ├── Dashboard.vue
│   │       │   └── Verifikasi.vue
│   │       └── Student/
│   │           ├── Register.vue
│   │           ├── Login.vue
│   │           └── Dashboard.vue
│   └── views/
│       └── app.blade.php          # Root template
├── app/Http/Controllers/Web/      # Inertia controllers
└── routes/web.php                 # Web routes
```

## 🎨 Cara Menambahkan Halaman Baru

### 1. Buat Component Vue (.vue)

**Lokasi:** `backend/resources/js/Pages/[Role]/[NamaFitur].vue`

**Contoh:** Membuat halaman Upload Dokumen untuk Siswa

```vue
<!-- backend/resources/js/Pages/Student/Dokumen.vue -->
<template>
  <StudentLayout>
    <div class="py-6">
      <h2 class="text-2xl font-bold mb-6">Upload Dokumen</h2>
      
      <div class="bg-white p-6 rounded-lg shadow">
        <form @submit.prevent="submit">
          <div class="mb-4">
            <label class="block text-sm font-medium mb-2">KTP/KK</label>
            <input type="file" @change="form.ktp = $event.target.files[0]"
                   class="block w-full border border-gray-300 rounded px-3 py-2">
          </div>
          
          <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Ijazah</label>
            <input type="file" @change="form.ijazah = $event.target.files[0]"
                   class="block w-full border border-gray-300 rounded px-3 py-2">
          </div>
          
          <button type="submit" :disabled="form.processing"
                  class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Upload
          </button>
        </form>
      </div>
    </div>
  </StudentLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import StudentLayout from '@/Layouts/StudentLayout.vue'

const form = useForm({
  ktp: null,
  ijazah: null
})

const submit = () => {
  form.post(route('siswa.dokumen.upload'))
}
</script>
```

### 2. Buat Controller

**Lokasi:** `backend/app/Http/Controllers/Web/[Role]Controller.php`

```php
<?php
// backend/app/Http/Controllers/Web/StudentDokumenController.php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentDokumenController extends Controller
{
    public function index()
    {
        $siswa = CalonSiswa::find(request()->session()->get('user.id'));
        
        return Inertia::render('Student/Dokumen', [
            'siswa' => $siswa
        ]);
    }
    
    public function upload(Request $request)
    {
        $request->validate([
            'ktp' => 'required|file|mimes:jpg,png,pdf|max:2048',
            'ijazah' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);
        
        // Save files
        $ktpPath = $request->file('ktp')->store('dokumen/ktp', 'public');
        $ijazahPath = $request->file('ijazah')->store('dokumen/ijazah', 'public');
        
        // Update database
        $siswa = CalonSiswa::find($request->session()->get('user.id'));
        $siswa->update([
            'ktp_path' => $ktpPath,
            'ijazah_path' => $ijazahPath,
            'dokumen_lengkap' => true
        ]);
        
        return redirect()->back()->with('success', 'Dokumen berhasil diupload');
    }
}
```

### 3. Tambahkan Route

**Lokasi:** `backend/routes/web.php`

```php
use App\Http\Controllers\Web\StudentDokumenController;

Route::prefix('siswa')->name('siswa.')->middleware('student')->group(function () {
    Route::get('/dokumen', [StudentDokumenController::class, 'index'])->name('dokumen');
    Route::post('/dokumen/upload', [StudentDokumenController::class, 'upload'])->name('dokumen.upload');
});
```

### 4. Build Assets

```bash
cd backend
npm run build
```

## 🔄 Cara Kerja Inertia.js

### Controller → View
```php
// Controller
return Inertia::render('Admin/Dashboard', [
    'stats' => $stats  // Props yang dikirim ke Vue
]);
```

```vue
<!-- Vue Component -->
<script setup>
defineProps({
  stats: Object  // Terima props dari controller
})
</script>
```

### Form Submission
```vue
<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  nama: '',
  email: ''
})

const submit = () => {
  form.post(route('siswa.register'))  // POST ke Laravel route
}
</script>
```

### Navigation
```vue
<template>
  <Link :href="route('admin.dashboard')" class="text-white">
    Dashboard
  </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>
```

## 🎯 Tips & Best Practices

### 1. **Gunakan Layout yang Sesuai**
- `AdminLayout` → Halaman admin
- `KeuanganLayout` → Halaman keuangan
- `StudentLayout` → Halaman siswa
- `GuestLayout` → Login/Register pages

### 2. **Akses Data dari Session**
```vue
<script setup>
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const admin = page.props.auth.admin  // Data admin dari session
</script>
```

### 3. **Handle Flash Messages**
```vue
<script setup>
import { usePage } from '@inertiajs/vue3'
import { watch } from 'vue'

const page = usePage()

watch(() => page.props.flash.success, (message) => {
  if (message) alert(message)
})
</script>
```

### 4. **Validasi Errors**
```vue
<template>
  <input v-model="form.email" type="email">
  <div v-if="form.errors.email" class="text-red-600">
    {{ form.errors.email }}
  </div>
</template>
```

### 5. **Konfirmasi Sebelum Delete**
```vue
<script setup>
import { router } from '@inertiajs/vue3'

const deleteItem = (id) => {
  if (confirm('Yakin hapus?')) {
    router.delete(route('admin.jurusan.destroy', id))
  }
}
</script>
```

## 📝 Contoh Lengkap: CRUD Modal

```vue
<template>
  <AdminLayout>
    <!-- Table -->
    <table>
      <tr v-for="item in items" :key="item.id">
        <td>{{ item.nama }}</td>
        <td>
          <button @click="edit(item)">Edit</button>
          <button @click="deleteItem(item.id)">Hapus</button>
        </td>
      </tr>
    </table>
    
    <!-- Modal -->
    <div v-if="showModal" class="modal">
      <form @submit.prevent="submit">
        <input v-model="form.nama" type="text">
        <button type="submit">Simpan</button>
      </form>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'

defineProps({
  items: Array
})

const showModal = ref(false)
const form = useForm({
  id: null,
  nama: ''
})

const openModal = () => {
  form.reset()
  showModal.value = true
}

const edit = (item) => {
  form.id = item.id
  form.nama = item.nama
  showModal.value = true
}

const submit = () => {
  if (form.id) {
    form.put(route('admin.item.update', form.id), {
      onSuccess: () => showModal.value = false
    })
  } else {
    form.post(route('admin.item.store'), {
      onSuccess: () => showModal.value = false
    })
  }
}

const deleteItem = (id) => {
  if (confirm('Yakin hapus?')) {
    router.delete(route('admin.item.destroy', id))
  }
}
</script>
```

## 🚀 Command Berguna

```bash
# Build untuk production
npm run build

# Development mode (auto-reload)
npm run dev

# Clear cache Laravel
php artisan optimize:clear

# Lihat routes
php artisan route:list
```

## 📂 Menghapus Angular (Lama)

Folder Angular lama ada di `C:\Users\ms-yhan\Documents\realpro\spmb\frontend`

**Cara hapus:**
1. Stop semua proses Node.js
2. Restart komputer (jika ada file terkunci)
3. Hapus folder `frontend` secara manual atau dengan:
   ```powershell
   Remove-Item "C:\Users\ms-yhan\Documents\realpro\spmb\frontend" -Recurse -Force
   ```

## ✅ Perbedaan Angular vs Inertia

| Aspek | Angular (Lama) | Inertia.js (Baru) |
|-------|----------------|-------------------|
| **Frontend** | Terpisah di `/frontend` | Dalam `/backend/resources/js` |
| **Authentication** | Bearer tokens | Session-based |
| **API** | Perlu buat API routes | Langsung dari controller |
| **CORS** | Perlu konfigurasi | Tidak perlu (same domain) |
| **Build** | `ng build` | `npm run build` |
| **Port** | 4200/4201 | 8000 (Laravel) |
| **Routing** | Angular Router | Laravel Routes |
| **Errors** | Manual handling | Auto-handled oleh Inertia |

## 🎉 Keuntungan Inertia.js

- ✅ Tidak perlu API layer
- ✅ Session auth (lebih aman)
- ✅ Validation errors otomatis
- ✅ SPA-like tanpa kompleksitas SPA
- ✅ Hot Module Replacement (HMR)
- ✅ Laravel helpers langsung bisa dipakai

---

**Sekarang sistem Anda 100% menggunakan Inertia.js + Vue 3!** 🚀
