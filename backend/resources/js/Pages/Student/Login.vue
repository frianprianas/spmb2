<template>
  <GuestLayout title="Login Siswa">
    <div class="min-h-screen flex items-center justify-center bg-blue-50 py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-md">
        <div>
          <h2 class="text-center text-3xl font-extrabold text-gray-900">
            Login Siswa
          </h2>
        </div>
        
        <form @submit.prevent="submit" class="mt-8 space-y-6">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input v-model="form.email" type="email" id="email" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
            <div v-if="form.errors.email" class="text-red-600 text-sm mt-1">{{ form.errors.email }}</div>
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input v-model="form.password" type="password" id="password" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
            <div v-if="form.errors.password" class="text-red-600 text-sm mt-1">{{ form.errors.password }}</div>
          </div>

          <button type="submit" :disabled="form.processing"
                  class="w-full py-2 px-4 border border-transparent rounded-md text-white bg-blue-600 hover:bg-blue-700 disabled:opacity-50">
            {{ form.processing ? 'Loading...' : 'Login' }}
          </button>
          
          <div class="text-center">
            <Link :href="route('siswa.register.form')" class="text-blue-600 hover:text-blue-800">
              Belum punya akun? Daftar di sini
            </Link>
          </div>
        </form>
      </div>
    </div>
  </GuestLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

const form = useForm({
  email: '',
  password: ''
})

const submit = () => {
  form.post(route('siswa.login'))
}
</script>
