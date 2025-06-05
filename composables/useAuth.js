import { ref, computed, onMounted, readonly } from 'vue';
import { useApi } from '~/composables/useApi'; // Assuming useApi is in the same directory

export const useAuth = () => {
  const isAuthenticated = ref(false)
  const user = ref(null)
  const loading = ref(false)

  // Check if user is authenticated
  const checkAuth = () => {
    if (process.client) {
      const token = localStorage.getItem('admin_token') || sessionStorage.getItem('admin_token')
      const userData = localStorage.getItem('admin_user') || sessionStorage.getItem('admin_user')
      
      if (token && userData) {
        isAuthenticated.value = true
        user.value = JSON.parse(userData)
        return true
      }
    }
    return false
  }

  // Login function
  const login = async (credentials) => {
    loading.value = true
    try {
      const { login } = useApi()
      const response = await login(credentials)
      
      if (response.token) {
        // Store token and user data
        localStorage.setItem('admin_token', response.token)
        localStorage.setItem('admin_user', JSON.stringify(response.user))
        
        isAuthenticated.value = true
        user.value = response.user
        
        return { success: true }
      }
    } catch (error) {
      console.error('Login error:', error)
      return { 
        success: false,
        message: error.data?.message || 'Login failed'
      }
    } finally {
      loading.value = false
    }
  }

  // Logout function
  const logout = async () => {
    try {
      const { logout: apiLogout } = useApi()
      await apiLogout()
    } catch (error) {
      console.error('Logout error:', error)
    } finally {
      // Clear local storage regardless
      localStorage.removeItem('admin_token')
      localStorage.removeItem('admin_user')
      sessionStorage.removeItem('admin_token')
      sessionStorage.removeItem('admin_user')
      
      isAuthenticated.value = false
      user.value = null
      
      // Redirect to login
      await navigateTo('/admin/login')
    }
  }

  // Initialize auth state
  onMounted(() => {
    checkAuth()
  })

  return {
    isAuthenticated: readonly(isAuthenticated),
    user: readonly(user),
    loading: readonly(loading),
    login,
    logout,
    checkAuth
  }
} 