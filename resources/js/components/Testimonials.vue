<template>
  <section
    id="testimonials"
    class="relative overflow-hidden py-16 bg-[#14141E]"
  >
    <div class="lg:w-[80%] mx-auto px-4">
      <h2 class="text-3xl font-bold text-center mb-8 animate-fade-in">
        <span class="text-[#FF3600]">Peoples</span> Feedback
      </h2>
      
      <!-- Loading State -->
      <div v-if="pending" class="flex justify-center items-center h-64">
        <div class="text-white animate-pulse">Loading testimonials...</div>
      </div>

      <!-- Swiper component for automatic sliding -->
      <swiper
        v-else-if="activeTestimonials?.length"
        :slides-per-view="2"
        :space-between="10"
        loop
        :autoplay="{ delay: 3000, disableOnInteraction: false }"
        speed="500"
        :breakpoints="{
          320: { slidesPerView: 1 },
          768: { slidesPerView: 2 },
          1024: { slidesPerView: 2 }
        }"
        :effect="'fade'"
        :fadeEffect="{ crossFade: true }"
      >
        <!-- Dynamic Testimonials from Backend -->
        <swiper-slide v-for="testimonial in activeTestimonials" :key="testimonial.id">
          <div class="testimonial-card hover:scale-105 transition-transform duration-300">
            <img
              :src="testimonial.image_url || '/default-avatar.jpg'"
              :alt="testimonial.name"
              class="testimonial-img hover:ring-2 hover:ring-[#FF3600] transition-all duration-300"
            />
            <p class="text-xl text-[#fff] mb-2 text-center">
              "{{ testimonial.message }}"
            </p>
            <p class="text-lg font-bold text-[#fff]">{{ testimonial.name }}</p>
            <p class="text-gray-300">
              {{ testimonial.position }}
              <span v-if="testimonial.company"> · {{ testimonial.company }}</span>
            </p>
            
            <!-- Rating Stars -->
            <div v-if="testimonial.rating" class="flex justify-center mt-2">
              <span v-for="n in testimonial.rating" :key="n" class="text-yellow-400 text-sm hover:scale-110 transition-transform duration-300">★</span>
            </div>
          </div>
        </swiper-slide>
      </swiper>

      <!-- Empty State -->
      <div v-else class="text-center py-12">
        <p class="text-white animate-fade-in">No testimonials available at the moment.</p>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/swiper-bundle.css";
import { computed } from 'vue';

// Fetch testimonials from API
const { getTestimonials } = useApi();
const { data: testimonials, pending } = await useLazyAsyncData('testimonials', () => getTestimonials());

// Show only active testimonials, sorted by sort_order
const activeTestimonials = computed(() => {
  if (!testimonials.value) return [];
  
  return testimonials.value
    .filter(t => t.is_active)
    .sort((a, b) => a.sort_order - b.sort_order);
});
</script>

<style scoped>
.testimonial-card {
  background-color: #14141e;
  padding: 2rem;
  border-radius: 0.5rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.testimonial-card:hover {
  box-shadow: 0 8px 16px rgba(255, 54, 0, 0.2);
}

.testimonial-img {
  width: 6rem;
  height: 6rem;
  border-radius: 50%;
  object-fit: cover;
  margin-bottom: 1rem;
  transition: all 0.3s ease;
}

/* Custom animations */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.animate-fade-in {
  animation: fadeIn 0.5s ease-in;
}

/* Swiper custom styles */
:deep(.swiper-slide) {
  transition: transform 0.3s ease;
}

:deep(.swiper-slide-active) {
  transform: scale(1.02);
}
</style> 