import { gql } from '@apollo/client/core'

const ME_QUERY = gql`
  query Me {
    me {
      id
      name
      email
      role
    }
  }
`

// アプリ起動時: localStorage にトークンがあれば me query でユーザー情報を復元する
export default defineNuxtPlugin(async (nuxtApp) => {
  const { token, currentUser, clearAuth } = useAuth()

  if (!token.value) return

  try {
    const apolloClient = (nuxtApp as any).$apolloClient
    const result = await apolloClient.query({
      query: ME_QUERY,
      fetchPolicy: 'network-only',
    })
    currentUser.value = {
      id:    result.data.me.id,
      name:  result.data.me.name,
      email: result.data.me.email,
      role:  result.data.me.role,
    }
  } catch {
    // トークンが無効なら認証状態をリセット
    clearAuth()
  }
})
