import SurveysUserList from './views/SurveysUserList'
import ShowSurveyUser from './views/ShowSurveyUser'

export const SurveyUsersRoutes = [
  {
    path: '/surveys-to-response',
    name: 'surveysUserList',
    component: SurveysUserList
  },
  {
    path: '/surveys-to-response/:surveyId',
    name: 'showSurveysUser',
    component: ShowSurveyUser
  }
]
