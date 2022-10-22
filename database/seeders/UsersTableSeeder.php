<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    public function run()
    {

        \DB::table('users')->delete();

        User::create(['name' => 'Administrador','email' => 'admin@admin.com','password' => bcrypt('12345678'),
        ])->assignRole('Admin');

        User::create(['name' => 'Gestor', 'email' => 'gestor@gestor.com','password'=>bcrypt('12345678'),
        ])->assignRole('Gestor');

        User::create(['name' => 'Milimetrica','email' => 'milimetrica@milimetrica.com','password' => bcrypt('12345678'),
        ])->assignRole('Milimetrica');


        // User::factory(9)->create();

    }
}
