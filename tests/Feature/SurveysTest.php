<?php

namespace Tests\Feature;

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
        $response = $this->post('/api/surveys', $this->data());

        $survey = Survey::first();

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
    }

    /** @test */
    public function name_must_be_required()
    {
        $response = $this->post('/api/surveys', array_merge($this->data(), ['name' => '']));

        $response->assertSessionHasErrors('name');
        $this->assertCount(0, Survey::all());
    }

    /** @test */
    public function description_can_be_nullable()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/api/surveys', array_except($this->data(), ['description']));

        $survey = Survey::first();

        $this->assertEquals(null, $survey->description);
        $this->assertCount(1, Survey::all());
    }

    /** @test */
    public function a_survey_can_be_retrieved()
    {
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
        $survey = factory(Survey::class)->create();
        $questions = factory(Question::class, 3)->create(['survey_id' =>$survey->id]);

        $response = $this->delete('/api/surveys/'.$survey->id, []);

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertCount(0, Question::all());
        $this->assertCount(0, Survey::all());
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
