<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Answer as AnswerResource;

class AnswersController extends Controller
{
    public function index()
    {
        $answers = Answer::with('question.inputType')->get();

        return AnswerResource::collection($answers);
    }

    public function store(Question $question)
    {
        $answer = $question->answers()->create([
            'answer' => 'Nueva Opción'
        ]);

        $answer->load('question.inputType');

        return (new AnswerResource($answer))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(Answer $answer)
    {
        $data = request()->validate([
            'answer' => 'required|string'
        ]);

        $answer->update($data);

        $answer->load('question.inputType');

        return (new AnswerResource($answer))->response()->setStatusCode(Response::HTTP_OK);
    }

    public function destroy(Answer $answer)
    {
        $answer->delete();

        return response([], Response::HTTP_OK);
    }

    /* private $arrayRequiredQuestions = [];

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
    } */
}
