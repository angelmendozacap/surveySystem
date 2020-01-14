export const SET_SURVEYS_USER = 'surveyUsers/SET_SURVEYS_USER'
export const SET_SURVEY_USER = 'surveyUsers/SET_SURVEY_USER'
export const SET_ANSWER_SURVEY = 'surveyUsers/SET_ANSWER_SURVEY'
export const SET_ERRORS = 'surveyUsers/SET_ERRORS'
const SET_SURVEYS_TAKEN = 'surveyUsers/SET_SURVEYS_TAKEN'
const UPDATE_SURVEYS_TAKEN = 'surveyUsers/UPDATE_SURVEYS_TAKEN'

export const SurveysUserStore = {
  namespaced: true,
  state: {
    surveysUser: null,
    surveyUser: null,
    surveysTaken: null,
  },
  getters: {
    surveysUserList(state) {
      return state.surveysUser
    },
    surveyUserItem(state) {
      return state.surveyUser
    },surveysTakenByMe(state) {
      return state.surveysTaken
    },
    surveysTakenByMe(state) {
      return state.surveysTaken
    }
  },
  actions: {
    getSurveysTaken: async ({ commit }) => {
      try {
        const res = await axios.get('/api/surveys-answered')

        commit(SET_SURVEYS_TAKEN, res.data)
      } catch (err) {
        console.log('Unable to fetch surveys taken by me')
      }
    },
    getAllSurveys: async ({ commit }) => {
      const res = await axios.get('/api/surveys-to-answer')
      commit(SET_SURVEY_USER, null)
      commit(SET_SURVEYS_USER, res.data)
    },
    getOneSurvey: async ({ commit }, surveyId) => {
      const res = await axios.get(`/api/surveys-to-answer/${surveyId}`)
      commit(SET_SURVEY_USER, res.data)
    },
    answerSurvey: async ({ commit }, payload) => {
      const { surveyId, responses } = payload
      const res = await axios.post(`/api/surveys-to-answer/${surveyId}`, { responses })

      commit(UPDATE_SURVEYS_TAKEN, res.data)
    }
  },
  mutations: {
    [SET_SURVEYS_USER](state, payload) {
      state.surveysUser = payload
    },
    [SET_SURVEY_USER](state, payload) {
      state.surveyUser = payload
    },
    [SET_SURVEYS_TAKEN](state, surveys) {
      state.surveysTaken = surveys
    },
    [UPDATE_SURVEYS_TAKEN](state, survey) {
      state.surveysTaken.data.push(survey)
    }
  }
}
