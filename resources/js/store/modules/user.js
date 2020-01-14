const SET_AUTH_USER = 'user/SET_AUTH_USER'

const state = {
  user: null
}
const getters = {
  authUser(state) {
    return state.user
  }
}

const mutations = {
  [SET_AUTH_USER](state, user) {
    state.user = user
  }
}

const actions = {
  fetchAuthUser: async ({ commit }) => {
    try {
      const res = await axios.get('/api/auth-user')
      commit(SET_AUTH_USER, res.data)

    } catch (err) {
      console.log('Unable to fetch auth user')
    }
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}
