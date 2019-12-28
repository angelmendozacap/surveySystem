<template>
  <section class="p-4">
    <h1 class="text-3xl text-left">Lista de Encuestas</h1>

  </section>
</template>

<script>

import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'SurveyList',
  methods: {
    ...mapActions('Survey', [
      'getSurveys'
    ])
  },
  computed: {
    ...mapGetters('Survey', [
      'surveyList'
    ])
  },
  mounted() {
    this.getSurveys()
  }
}
</script>
