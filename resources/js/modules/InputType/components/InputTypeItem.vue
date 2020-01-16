<template>
  <article class="inputType__item p-4 border-b border-gray-400 hover:bg-gray-200 cursor-pointer relative">
    <h2 class="text-xl font-semibold text-blue-500" v-text="inputType.data.display_name"></h2>
    <p class="text-gray-800">Tipo de Pregunta: <code class="text-yellow-500">{{ inputType.data.type }}</code></p>
    <small class="text-gray-600">Creado {{ inputType.data.created_at }}</small>

    <button @click="deleteInputType(inputType.data.id)" class="inputType__delete-btn absolute top-0 right-0 px-2 py-1 text-sm bg-red-500 text-white hover:bg-red-400">Borrar</button>
  </article>
</template>

<script>

import { mapActions } from 'vuex'

export default {
  name: 'InputTypeItem',
  props: {
    inputType: {
      type: Object,
      required: true
    }
  },
  methods: {
    ...mapActions("InputType", [
      "deleteInputType"
    ]),
  }
}
</script>

<style lang="scss" scoped>
  .inputType__item {

    .inputType__delete-btn {
      opacity: 0;
      transform: scale(0);

      transition: all .3s;
    }

    &:hover .inputType__delete-btn {
      opacity: 1;
      transform: scale(1);
    }
  }
</style>
