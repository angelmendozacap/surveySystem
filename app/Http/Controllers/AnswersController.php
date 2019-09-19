<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Survey;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AnswersController extends Controller
{
    private $arrayRequiredQuestions = [];

    public function store(Request $request, Survey $survey)
    {
        // dd($request->all());

        // Questions Validation
        $currentQuestions = $survey->questions;

        if (count($currentQuestions) !== count($request->all()) ) {
            return response([
                "message" => "Datos enviados incorrectos"
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        };

        foreach ($currentQuestions as $question) {
            $this->arrayRequiredQuestions[$question->code_name_input] = $question->is_required ? 'required' : 'nullable';
        }

        Validator::make(
            $request->all(),
            $this->arrayRequiredQuestions,
            $this->messages()
        )->validate();

        // PREPARING ARRAY JSON BEFORE SAVE
        $arrayAnswers = [];
        foreach ($currentQuestions as $question) {
            array_push($arrayAnswers, [
                $question->code_name_input => [
                    'survey_id' => $question->survey->id,
                    'question_id' => $question->id,
                    'answer' => $request[$question->code_name_input],
                    'input_type' => $question->inputType->name,
                    'option_group' => $question->optionGroup->name_group ?? null
                ]
            ]);
        }
        // dd([
        //     'answers_array' => $arrayAnswers
        // ]);
        $answers = $survey->answers()->create([
            'answers_array' => $arrayAnswers
        ]);

        // dd($answers);

        $this->arrayRequiredQuestions = [];
        return response([], Response::HTTP_CREATED);
    }

    private function messages()
    {
        return [
            'required' => "Este campo es obligatorio"
        ];
    }
}