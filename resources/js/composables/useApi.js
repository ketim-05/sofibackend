import axios from 'axios';

const api = axios.create({
  baseURL: '/api/v1/admin',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
});

// Add request interceptor to include auth token
api.interceptors.request.use(config => {
  const token = localStorage.getItem('admin_token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

export function useApi() {
  // Testimonials
  const getTestimonials = async () => {
    const response = await api.get('/testimonials');
    return response.data;
  };

  const getTestimonial = async (id) => {
    const response = await api.get(`/testimonials/${id}`);
    return response.data;
  };

  const createTestimonial = async (data) => {
    const response = await api.post('/testimonials', data);
    return response.data;
  };

  const updateTestimonial = async (id, data) => {
    const response = await api.put(`/testimonials/${id}`, data);
    return response.data;
  };

  const deleteTestimonial = async (id) => {
    const response = await api.delete(`/testimonials/${id}`);
    return response.data;
  };

  // Auth functions
  const login = async (credentials) => {
    const response = await api.post('/login', credentials);
    return response.data;
  };

  const logout = async () => {
    const response = await api.post('/logout');
    return response.data;
  };

  return {
    // Testimonials
    getTestimonials,
    getTestimonial,
    createTestimonial,
    updateTestimonial,
    deleteTestimonial,
    // Auth
    login,
    logout
  };
} 