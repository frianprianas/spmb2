<template>
  <StudentLayout>
    <div class="py-6">
      <h2 class="text-2xl font-bold text-gray-900 mb-6">Dashboard Siswa</h2>
      
      <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h3 class="text-lg font-semibold mb-4">Status Pendaftaran</h3>
        <div class="space-y-2">
          <div class="flex justify-between">
            <span>Email Verified:</span>
            <span :class="siswa.email_verified_at ? 'text-green-600' : 'text-red-600'">
              {{ siswa.email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi' }}
            </span>
          </div>
          <div class="flex justify-between">
            <span>Dokumen:</span>
            <span :class="siswa.dokumen_lengkap ? 'text-green-600' : 'text-orange-600'">
              {{ siswa.dokumen_lengkap ? 'Lengkap' : 'Belum Lengkap' }}
            </span>
          </div>
          <div class="flex justify-between">
            <span>Pembayaran:</span>
            <span :class="siswa.status_pembayaran === 'lunas' ? 'text-green-600' : 'text-orange-600'">
              {{ siswa.status_pembayaran || 'Belum Bayar' }}
            </span>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Langkah Berikutnya</h3>
        <ol class="list-decimal list-inside space-y-2">
          <li v-if="!siswa.email_verified_at">Verifikasi email Anda</li>
          <li v-if="!siswa.dokumen_lengkap">Upload dokumen yang diperlukan</li>
          <li v-if="siswa.status_pembayaran !== 'lunas'">Lakukan pembayaran pendaftaran</li>
          <li v-if="!siswa.formulir_lengkap">Lengkapi formulir pendaftaran</li>
        </ol>
      </div>
    </div>
  </StudentLayout>
</template>

<script setup>
import StudentLayout from '@/Layouts/StudentLayout.vue'

defineProps({
  siswa: Object
})
</script>
