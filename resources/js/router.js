import Vue from 'vue'
import VueRouter from 'vue-router'

// Modules
import { SurveyRoutes } from './modules/Survey/routes'
import { InputTypeRoutes } from './modules/InputType/routes'
import { SurveyUsersRoutes } from './modules/SurveysUser/routes'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    redirect: { name: 'surveysUserList' }
  },
  ...SurveyRoutes,
  ...InputTypeRoutes,
  ...SurveyUsersRoutes,
  { path: '*', redirect: { name: 'home' } }
]

export default new VueRouter({
  mode: 'history',
  routes
})
