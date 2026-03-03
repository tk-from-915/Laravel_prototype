export default defineNuxtConfig({
  compatibilityDate: '2025-05-15',
  devtools: { enabled: true },

  css: ['~/assets/css/admin.scss'],

  devServer: {
    host: '0.0.0.0',
    port: 3000,
  },

  vite: {
    css: {
      preprocessorOptions: {
        scss: {
          // _variables.scss を全コンポーネントの <style lang="scss"> に自動 inject
          additionalData: '@use "~/assets/css/_variables.scss" as *;',
        },
      },
    },
  },

  runtimeConfig: {
    public: {
      graphqlUrl: process.env.NUXT_PUBLIC_GRAPHQL_URL || 'http://localhost:8000/graphql',
    },
  },
})
