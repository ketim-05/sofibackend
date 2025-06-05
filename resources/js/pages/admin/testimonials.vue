<template>
  <div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Manage Testimonials</h1>
      <button
        @click="showForm = true"
        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
      >
        Add New Testimonial
      </button>
    </div>

    <!-- Testimonials List -->
    <div v-if="!showForm" class="bg-white shadow-md rounded-lg overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="testimonial in testimonials" :key="testimonial.id">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="h-10 w-10 flex-shrink-0">
                  <img
                    :src="testimonial.image_url || '/default-avatar.jpg'"
                    :alt="testimonial.name"
                    class="h-10 w-10 rounded-full object-cover"
                  />
                </div>
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900">{{ testimonial.name }}</div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ testimonial.position }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ testimonial.company }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex">
                <span v-for="n in testimonial.rating" :key="n" class="text-yellow-400">★</span>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span
                :class="[
                  testimonial.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800',
                  'px-2 inline-flex text-xs leading-5 font-semibold rounded-full'
                ]"
              >
                {{ testimonial.is_active ? 'Active' : 'Inactive' }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <button
                @click="editTestimonial(testimonial)"
                class="text-indigo-600 hover:text-indigo-900 mr-3"
              >
                Edit
              </button>
              <button
                @click="deleteTestimonial(testimonial.id)"
                class="text-red-600 hover:text-red-900"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Testimonial Form -->
    <div v-else class="bg-white shadow-md rounded-lg p-6">
      <h2 class="text-xl font-bold mb-4">{{ editingTestimonial ? 'Edit' : 'Add' }} Testimonial</h2>
      <TestimonialForm
        :testimonial="editingTestimonial"
        @saved="handleSaved"
        @cancel="showForm = false"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useApi } from '@/composables/useApi';
import TestimonialForm from '@/components/admin/TestimonialForm.vue';

const { getTestimonials, deleteTestimonial: deleteTestimonialApi } = useApi();
const testimonials = ref([]);
const showForm = ref(false);
const editingTestimonial = ref(null);

const loadTestimonials = async () => {
  try {
    const response = await getTestimonials();
    testimonials.value = response.data;
  } catch (error) {
    console.error('Error loading testimonials:', error);
  }
};

const editTestimonial = (testimonial) => {
  editingTestimonial.value = { ...testimonial };
  showForm.value = true;
};

const deleteTestimonial = async (id) => {
  if (!confirm('Are you sure you want to delete this testimonial?')) return;
  
  try {
    await deleteTestimonialApi(id);
    await loadTestimonials();
  } catch (error) {
    console.error('Error deleting testimonial:', error);
  }
};

const handleSaved = async () => {
  showForm.value = false;
  editingTestimonial.value = null;
  await loadTestimonials();
};

onMounted(loadTestimonials);
</script> 