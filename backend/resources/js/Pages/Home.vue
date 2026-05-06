<template>
  <div class="min-h-screen bg-white font-sans">

    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 bg-white/90 backdrop-blur-md shadow-sm border-b border-blue-50">
      <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl flex items-center justify-center shadow-md">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
            </svg>
          </div>
          <div>
            <p class="font-bold text-gray-900 leading-none text-sm">SMK Bakti Nusantara 666</p>
            <p class="text-xs text-blue-600 font-medium">PPDB Online {{ tahunAjaran }}</p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <Link :href="route('siswa.login')"
                class="px-4 py-2 text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">
            Login
          </Link>
          <Link :href="route('siswa.register.form')"
                class="px-5 py-2 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full hover:from-blue-700 hover:to-indigo-700 shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
            Daftar Sekarang
          </Link>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-24 pb-20 overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800">
      <!-- Background Decorations -->
      <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-500/10 rounded-full blur-3xl"></div>
      </div>

      <div class="relative max-w-7xl mx-auto px-6 py-16 text-center">
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-2 mb-8">
          <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
          <span class="text-white/90 text-sm font-medium">Pendaftaran Dibuka — Tahun Ajaran {{ tahunAjaran }}</span>
        </div>

        <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-6">
          Raih Masa Depanmu<br>
          <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-orange-300">
            Bersama Kami
          </span>
        </h1>

        <p class="text-lg md:text-xl text-blue-100 max-w-2xl mx-auto mb-10">
          Penerimaan Peserta Didik Baru (PPDB) SMK Bakti Nusantara 666.
          Daftarkan dirimu sekarang dan pilih jurusan terbaikmu!
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <Link :href="route('siswa.register.form')"
                class="px-8 py-4 text-base font-bold text-blue-700 bg-white rounded-2xl hover:bg-yellow-50 shadow-xl hover:shadow-2xl transition-all duration-200 transform hover:-translate-y-1">
            🚀 Daftar Sekarang — Gratis!
          </Link>
          <a href="#jurusan"
             class="px-8 py-4 text-base font-semibold text-white border-2 border-white/40 rounded-2xl hover:bg-white/10 backdrop-blur-sm transition-all duration-200">
            Lihat Jurusan ↓
          </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-3 gap-6 max-w-lg mx-auto mt-16">
          <div class="text-center">
            <p class="text-3xl font-extrabold text-white">5</p>
            <p class="text-blue-200 text-sm mt-1">Jurusan</p>
          </div>
          <div class="text-center border-x border-white/20">
            <p class="text-3xl font-extrabold text-white">180</p>
            <p class="text-blue-200 text-sm mt-1">Kuota Siswa</p>
          </div>
          <div class="text-center">
            <p class="text-3xl font-extrabold text-white">100%</p>
            <p class="text-blue-200 text-sm mt-1">Online</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Alur Pendaftaran -->
    <section class="py-20 bg-gray-50">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-extrabold text-gray-900">Alur Pendaftaran</h2>
          <p class="text-gray-500 mt-3">Mudah, cepat, dan bisa dilakukan dari mana saja</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
          <div v-for="(step, index) in steps" :key="index"
               class="relative bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
            <div class="w-12 h-12 mx-auto mb-4 rounded-2xl flex items-center justify-center text-2xl"
                 :class="step.bg">
              {{ step.icon }}
            </div>
            <div class="absolute -top-3 -right-3 w-7 h-7 bg-blue-600 text-white rounded-full text-xs font-bold flex items-center justify-center shadow">
              {{ index + 1 }}
            </div>
            <h3 class="font-bold text-gray-900 mb-2">{{ step.title }}</h3>
            <p class="text-gray-500 text-sm">{{ step.desc }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Jurusan Section -->
    <section id="jurusan" class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-extrabold text-gray-900">Pilih Jurusanmu</h2>
          <p class="text-gray-500 mt-3">{{ jurusan.length }} Kompetensi keahlian tersedia untuk kamu</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="j in jurusan" :key="j.id"
               class="group bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
            <div class="flex items-start justify-between mb-4">
              <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white font-bold text-sm shadow-md"
                   :class="jurusanColors[j.kode_jurusan] || 'bg-gradient-to-br from-blue-500 to-blue-700'">
                {{ j.kode_jurusan }}
              </div>
              <span class="text-xs font-semibold px-3 py-1 bg-green-50 text-green-600 rounded-full border border-green-100">
                Kuota: {{ j.kuota }} siswa
              </span>
            </div>
            <h3 class="font-bold text-gray-900 text-lg mb-2 group-hover:text-blue-600 transition-colors">
              {{ j.nama_jurusan }}
            </h3>
            <p class="text-gray-500 text-sm leading-relaxed">{{ j.deskripsi }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-blue-600 to-indigo-700">
      <div class="max-w-3xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-extrabold text-white mb-4">Siap untuk Mendaftar?</h2>
        <p class="text-blue-100 text-lg mb-8">Proses pendaftaran hanya membutuhkan beberapa menit. Segera amankan posisimu!</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <Link :href="route('siswa.register.form')"
                class="px-8 py-4 font-bold text-blue-700 bg-white rounded-2xl hover:bg-yellow-50 shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
            Mulai Pendaftaran →
          </Link>
          <Link :href="route('siswa.login')"
                class="px-8 py-4 font-semibold text-white border-2 border-white/40 rounded-2xl hover:bg-white/10 transition-all duration-200">
            Sudah punya akun? Login
          </Link>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-10 text-center">
      <div class="flex items-center justify-center gap-2 mb-3">
        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
          <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
          </svg>
        </div>
        <span class="text-white font-bold">SMK Bakti Nusantara 666</span>
      </div>
      <p class="text-sm">© {{ new Date().getFullYear() }} PPDB Online. Semua hak cipta dilindungi.</p>
    </footer>

  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  jurusan: {
    type: Array,
    default: () => []
  }
})

const tahunAjaran = `${new Date().getFullYear()}/${new Date().getFullYear() + 1}`

const steps = [
  { icon: '📝', title: 'Buat Akun', desc: 'Isi data diri dan pilih jurusan yang diminati', bg: 'bg-blue-50' },
  { icon: '💳', title: 'Bayar Pendaftaran', desc: 'Upload bukti pembayaran biaya pendaftaran', bg: 'bg-green-50' },
  { icon: '📋', title: 'Isi Formulir', desc: 'Lengkapi data diri dan upload dokumen persyaratan', bg: 'bg-yellow-50' },
  { icon: '🎉', title: 'Pengumuman', desc: 'Pantau status penerimaan melalui dashboard', bg: 'bg-purple-50' },
]

const jurusanColors = {
  RPL: 'bg-gradient-to-br from-blue-500 to-blue-700',
  DKV: 'bg-gradient-to-br from-pink-500 to-rose-600',
  ANM: 'bg-gradient-to-br from-purple-500 to-indigo-600',
  AKT: 'bg-gradient-to-br from-green-500 to-emerald-600',
  PM:  'bg-gradient-to-br from-orange-500 to-amber-600',
}
</script>
