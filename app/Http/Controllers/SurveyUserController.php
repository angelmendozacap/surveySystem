<?php

namespace App\Http\Controllers;

use App\Survey;
use Illuminate\Http\Request;
use App\Http\Resources\SurveyTaken as SurveyTakenResource;
use Symfony\Component\HttpFoundation\Response;
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

    public function store(Survey $survey)
    {
        $data = request()->all();
        $surveyUser = $survey->surveysAnswered()->create([
            'user_id' => auth()->user()->id
        ]);

        $surveyUser->responses()->createMany($data['responses']);
        $surveyUser->load('survey');

        return (new SurveyTakenResource($surveyUser))->response()->setStatusCode(Response::HTTP_CREATED);
    }
}
