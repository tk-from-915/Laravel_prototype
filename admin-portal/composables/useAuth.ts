export type UserRole = 'admin' | 'member'

export interface AuthUser {
  id: number
  name: string
  email: string
  role: UserRole
}

export const useAuth = () => {
  // トークン: localStorage から復元し、useState で全コンポーネント間で共有
  const token = useState<string | null>('auth_token', () => {
    if (import.meta.client) return localStorage.getItem('auth_token')
    return null
  })

  const currentUser = useState<AuthUser | null>('currentUser', () => null)

  const isAuthenticated = computed(() => !!token.value)
  const isAdmin = computed(() => currentUser.value?.role === 'admin')

  const setAuth = (newToken: string, user: AuthUser) => {
    token.value = newToken
    currentUser.value = user
    if (import.meta.client) localStorage.setItem('auth_token', newToken)
  }

  const clearAuth = () => {
    token.value = null
    currentUser.value = null
    if (import.meta.client) localStorage.removeItem('auth_token')
  }

  return { token, currentUser, isAuthenticated, isAdmin, setAuth, clearAuth }
}
