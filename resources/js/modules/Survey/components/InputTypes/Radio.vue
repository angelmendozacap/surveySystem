<template>
  <fieldset class="choices border-2 rounded-lg p-4 relative">
    <legend class="text-gray-700 font-bold">Opciones</legend>

    <div v-for="(answer,index) in answers" :key="index" class="flex items-center text-blue-500 mb-3">
      <label :for="`${questionCode}_a${index}`">
        <svg class="fill-current mr-3 w-6 h-6" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 510 510" style="enable-background:new 0 0 510 510;" xml:space="preserve"><g><g><path d="M255,127.5c-71.4,0-127.5,56.1-127.5,127.5c0,71.4,56.1,127.5,127.5,127.5c71.4,0,127.5-56.1,127.5-127.5C382.5,183.6,326.4,127.5,255,127.5z M255,0C114.75,0,0,114.75,0,255s114.75,255,255,255s255-114.75,255-255S395.25,0,255,0zM255,459c-112.2,0-204-91.8-204-204S142.8,51,255,51s204,91.8,204,204S367.2,459,255,459z"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
      </label>

      <input
        type="text"
        name="answers[][answer]"
        :id="`${questionCode}_a${index}`"
        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-accent"
        placeholder="Opción"
        :value="answer.answer"
      />
    </div>

    <button @click.prevent="answers.push({ asnwer: '' })" class="choices__btn-add w-8 h-8 rounded-full text-center font-bold text-xl text-white bg-green-500 border-2 border-gray-400 absolute top-0 right-0 outline-none">+</button>
  </fieldset>
</template>

<script>
export default {
  name: 'RadioInput',
  props: {
    questionCode: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      answers: [
        {
          answer: 'Opción 1'
        }
      ]
    }
  }
}
</script>

<style lang="scss" scoped>
  .choices {
    &__btn-add {
      opacity: 0;
      transform: scale(0);
      transition: all .3s;
      vertical-align: text-top;
    }

    &:hover &__btn-add {
      opacity: 1;
      transform: scale(1);
    }
  }
</style>
