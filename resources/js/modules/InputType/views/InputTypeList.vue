<template>
  <section class="p-4" v-if="inputTypesList">
    <div class="flex items-center justify-between mb-2">
      <h1 class="text-3xl text-left">Tipos de Preguntas</h1>

      <button @click="showModal = !showModal" class="px-2 py-1 rounded text-white bg-green-500 hover:bg-green-400">Agregar Tipo</button>
    </div>

    <p
      v-if="!inputTypesList.data.length"
      class="p-4 mb-5 rounded bg-white shadow text-red-500 text-center font-medium"
    >No se encontraron tipos de preguntas</p>

    <div v-else class="mb-5 rounded bg-white shadow">
      <InputTypeItem v-for="(inputType,index) in inputTypesList.data" :inputType="inputType" :key="index" />
    </div>

    <div v-if="showModal" @click="showModal = !showModal" class="absolute right-0 left-0 bottom-0 top-0 z-10"></div>
    <div v-if="showModal" class="absolute right-0 top-0 p-4 mt-16 mr-4 bg-blue-600 rounded-lg z-20 shadow-2xl">
      <form @submit.prevent="createNewInputType">
        <div class="flex items-center mb-2">
          <div class="w-1/3">
            <label class="block text-white font-bold mb-1 mb-0" for="type">
              Tipo
            </label>
          </div>
          <div class="w-2/3">
            <input autocomplete="off" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-accent" id="type" name="type" type="text">
            <small v-if="errorsList" class="font-bold bg-red-500 text-white px-2 py-1 rounded-lg">Campo Requerido</small>
          </div>
        </div>

        <div class="flex items-center mb-2">
          <div class="w-1/3">
            <label class="block text-white font-bold mb-1 mb-0" for="display_name">
              Nombre a mostrar
            </label>
          </div>
          <div class="w-2/3">
            <input autocomplete="off" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-accent" id="display_name" name="display_name" type="text">
            <small v-if="errorsList" class="font-bold bg-red-500 text-white px-2 py-1 rounded-lg">Campo Requerido</small>
          </div>
        </div>

        <div class="flex justify-end">
          <button type="submit" class="px-2 py-1 rounded bg-yellow-500 hover:bg-yellow-400 text-white roun">Guardar</button>
        </div>
      </form>
    </div>
  </section>
</template>

<script>

import InputTypeItem from '../components/InputTypeItem'

import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'InputTypeList',
  components: {
    InputTypeItem
  },
  data() {
    return {
      showModal: false
    }
  },
  methods: {
    ...mapActions("InputType", [
      "getInputTypes",
      "createInputType",
    ]),
    async createNewInputType(e) {
      const data = {
        type: e.target.type.value,
        display_name: e.target.display_name.value
      }
      await this.createInputType(data)

      if (!this.errorsList) {
        e.target.reset()
        this.showModal = false
      }
    }
  },
  computed: {
    ...mapGetters("InputType", ["inputTypesList", "errorsList"])
  },
  mounted() {
    this.getInputTypes();
  }
}
</script>
