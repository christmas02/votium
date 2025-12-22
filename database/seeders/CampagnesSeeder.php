<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Customer;

class CampagnesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('fr_FR');

        $customerIds = Customer::pluck('customer_id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            DB::table('campagnes')->insert([
                'campagne_id' => (string) Str::uuid(),
                'name' => ucfirst($faker->words(3, true)),
                'description' => $faker->paragraphs(3, true),
                'image_couverture' => 'default_image_couverture.jpg',
                'customer_id' => count($customerIds) ? $faker->randomElement($customerIds) : (string) Str::uuid(),
                'text_cover_isActive' => $faker->boolean(50),
                'inscription_isActive' => $faker->boolean(70),
                'inscription_date_debut' => $faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
                'inscription_date_fin'   => $faker->dateTimeBetween('+1 month', '+3 months')->format('Y-m-d'),
                'heure_debut_inscription' => $faker->time('H:i:s'),
                'heure_fin_inscription' => $faker->time('H:i:s'),
                'identifiants_personnalises_isActive' => $faker->randomElement(['1', '0']),
                'afficher_montant_pourcentage' => $faker->randomElement(['clair', 'pourcentage', 'les_deux']),
                'ordonner_candidats_votes_decroissants' => $faker->randomElement(['1', '0']),
                'quantite_vote' => (string) $faker->randomElement(['100', '200', '300', '500', '1000']),
                'color_primaire' => $faker->hexColor,
                'color_secondaire' => $faker->hexColor,
                'condition_participation' => 'default_condition.pdf',
                'is_active' => $faker->boolean(90),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
