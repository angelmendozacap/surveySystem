<?php

namespace Tests\Feature;

use App\Answer;
use App\InputType;
use App\Role;
use App\User;
use App\Survey;
use App\Question;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SurveysTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_list_of_surveys_can_be_retrieved()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $survey = factory(Survey::class)->create();
        $anotherSurvey = factory(Survey::class)->create();

        $response = $this->get('/api/surveys');
        $response->assertJsonCount(1)->assertJson([
            'data' => [
                [
                    'data' => [
                        'survey_id' => $survey->id,
                    ],
                    'links' => [
                        'self' => $survey->path(),
                    ]
                ],
                [
                    'data' => [
                        'survey_id' => $anotherSurvey->id,
                    ],
                    'links' => [
                        'self' => $anotherSurvey->path(),
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    public function create_a_new_survey()
    {
        collect(['admin', 'creator'])
            ->each(function ($field) {
                $rol = factory(Role::class)->create(['name' => $field]);

                $user = factory(User::class)->create(['role_id' => $rol->id]);

                $response = $this->actingAs($user, 'api')
                    ->post('/api/surveys', $this->data());

                $survey = Survey::all()->last();

                $this->assertEquals('Test Survey', $survey->name);
                $this->assertEquals('A New Test Description', $survey->description);
                $this->assertEquals('draft', $survey->status);

                $response->assertStatus(Response::HTTP_CREATED);
                $response->assertJson([
                    'data' => [
                        'survey_id' => $survey->id,
                    ],
                    'links' => [
                        'self' => $survey->path(),
                    ]
                ]);
            });
    }

    /** @test */
    public function only_admin_and_creator_users_can_create_surveys()
    {
        $rol = factory(Role::class)->create(['name' => 'student']);

        $user = factory(User::class)->create(['role_id' => $rol->id]);

        $this->actingAs($user, 'api');

        $response = $this->post('/api/surveys', $this->data());
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function name_must_be_required()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $response = $this->post('/api/surveys', array_merge($this->data(), ['name' => '']));

        $response->assertSessionHasErrors('name');
        $this->assertCount(0, Survey::all());
    }

    /** @test */
    public function description_can_be_nullable()
    {
        // $this->withoutExceptionHandling();
        $role = factory(Role::class)->create(['name' => 'admin']);

        $user = factory(User::class)->create(['role_id' => $role->id]);

        $this->actingAs($user, 'api');

        $response = $this->post('/api/surveys', array_except($this->data(), ['description']));

        $survey = Survey::first();

        $this->assertEquals(null, $survey->description);
        $this->assertCount(1, Survey::all());
    }

    /** @test */
    public function a_survey_can_be_retrieved()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $survey = factory(Survey::class)->create();
        $response = $this->get('/api/surveys/'.$survey->id);

        $response->assertJson([
            'data' => [
                'survey_id' => $survey->id,
                'survey_name' => $survey->name,
                'description' => $survey->description,
                'status' => $survey->status,
                'created_at' => $survey->created_at->diffForHumans(),
            ],
            'links' => [
                'self' => $survey->path(),
            ]
        ]);
    }

    /** @test */
    public function a_survey_can_be_patched()
    {
        $this->withoutExceptionHandling();

        $role = factory(Role::class)->create(['name' => 'admin']);

        $user = factory(User::class)->create(['role_id' => $role->id]);

        $this->actingAs($user, 'api');

        $survey = factory(Survey::class)->create();
        $response = $this->patch('/api/surveys/'.$survey->id, array_merge($this->data(), ['status' => 'ready']));

        $survey = $survey->fresh();

        $this->assertEquals('Test Survey', $survey->name);
        $this->assertEquals('A New Test Description', $survey->description);
        $this->assertEquals('ready', $survey->status);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson([
            'data' => [
                'survey_id' => $survey->id,
                'survey_name' => $survey->name,
                'description' => $survey->description,
                'status' => $survey->status,
                'created_at' => $survey->created_at->diffForHumans(),
            ],
            'links' => [
                'self' => $survey->path(),
            ]
        ]);

    }

    /** @test */
    public function a_survey_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $role = factory(Role::class)->create(['name' => 'admin']);

        $user = factory(User::class)->create(['role_id' => $role->id]);

        $this->actingAs($user, 'api');

        $survey = factory(Survey::class)->create();

        $inputType = factory(InputType::class)->create();
        $questions = factory(Question::class, 3)->create([
            'survey_id' => $survey->id,
            'input_type_id' => $inputType->id
        ]);

        $questions->each(function ($question) {
            factory(Answer::class)->create([
                'question_id' => $question->id
            ]);
        });

        $response = $this->delete('/api/surveys/'.$survey->id, []);

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertCount(0, Survey::all());
        $this->assertCount(0, Question::all());
        $this->assertCount(0, Answer::all());
    }

    /** @test */
    public function a_survey_status_can_be_changed()
    {
        $this->withoutExceptionHandling();

        $role = factory(Role::class)->create(['name' => 'admin']);
        $user = factory(User::class)->create(['role_id' => $role->id]);

        $survey = factory(Survey::class)->create();
        $questions = factory(Question::class, 3)->create(['survey_id' => $survey->id]);

        collect(['draft', 'ready', 'finished'])->each(function ($field) use ($user, $survey) {

            $this->actingAs($user, 'api');

            $response = $this->patch('/api/surveys/'.$survey->id.'/change-status', [ 'status' => $field ]);

            $response->assertStatus(Response::HTTP_OK);

            $survey = $survey->fresh();

            $this->assertEquals($field, $survey->status);

            $response->assertJson([
                'data' => [
                    'survey_id' => $survey->id,
                    'survey_name' => $survey->name,
                    'description' => $survey->description,
                    'status' => $survey->status,
                    'created_at' => $survey->created_at->diffForHumans(),
                ],
                'links' => [
                    'self' => $survey->path(),
                ]
            ]);
        });

        $this->assertCount(3, Question::all());
        $this->assertCount(1, Survey::all());
    }

    private function data()
    {
        return [
            'name' => 'Test Survey',
            'description' => 'A New Test Description',
            'status' => 'draft'
        ];
    }
}
