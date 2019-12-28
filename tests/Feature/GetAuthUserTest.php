<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetAuthUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_be_fetched()
    {
        $this->withoutExceptionHandling();

        $role = factory(Role::class)->create();

        $user = factory(User::class)->create(['role_id' => $role->id]);

        $this->actingAs($user, 'api');

        $response = $this->get('/api/auth-user');

        $response->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'data' => [
                    'user_id' => $user->id,
                    'role' => [
                        'data' => [
                            'role_id' => $role->id,
                            'name' => $role->name,
                            'created_at' => $role->created_at->diffForHumans()
                        ],
                        'links' => [
                            'self' => url('/roles/'.$role->id),
                        ],
                    ],
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at->diffForHumans()
                ],
                'links' => [
                    'self' => url('/users/'.$user->id)
                ]
            ]);
    }
}
