/** determining the env file name to read from according to the environment */
const path = require("path");
const fs = require("fs");
const env = process.env.NODE_ENV;
const envFile = `.env.${env}`;
const envPath = path.resolve(process.cwd(), envFile);
const defaultEnvFile = ".env";
const defaultEnvPath = path.resolve(process.cwd(), defaultEnvFile);
require("dotenv-expand")(
  require("dotenv").config({
    path: fs.existsSync(envPath) ? envPath : defaultEnvPath,
  })
);
const envFileUsable = fs.existsSync(envPath) ? envFile : defaultEnvFile;
/** env file reading end */

export default {
  // Target: https://go.nuxtjs.dev/config-target
  target: "server",

  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    title: "Buy and Sell Exclusive Feet Pics | Secure Platform for Feet Photos",
    
  //    script: [
  //   {
  //     hid: 'gtm-script',
  //     src: 'https://www.googletagmanager.com/gtag/js?id=G-Z7K3J0SWL0',
  //     async: true,
  //   },
  // ],

    meta: [
      { charset: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1" },
      { hid: "description", name: "description", content: "Discover a trusted marketplace to buy and sell feet pics. Join today for secure transactions and access to exclusive feet photos from top celebrities." },
      { name: "format-detection", content: "telephone=no" },
      { name: 'title', content: 'Buy and Sell Exclusive Feet Pics | Secure Platform for Feet Photos' },
      { name: 'description', content: 'Discover a trusted marketplace to buy and sell feet pics. Join today for secure transactions and access to exclusive feet photos from top celebrities' },
      {
        property: 'og:title',
        content: 'Buy and Sell Exclusive Feet Pics | Secure Platform for Feet Photos',
      },
      {
        property: 'og:site_name',
        content: 'famefeet',
      },
      {
        property: 'og:url',
        content: 'https://famefeet.com/',
      },
      {
        property: 'og:description',
        content: 'Discover a trusted marketplace to buy and sell feet pics. Join today for secure transactions and access to exclusive feet photos from top celebrities.',
      },
      {
        property: 'og:type',
        content: 'website',
      },
      {
        property: 'og:image',
        content: 'https://instagram.flhe3-1.fna.fbcdn.net/v/t51.2885-19/460957366_8474697562590929_3142451485831234722_n.jpg?_nc_ht=instagram.flhe3-1.fna.fbcdn.net&_nc_cat=105&_nc_ohc=Ca-tRkQFoOMQ7kNvgGPsMQY&_nc_gid=712ede8c9f7f477eb4f2474bd0d36b59&edm=ALGbJPMBAAAA&ccb=7-5&oh=00_AYCGo_R4SD515jWDO2Is8SKrSvFyYss91ncXBxfwPFL24Q&oe=6705C166&_nc_sid=7d3ac5',
      },
      // Open Graph / Facebook
      { property: 'og:type', content: 'website' },
      { property: 'og:url', content: 'https://famefeet.com' },
      { property: 'og:title', content: 'Buy and Sell Exclusive Feet Pics | Secure Platform for Feet Photos' },
      { property: 'og:description', content: 'Discover a trusted marketplace to buy and sell feet pics. Join today for secure transactions and access to exclusive feet photos from top celebrities' },
      { property: 'og:image', content: 'https://famefeet.com/_nuxt/img/famefeet-logo.cf4d8a2.png' },

      // Twitter
      { property: 'twitter:card', content: 'summary_large_image' },
      { property: 'twitter:url', content: 'https://famefeet.com' },
      { property: 'twitter:title', content: 'Buy and Sell Exclusive Feet Pics | Secure Platform for Feet Photos' },
      { property: 'twitter:description', content: 'Discover a trusted marketplace to buy and sell feet pics. Join today for secure transactions and access to exclusive feet photos from top celebrities' },
      { property: 'twitter:image', content: 'https://famefeet.com/_nuxt/img/famefeet-logo.cf4d8a2.png' },
    ],
    link: [
      { rel: "icon", type: "image/png", href: "/favicon-32x32.png" },
      {
        rel: "stylesheet",
        href: "https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;800&display=swap",
      },
      {
        rel: "stylesheet",
        href: "https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css",
      },
      {
        rel: "stylesheet",
        href: "https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css",
      },
      {
        rel: "stylesheet",
        href: "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css",
      },
      {
        rel: "apple-touch-icon",
        sizes: "76x76",
        href: "/apple-touch-icon.png",
      },
      {
        rel: "icon",
        type: "image/png",
        sizes: "32x32",
        href: "/favicon-32x32.png",
      },
      {
        rel: "icon",
        type: "image/png",
        sizes: "16x16",
        href: "/favicon-16x16.png",
      },
      { rel: "manifest", href: "/site.webmanifest" },
    ],
  },

  /*
   ** Set the link active classes
   */
  router: {
    linkActiveClass: "active open",
  },

  /*
   ** Customize the progress bar color
   */
  loading: { color: "#42A5CC" },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
    "~/node_modules/font-awesome/css/font-awesome.min.css",
    /* Import Bootstrap Vue Styles */
    "~/node_modules/bootstrap-vue/dist/bootstrap-vue.css",
    /* Import Lightbox Styles */
    "~/assets/css/lightbox.css",
    /* Import Core SCSS */
    { src: "~/assets/scss/style.scss", lang: "scss" },
    // "~/assets/style/navbar.css",
  ],
 // Axios module configuration: https://go.nuxtjs.dev/config-axios
  axios: {
    // Workaround to avoid enforcing hard-coded localhost:3000: https://github.com/nuxt-community/axios-module/issues/308
    baseURL: process.env.BASE_URL,
  },
 

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    // https://go.nuxtjs.dev/eslint
    // '@nuxtjs/eslint-module'
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/bootstrap
    "bootstrap-vue/nuxt",
    // https://go.nuxtjs.dev/axios
    "@nuxtjs/axios",
    // https://go.nuxtjs.dev/pwa
    "@nuxtjs/pwa",
    // https://github.com/nuxt-community/autthis.$nuxt.$auth.$storageh-module
    "@nuxtjs/auth",
    // https://github.com/nuxt-community/dotenv-module
    ["@nuxtjs/dotenv", { filename: envFileUsable }],
    '@nuxtjs/gtm',
  ],

  gtm: {
    id: 'GTM-KASDHK83', // Replace with your GTM ID
    enabled: true, // To ensure it is enabled
    autoInit: true, // Automatically initialize GTM
  },

  auth: {
    strategies: {
      // google: {
      //   client_id: process.env.GOOGLE_CLIENT_ID,
      //   userinfo_endpoint: "https://www.googleapis.com/oauth2/v3/userinfo",
      //   scope: [
      //     "openid",
      //     "profile",
      //     "email",
      //     "https://www.googleapis.com/auth/user.birthday.read",
      //     "https://www.googleapis.com/auth/user.phonenumbers.read",
      //   ],
      // },
      local: {
        endpoints: {
          login: {
            url: "/auth/loginUser",
            method: "post",
            propertyName: "access_token",
          },
          user: {
            url: "/auth/getAuthenticateUser",
            method: "get",
            propertyName: false,
          },
          logout: false,
        },
        tokenRequired: true,
        tokenType: "Bearer",
      },
    },
  },
 // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    "~plugins/mixins/user.js",
    "~/plugins/filters.js",
    { src: "~/plugins/Vuelidate" },
    { src: "~/plugins/laravel-echo", ssr: false },
    { src: "~/plugins/plugin.js", mode: "client" },
    { src: "~/plugins/usps-webtools", ssr: false },
  ],
  // PWA module configuration: https://go.nuxtjs.dev/pwa
  pwa: {
    manifest: {
      lang: "en",
    },
  },
  /* Import bootstrapVue Icons Set */
  bootstrapVue: {
    icons: true,
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
    extend(config, { isDev, isClient }) {
      config.node = {
        fs: "empty",
      };
    },
    // vendor: ["@johmun/vue-tags-input"],
    babel: {
      compact: true,
    },
  },
};
