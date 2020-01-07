export const SET_QUESTIONS = 'question/SET_QUESTIONS'
export const CREATE_QUESTION = 'question/CREATE_QUESTION'
export const DELETE_QUESTION = 'question/DELETE_QUESTION'
export const UPDATE_QUESTION = 'question/UPDATE_QUESTION'
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
    },
    errorsList(state) {
      return state.errors
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
    updateQuestion: async ({ commit }, payload) => {
      try {
        const { questionId, question } = payload
        const res = await axios.patch(`/api/questions/${questionId}`, question)

        commit(UPDATE_QUESTION, res.data)
        commit(SET_ERRORS, null)
      } catch (err) {
        commit(SET_ERRORS, err.response.data.errors)
      }
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
    [UPDATE_QUESTION](state, payload) {
      const newState = state.questions.data.map(question => {
        if (question.data.id === payload.data.id) question = payload

        return question
      })

      state.questions.data = newState
    },
    [SET_ERRORS](state, payload) {
      state.errors = payload
    }
  },
}
