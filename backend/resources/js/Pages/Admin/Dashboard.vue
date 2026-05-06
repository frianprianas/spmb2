<template>
  <AdminLayout>
    <div class="space-y-6">
      <!-- Header with Gradient -->
      <div class="bg-gradient-to-r from-blue-500 to-blue-700 rounded-2xl shadow-lg p-8 text-white">
        <h1 class="text-3xl font-bold">Selamat Datang, Admin! 👋</h1>
        <p class="mt-2 text-blue-100">Berikut adalah ringkasan data pendaftaran mahasiswa baru</p>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Total Siswa</p>
              <p class="mt-2 text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">{{ stats.total_calon_siswa }}</p>
            </div>
            <div class="p-3 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
              </svg>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Sudah Bayar</p>
              <p class="mt-2 text-3xl font-bold text-green-600">{{ stats.sudah_bayar }}</p>
            </div>
            <div class="p-3 bg-gradient-to-br from-green-400 to-green-600 rounded-xl">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Menunggu Verifikasi</p>
              <p class="mt-2 text-3xl font-bold text-yellow-600">{{ stats.menunggu_verifikasi }}</p>
            </div>
            <div class="p-3 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-medium text-gray-600">Belum Bayar</p>
              <p class="mt-2 text-3xl font-bold text-red-600">{{ stats.total_calon_siswa - stats.sudah_bayar - stats.menunggu_verifikasi }}</p>
            </div>
            <div class="p-3 bg-gradient-to-br from-red-400 to-red-600 rounded-xl">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Per Jurusan -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
          <h3 class="text-lg font-semibold text-gray-900">Pendaftar per Jurusan</h3>
        </div>
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div v-for="jurusan in stats.per_jurusan" :key="jurusan.jurusan_id" 
                 class="p-4 border border-gray-200 rounded-xl hover:border-blue-300 hover:shadow-md transition-all">
              <div class="flex items-center justify-between">
                <div>
                  <p class="font-semibold text-gray-900">{{ jurusan.nama_jurusan }}</p>
                  <p class="text-sm text-gray-500 mt-1">Kode: {{ jurusan.kode_jurusan }}</p>
                </div>
                <div class="text-right">
                  <p class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">{{ jurusan.total }}</p>
                  <p class="text-xs text-gray-500 mt-1">pendaftar</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({
  stats: Object
});
</script>
