<template>
  <AdminLayout>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
      <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold">Kelola Jurusan</h3>
          <button @click="openModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
            Tambah Jurusan
          </button>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Jurusan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kuota</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="jurusan in jurusanList" :key="jurusan.id">
                <td class="px-6 py-4 whitespace-nowrap">{{ jurusan.kode_jurusan }}</td>
                <td class="px-6 py-4">{{ jurusan.nama_jurusan }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ jurusan.kuota }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  <button @click="openModal(jurusan)" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                  <button @click="deleteJurusan(jurusan)" class="text-red-600 hover:text-red-900">Hapus</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="fixed z-10 inertial-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeModal()"></div>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <form @submit.prevent="saveJurusan">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
              <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">
                {{ isEditMode ? 'Edit Jurusan' : 'Tambah Jurusan' }}
              </h3>
              
              <div class="space-y-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700">Nama Jurusan</label>
                  <input v-model="form.nama_jurusan" type="text" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                  <textarea v-model="form.deskripsi" required rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>
                
                <div>
                  <label class="block text-sm font-medium text-gray-700">Kuota</label>
                  <input v-model.number="form.kuota" type="number" required min="1" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
                </div>
              </div>
            </div>
            
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
              <button type="submit" :disabled="form.processing" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                {{ form.processing ? 'Menyimpan...' : 'Simpan' }}
              </button>
              <button @click.prevent="closeModal()" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Batal
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  jurusanList: Array
});

const showModal = ref(false);
const isEditMode = ref(false);
const editingId = ref(null);

const form = useForm({
  nama_jurusan: '',
  deskripsi: '',
  kuota: 0
});

const openModal = (jurusan = null) => {
  if (jurusan) {
    isEditMode.value = true;
    editingId.value = jurusan.id;
    form.nama_jurusan = jurusan.nama_jurusan;
    form.deskripsi = jurusan.deskripsi;
    form.kuota = jurusan.kuota;
  } else {
    isEditMode.value = false;
    editingId.value = null;
    form.reset();
  }
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  form.reset();
};

const saveJurusan = () => {
  if (isEditMode.value) {
    form.put(route('admin.jurusan.update', editingId.value), {
      onSuccess: () => closeModal()
    });
  } else {
    form.post(route('admin.jurusan.store'), {
      onSuccess: () => closeModal()
    });
  }
};

const deleteJurusan = (jurusan) => {
  if (confirm(`Apakah Anda yakin ingin menghapus jurusan ${jurusan.nama_jurusan}?`)) {
    router.delete(route('admin.jurusan.destroy', jurusan.id));
  }
};
</script>
