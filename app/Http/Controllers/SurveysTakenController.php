<?php

namespace App\Http\Controllers;

use App\Survey;
use Illuminate\Http\Request;
use App\Http\Resources\SurveyTaken as SurveyTakenResource;

class SurveysTakenController extends Controller
{
    public function index()
    {

        $surveysActive = Survey::where('status', 'ready')->get()->pluck('id');

        $surveysTaken = auth()->user()->surveysTaken->whereIn('survey_id', $surveysActive);

        return SurveyTakenResource::collection($surveysTaken);
    }
}
