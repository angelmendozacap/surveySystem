import SurveyList from './views/SurveyList'
import CreateSurvey from './views/CreateSurvey'


export const SurveyRoutes = [
  {
    path: '/surveys',
    name: 'surveyList',
    component: SurveyList
  },
  {
    path: '/surveys/create',
    name: 'surveyCreate',
    component: CreateSurvey
  }
]
