export const SET_QUESTIONS = 'question/SET_QUESTIONS'
export const CREATE_QUESTION = 'question/CREATE_QUESTION'
export const SET_ERRORS = 'question/SET_ERRORS'

export const QuestionStore = {
  namespaced: true,
  state: {
    questions: [],
    errors: null
  },
  getters: {
    questionsList(state) {
      return state.questions
    }
  },
  actions: {
    getQuestions: async ({ commit }, surveyId) => {
      const res = await axios.get(`/api/surveys/${surveyId}/questions`)
      commit(SET_QUESTIONS, res.data.data)
    },
    createQuestion: async ({ commit }, surveyId) => {
      const res = await axios.post(`/api/surveys/${surveyId}/questions`)
      commit(CREATE_QUESTION, res.data)
    }
  },
  mutations: {
    [SET_QUESTIONS](state, payload) {
      state.questions = payload
    },
    [CREATE_QUESTION](state, payload) {
      state.questions.push(payload)
    },
    [SET_ERRORS](state, payload) {
      state.errors = payload
    }
  },
}
