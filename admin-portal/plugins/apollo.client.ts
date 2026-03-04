import { ApolloClient, InMemoryCache, createHttpLink, ApolloLink } from '@apollo/client/core'
import { DefaultApolloClient } from '@vue/apollo-composable'

export default defineNuxtPlugin((nuxtApp) => {
  const config = useRuntimeConfig()

  const httpLink = createHttpLink({
    uri: config.public.graphqlUrl,
  })

  // リクエストごとに localStorage からトークンを読んで Authorization ヘッダーを付与
  const authLink = new ApolloLink((operation, forward) => {
    const token = localStorage.getItem('auth_token')
    if (token) {
      operation.setContext({
        headers: { Authorization: `Bearer ${token}` },
      })
    }
    return forward(operation)
  })

  const apolloClient = new ApolloClient({
    link: authLink.concat(httpLink),
    cache: new InMemoryCache(),
  })

  nuxtApp.vueApp.provide(DefaultApolloClient, apolloClient)
  // auth.client.ts から $apolloClient としてアクセスできるようにする
  nuxtApp.provide('apolloClient', apolloClient)
})
