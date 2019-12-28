<template>
  <section class="p-4">
    <h1 class="text-3xl text-left mb-5">Nueva Encuesta</h1>

    <form @submit.prevent="submitForm">
      <InputField
        name="name"
        label="Título de la Encuesta"
        placeholder="Título"
        @update:field="form.name = $event"
        :errors="errorsList"
      />

      <InputField
        name="description"
        label="Descripción de la Encuesta"
        placeholder="Descripción"
        @update:field="form.description = $event"
        :errors="errorsList"
      />

      <div class="flex justify-end">
        <button
          type="submit"
          class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400"
        >Crear Nueva Encuesta</button>
      </div>
    </form>
  </section>
</template>

<script>

import InputField from "../../../components/InputField";

import { mapActions, mapGetters } from 'vuex'

export default {
  name: "CreateSurvey",
  components: {
    InputField
  },
  data() {
    return {
      form: {
        name: '',
        description: '',
        status: 'draft'
      }
    };
  },
  methods: {
    ...mapActions('Survey', [
      'createSurvey'
    ]),
    async submitForm() {
      await this.createSurvey(this.form)

      if (!this.surveyItem) return

      this.$router.push(this.surveyItem.links.self)
    }
  },
  computed: {
    ...mapGetters('Survey', [
      'surveyItem',
      'errorsList',
    ])
  }
};
</script>
