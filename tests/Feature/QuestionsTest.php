<?php

namespace Tests\Feature;

use App\Survey;
use App\Question;
use App\InputType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuestionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function questions_can_be_retrieved_by_its_respective_survey()
    {
        $survey = factory(Survey::class)->create();
        $questions = factory(Question::class, 3)->create([
            'survey_id' => $survey->id,
            'input_type_id' => 'text',
        ]);
        $response = $this->get("/api/surveys/{$survey->id}/questions");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(1)->assertJson([
            'data' => [
                [
                    'survey_id' => $survey->id,
                    'input_type' => 'text',
                ],
                [
                    'survey_id' => $survey->id,
                    'input_type' => 'text',
                ],
                [
                    'survey_id' => $survey->id,
                    'input_type' => 'text',
                ]
            ]
        ]);

        $this->assertCount(3, Question::all());
        $this->assertCount(1, InputType::all());
    }

    /** @test */
    public function a_question_can_be_created_by_its_respective_survey_with_new_input_type()
    {
        $this->withoutExceptionHandling();
        $survey = factory(Survey::class)->create();
        $response = $this->post("/api/surveys/{$survey->id}/questions");

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'question_id' => 1,
                'name' => 'Pregunta',
                'subtext' => null,
                'is_required' => false,
                'survey_id' => $survey->id,
                'input_type' => 'text',
            ]
        ]);

        $this->assertCount(1, Question::all());
        $this->assertCount(1, InputType::all());
    }

    /** @test */
    public function a_question_can_be_created_by_its_respective_survey_with_an_input_type()
    {
        $this->withoutExceptionHandling();
        $survey = factory(Survey::class)->create();
        $input = factory(InputType::class)->create(['name' => 'text']);
        $response = $this->post("/api/surveys/{$survey->id}/questions");

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'question_id' => 1,
                'name' => 'Pregunta',
                'subtext' => null,
                'is_required' => false,
                'survey_id' => $survey->id,
                'input_type' => $input->name,
            ]
        ]);

        $this->assertCount(1, Question::all());
        $this->assertCount(1, InputType::all());

        $this->assertEquals('text', $input->name);
    }

    /** @test */
    public function name_is_required_when_is_updating()
    {
        $question = factory(Question::class)->create();
        $response = $this->patch("/api/questions/{$question->id}",
            array_merge($this->data(), ['name' => '']));

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function input_type_id_is_required_when_is_updating()
    {
        $question = factory(Question::class)->create();
        $response = $this->patch("/api/questions/{$question->id}",
            array_merge($this->data(), ['input_type_id' => '']));

        $response->assertSessionHasErrors('input_type_id');
    }

    /** @test */
    public function input_type_id_is_a_string_when_is_updating()
    {
        $question = factory(Question::class)->create();
        $response = $this->patch("/api/questions/{$question->id}",
            array_merge($this->data(), ['input_type_id' => 1]));

        $response->assertSessionHasErrors('input_type_id');
    }

    /** @test */
    public function field_is_required_is_boolean_when_is_updating()
    {
        $question = factory(Question::class)->create();
        $response = $this->patch("/api/questions/{$question->id}",
            array_merge($this->data(), ['is_required' => 'true']));

        $response->assertSessionHasErrors('is_required');
    }

    /** @test */
    public function a_question_can_be_patched()
    {
        $this->withoutExceptionHandling();
        $question = factory(Question::class)->create();
        $response = $this->patch("/api/questions/{$question->id}", $this->data());

        $question = $question->fresh();

        $response->assertStatus(Response::HTTP_OK);

        $this->assertEquals('Pregunta Uno', $question->name);
        $this->assertEquals('Subtext', $question->subtext);
        $this->assertEquals(true, $question->is_required);
        $this->assertEquals('text', $question->inputType->name);

        $response->assertJson([
            'data' => [
                'question_id' => 1,
                'name' => $question->name,
                'subtext' => $question->subtext,
                'is_required' => $question->is_required,
                'survey_id' => $question->survey_id,
                'input_type' => 'text',
            ]
        ]);
    }

    /** @test */
    public function a_question_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $question = factory(Question::class)->create();
        $response = $this->delete("/api/questions/{$question->id}");

        $response->assertStatus(Response::HTTP_OK);

        $this->assertCount(0, Question::all());
    }

    private function data()
    {
        return [
            'name' => 'Pregunta Uno',
            'subtext' => 'Subtext',
            'is_required' => true,
            'input_type_id' => 'text',
        ];
    }
}
