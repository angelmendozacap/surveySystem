<?php

namespace App\Http\Controllers;

use App\Survey;
use Illuminate\Http\Request;
use App\Http\Resources\SurveyUser as SurveyUserResource;
use App\Http\Resources\SurveyQuestions as SurveyQuestionsResource;

class SurveyUserController extends Controller
{
    public function index()
    {
        $surveys = Survey::where('status', 'ready')->get();

        return SurveyUserResource::collection($surveys);
    }

    public function show(Survey $survey)
    {
        $survey->load('questions.answers', 'questions.inputType');

        return new SurveyQuestionsResource($survey);
    }
}
