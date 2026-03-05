// 未認証ユーザーを /login にリダイレクトするグローバルミドルウェア
// SSR では localStorage が使えないため、クライアント側のみで動作させる
export default defineNuxtRouteMiddleware((to) => {
  if (import.meta.server) return

  const { token } = useAuth()

  const publicPaths = ['/login', '/signup', '/password-reset']
  if (!publicPaths.includes(to.path) && !token.value) {
    return navigateTo('/login')
  }
})
