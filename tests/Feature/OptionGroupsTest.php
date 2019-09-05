<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\OptionGroup;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OptionGroupsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_option_group_can_be_added()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('api/option-groups', $this->data());

        $response->assertStatus(Response::HTTP_CREATED);

        $group = OptionGroup::first();

        $this->assertEquals('Disagree-Agree', $group->name_group);

        $this->assertEquals([
            'Completamente en Desacuerdo',
            'En Desacuerdo',
            'Ni de Acuerdo ni en Desacuerdo',
            'De Acuerdo',
            'Completamente de Acuerdo'
        ], $group->options);

        $this->assertCount(1, OptionGroup::all());
    }

    /** @test */
    public function fields_are_required()
    {
        $data = collect($this->data());

        $data->each(function ($item, $key) {
            $response = $this->post('api/option-groups', array_merge($this->data(), [$key => '']));
            $response->assertSessionHasErrors($key);
            $this->assertCount(0, OptionGroup::all());
        });
    }

    /** @test */
    public function options_must_be_an_array()
    {
        $response = $this->post('api/option-groups', array_merge($this->data(), ['options' => 'De Acuerdo']));
        $response->assertSessionHasErrors('options');
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
