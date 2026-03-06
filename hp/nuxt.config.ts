export default defineNuxtConfig({
  compatibilityDate: '2025-05-15',
  ssr: false,
  devtools: { enabled: true },

  devServer: {
    host: '0.0.0.0',
    port: 3000,
  },

  css: [
    '~/assets/css/main.css',
    '~/assets/css/page.css',
  ],

  app: {
    head: {
      link: [
        {
          rel: 'icon',
          type: 'image/svg+xml',
          href: '/images/leef.svg',
        },
        {
          rel: 'stylesheet',
          href: 'https://fonts.googleapis.com/css2?family=Ribeye&display=swap',
        },
        {
          rel: 'stylesheet',
          href: 'https://fonts.googleapis.com/earlyaccess/kokoro.css',
        },
      ],
    },
  },

  runtimeConfig: {
    public: {
      graphqlUrl: process.env.NUXT_PUBLIC_GRAPHQL_URL || 'http://localhost:8000/graphql',
    },
  },
})
