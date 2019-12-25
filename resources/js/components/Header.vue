<template>
  <header class="bg-white h-12 pl-4 flex items-center justify-between border-b border-gray-400 shadow-sm">
    <router-link :to="{name: 'home'}">
      <p class="text-primary text-2xl tracking-tighter">Encuestas FIS</p>
    </router-link>

    <div class="h-full px-4 py-1 text-white bg-blue-600 hover:bg-blue-500 flex items-center">
      <h3 class="text-capitalize" v-if="authUser" v-text="authUser.data.name"></h3>
    </div>
  </header>
</template>

<script>

import { mapGetters } from 'vuex'

export default {
  name: 'Header',
  computed: {
    ...mapGetters('User', [
      'authUser'
    ])
  }
}
</script>
