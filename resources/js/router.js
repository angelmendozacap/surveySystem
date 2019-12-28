import Vue from 'vue'
import VueRouter from 'vue-router'
import Start from './views/Start'

// Views
import SurveyList from './views/SurveyList'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: Start
  },
  {
    path: '/surveys',
    name: 'surveyList',
    component: SurveyList
  }
]

export default new VueRouter({
  mode: 'history',
  routes
})
