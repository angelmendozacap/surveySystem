<template>
  <article class="p-4 mb-5 pb-4 rounded bg-white shadow border-gray-500">
    <p class="mb-1 text-blue-400 text-2xl leading-tight">{{ index }}. {{ question.data.name }}</p>
    <span class="mb-1 text-gray-600 leading-tight">
      <em>{{ question.data.subtext }}</em>
    </span>

    <fieldset class="border-2 rounded-lg p-4 mt-1">
      <legend class="text-gray-500 text-sm font-bold">Opciones</legend>

      <div v-for="(answer,index) in question.data.answers" :key="index">
        <input type="radio" class="mr-3" :id="`${question.data.code_name}_a${answer.data.answer_id}`" :name="question.data.code_name" :value="answer.data.answer_id">
        <label class="text-xl text-gray-600" :for="`${question.data.code_name}_a${answer.data.answer_id}`" v-text="answer.data.answer"></label>
      </div>
    </fieldset>
  </article>
</template>

<script>
export default {
  name: 'SurveyUserItem',
  props: {
    question: {
      type: Object,
      required: true
    },
    index: {
      type: Number,
    }
  }
}
</script>
