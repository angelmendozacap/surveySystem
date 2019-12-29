export const SET_SURVEYS = 'survey/SET_SURVEYS'
export const SET_QUESTIONS = 'survey/SET_QUESTIONS'
export const SET_SURVEY = 'survey/SET_SURVEY'
export const SET_ERRORS = 'survey/SET_ERRORS'


export const SurveyStore = {
  namespaced: true,
  state: {
    surveys: [],
    questions: [],
    survey: null,
    errors: null
  },
  getters: {
    surveyList(state) {
      return state.surveys
    },
    questionsList(state) {
      return state.questions
    },
    surveyItem(state) {
      return state.survey
    },
    errorsList(state) {
      return state.errors
    }
  },
  actions: {
    getSurveys: async ({ commit }) => {
      const res = await axios.get('/api/surveys')
      commit(SET_SURVEYS, res.data.data)
    },
    getQuestions: async ({ commit }, surveyId) => {
      const res = await axios.get(`/api/surveys/${surveyId}/questions`)
      commit(SET_QUESTIONS, res.data.data)
    },
    getSurvey: async ({ commit }, surveyId) => {
      const res = await axios.get(`/api/surveys/${surveyId}`)
      commit(SET_SURVEY, res.data)
    },
    createSurvey: async ({ commit }, { name, description, status }) => {
      try {
        const res = await axios.post('/api/surveys', { name, description, status })
        commit(SET_SURVEY, res.data)
      } catch (err) {
        commit(SET_ERRORS, err.response.data.errors)
      }
    }
  },
  mutations: {
    [SET_SURVEYS](state, payload) {
      state.surveys = payload
    },
    [SET_QUESTIONS](state, payload) {
      state.questions = payload
    },
    [SET_SURVEY](state, payload) {
      state.surveys.push(payload)
      state.survey = payload
    },
    [SET_ERRORS](state, payload) {
      state.errors = payload
    }
  },
}
