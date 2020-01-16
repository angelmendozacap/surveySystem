<?php

namespace Tests\Feature;

use App\User;
use App\InputType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InputTypeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_input_type_can_be_created()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $response = $this->post('/api/input-types', $this->data());

        $inputType = InputType::first();

        $this->assertEquals($inputType->type, 'text');
        $this->assertEquals($inputType->display_name, 'Párrafo');

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertExactJson([
            'data' => [
                'id' => $inputType->id,
                'type' => $inputType->type,
                'display_name' => $inputType->display_name,
                'created_at' => $inputType->created_at->diffForHumans()
            ]
        ]);
    }

    /** @test */
    public function input_type_fields_are_required()
    {
        // $this->withoutExceptionHandling();
        collect(['type', 'display_name'])->each(function ($field) {
            $this->actingAs($user = factory(User::class)->create(), 'api');

            $response = $this->post('/api/input-types',
                array_merge($this->data(), [ $field => '' ])
            );

            $response->assertSessionHasErrors($field);
            $this->assertCount(0, InputType::all());
        });
    }

    /** @test */
    public function an_input_types_collection_can_be_retrieved()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $inputTypes = factory(InputType::class, 2)->create();

        $response = $this->get('/api/input-types')->assertStatus(Response::HTTP_OK);

        $response->assertExactJson([
            'data' => [
                [
                    'data' => [
                        'id' => $inputTypes->first()->id,
                        'type' => $inputTypes->first()->type,
                        'display_name' => $inputTypes->first()->display_name,
                        'created_at' => $inputTypes->first()->created_at->diffForHumans()
                    ]
                ],
                [
                    'data' => [
                        'id' => $inputTypes->last()->id,
                        'type' => $inputTypes->last()->type,
                        'display_name' => $inputTypes->last()->display_name,
                        'created_at' => $inputTypes->last()->created_at->diffForHumans()
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    public function an_input_type_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $inputType = factory(InputType::class)->create();

        $response = $this->delete('/api/input-types/'.$inputType->id)->assertStatus(Response::HTTP_OK);

        $this->assertCount(0, InputType::all());
    }

    private function data()
    {
        return [
            'type' => 'text',
            'display_name' => 'Párrafo',
        ];
    }
}
