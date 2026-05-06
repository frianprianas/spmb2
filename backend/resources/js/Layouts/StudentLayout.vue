<template>
  <div class="flex h-screen bg-gray-50 overflow-hidden">
    <!-- Sidebar -->
    <aside class="flex flex-col w-64 bg-gradient-to-b from-blue-600 to-blue-700 text-white transition-all duration-300" :class="{ '-ml-64': !sidebarOpen }">
      <!-- Logo/Brand -->
      <div class="flex items-center justify-center h-16 bg-blue-800 shadow-lg">
        <div class="flex items-center space-x-2">
          <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
            <span class="text-blue-600 font-bold text-xl">🎓</span>
          </div>
          <span class="text-xl font-bold">Portal Siswa</span>
        </div>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <Link :href="route('siswa.dashboard')" 
              class="flex items-center px-4 py-3 rounded-lg transition-all duration-200"
              :class="isCurrentRoute('siswa.dashboard') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-blue-500'">
          <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
          </svg>
          <span class="font-medium">Dashboard</span>
        </Link>

        <Link :href="route('siswa.dokumen')" 
              class="flex items-center px-4 py-3 rounded-lg transition-all duration-200"
              :class="isCurrentRoute('siswa.dokumen') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-blue-500'">
          <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
          </svg>
          <span class="font-medium">Upload Dokumen</span>
        </Link>

        <Link :href="route('siswa.pembayaran')" 
              class="flex items-center px-4 py-3 rounded-lg transition-all duration-200"
              :class="isCurrentRoute('siswa.pembayaran') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-blue-500'">
          <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
          </svg>
          <span class="font-medium">Pembayaran</span>
        </Link>

        <Link :href="route('siswa.formulir')" 
              class="flex items-center px-4 py-3 rounded-lg transition-all duration-200"
              :class="isCurrentRoute('siswa.formulir') ? 'bg-white text-blue-600 shadow-lg' : 'text-white hover:bg-blue-500'">
          <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          <span class="font-medium">Formulir Lengkap</span>
        </Link>
      </nav>

      <!-- User Profile -->
      <div class="p-4 bg-blue-800">
        <div class="flex items-center space-x-3 mb-3">
          <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
            <span class="text-blue-600 font-bold">{{ $page.props.auth.user.nama.charAt(0) }}</span>
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium truncate">{{ $page.props.auth.user.nama }}</p>
            <p class="text-xs text-blue-200 truncate">{{ $page.props.auth.user.email }}</p>
          </div>
        </div>
        <Link :href="route('siswa.logout')" method="post" as="button" 
              class="w-full flex items-center justify-center px-4 py-2 bg-blue-900 hover:bg-blue-950 rounded-lg transition-colors duration-200">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
          </svg>
          <span class="text-sm font-medium">Logout</span>
        </Link>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Top Header -->
      <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200">
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
        <div class="flex items-center space-x-2">
          <span class="text-2xl">📚</span>
          <h1 class="text-xl font-semibold text-gray-800">Pendaftaran Mahasiswa Baru</h1>
        </div>
        <div class="text-sm text-gray-500">
          {{ new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}
        </div>
      </header>

      <!-- Page Content -->
      <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const sidebarOpen = ref(true);
const page = usePage();

const isCurrentRoute = (routeName) => {
  return page.url.startsWith('/' + routeName.replace('.', '/'));
};
</script>
