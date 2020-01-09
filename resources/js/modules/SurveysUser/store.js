export const SET_SURVEYS_USER = 'surveyUsers/SET_SURVEYS_USER'
export const SET_SURVEY_USER = 'surveyUsers/SET_SURVEY_USER'
export const SET_ERRORS = 'surveyUsers/SET_ERRORS'

export const SurveysUserStore = {
  namespaced: true,
  state: {
    surveysUser: null,
    surveyUser: null,
  },
  getters: {
    surveysUserList(state) {
      return state.surveysUser
    },
    surveyUserItem(state) {
      return state.surveyUser
    }
  },
  actions: {
    getAllSurveys: async ({ commit }) => {
      const res = await axios.get('/api/surveys-to-answer')
      commit(SET_SURVEY_USER, null)
      commit(SET_SURVEYS_USER, res.data)
    },
    getOneSurvey: async ({ commit }, surveyId) => {
      const res = await axios.get(`/api/surveys-to-answer/${surveyId}`)
      commit(SET_SURVEY_USER, res.data)
    },
  },
  mutations: {
    [SET_SURVEYS_USER](state, payload) {
      state.surveysUser = payload
    },
    [SET_SURVEY_USER](state, payload) {
      state.surveyUser = payload
    }
  }
}
