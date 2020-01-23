import SurveyList from './views/SurveyList'
import ShowSurvey from './views/ShowSurvey'
import CreateSurvey from './views/CreateSurvey'

export const SurveyRoutes = [
  {
    path: '/surveys',
    name: 'surveyList',
    component: SurveyList,
    meta: { onlyAdminsAndCreators: true }
  },
  {
    path: '/surveys/:surveyId',
    name: 'showSurvey',
    component: ShowSurvey,
    meta: { onlyAdminsAndCreators: true }
  },
  {
    path: '/surveys/create',
    name: 'createSurvey',
    component: CreateSurvey,
    meta: { onlyAdminsAndCreators: true }
  }
]
