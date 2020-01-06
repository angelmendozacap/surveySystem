import Vue from 'vue'
import VueRouter from 'vue-router'
import Start from './views/Start'

// Modules
import { SurveyRoutes } from './modules/Survey/routes'
import { InputTypeRoutes } from './modules/InputType/routes'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: Start
  },
  ...SurveyRoutes,
  ...InputTypeRoutes
]

export default new VueRouter({
  mode: 'history',
  routes
})
