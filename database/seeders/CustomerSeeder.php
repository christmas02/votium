<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('fr_FR');

        // Récupère au moins un user_id existant pour lier les customers (si aucun user, on génère un uuid)
        $userIds = User::pluck('user_id')->toArray();
        for ($i = 0; $i < 10; $i++) {
            DB::table('customers')->insert([
                'customer_id' => (string) Str::uuid(),
                'user_id' => count($userIds) ? $faker->randomElement($userIds) : (string) Str::uuid(),
                'entreprise' => $faker->company,
                'pays_siege' => $faker->country,
                'email' => $faker->unique()->companyEmail,
                'phonenumber' => $faker->phoneNumber,
                'adresse' => $faker->address,
                'link_facebook' => $faker->boolean(40) ? $faker->url : null,
                'link_instagram' => $faker->boolean(30) ? $faker->url : null,
                'link_twitter' => $faker->boolean(30) ? $faker->url : null,
                'link_tiktok' => $faker->boolean(30) ? $faker->url : null,
                'link_youtube' => $faker->boolean(20) ? $faker->url : null,
                'logo' => 'logo.png',
                'link_linkedin' => $faker->boolean(40) ? $faker->url : null,
                'link_website' => $faker->boolean(60) ? $faker->url : null,
                'is_active' => $faker->boolean(90),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}