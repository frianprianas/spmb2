<template>
  <div class="flex h-screen bg-gray-50 overflow-hidden">
    <!-- Sidebar -->
    <aside class="flex flex-col w-64 bg-gradient-to-b from-green-600 to-green-700 text-white transition-all duration-300" :class="{ '-ml-64': !sidebarOpen }">
      <!-- Logo/Brand -->
      <div class="flex items-center justify-center h-16 bg-green-800 shadow-lg">
        <div class="flex items-center space-x-2">
          <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
            <span class="text-green-600 font-bold text-xl">💰</span>
          </div>
          <span class="text-xl font-bold">Keuangan</span>
        </div>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <Link :href="route('keuangan.dashboard')" 
              class="flex items-center px-4 py-3 rounded-lg transition-all duration-200"
              :class="isCurrentRoute('keuangan.dashboard') ? 'bg-white text-green-600 shadow-lg' : 'text-white hover:bg-green-500'">
          <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
          </svg>
          <span class="font-medium">Dashboard</span>
        </Link>

        <Link :href="route('keuangan.verifikasi')" 
              class="flex items-center px-4 py-3 rounded-lg transition-all duration-200"
              :class="isCurrentRoute('keuangan.verifikasi') ? 'bg-white text-green-600 shadow-lg' : 'text-white hover:bg-green-500'">
          <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <span class="font-medium">Verifikasi Pembayaran</span>
        </Link>
      </nav>

      <!-- User Profile -->
      <div class="p-4 bg-green-800">
        <div class="flex items-center space-x-3 mb-3">
          <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
            <span class="text-green-600 font-bold">{{ $page.props.auth.keuangan.nama.charAt(0) }}</span>
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium truncate">{{ $page.props.auth.keuangan.nama }}</p>
            <p class="text-xs text-green-200 truncate">{{ $page.props.auth.keuangan.email }}</p>
          </div>
        </div>
        <Link :href="route('keuangan.logout')" method="post" as="button" 
              class="w-full flex items-center justify-center px-4 py-2 bg-green-900 hover:bg-green-950 rounded-lg transition-colors duration-200">
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
          <span class="text-2xl">💵</span>
          <h1 class="text-xl font-semibold text-gray-800">Manajemen Keuangan</h1>
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
