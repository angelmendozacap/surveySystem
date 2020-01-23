<template>
  <section class="p-4">
    <h1 class="text-3xl mb-2 text-left">Lista de Encuestas</h1>

    <p
      v-if="!surveyList.length"
      class="p-4 mb-5 rounded bg-white shadow text-red-500 text-center font-medium"
    >No se encontraron encuestas</p>

    <div v-else class="mb-5 rounded bg-white shadow">
      <article
        class="survey-item p-4 border-b border-gray-400 hover:bg-gray-100 cursor-pointer relative"
        v-for="(survey,index) in surveyList"
        :key="index"
      >
        <div class="flex items-center">
          <h2 class="text-2xl font-semibold text-blue-500">
            <router-link
              class="hover:underline"
              :to="survey.links.self"
              v-text="survey.data.survey_name"
            ></router-link>
          </h2>
          <span
            class="ml-2 mt-1 w-3 h-3 rounded-full"
            :class="{'bg-green-600': survey.data.status === 'ready', 'bg-accent': survey.data.status === 'draft'}"
          ></span>
        </div>
        <small class="text-gray-600">Creado {{ survey.data.created_at }}</small>

        <button @click="deleteSurvey(survey.data.survey_id)" class="z-50 survey-item__btn px-2 py-1 text-sm bg-red-500 text-white hover:bg-red-400 uppercase absolute right-0 top-0">Borrar</button>
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
