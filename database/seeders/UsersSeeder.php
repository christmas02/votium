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
        // 2 admins (emails fixes pour accès facile)
        $admins = [
            ['name' => 'Super Admin', 'email' => 'admin@exemple.com'],
            ['name' => 'Second Admin', 'email' => 'admin2@exemple.com'],
        ];

        foreach ($admins as $admin) {
            User::create([
                'user_id' => (string) Str::uuid(),
                'name' => $admin['name'],
                'email' => $admin['email'],
                'role' => 'admin',
                'password' => Hash::make('password123'),
                'phonenumber' => $faker->phoneNumber,
            ]);
        }

        // 10 customers générés customer1@exemple.com
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'user_id' => (string) Str::uuid(),
                'name' => $faker->name,
                'email' => 'customer' . $i . '@exemple.com',
                'role' => 'customer',
                'password' => Hash::make('password123'),
                'phonenumber' => $faker->phoneNumber,
            ]);
        }
    }
}
