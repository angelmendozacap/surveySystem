<template>
  <section class="p-4">
    <h1 class="text-3xl mb-2 text-left">Lista de Encuestas</h1>

    <p
      v-if="!surveyList.length"
      class="p-4 mb-5 rounded bg-white shadow text-red-500 text-center font-medium"
    >No se encontraron encuestas</p>

    <div v-else class="mb-5 rounded bg-white shadow">
      <article
        class="survey-item border-b border-gray-400 hover:bg-gray-200 cursor-pointer flex"
        v-for="(survey,index) in surveyList"
        :key="index"
      >
        <router-link :to="survey.links.self" class="flex-1 p-4">
          <div class="flex items-center">
            <h2 class="text-3xl font-semibold text-blue-500" v-text="survey.data.survey_name"></h2>
            <span
              class="ml-2 mt-1 w-3 h-3 rounded-full"
              :class="{'bg-green-600': survey.data.status === 'ready', 'bg-accent': survey.data.status === 'draft'}"
            ></span>
          </div>
          <p class="text-gray-600">Creado {{ survey.data.created_at }}</p>
        </router-link>

        <div class="z-10 flex flex-col">
          <button @click="deleteSurvey(survey.data.survey_id)" class="survey-item__btn px-2 py-1 text-sm bg-red-500 hover:bg-red-400 text-white uppercase">Borrar</button>
          <button class="survey-item__btn px-2 py-1 text-sm bg-teal-500 hover:bg-teal-400 text-white uppercase">Resultados</button>
        </div>

      </article>
    </div>
  </section>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  name: "SurveyList",
  methods: {
    ...mapActions("Survey", ["getSurveys", "deleteSurvey"])
  },
  computed: {
    ...mapGetters("Survey", ["surveyList"])
  },
  mounted() {
    this.getSurveys();
  }
};
</script>

<style lang="scss" scoped>
  .survey-item {

    &__btn {
      opacity: 0;
      transform: scale(0);

      transition: all .3s;
    }

    &:hover &__btn {
      opacity: 1;
      transform: scale(1);
    }
  }
</style>
