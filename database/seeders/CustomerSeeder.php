<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('fr_FR');

        // Récupère les users existants avec le rôle 'customer' (créés par UsersSeeder)
        $users = User::where('role', 'customer')->get();

        if ($users->isEmpty()) {
            \Log::warning('CustomerSeeder: aucun user de rôle "customer" trouvé. Aucun enregistrement customer créé.');
            return;
        }

        foreach ($users as $user) {
            // Si un customer existe déjà pour ce user, on skip
            $exists = DB::table('customers')->where('user_id', $user->user_id)->exists();
            if ($exists) {
                continue;
            }

            DB::table('customers')->insert([
                'customer_id' => (string) Str::uuid(),
                'user_id' => $user->user_id,
                'entreprise' => $faker->company,
                'pays_siege' => $faker->country,
                'email' => $user->email,
                'phonenumber' => $user->phonenumber ?? $faker->phoneNumber,
                'adresse' => $faker->address,
                'link_facebook' => $faker->boolean(40) ? $faker->url : null,
                'link_instagram' => $faker->boolean(30) ? $faker->url : null,
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