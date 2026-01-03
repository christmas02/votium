<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\Campagne;

class CategoryCampagneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('fr_FR');

        // Récupérer toutes les campagnes existantes
        $campagnes = Campagne::pluck('campagne_id');
        foreach ($campagnes as $campagneId) {

            // 3 catégories par campagne
            for ($i = 1; $i <= 2; $i++) {

                DB::table('category_campagnes')->insert([
                    'category_id' => (string) Str::uuid(),
                    'campagne_id' => $campagneId,
                    'name' => $faker->name,
                    'description' => $faker->paragraph(2),
                    'icon' => $faker->randomElement(['homme', 'femme', 'enfant', 'jeune']),
                    'is_active' => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
