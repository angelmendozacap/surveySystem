import SurveyList from './views/SurveyList'
import ShowSurvey from './views/ShowSurvey'
import CreateSurvey from './views/CreateSurvey'

export const SurveyRoutes = [
  {
    path: '/surveys',
    name: 'surveyList',
    component: SurveyList
  },
  {
    path: '/surveys/:surveyId',
    name: 'showSurvey',
    component: ShowSurvey
  },
  {
    path: '/surveys/create',
    name: 'createSurvey',
    component: CreateSurvey
  }
]
