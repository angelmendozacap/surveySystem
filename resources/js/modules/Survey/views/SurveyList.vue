<template>
  <section class="p-4">
    <h1 class="text-3xl mb-2 text-left">Lista de Encuestas</h1>

    <p
      v-if="!surveyList.length"
      class="p-4 mb-5 rounded bg-white shadow text-red-500 text-center font-medium"
    >No se encontraron encuestas</p>

    <div v-else class="mb-5 rounded bg-white shadow">
      <router-link
        :to="survey.links.self"
        tag="article"
        class="p-4 border-b border-gray-400 hover:bg-gray-200 cursor-pointer"
        v-for="(survey,index) in surveyList"
        :key="index"
      >
        <div class="flex items-center">
          <h2 class="text-xl font-semibold text-blue-500" v-text="survey.data.survey_name"></h2>
          <span
            class="ml-2 mt-1 w-3 h-3 rounded-full"
            :class="{'bg-green-600': survey.data.status === 'ready', 'bg-accent': survey.data.status === 'draft'}"
          ></span>
        </div>
        <small class="text-gray-600">Creado {{ survey.data.created_at }}</small>
      </router-link>
    </div>
  </section>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  name: "SurveyList",
  methods: {
    ...mapActions("Survey", ["getSurveys"])
  },
  computed: {
    ...mapGetters("Survey", ["surveyList"])
  },
  mounted() {
    this.getSurveys();
  }
};
</script>
