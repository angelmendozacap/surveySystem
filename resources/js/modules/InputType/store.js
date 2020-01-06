export const SET_INPUT_TYPES = 'question/SET_INPUT_TYPES'
export const CREATE_INPUT_TYPE = 'question/CREATE_INPUT_TYPE'
export const DELETE_INPUT_TYPE = 'question/DELETE_INPUT_TYPE'
export const SET_ERRORS = 'question/SET_ERRORS'

export const InputTypeStore = {
  namespaced: true,
  state: {
    inputTypes: null,
    errors: null
  },
  getters: {
    inputTypesList(state) {
      return state.inputTypes
    },
    errorsList(state) {
      return state.errors
    }
  },
  actions: {
    getInputTypes: async ({ commit }) => {
      const res = await axios.get('/api/input-types')
      commit(SET_INPUT_TYPES, res.data)
    },
    createInputType: async ({ commit }, { type, display_name }) => {
      try{
        const res = await axios.post('/api/input-types', { type, display_name })
        commit(CREATE_INPUT_TYPE, res.data)
        commit(SET_ERRORS, null)
      } catch (err) {
        commit(SET_ERRORS, err.response.data.errors)
      }
    },
    deleteInputType: async ({ commit }, inputTypeId) => {
      try {
        await axios.delete(`/api/input-types/${inputTypeId}`)
        commit(DELETE_INPUT_TYPE, inputTypeId)
      } catch (err) {
        if (err.response.status === 404) {
          console.error('No se encontró el tipo de pregunta')
        }
      }
    }
  },
  mutations: {
    [SET_INPUT_TYPES](state, payload) {
      state.inputTypes = payload
    },
    [CREATE_INPUT_TYPE](state, payload) {
      state.inputTypes.data.push(payload)
    },
    [DELETE_INPUT_TYPE](state, payload) {
      const inputTypeIdDeleted = parseInt(payload)
      state.inputTypes.data = state.inputTypes.data.filter(inputType => inputType.data.id !== inputTypeIdDeleted)
    },
    [SET_ERRORS](state, payload) {
      state.errors = payload
    }
  },
}
