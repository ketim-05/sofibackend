<template>
  <form @submit.prevent="handleSubmit" class="space-y-4">
    <div>
      <label for="name" class="block text-sm font-medium text-gray-700">Name *</label>
      <input
        type="text"
        id="name"
        v-model="form.name"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        required
      />
    </div>

    <div>
      <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
      <input
        type="text"
        id="position"
        v-model="form.position"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
      />
    </div>

    <div>
      <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
      <input
        type="text"
        id="company"
        v-model="form.company"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
      />
    </div>

    <div>
      <label for="message" class="block text-sm font-medium text-gray-700">Message *</label>
      <textarea
        id="message"
        v-model="form.message"
        rows="4"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        required
      ></textarea>
    </div>

    <div>
      <label for="rating" class="block text-sm font-medium text-gray-700">Rating *</label>
      <select
        id="rating"
        v-model="form.rating"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        required
      >
        <option value="1">1 Star</option>
        <option value="2">2 Stars</option>
        <option value="3">3 Stars</option>
        <option value="4">4 Stars</option>
        <option value="5">5 Stars</option>
      </select>
    </div>

    <div>
      <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
      <input
        type="file"
        id="image"
        @change="handleImageUpload"
        class="mt-1 block w-full"
        accept="image/*"
      />
    </div>

    <div class="flex items-center">
      <input
        type="checkbox"
        id="is_active"
        v-model="form.is_active"
        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
      />
      <label for="is_active" class="ml-2 block text-sm text-gray-700">Active</label>
    </div>

    <div>
      <label for="sort_order" class="block text-sm font-medium text-gray-700">Sort Order</label>
      <input
        type="number"
        id="sort_order"
        v-model="form.sort_order"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
      />
    </div>

    <div class="flex justify-end space-x-3">
      <button
        type="button"
        @click="$emit('cancel')"
        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
      >
        Cancel
      </button>
      <button
        type="submit"
        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700"
        :disabled="loading"
      >
        {{ loading ? 'Saving...' : 'Save' }}
      </button>
    </div>
  </form>
</template>

<script setup>
import { ref } from 'vue';
import { useApi } from '@/composables/useApi';

const props = defineProps({
  testimonial: {
    type: Object,
    default: () => ({
      name: '',
      position: '',
      company: '',
      message: '',
      rating: 5,
      image_url: '',
      is_active: true,
      sort_order: 0
    })
  }
});

const emit = defineEmits(['saved', 'cancel']);

const { createTestimonial, updateTestimonial } = useApi();
const loading = ref(false);

const form = ref({
  name: props.testimonial.name,
  position: props.testimonial.position,
  company: props.testimonial.company,
  message: props.testimonial.message,
  rating: props.testimonial.rating,
  image_url: props.testimonial.image_url,
  is_active: props.testimonial.is_active,
  sort_order: props.testimonial.sort_order
});

const handleImageUpload = (event) => {
  const file = event.target.files[0];
  if (file) {
    // Here you would typically upload the file to your server
    // and get back a URL. For now, we'll just use a placeholder
    form.value.image_url = URL.createObjectURL(file);
  }
};

const handleSubmit = async () => {
  try {
    loading.value = true;
    const data = { ...form.value };
    
    if (props.testimonial.id) {
      await updateTestimonial(props.testimonial.id, data);
    } else {
      await createTestimonial(data);
    }
    
    emit('saved');
  } catch (error) {
    console.error('Error saving testimonial:', error);
    // You might want to show an error message to the user here
  } finally {
    loading.value = false;
  }
};
</script> 