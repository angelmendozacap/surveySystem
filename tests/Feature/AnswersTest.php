<?php

namespace Tests\Feature;

use App\Answer;
use App\Survey;
use App\Question;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnswersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_question_can_be_answered()
    {
        // $this->withoutExceptionHandling();
        $survey = factory(Survey::class)->create();
        $questionOne = factory(Question::class)->create([
            'survey_id' => $survey->id,
            'input_type_id' => 'text',
            'is_required' => true
        ]);

        $questionTwo = factory(Question::class)->create([
            'survey_id' => $survey->id,
            'input_type_id' => 'text',
            'is_required' => true
        ]);

        $questionThree = factory(Question::class)->create([
            'survey_id' => $survey->id,
            'input_type_id' => 'text',
            'is_required' => true
        ]);

        $questionFour = factory(Question::class)->create([
            'survey_id' => $survey->id,
            'input_type_id' => 'text',
            'is_required' => true
        ]);

        $answers = [];

        foreach ($survey->questions as $question) {
            $answers[$question->code_name_input] = "Hola tildación {$question->id}";
        }
        // $answers["s2_q1"] = "Hola soy un dato maligno";

        $response = $this->post("/api/surveys/{$survey->id}/answers", $answers);
        // $response->assertSessionHasErrors(['s1_q2', 's1_q3']);
        dd($response->getContent());
        $response->assertStatus(Response::HTTP_CREATED);

        // $this->assertCount(4, Answer::all());
    }
}