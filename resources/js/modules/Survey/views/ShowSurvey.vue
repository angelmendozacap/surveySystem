<template>
  <section class="p-4" v-if="surveyItem">
    <div class="p-4 mb-5 rounded bg-white shadow">
      <h1 class="text-3xl text-left text-blue-500">Encuesta | {{ surveyItem.data.survey_name }}</h1>
      <hr class="my-2">
      <p class="mb-2" v-text="surveyItem.data.description"></p>
      <button class="py-2 px-4 rounded bg-yellow-500 hover:bg-yellow-400 text-white">Agregar Pregunta</button>
    </div>


  </section>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
export default {
  name: 'ShowSurvey',
  methods: {
    ...mapActions('Survey', [
      'getSurvey'
    ])
  },
  computed: {
    ...mapGetters('Survey', [
      'surveyItem'
    ])
  },
  mounted() {
    this.getSurvey(this.$route.params.surveyId)
  }
}
</script>
