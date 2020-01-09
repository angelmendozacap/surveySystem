import SurveysUserList from './views/SurveysUserList'
import ShowSurveyUser from './views/ShowSurveyUser'

export const SurveyUsersRoutes = [
  {
    path: '/surveys-to-answer',
    name: 'surveysUserList',
    component: SurveysUserList
  },
  {
    path: '/surveys-to-answer/:surveyId',
    name: 'showSurveysUser',
    component: ShowSurveyUser
  }
]
