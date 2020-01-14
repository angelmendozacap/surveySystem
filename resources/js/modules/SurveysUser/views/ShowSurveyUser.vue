<template>
  <section class="p-4" v-if="surveyUserItem">
    <div class="p-4 mb-8 rounded bg-white shadow-lg">
      <h1 class="text-4xl leading-tight text-left text-blue-500">Encuesta | {{ surveyUserItem.data.survey_name }}</h1>

      <hr class="my-2" />

      <p class="mb-2" v-text="surveyUserItem.data.description"></p>

    </div>

      <form @submit.prevent="submitQuestions">
        <div class="flex flex-col items-center">
          <div class="md:w-3/4 w-full">
            <SurveyUserItem v-for="(question,index) in surveyUserItem.data.questions" :key="index" :question="question" :index="index + 1" />
            <button type="submit" class=" w-full px-3 py-2 rounded text-lg text-white bg-green-500 hover:bg-green-400">Enviar Respuestas</button>
          </div>
        </div>
      </form>
  </section>
</template>

<script>

import SurveyUserItem from '../components/SurveyUserItem'

import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'ShowSurveyUser',
  components: {
    SurveyUserItem
  },
  methods: {
    ...mapActions("SurveysUser", ["getOneSurvey", "answerSurvey"]),

    submitQuestions(e) {
      const responses = []
      this.surveyUserItem.data.questions.forEach(question => {
        const answer = {
          answer_id: e.target[question.data.code_name].value || null,
          question_id: question.data.question_id
        }

        responses.push(answer)
      })
      const data = {
        surveyId: this.surveyUserItem.data.survey_id,
        responses
      }

      this.answerSurvey(data)
    }
  },
  computed: {
    ...mapGetters("SurveysUser", ["surveyUserItem"]),
  },
  mounted() {
    const surveyId = this.$route.params.surveyId;

    this.getOneSurvey(surveyId);
  }
}
</script>
