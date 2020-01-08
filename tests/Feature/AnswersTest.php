<?php

namespace Tests\Feature;

use App\User;
use App\Answer;
use App\Survey;
use App\Question;
use App\InputType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnswersTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $survey;
    protected $inputType;
    protected $question;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->survey = factory(Survey::class)->create();
        $this->inputType = factory(InputType::class)->create([
            'type' => 'radio',
            'display_name' => 'Opción Multiple'
        ]);

        $this->question = factory(Question::class)->create([
            'survey_id' => $this->survey->id,
            'input_type_id' => $this->inputType->id
        ]);
    }

    /** @test */
    public function a_list_of_answer_can_be_retrieved_by_its_question()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->user, 'api');

        $answers = factory(Answer::class, 2)->create([
            'question_id' => $this->question->id
        ]);

        $anotherQuestion = factory(Question::class)->create([
            'survey_id' => $this->survey->id,
            'input_type_id' => $this->inputType->id
        ]);

        $anotherAnswers = factory(Answer::class, 2)->create([
            'question_id' => $anotherQuestion->id
        ]);

        $response = $this->get("/api/questions/{$anotherQuestion->id}/answers");

        $response->assertJsonCount(1)->assertJson([
            'data' => [
                [
                    'data' => [
                        'answer_id' => $anotherAnswers->first()->id,
                        'answer' => $anotherAnswers->first()->answer,
                        'question' => [
                            'data' => [
                                'question_id' => $anotherQuestion->id
                            ]
                        ]
                    ]
                ],
                [
                    'data' => [
                        'answer_id' => $anotherAnswers->last()->id,
                        'answer' => $anotherAnswers->last()->answer,
                        'question' => [
                            'data' => [
                                'question_id' => $anotherQuestion->id
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $this->assertCount(2, Question::all());
        $this->assertCount(4, Answer::all());
    }

    /** @test */
    public function an_answer_can_be_created_by_its_question()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->user, 'api');

        $response = $this->post("/api/questions/{$this->question->id}/answers");

        $answer = Answer::first();

        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJson([
            'data' => [
                'answer_id' => $answer->id,
                'answer' => $answer->answer,
                'question' => [
                    'data' => [
                        'question_id' => $this->question->id,
                        'input_type' => [
                            'data' => [
                                'id' => $this->inputType->id
                            ]
                        ]
                    ]
                ],
                'created_at' => $answer->created_at->diffForHumans(),
                'updated_at' => $answer->updated_at->diffForHumans()
            ]
        ]);
    }

    /** @test */
    public function an_answer_can_be_patched()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->user, 'api');

        $answer = factory(Answer::class)->create([
            'question_id' => $this->question->id
        ]);

        $response = $this->patch('/api/answers/'.$answer->id, $this->data());

        $response->assertStatus(Response::HTTP_OK);

        $answer = $answer->fresh();

        $this->assertEquals($this->question->id, $answer->question_id);
        $this->assertEquals('Choice 1', $answer->answer);

        $response->assertJson([
            'data' => [
                'answer_id' => $answer->id,
                'answer' => $answer->answer,
                'question' => [
                    'data' => [
                        'question_id' => $this->question->id,
                        'input_type' => [
                            'data' => [
                                'id' => $this->inputType->id
                            ]
                        ]
                    ]
                ],
                'created_at' => $answer->created_at->diffForHumans(),
                'updated_at' => $answer->updated_at->diffForHumans()
            ]
        ]);
    }

    /** @test */
    public function answer_is_required_when_updating()
    {

        $this->actingAs($this->user, 'api');

        $answer = factory(Answer::class)->create([
            'question_id' => $this->question->id
        ]);

        $response = $this->patch('/api/answers/'.$answer->id,
            array_merge($this->data(), ['answer' => '']));


        $response->assertSessionHasErrors('answer');
        $this->assertNotEquals('Nueva Opción', $answer->answer);
    }

    /** @test */
    public function an_answer_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->user, 'api');

        $answer = factory(Answer::class)->create([
            'question_id' => $this->question->id
        ]);

        $response = $this->delete('/api/answers/'.$answer->id);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertCount(0, Answer::all());
    }

    private function data()
    {
        return [
            'answer' => 'Choice 1'
        ];
    }
}
