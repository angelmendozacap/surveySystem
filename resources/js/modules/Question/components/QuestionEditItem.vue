<template>
  <article class="p-4 border-b border-gray-500">
    <div class="flex -mx-2 mb-4">
      <div class="w-1/2 px-2">
        <input
          type="text"
          :value="'¿'+question.name+'?'"
          id="name"
          class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-accent"
        />
      </div>

      <div class="w-1/2 px-2">
        <div class="relative">
          <select class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
            <option>Párrafo</option>
            <option>Option 2</option>
            <option>Option 3</option>
          </select>

          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
          </div>
        </div>
      </div>
    </div>

    <div class="w-full mb-4">
      <label
        class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
        for="subtext"
      >Descripción <span class="text-gray-600 lowercase">(opcional)</span></label>
      <input
        type="text"
        :value="question.subtext"
        id="subtext"
        class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-accent"
      />
    </div>
  </article>
</template>

<script>
export default {
  name: "QuestionEditItem",
  props: {
    question: {
      type: Object,
      required: true
    }
  }
};
</script>
