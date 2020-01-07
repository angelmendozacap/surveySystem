export const SET_QUESTIONS = 'question/SET_QUESTIONS'
export const CREATE_QUESTION = 'question/CREATE_QUESTION'
export const DELETE_QUESTION = 'question/DELETE_QUESTION'
export const SET_ERRORS = 'question/SET_ERRORS'

export const QuestionStore = {
  namespaced: true,
  state: {
    questions: null,
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
      commit(SET_QUESTIONS, res.data)
    },
    createQuestion: async ({ commit }, surveyId) => {
      const res = await axios.post(`/api/surveys/${surveyId}/questions`)
      commit(CREATE_QUESTION, res.data)
    },
    deleteQuestion: async ({ commit }, questionId) => {
      try {
        await axios.delete(`/api/questions/${questionId}`)
        commit(DELETE_QUESTION, questionId)
      } catch (err) {
        if (err.response.status === 404) {
          console.error('No se encontró la pregunta')
        }
      }
    }
  },
  mutations: {
    [SET_QUESTIONS](state, payload) {
      state.questions = payload
    },
    [CREATE_QUESTION](state, payload) {
      state.questions.data.push(payload)
    },
    [DELETE_QUESTION](state, payload) {
      const questionIdDeleted = parseInt(payload)
      state.questions.data = state.questions.data.filter(question => question.data.question_id !== questionIdDeleted)
    },
    [SET_ERRORS](state, payload) {
      state.errors = payload
    }
  },
}
