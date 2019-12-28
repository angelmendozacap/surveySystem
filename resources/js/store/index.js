import Vue from 'vue'
import Vuex from 'vuex'

// Modules
import User from './modules/user'
import { SurveyStore } from './modules/survey'


Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    User,
    Survey: { ...SurveyStore }
  }
})
