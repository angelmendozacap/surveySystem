export const SET_SURVEYS = 'survey/SET_SURVEYS'

export const SurveyStore = {
  namespaced: true,
  state: {
    surveys: []
  },
  getters: {
    surveyList(state) {
      return state.surveys
    }
  },
  actions: {
    getSurveys: async ({ commit }) => {
      const res = await axios.get('/api/surveys')
      commit(SET_SURVEYS, res.data)
    }
  },
  mutations: {
    [SET_SURVEYS](state, payload) {
      state.surveys = payload
    }
  },
}
