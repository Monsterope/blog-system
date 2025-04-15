// https://nuxt.com/docs/api/configuration/nuxt-config
import tailwindcss from "@tailwindcss/vite"
import ui from "@nuxt/ui/vite";

export default defineNuxtConfig({
  compatibilityDate: '2024-11-01',
  devtools: { enabled: true },
  ssr: false,
  
  // plugins: [
  //   { src: '~/plugins/quill.client.ts', mode: 'client' }, // เชื่อมต่อ TinyMCE plugin
  // ],

  runtimeConfig: {
    API_URL: process.env.API_URL,
    public: {
      APP_URL: process.env.APP_URL,
      API_URL: process.env.API_URL,
    }
  },

  modules: [
    '@nuxt/eslint',
    '@nuxt/image',
    '@nuxt/ui',
    '@nuxt/fonts',
    '@nuxt/icon',
    // '@nuxt/content',
    '@nuxtjs/sitemap',
    '@nuxtjs/robots',
  ],

  sitemap: {
    siteUrl: process.env.APP_URL,
    async routes() {
      const blogs = await $fetch(`${process.env.API_URL}/blogs`)
      return blogs.map((blog: any) => `/blog/${blog.id}`)
    } // หรือแบบ dynamic จาก API ก็ได้
  },
  robots: {
    rules: [
      {
        userAgent: '*',
        allow: '/',
        disallow: '/admin'
      }
    ],
    sitemap: `${process.env.APP_URL}/sitemap.xml`
  },
  
  vite: {
    plugins: [
      tailwindcss(),
      ui()
    ]
  },

  css: [
    '~/assets/css/main.css',
  ],
})