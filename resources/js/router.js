import Vue from 'vue'
import VueRouter from 'vue-router'
import Start from './views/Start'

// Modules
import { SurveyRoutes } from './modules/Survey/routes'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: Start
  },
  ...SurveyRoutes
]

export default new VueRouter({
  mode: 'history',
  routes
})
