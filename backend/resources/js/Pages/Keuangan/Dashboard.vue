<template>
  <KeuanganLayout>
    <div class="py-6">
      <h2 class="text-2xl font-bold text-gray-900 mb-6">Dashboard Keuangan</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
          <div class="text-sm text-gray-600">Total Pembayaran</div>
          <div class="text-3xl font-bold text-green-600">{{ stats.total_pembayaran }}</div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
          <div class="text-sm text-gray-600">Sudah Diverifikasi</div>
          <div class="text-3xl font-bold text-blue-600">{{ stats.sudah_verifikasi }}</div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
          <div class="text-sm text-gray-600">Menunggu Verifikasi</div>
          <div class="text-3xl font-bold text-orange-600">{{ stats.menunggu_verifikasi }}</div>
        </div>
      </div>
    </div>
  </KeuanganLayout>
</template>

<script setup>
import KeuanganLayout from '@/Layouts/KeuanganLayout.vue'

defineProps({
  stats: Object
})
</script>
