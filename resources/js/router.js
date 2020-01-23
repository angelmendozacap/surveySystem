import Vue from 'vue'
import VueRouter from 'vue-router'

// Modules
import { SurveyRoutes } from './modules/Survey/routes'
import { InputTypeRoutes } from './modules/InputType/routes'
import { SurveyUsersRoutes } from './modules/SurveysUser/routes'

import Store from './store/index'
import { Roles } from './helpers/roles'

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

const router = new VueRouter({
  mode: 'history',
  routes
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.onlyAdminsAndCreators)) {
    if (!Store.getters['User/authUser']) {
      next({ name: 'home' })
    } else {
      if (!Roles.onlyAdminsAndCreators(Store.getters['User/authUser'].data.role.data.name)) {
        next({ name: 'home' })
      } else {
        next()
      }
    }

  } else {
    next()
  }

})

export default router
