<template>
  <div class="flex h-screen bg-gray-50 overflow-hidden">
    <!-- Sidebar -->
    <aside class="flex flex-col w-64 bg-gradient-to-b from-red-600 to-red-700 text-white transition-all duration-300" :class="{ '-ml-64': !sidebarOpen }">
      <!-- Logo/Brand -->
      <div class="flex items-center justify-center h-16 bg-red-800 shadow-lg">
        <div class="flex items-center space-x-2">
          <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
            <span class="text-red-600 font-bold text-xl">A</span>
          </div>
          <span class="text-xl font-bold">Admin Panel</span>
        </div>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <Link :href="route('admin.dashboard')" 
              class="flex items-center px-4 py-3 rounded-lg transition-all duration-200"
              :class="isCurrentRoute('admin.dashboard') ? 'bg-white text-red-600 shadow-lg' : 'text-white hover:bg-red-500'">
          <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
          </svg>
          <span class="font-medium">Dashboard</span>
        </Link>

        <Link :href="route('admin.calon-siswa.index')" 
              class="flex items-center px-4 py-3 rounded-lg transition-all duration-200"
              :class="isCurrentRoute('admin.calon-siswa.index') ? 'bg-white text-red-600 shadow-lg' : 'text-white hover:bg-red-500'">
          <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
          </svg>
          <span class="font-medium">Calon Siswa</span>
        </Link>

        <Link :href="route('admin.jurusan.index')" 
              class="flex items-center px-4 py-3 rounded-lg transition-all duration-200"
              :class="isCurrentRoute('admin.jurusan.index') ? 'bg-white text-red-600 shadow-lg' : 'text-white hover:bg-red-500'">
          <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
          </svg>
          <span class="font-medium">Jurusan</span>
        </Link>
      </nav>

      <!-- User Profile -->
      <div class="p-4 bg-red-800">
        <div class="flex items-center space-x-3 mb-3">
          <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
            <span class="text-red-600 font-bold">{{ $page.props.auth.admin.nama.charAt(0) }}</span>
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium truncate">{{ $page.props.auth.admin.nama }}</p>
            <p class="text-xs text-red-200 truncate">{{ $page.props.auth.admin.email }}</p>
          </div>
        </div>
        <Link :href="route('admin.logout')" method="post" as="button" 
              class="w-full flex items-center justify-center px-4 py-2 bg-red-900 hover:bg-red-950 rounded-lg transition-colors duration-200">
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
          <span class="text-2xl">📊</span>
          <h1 class="text-xl font-semibold text-gray-800">Sistem Penerimaan Mahasiswa Baru</h1>
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
  return page.url.startsWith('/' + routeName.replace('.', '/').replace('admin/', 'admin/'));
};
</script>
