export type UserRole = 'admin' | 'viewer'

export interface AuthUser {
  id: number
  name: string
  email: string
  role: UserRole
}

export const useAuth = () => {
  // TODO: GraphQL から認証済みユーザー情報を取得する
  const currentUser = useState<AuthUser>('currentUser', () => ({
    id: 1,
    name: 'toki',
    email: 'aaa@email.com',
    role: 'admin',
  }))

  const isAdmin = computed(() => currentUser.value.role === 'admin')

  return { currentUser, isAdmin }
}
