<template>
  <article class="p-4 mb-5 pb-4 rounded bg-white shadow border-gray-500">
    <p class="mb-1 text-blue-400 leading-tight font-bold">{{ index }}. {{ question.data.name }}</p>
    <span class="mb-1 text-gray-600 text-sm leading-tight">
      <em>{{ question.data.subtext }}</em>
    </span>

    <fieldset class="border-2 rounded-lg p-4">
      <legend class="text-gray-700 font-bold">Opciones</legend>

      <div v-for="(answer,index) in question.data.answers" :key="index">
        <input type="radio" :id="`${question.data.code_name}_a${answer.data.answer_id}`" :name="question.data.code_name" :value="answer.data.answer_id">
        <label :for="`${question.data.code_name}_a${answer.data.answer_id}`" v-text="answer.data.answer"></label>
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
