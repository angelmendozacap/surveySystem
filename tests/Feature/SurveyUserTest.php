<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use App\Answer;
use App\Survey;
use App\Question;
use App\InputType;
use App\SurveyUser;
use Tests\TestCase;
use App\SurveyResponse;
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

        $response = $this->get('/api/surveys-to-answer')
            ->assertStatus(Response::HTTP_OK);

        $response->assertJson([
            'data' => [
                [
                    'data' => [
                        'survey_id' => $this->survey->id,
                        'status' => 'ready',
                    ],
                    'links' => [
                        'self' => '/surveys-to-answer/' . $this->survey->id
                    ]
                ],
                [
                    'data' => [
                        'survey_id' => $anotherSurvey->id,
                        'status' => 'ready',
                    ],
                    'links' => [
                        'self' => '/surveys-to-answer/' . $anotherSurvey->id
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

        $response = $this->get('/api/surveys-to-answer/' . $this->survey->id)
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

    /** @test */
    public function surveys_taken_can_be_retrieved()
    {
        $this->withoutExceptionHandling();

        $adminRole = factory(Role::class)->create(['name' => 'admin']);
        $user = factory(User::class)->create(['role_id' => $adminRole->id]);

        $this->actingAs($user, 'api');

        $answersforQuestion1 = factory(Answer::class, 2)->create([
            'question_id' => $this->questions->first()->id
        ]);

        $answersforQuestion2 = factory(Answer::class, 2)->create([
            'question_id' => $this->questions->last()->id
        ]);

        $this->post("/api/surveys-to-answer/{$this->survey->id}", [
            'responses' => [
                [
                    'answer_id' => $answersforQuestion1->last()->id,
                    'question_id' => $this->questions->first()->id,
                ],
                [
                    'answer_id' => $answersforQuestion2->first()->id,
                    'question_id' => $this->questions->last()->id,
                ],
            ]
        ]);

        factory(Survey::class, 2)->create([ 'status' => 'draft' ]);

        $response = $this->get('/api/surveys-answered')
            ->assertStatus(Response::HTTP_OK);

        // dd($response->getContent());
        $response->assertJson([
            'data' => [
                [
                    'data' => [
                        'survey_taken_id' => $this->survey->id,
                        'user_id' => $user->id,
                        'survey' => [
                            'data' => [
                                'survey_name' => $this->survey->name,
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    public function a_user_can_take_a_survey_only_with_choices()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($this->user, 'api');

        $answersforQuestion1 = factory(Answer::class, 2)->create([
            'question_id' => $this->questions->first()->id
        ]);

        $answersforQuestion2 = factory(Answer::class, 2)->create([
            'question_id' => $this->questions->last()->id
        ]);

        $response = $this->post("/api/surveys-to-answer/{$this->survey->id}", [
            'responses' => [
                [
                    'answer_id' => $answersforQuestion1->last()->id,
                    'question_id' => $this->questions->first()->id,
                ],
                [
                    'answer_id' => $answersforQuestion2->first()->id,
                    'question_id' => $this->questions->last()->id,
                ],
            ]
        ]);

        // dd($response->getContent());

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertCount(1, $surveyUser = SurveyUser::all());

        $this->assertEquals($surveyUser->first()->survey_id, $this->survey->id);
        $this->assertEquals($surveyUser->first()->user_id, $this->user->id);

        $responses = SurveyResponse::all();
        $this->assertEquals($surveyUser->first()->id, $responses->first()->survey_user_id);
        $this->assertEquals($answersforQuestion1->last()->id, $responses->first()->answer_id);
        $this->assertEquals($answersforQuestion2->first()->id, $responses->last()->answer_id);

        $response->assertJson([
            'data' => [
                'survey_taken_id' => $surveyUser->first()->id,
                'user_id' => $this->user->id,
                'survey' => [
                    'data' => [
                        'survey_id' => $this->survey->id
                    ]
                ],
                'taken_at' => $surveyUser->first()->created_at->diffForHumans(),
            ]
        ]);
    }
}
