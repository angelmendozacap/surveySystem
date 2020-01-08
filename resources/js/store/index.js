import Vue from 'vue'
import Vuex from 'vuex'

// Modules
import User from './modules/user'
import { SurveyStore } from '../modules/Survey/store'
import { QuestionStore } from '../modules/Question/store'
import { InputTypeStore } from '../modules/InputType/store'
import { AnswerStore } from '../modules/Answer/store'


Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    User,
    Survey: { ...SurveyStore },
    Question: { ...QuestionStore },
    InputType: { ...InputTypeStore },
    Answer: { ...AnswerStore }
  }
})
