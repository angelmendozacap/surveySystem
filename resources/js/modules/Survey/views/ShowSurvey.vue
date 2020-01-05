<template>
  <section class="p-4" v-if="surveyItem">
    <div class="p-4 mb-5 rounded bg-white shadow-lg sticky top-0 z-10">
      <div class="flex items-center justify-between">
        <h1 class="text-3xl text-left text-blue-500">Encuesta | {{ surveyItem.data.survey_name }}</h1>
        <button class="py-1 px-2 text-sm bg-green-500 text-white rounded hover:bg-green-400">Habilitar Encuesta</button>
      </div>

      <hr class="my-2" />

      <p class="mb-2" v-text="surveyItem.data.description"></p>

      <button
        @click="createQuestion(surveyItem.data.survey_id)"
        class="py-2 px-4 rounded bg-yellow-500 hover:bg-yellow-400 text-white flex items-center"
      >
        <svg version="1.1" class="fill-current w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 52 52" style="enable-background:new 0 0 52 52;" xml:space="preserve"><g><path d="M26,0C11.664,0,0,11.663,0,26s11.664,26,26,26s26-11.663,26-26S40.336,0,26,0z M26,50C12.767,50,2,39.233,2,26S12.767,2,26,2s24,10.767,24,24S39.233,50,26,50z"/><path d="M38.5,25H27V14c0-0.553-0.448-1-1-1s-1,0.447-1,1v11H13.5c-0.552,0-1,0.447-1,1s0.448,1,1,1H25v12c0,0.553,0.448,1,1,1s1-0.447,1-1V27h11.5c0.552,0,1-0.447,1-1S39.052,25,38.5,25z"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
        Agregar Pregunta
      </button>
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
