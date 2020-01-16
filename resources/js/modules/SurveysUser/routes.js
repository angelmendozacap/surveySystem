const SurveysUserList = () => import('./views/SurveysUserList')
const ShowSurveyUser = () => import('./views/ShowSurveyUser')

import store from '../../store/index'

export const SurveyUsersRoutes = [
  {
    path: '/surveys-to-answer',
    name: 'surveysUserList',
    component: SurveysUserList
  },
  {
    path: '/surveys-to-answer/:surveyId',
    name: 'showSurveysUser',
    component: ShowSurveyUser,
    beforeEnter: (to, from, next) => {
      try {
        const surveyId = parseInt(to.params.surveyId)

        const surveyTaken = store.getters['SurveysUser/surveysTakenByMe'].data.find(surveyTaken => surveyTaken.data.survey.data.survey_id == surveyId) || false

        if (!surveyTaken)
          next()
      } catch (err) {
        next({
          name: 'surveysUserList'
        })
      }

    }
  }
]
