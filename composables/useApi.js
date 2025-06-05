import { ref, computed, onMounted, readonly } from 'vue';
import { useAuth } from '~/composables/useAuth'; // Import useAuth

export const useApi = () => {
  const config = useRuntimeConfig()
  const baseURL = config.public.apiBase || 'http://localhost:8000/api/v1'

  // Generic API call function with error handling
  const apiCall = async (endpoint, options = {}) => {
    try {
      // Retrieve the token using useAuth
      const { checkAuth } = useAuth();
      checkAuth(); // Ensure auth state is checked
      const token = localStorage.getItem('admin_token') || sessionStorage.getItem('admin_token');

      const headers = {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        ...options.headers
      };

      // Add Authorization header if token exists
      if (token) {
        headers['Authorization'] = `Bearer ${token}`;
      }

      const response = await $fetch(`${baseURL}${endpoint}`, {
        headers: headers,
        ...options
      })
      return response
    } catch (error) {
      console.error(`API Error for ${endpoint}:`, error)
      throw error
    }
  }

  return {
    // Blog API functions
    getBlogs: (page = 1, perPage = 16) => 
      apiCall(`/blogs?page=${page}&per_page=${perPage}`),
    getBlog: (id) => 
      apiCall(`/blogs/${id}`),
    getFeaturedBlogs: () => 
      apiCall('/blogs/featured'),

    // Testimonial API functions (Public)
    getTestimonials: () => 
      apiCall('/testimonials'),
    getFeaturedTestimonials: () => 
      apiCall('/testimonials/featured'),

    // Testimonial API functions (Admin)
    adminGetTestimonials: () =>
      apiCall('/admin/testimonials'), // Assuming an admin index endpoint exists
    adminCreateTestimonial: (data) =>
      apiCall('/admin/testimonials', { method: 'POST', body: data }),
    adminUpdateTestimonial: (id, data) =>
      apiCall(`/admin/testimonials/${id}`, { method: 'PUT', body: data }),
    adminDeleteTestimonial: (id) =>
      apiCall(`/admin/testimonials/${id}`, { method: 'DELETE' }),
    // Assuming backend has endpoints for toggling featured/status
    adminToggleTestimonialFeatured: (id) =>
      apiCall(`/admin/testimonials/${id}/toggle-featured`, { method: 'PATCH' }), // Or PUT, depending on backend
    adminUpdateTestimonialStatus: (id, isActive) =>
      apiCall(`/admin/testimonials/${id}/status`, { method: 'PATCH', body: { is_active: isActive } }), // Or PUT

    // Generic API call
    apiCall
  }
} 