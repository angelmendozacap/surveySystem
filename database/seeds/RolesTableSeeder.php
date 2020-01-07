<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'admin'
            ],
            [
                'name' => 'student'
            ],
            [
                'name' => 'creator'
            ]
        ];

        collect($roles)->each(function ($rol) {
            Role::create($rol);
        });
    }
}
