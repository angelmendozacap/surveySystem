<?php

namespace App\Http\Controllers;

use App\Survey;
use App\Question;
use App\InputType;
use Illuminate\Http\Request;
use App\Http\Requests\StoreQuestionRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Question as QuestionResource;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Survey $survey)
    {
        $questions = $survey->questions;
        return QuestionResource::collection($questions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Survey $survey)
    {
        $defaultInputType = InputType::firstOrCreate([
            'type' => 'radio',
            'display_name' => 'Opción Múltiple'
        ]);

        $question = $survey->questions()->create([
            'name' => 'Pregunta',
            'subtext' => null,
            'is_required' => false,
            'input_type_id' => $defaultInputType->id
        ]);
        return (new QuestionResource($question))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestionRequest $request, Question $question)
    {
        $question->update($request->all());
        return (new QuestionResource($question))->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->answers()->delete();
        $question->delete();
        return response([], Response::HTTP_OK);
    }
}
