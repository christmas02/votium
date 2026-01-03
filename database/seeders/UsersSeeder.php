<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('fr_FR');
        User::create([
            'user_id' => (string) Str::uuid(),
            'name' => 'Super Admin',
            'email' => 'admin@exemple.com',
            'role' => 'admin',
            'password' => Hash::make('password123'),
            'phonenumber' => $faker->phoneNumber,
        ]);
    }
}
