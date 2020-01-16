<template>
  <button
    class="py-1 px-2 rounded text-white"
    :class="classSurveyStatus"
    v-text="textSurveyStatus"
    @click="changeStatus"
  >
  </button>
</template>

<script>
import { mapActions } from 'vuex'
export default {
  name: 'DraftOrReadyBtn',
  props: {
    survey: {
      type: Object,
      required: true
    }
  },
  methods: {
    ...mapActions('Survey', ['changeSurveyStatus']),

    changeStatus() {
      const data = {
        status: this.survey.data.status === 'draft' ? 'ready' : 'draft',
        surveyId: this.survey.data.survey_id
      }

      this.changeSurveyStatus(data)
    }
  },
  computed: {
    classSurveyStatus() {
      return {
        'bg-green-500 hover:bg-green-400': this.survey.data.status === 'draft',
        'bg-gray-600 hover:bg-gray-500': this.survey.data.status === 'ready',
      }
    },
    textSurveyStatus() {
      return this.survey.data.status === 'draft' ? 'Habilitar' : 'Ocultar para Edición'
    }
  }
}
</script>
