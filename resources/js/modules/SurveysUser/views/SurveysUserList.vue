<template>
  <section class="p-4">
    <h1 class="text-3xl mb-2 text-left">Encuestas a Responder</h1>

    <p
      v-if="!surveysUserList || !surveysUserList.data.length"
      class="p-4 mb-5 rounded bg-white shadow text-red-500 text-center font-medium"
    >No se encontraron encuestas</p>

    <div v-else class="mb-5 rounded bg-white shadow">
      <div v-if="surveysTakenByMe">
        <router-link
          tag="article"
          :to="survey.links.self"
          :class="{'bg-gray-200 opacity-75': disableSurvey(surveysTakenByMe.data, survey.data.survey_id)}"
          class="p-4 border-b border-gray-400 hover:bg-gray-200 cursor-pointer"
          v-for="(survey,index) in surveysUserList.data"
          :key="index"
        >
          <h2 class="text-2xl font-semibold text-blue-500" v-text="survey.data.survey_name"></h2>

          <p v-if="disableSurvey(surveysTakenByMe.data, survey.data.survey_id)" class="mt-2 font-light text-muted italic text-green-600 flex items-center">
            <svg class="fill-current mr-1 w-5 h-5" viewBox="0 -21 512.016 512" xmlns="http://www.w3.org/2000/svg"><path d="m234.667969 469.339844c-129.386719 0-234.667969-105.277344-234.667969-234.664063s105.28125-234.6679685 234.667969-234.6679685c44.992187 0 88.765625 12.8203125 126.589843 37.0976565 7.425782 4.78125 9.601563 14.679687 4.820313 22.125-4.796875 7.445312-14.675781 9.597656-22.121094 4.820312-32.640625-20.972656-70.441406-32.042969-109.289062-32.042969-111.746094 0-202.667969 90.921876-202.667969 202.667969 0 111.742188 90.921875 202.664063 202.667969 202.664063 111.742187 0 202.664062-90.921875 202.664062-202.664063 0-6.679687-.320312-13.292969-.9375-19.796875-.851562-8.8125 5.589844-16.621094 14.378907-17.472656 8.832031-.8125 16.617187 5.589844 17.472656 14.378906.722656 7.53125 1.085937 15.167969 1.085937 22.890625 0 129.386719-105.277343 234.664063-234.664062 234.664063zm0 0"/><path d="m261.332031 288.007812c-4.09375 0-8.191406-1.558593-11.304687-4.691406l-96-96c-6.25-6.253906-6.25-16.386718 0-22.636718s16.382812-6.25 22.632812 0l84.695313 84.695312 223.335937-223.339844c6.253906-6.25 16.386719-6.25 22.636719 0s6.25 16.382813 0 22.632813l-234.667969 234.667969c-3.136718 3.113281-7.230468 4.671874-11.328125 4.671874zm0 0"/></svg>
            Respondido {{ disableSurvey(surveysTakenByMe.data, survey.data.survey_id) }}
          </p>
          <p v-else class="mt-2 font-light text-muted italic text-orange-500 flex items-center">
            <svg class="fill-current mr-1 w-5 h-5" enable-background="new 0 0 512 512" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><g><g><path d="m256 512c-68.38 0-132.667-26.629-181.02-74.98-48.351-48.353-74.98-112.64-74.98-181.02s26.629-132.667 74.98-181.02c48.353-48.351 112.64-74.98 181.02-74.98s132.667 26.629 181.02 74.98c48.351 48.353 74.98 112.64 74.98 181.02s-26.629 132.667-74.98 181.02c-48.353 48.351-112.64 74.98-181.02 74.98zm0-482c-60.367 0-117.12 23.508-159.806 66.194s-66.194 99.439-66.194 159.806 23.508 117.12 66.194 159.806 99.439 66.194 159.806 66.194 117.12-23.508 159.806-66.194 66.194-99.439 66.194-159.806-23.508-117.12-66.194-159.806-99.439-66.194-159.806-66.194z"/></g><g><path d="m241 60.036h30v40.032h-30z"/></g><g><path d="m360.398 116.586h40.032v30h-40.032z" transform="matrix(.707 -.707 .707 .707 18.375 307.534)"/></g><g><path d="m411.932 241h40.032v30h-40.032z"/></g><g><path d="m365.414 360.398h30v40.032h-30z" transform="matrix(.707 -.707 .707 .707 -157.573 380.414)"/></g><g><path d="m241 411.932h30v40.032h-30z"/></g><g><path d="m111.57 365.414h40.032v30h-40.032z" transform="matrix(.707 -.707 .707 .707 -230.453 204.466)"/></g><g><path d="m60.036 241h40.032v30h-40.032z"/></g><g><path d="m116.586 111.57h30v40.032h-30z" transform="matrix(.707 -.707 .707 .707 -54.505 131.586)"/></g><g><path d="m361.892 271h-120.892v-120.892h30v90.892h90.892z"/></g></g></svg>
            Encuesta Pendiente
          </p>

        </router-link>
      </div>
    </div>
  </section>
</template>

<script>

import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'SurveysUserList',
  methods: {
    ...mapActions("SurveysUser", ["getAllSurveys"]),

    disableSurvey(surveysTakenByMe, survey_id) {
      const surveyTaken = surveysTakenByMe.find(surveyTaken => surveyTaken.data.survey.data.survey_id == survey_id)

      if (!surveyTaken) {
        return false
      }

      return surveyTaken.data.taken_at
    }
  },
  computed: {
    ...mapGetters("SurveysUser", ["surveysUserList", "surveysTakenByMe"])
  },
  mounted() {
    this.getAllSurveys();
  }
}
</script>
