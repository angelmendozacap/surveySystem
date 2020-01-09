import Vue from 'vue'
import VueRouter from 'vue-router'
import Start from './views/Start'

// Modules
import { SurveyRoutes } from './modules/Survey/routes'
import { InputTypeRoutes } from './modules/InputType/routes'
import { SurveyUsersRoutes } from './modules/SurveysUser/routes'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: Start
  },
  ...SurveyRoutes,
  ...InputTypeRoutes,
  ...SurveyUsersRoutes
]

export default new VueRouter({
  mode: 'history',
  routes
})
