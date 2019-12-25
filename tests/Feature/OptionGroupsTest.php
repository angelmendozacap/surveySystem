<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\OptionGroup;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OptionGroupsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_list_of_option_groups_can_be_retrieved()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $group = factory(OptionGroup::class)->create();
        $anotherGroup = factory(OptionGroup::class)->create();

        $response = $this->get('/api/option-groups');
        $response->assertJsonCount(1)->assertJson([
            'data' => [
                [
                    'data' => [
                        'option_group_id' => $group->id,
                    ],
                    'links' => [
                        'self' => $group->path(),
                    ]
                ],
                [
                    'data' => [
                        'option_group_id' => $anotherGroup->id,
                    ],
                    'links' => [
                        'self' => $anotherGroup->path(),
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    public function a_option_group_can_be_added()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $response = $this->post('api/option-groups', $this->data());

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertCount(1, OptionGroup::all());

        $group = OptionGroup::first();

        $this->assertEquals('Disagree-Agree', $group->name_group);

        $this->assertEquals([
            'Completamente en Desacuerdo',
            'En Desacuerdo',
            'Ni de Acuerdo ni en Desacuerdo',
            'De Acuerdo',
            'Completamente de Acuerdo'
        ], $group->options);

        $response->assertJson([
            'data' => [
                'option_group_id' => $group->id,
                'name_group' => $group->name_group,
                'options' => $group->options,
            ],
            'links' => [
                'self' => $group->path(),
            ]
        ]);
    }

    /** @test */
    public function fields_are_required()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $data = collect($this->data());

        $data->each(function ($item, $field) {
            $response = $this->post('api/option-groups', array_merge($this->data(), [$field => '']));
            $response->assertSessionHasErrors($field);
            $this->assertCount(0, OptionGroup::all());
        });
    }

    /** @test */
    public function options_must_be_an_array()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $response = $this->post('api/option-groups', array_merge($this->data(), ['options' => 'De Acuerdo']));
        $response->assertSessionHasErrors('options');
        $this->assertCount(0, OptionGroup::all());
    }

    /** @test */
    public function a_option_group_can_be_retrieved()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $group = factory(OptionGroup::class)->create();
        $response = $this->get('api/option-groups/'.$group->id);

        $response->assertJson([
            'data' => [
                'option_group_id' => $group->id,
                'name_group' => $group->name_group,
                'options' => $group->options,
            ],
            'links' => [
                'self' => $group->path(),
            ]
        ]);
    }

    /** @test */
    public function a_option_group_can_be_patched()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $group = factory(OptionGroup::class)->create();
        $response = $this->patch('api/option-groups/'. $group->id, $this->data());

        $group = $group->fresh();

        $response->assertStatus(Response::HTTP_OK);

        $this->assertEquals('Disagree-Agree', $group->name_group);

        $this->assertEquals([
            'Completamente en Desacuerdo',
            'En Desacuerdo',
            'Ni de Acuerdo ni en Desacuerdo',
            'De Acuerdo',
            'Completamente de Acuerdo'
        ], $group->options);

        $response->assertJson([
            'data' => [
                'option_group_id' => $group->id,
                'name_group' => $group->name_group,
                'options' => $group->options,
            ],
            'links' => [
                'self' => $group->path(),
            ]
        ]);
    }

    /** @test */
    public function a_option_group_can_be_deleted()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $group = factory(OptionGroup::class)->create();
        $response = $this->delete('/api/option-groups/'.$group->id, []);
        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertCount(0, OptionGroup::all());
    }

    public function data()
    {
        return [
            'name_group' => 'Disagree-Agree',
            'options' => [
                'Completamente en Desacuerdo',
                'En Desacuerdo',
                'Ni de Acuerdo ni en Desacuerdo',
                'De Acuerdo',
                'Completamente de Acuerdo'
            ]
        ];
    }
}
