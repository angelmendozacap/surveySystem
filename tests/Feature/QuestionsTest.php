<?php

namespace Tests\Feature;

use App\User;
use App\Answer;
use App\Survey;
use App\Question;
use App\InputType;
use Tests\TestCase;
use App\OptionGroup;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuestionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function questions_can_be_retrieved_by_its_respective_survey()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $survey = factory(Survey::class)->create();
        $questions = factory(Question::class, 2)->create([
            'survey_id' => $survey->id,
        ]);
        $response = $this->get("/api/surveys/{$survey->id}/questions");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(1)->assertJson([
            'data' => [
                [
                    'data' => [
                        'survey_id' => $survey->id,
                        'code_name' => $questions->first()->code_name_input,
                        'input_type' => [
                            'data' => [
                                'type' => $questions->first()->inputType->type,
                            ]
                        ],
                    ]
                ],
                [
                    'data' => [
                        'survey_id' => $survey->id,
                        'code_name' => $questions->last()->code_name_input,
                        'input_type' => [
                            'data' => [
                                'type' => $questions->last()->inputType->type,
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $this->assertCount(2, Question::all());
        $this->assertCount(2, InputType::all());
    }

    /** @test */
    public function a_question_can_be_created_by_its_respective_survey_with_new_input_type()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $this->withoutExceptionHandling();
        $survey = factory(Survey::class)->create();
        $response = $this->post("/api/surveys/{$survey->id}/questions");

        $question = Question::first();

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'question_id' => $question->id,
                'name' => $question->name,
                'code_name' => $question->code_name_input,
                'subtext' => null,
                'is_required' => $question->is_required,
                'survey_id' => $survey->id,
                'input_type' => [
                    'data' => [
                        'type' => $question->inputType->type
                    ]
                ]
            ]
        ]);

        $this->assertCount(1, Question::all());
        $this->assertCount(1, InputType::all());
    }

    /** @test */
    public function a_question_can_be_created_by_its_respective_survey_with_an_input_type()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $this->withoutExceptionHandling();
        $survey = factory(Survey::class)->create();
        $input = factory(InputType::class)->create([
            'type' => 'radio',
            'display_name' => 'Opción Múltiple'
        ]);
        $response = $this->post("/api/surveys/{$survey->id}/questions");

        $question = Question::first();

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'question_id' => $question->id,
                'name' => $question->name,
                'code_name' => $question->code_name_input,
                'subtext' => null,
                'is_required' => $question->is_required,
                'survey_id' => $survey->id,
                'input_type' => [
                    'data' => [
                        'type' => $question->inputType->type
                    ]
                ]
            ]
        ]);

        $this->assertCount(1, Question::all());
        $this->assertCount(1, InputType::all());

        $this->assertEquals($question->inputType->type, $input->type);
        $this->assertEquals($question->inputType->display_name, $input->display_name);
    }

    /** @test */
    public function name_is_required_when_is_updating()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $question = factory(Question::class)->create();
        $response = $this->patch("/api/questions/{$question->id}",
            array_merge($this->data(), ['name' => '']));

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function input_type_id_is_required_when_is_updating()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $question = factory(Question::class)->create();
        $response = $this->patch("/api/questions/{$question->id}",
            array_merge($this->data(), ['input_type_id' => '']));

        $response->assertSessionHasErrors('input_type_id');
    }

    /** @test */
    public function field_is_required_is_boolean_when_is_updating()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $question = factory(Question::class)->create();
        $response = $this->patch("/api/questions/{$question->id}",
            array_merge($this->data(), ['is_required' => 'true']));

        $response->assertSessionHasErrors('is_required');
    }

    /** @test */
    public function a_question_can_be_patched()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $question = factory(Question::class)->create();
        $inputType = factory(InputType::class)->create([ 'type' => 'text' ]);

        $response = $this->patch("/api/questions/{$question->id}",
            array_merge($this->data(), [ 'input_type_id' => $inputType->id ]));

        $question = $question->fresh();
        // dd($question);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertEquals('Pregunta Uno', $question->name);
        $this->assertEquals('Subtext', $question->subtext);
        $this->assertEquals(true, $question->is_required);
        $this->assertEquals($inputType->type, $question->inputType->type);
        $this->assertEquals($inputType->display_name, $question->inputType->display_name);

        $response->assertJson([
            'data' => [
                'question_id' => 1,
                'name' => $question->name,
                'code_name' => "{$question->code_name_input}",
                'subtext' => $question->subtext,
                'is_required' => $question->is_required,
                'survey_id' => $question->survey_id,
                'input_type' => [
                    'data' => [
                        'type' => $inputType->type
                    ]
                ],
            ]
        ]);
    }

    /** @test */
    public function a_question_can_be_deleted()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $question = factory(Question::class)->create();

        $answers = factory(Answer::class, 4)->create([
            'question_id' => $question->id
        ]);

        $response = $this->delete("/api/questions/{$question->id}");

        $response->assertStatus(Response::HTTP_OK);

        $this->assertCount(0, Answer::all());
        $this->assertCount(0, Question::all());
    }

    /* public function an_option_group_can_be_selected_by_a_question()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $question = factory(Question::class)->create();
        $group = factory(OptionGroup::class)->create();
        $response = $this->patch("/api/questions/{$question->id}",
            array_merge($this->data(),['option_group_id' => $group->id]));

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
                'code_name' => "{$question->code_name_input}",
                'subtext' => $question->subtext,
                'is_required' => $question->is_required,
                'survey_id' => $question->survey_id,
                'input_type' => 'text',
                'option_group' => $group->name_group
            ]
        ]);

    } */

    private function data()
    {
        return [
            'name' => 'Pregunta Uno',
            'subtext' => 'Subtext',
            'is_required' => true,
            'input_type_id' => 1,
            'option_group_id' => null
        ];
    }
}
