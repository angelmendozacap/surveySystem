export const SET_ANSWERS = 'answer/SET_ANSWERS'
export const CREATE_ANSWER = 'answer/CREATE_ANSWER'
export const DELETE_ANSWER = 'answer/DELETE_ANSWER'
export const UPDATE_ANSWER = 'answer/UPDATE_ANSWER'
export const SET_ERRORS = 'answer/SET_ERRORS'

export const AnswerStore = {
  namespaced: true,
  state: {
    answers: null,
    errors: null
  },
  getters: {
    answersList(state) {
      return state.answers
    }
  },
  actions: {
    getAnswers: async ({ commit }, questionId) => {
      const res = await axios.get(`/api/questions/${questionId}/answers`)

      return res.data
    },
    createAnswer: async ({ commit }, questionId) => {
      const res = await axios.post(`/api/questions/${questionId}/answers`)

      return res.data
    },
    updateAnswer: async ({ commit }, payload) => {
      const { answerId, answer } = payload
      const res = await axios.patch(`/api/answers/${answerId}`, answer)

      return res.data
    },
    deleteAnswer: async ({ commit }, answerId) => {
      await axios.delete(`/api/answers/${answerId}`)
    }
  },
  mutations: {
    [SET_ANSWERS](state, payload) {
      state.answers = payload
    },
    [CREATE_ANSWER](state, payload) {
      state.answers.data.push(payload)
    },
    [DELETE_ANSWER](state, payload) {
      const answerIdDeleted = parseInt(payload)
      state.answers.data = state.answers.data.filter(answer => answer.data.answer_id !== answerIdDeleted)
    },
    [UPDATE_ANSWER](state, payload) {
      const newState = state.answers.data.map(answer => {
        if (answer.data.id === payload.data.id) answer = payload

        return answer
      })

      console.log(newState)

      state.answers.data = newState
    },
    [SET_ERRORS](state, payload) {
      state.errors = payload
    }
  }
}
