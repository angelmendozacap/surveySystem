<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'admin')->firstOrFail();

        $user = factory(User::class)->create([
            'name' => 'Alfredo Mendoza',
            'email' => '1930.kick@gmail.com',
            'role_id' => $role->id
        ]);
    }
}
