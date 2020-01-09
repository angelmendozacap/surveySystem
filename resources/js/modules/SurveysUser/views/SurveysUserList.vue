<template>
  <section class="p-4">
    <h1 class="text-3xl mb-2 text-left">Encuestas a Responder</h1>

    <p
      v-if="!surveysUserList || !surveysUserList.data.length"
      class="p-4 mb-5 rounded bg-white shadow text-red-500 text-center font-medium"
    >No se encontraron encuestas</p>

    <div v-else class="mb-5 rounded bg-white shadow">
      <router-link
        :to="survey.links.self"
        tag="article"
        class="p-4 border-b border-gray-400 hover:bg-gray-200 cursor-pointer"
        v-for="(survey,index) in surveysUserList.data"
        :key="index"
      >
        <h2 class="text-xl font-semibold text-blue-500" v-text="survey.data.survey_name"></h2>

        <small class="text-gray-600">Creado {{ survey.data.created_at }}</small>
      </router-link>
    </div>
  </section>
</template>

<script>

import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'SurveysUserList',
  methods: {
    ...mapActions("SurveysUser", ["getAllSurveys"])
  },
  computed: {
    ...mapGetters("SurveysUser", ["surveysUserList"])
  },
  mounted() {
    this.getAllSurveys();
  }
}
</script>
