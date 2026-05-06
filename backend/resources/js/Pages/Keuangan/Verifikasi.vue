<template>
  <KeuanganLayout>
    <div class="py-6">
      <h2 class="text-2xl font-bold text-gray-900 mb-6">Verifikasi Pembayaran</h2>
      
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="pembayaran in pembayarans" :key="pembayaran.id">
              <td class="px-6 py-4 whitespace-nowrap">{{ pembayaran.calon_siswa.nama }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ pembayaran.calon_siswa.email }}</td>
              <td class="px-6 py-4 whitespace-nowrap">Rp {{ pembayaran.jumlah.toLocaleString() }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="{
                  'bg-yellow-100 text-yellow-800': pembayaran.status === 'pending',
                  'bg-green-100 text-green-800': pembayaran.status === 'verified',
                  'bg-red-100 text-red-800': pembayaran.status === 'rejected'
                }" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                  {{ pembayaran.status }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap space-x-2">
                <button v-if="pembayaran.status === 'pending'" 
                        @click="verifikasi(pembayaran.id, 'verified')"
                        class="text-green-600 hover:text-green-900">Verifikasi</button>
                <button v-if="pembayaran.status === 'pending'" 
                        @click="verifikasi(pembayaran.id, 'rejected')"
                        class="text-red-600 hover:text-red-900">Tolak</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </KeuanganLayout>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import KeuanganLayout from '@/Layouts/KeuanganLayout.vue'

defineProps({
  pembayarans: Array
})

const verifikasi = (id, status) => {
  if (confirm(`Apakah Anda yakin ingin ${status === 'verified' ? 'memverifikasi' : 'menolak'} pembayaran ini?`)) {
    router.post(route('keuangan.verifikasi.update', id), { status })
  }
}
</script>
