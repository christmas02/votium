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
        //
        User::create([
            'user_id' => Str::uuid(),
            'name' => 'John Doe',
            'email' => 'john@exemple.com',
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);
        dd('called');
    }
}
