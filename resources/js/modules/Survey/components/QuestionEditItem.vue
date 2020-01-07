<template>
  <article class="question-item px-4 pt-8 pb-4 border-b border-gray-500 relative">
    <div class="flex -mx-2 mb-4">
      <div class="w-1/2 px-2">
        <label
          class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
          :for="`${question.data.code_name}_name`"
        >Pregunta</label>
        <input
          type="text"
          v-model="questionData.name"
          :id="`${question.data.code_name}_name`"
          @input="saveQuestion"
          class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-accent"
          placeholder="Pregunta"
        />

        <p v-if="errorsList && errorsList['name'] && questionData.name == ''" class="mt-1 text-red-500 text-sm">
          <span>Pregunta Requerida</span>
        </p>
      </div>

      <div class="w-1/2 px-2">
        <label
          class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
          :for="`${question.data.code_name}_input_type_id`"
        >Tipo de Pregunta</label>
        <div v-if="inputTypesList" class="relative">
          <select
            class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded leading-tight focus:outline-none focus:shadow-outline"
            v-model="questionData.input_type_id"
            @change="saveQuestion"
            :id="`${question.data.code_name}_input_type_id`"
          >
            <option value="0" disabled>Seleccione una Opción</option>
            <option
              v-for="(inputType,index) in inputTypesList.data"
              :key="index"
              :value="inputType.data.id"
              v-text="inputType.data.display_name"
            ></option>
          </select>

          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
          </div>
        </div>

        <p v-if="errorsList && errorsList['input_type_id'] && questionData.input_type_id == 0" class="mt-1 text-red-500 text-sm">
          <span>Campo Requerido</span>
        </p>
      </div>
    </div>

    <span v-if="!withDescription && question.data.subtext == null">
      <a
        @click.prevent="withDescription = !withDescription"
        class="-mt-3 text-sm text-blue-400 underline hover:text-blue-500 hover:no-underline cursor-pointer"
      >
        Agregar Descripción (opcional)
      </a>
    </span>
    <div v-else class="w-full mb-4">
      <label
        class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
        :for="`${question.data.code_name}_subtext`"
      >Descripción <span class="text-gray-600 lowercase">(opcional)</span></label>
      <input
        type="text"
        v-model="questionData.subtext"
        @input="saveQuestion"
        :id="`${question.data.code_name}_subtext`"
        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-accent"
      />
    </div>

    <div class="w-full my-4">
      <component :is="currentInputType" :questionCode="question.data.code_name" />
    </div>

    <button @click="deleteQuestion(question.data.question_id)" class="question-item__btn px-2 py-1 text-sm bg-red-500 text-white hover:bg-red-400 uppercase absolute right-0 top-0">Borrar</button>
  </article>
</template>

<script>

// InputTypes
import TextInput from '../components/InputTypes/Text'
import RadioInput from '../components/InputTypes/Radio'
import CheckBoxInput from '../components/InputTypes/CheckBox'
import TextArea from '../components/InputTypes/TextArea'
import Select from '../components/InputTypes/Select'

import _ from 'lodash'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: "QuestionEditItem",
  props: {
    question: {
      type: Object,
      required: true
    }
  },
  components: {
    'text-input': TextInput,
    'radio-input': RadioInput,
    'checkbox-input': CheckBoxInput,
    'textarea-input': TextArea,
    'select-input': Select
  },
  data() {
    return {
      questionData: {
        name: this.question.data.name,
        subtext: this.question.data.subtext,
        input_type_id: this.question.data.input_type.data.id,
        is_required: this.question.data.is_required,
      },
      withDescription: false,
    }
  },
  methods: {
    ...mapActions('Question', ['deleteQuestion', 'updateQuestion']),

    saveQuestion: _.debounce(function () {
      const data = {
        questionId: this.question.data.question_id,
        question: this.questionData
      }

      this.updateQuestion(data)
    }, 1000)
  },
  computed: {
    ...mapGetters('InputType', ["inputTypesList"]),
    ...mapGetters('Question', ["errorsList"]),

    currentInputType() {
      let inputType = 'radio'
      if (this.inputTypesList) {
        const currentInputType = this.inputTypesList.data.find(inputType => inputType.data.id == this.questionData.input_type_id)
        inputType = currentInputType.data.type.toLowerCase()
      }

      return `${inputType}-input`
    }
  }
};
</script>

<style lang="scss" scoped>
  .question-item {

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
