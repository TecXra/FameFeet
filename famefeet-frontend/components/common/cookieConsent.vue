<template>
  <div v-if="showCookieConsent" class="cookie-consent" :style="cookieConsentStyle">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-8">
          <p :style="{ margin: 0 }">
            This website uses cookies to ensure you get the best experience. By using our site, you acknowledge that you have read and understand our Cookie Policy. 
            <nuxt-link class="text-white ms-3" :to="'/privacy'" target="_blank">
              Learn More
            </nuxt-link>
          </p>
        </div>
        <div class="col-12 col-md-4 text-right">
          <button class="btn btn-light" @click="handleAccept">Accept</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Cookies from 'js-cookie'

export default {
  name: 'CookieConsent',

  data() {
    return {
      showCookieConsent: true,
    }
  },

  mounted() {
    const cookieAccepted = Cookies.get('cookieAccepted')
    if (cookieAccepted) {
      this.showCookieConsent = false
    }
  },

  methods: {
    handleAccept() {
      const expirationDate = 365 // Set expiration to 1 year

      Cookies.set('cookieAccepted', true, { expires: expirationDate, path: '/' })
      this.showCookieConsent = false
    },
  },

  computed: {
    cookieConsentStyle() {
      return {
        position: 'fixed',
        bottom: '0',
        left: '0',
        width: '100%',
        background: 'rgba(0, 0, 0, 0.8)',
        color: '#fff',
        padding: '20px 20px',
        fontSize: '14px',
      }
    },
  },
}
</script>

<style scoped>
.cookie-consent {
  z-index: 1000;
}
</style>
