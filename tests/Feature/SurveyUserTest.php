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

class SurveyUserTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $survey;
    protected $inputType;
    protected $questions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->survey = factory(Survey::class)->create([
            'status' => 'ready'
        ]);
        $this->inputType = factory(InputType::class)->create([
            'type' => 'radio',
            'display_name' => 'Opción Multiple'
        ]);

        $this->questions = factory(Question::class, 2)->create([
            'survey_id' => $this->survey->id,
            'input_type_id' => $this->inputType->id
        ]);
    }

    /** @test */
    public function list_of_surveys_can_be_displayed_for_the_user()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->user, 'api');

        $anotherSurvey = factory(Survey::class)->create(['status' => 'ready']);

        $response = $this->get('/api/surveys-to-response')
            ->assertStatus(Response::HTTP_OK);

        $response->assertJson([
            'data' => [
                [
                    'data' => [
                        'survey_id' => $this->survey->id,
                        'status' => 'ready',
                    ],
                    'links' => [
                        'self' => '/surveys-to-response/' . $this->survey->id
                    ]
                ],
                [
                    'data' => [
                        'survey_id' => $anotherSurvey->id,
                        'status' => 'ready',
                    ],
                    'links' => [
                        'self' => '/surveys-to-response/' . $anotherSurvey->id
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    public function a_survey_can_be_retrieved_with_questions_and_answers()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->user, 'api');

        $answersforQuestion1 = factory(Answer::class, 2)->create([
            'question_id' => $this->questions->first()->id
        ]);

        $answersforQuestion2 = factory(Answer::class, 2)->create([
            'question_id' => $this->questions->last()->id
        ]);

        $response = $this->get('/api/surveys-to-response/' . $this->survey->id)
            ->assertStatus(Response::HTTP_OK);

        // dd(json_decode($response->getContent()));

        $response->assertJson([
            'data' => [
                'survey_id' => $this->survey->id,
                'questions' => [
                    [
                        'data' => [
                            'question_id' => $this->questions->first()->id,
                            'input_type' => [
                                'data' => [
                                    'id' => $this->inputType->id
                                ]
                            ],
                            'answers' => [
                                [
                                    'data' => [
                                        'answer_id' => $answersforQuestion1->first()->id
                                    ]
                                ],
                                [
                                    'data' => [
                                        'answer_id' => $answersforQuestion1->last()->id
                                    ]
                                ]
                            ]
                        ],
                    ],
                    [
                        'data' => [
                            'question_id' => $this->questions->last()->id,
                            'input_type' => [
                                'data' => [
                                    'id' => $this->inputType->id
                                ]
                            ],
                            'answers' => [
                                [
                                    'data' => [
                                        'answer_id' => $answersforQuestion2->first()->id
                                    ]
                                ],
                                [
                                    'data' => [
                                        'answer_id' => $answersforQuestion2->last()->id
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }
}
