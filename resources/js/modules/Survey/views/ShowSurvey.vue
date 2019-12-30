<template>
  <section class="p-4" v-if="surveyItem">
    <div class="p-4 mb-5 rounded bg-white shadow-lg sticky top-0 z-10">
      <h1 class="text-3xl text-left text-blue-500">Encuesta | {{ surveyItem.data.survey_name }}</h1>

      <hr class="my-2" />

      <p class="mb-2" v-text="surveyItem.data.description"></p>

      <button
        @click="createQuestion(surveyItem.data.survey_id)"
        class="py-2 px-4 rounded bg-yellow-500 hover:bg-yellow-400 text-white"
      >Agregar Pregunta</button>
    </div>

    <div v-if="!questionsList.length" class="p-4 mb-5 rounded bg-white shadow">
      <p class="text-red-500 text-center font-medium">No se encontraron preguntas</p>
    </div>
    <div v-else class="mb-5 rounded bg-white shadow">
      <QuestionEditItem v-for="(question, index) in questionsList" :key="index" :question="question" />
    </div>

  </section>
</template>

<script>

import QuestionEditItem from '../../Question/components/QuestionEditItem'

import { mapActions, mapGetters } from "vuex";

export default {
  name: "ShowSurvey",
  components: {
    QuestionEditItem
  },
  methods: {
    ...mapActions("Survey", ["getSurvey"]),
    ...mapActions("Question", ["getQuestions", "createQuestion"])
  },
  computed: {
    ...mapGetters("Survey", ["surveyItem"]),
    ...mapGetters("Question", ["questionsList"])
  },
  mounted() {
    const surveyId = this.$route.params.surveyId;

    this.getSurvey(surveyId);
    this.getQuestions(surveyId);
  }
};
</script>
