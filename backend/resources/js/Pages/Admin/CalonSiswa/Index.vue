<template>
  <AdminLayout>
    <div class="space-y-6">
      <!-- Header -->
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Data Calon Siswa</h1>
          <p class="mt-1 text-sm text-gray-600">Kelola data pendaftar calon siswa baru</p>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Total Pendaftar</p>
              <p class="mt-2 text-3xl font-bold text-gray-900">{{ calonSiswa.length }}</p>
            </div>
            <div class="p-3 bg-blue-100 rounded-lg">
              <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
              </svg>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Sudah Bayar</p>
              <p class="mt-2 text-3xl font-bold text-green-600">{{ sudahBayar }}</p>
            </div>
            <div class="p-3 bg-green-100 rounded-lg">
              <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Menunggu</p>
              <p class="mt-2 text-3xl font-bold text-yellow-600">{{ menunggu }}</p>
            </div>
            <div class="p-3 bg-yellow-100 rounded-lg">
              <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Belum Bayar</p>
              <p class="mt-2 text-3xl font-bold text-red-600">{{ belumBayar }}</p>
            </div>
            <div class="p-3 bg-red-100 rounded-lg">
              <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Table Card -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
          <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Daftar Calon Siswa</h2>
            <div class="flex items-center space-x-3">
              <input type="text" v-model="search" placeholder="Cari nama atau email..." 
                     class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
              <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jurusan</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status Pembayaran</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Dokumen</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tgl Daftar</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr v-for="(siswa, index) in filteredSiswa" :key="siswa.id" class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 text-sm text-gray-900">{{ index + 1 }}</td>
                <td class="px-6 py-4">
                  <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold">
                      {{ siswa.nama.charAt(0) }}
                    </div>
                    <div class="ml-3">
                      <p class="text-sm font-medium text-gray-900">{{ siswa.nama }}</p>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">{{ siswa.email }}</td>
                <td class="px-6 py-4">
                  <span class="px-3 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-700">
                    {{ siswa.jurusan?.nama_jurusan || '-' }}
                  </span>
                </td>
                <td class="px-6 py-4">
                  <span v-if="siswa.status_pembayaran === 'lunas'" 
                        class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                    ✓ Lunas
                  </span>
                  <span v-else-if="siswa.status_pembayaran === 'menunggu_verifikasi'" 
                        class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                    ⏳ Menunggu
                  </span>
                  <span v-else 
                        class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                    ✗ Belum Bayar
                  </span>
                </td>
                <td class="px-6 py-4">
                  <span v-if="siswa.dokumen_lengkap" 
                        class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                    ✓ Lengkap
                  </span>
                  <span v-else 
                        class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                    − Belum
                  </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">
                  {{ new Date(siswa.created_at).toLocaleDateString('id-ID') }}
                </td>
              </tr>
              <tr v-if="filteredSiswa.length === 0">
                <td colspan="7" class="px-6 py-12 text-center">
                  <div class="flex flex-col items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="text-gray-600 font-medium">Belum ada data calon siswa</p>
                    <p class="text-gray-500 text-sm mt-1">Data akan muncul ketika ada pendaftar baru</p>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, computed } from 'vue';

const props = defineProps({
  calonSiswa: Array,
});

const search = ref('');

const filteredSiswa = computed(() => {
  if (!search.value) return props.calonSiswa;
  
  const searchLower = search.value.toLowerCase();
  return props.calonSiswa.filter(siswa => 
    siswa.nama.toLowerCase().includes(searchLower) ||
    siswa.email.toLowerCase().includes(searchLower)
  );
});

const sudahBayar = computed(() => 
  props.calonSiswa.filter(s => s.status_pembayaran === 'lunas').length
);

const menunggu = computed(() => 
  props.calonSiswa.filter(s => s.status_pembayaran === 'menunggu_verifikasi').length
);

const belumBayar = computed(() => 
  props.calonSiswa.filter(s => s.status_pembayaran === 'belum_bayar').length
);
</script>
