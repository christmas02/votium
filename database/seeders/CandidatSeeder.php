<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Candidat;
use App\Models\Campagne;
use App\Models\Etape;
use App\Models\CategoryCampagne;
use App\Models\CandidatEtapCategoryCampagne;
use Illuminate\Support\Facades\DB;

class CandidatSeeder extends Seeder
{
    public function run()
    {
        $campagnes = Campagne::all();
        $etapes    = Etape::all();
        $categories = CategoryCampagne::all();
        $faker = \Faker\Factory::create('fr_FR');
        foreach ($campagnes as $campagne) {

            // Créer 5 candidats par campagne
            for ($i = 1; $i <= 10; $i++) {

                $candidat = Candidat::create([
                    'candidat_id' => Str::upper(Str::random(8)),
                    'name' => $faker->lastName(),
                    'sexe' => $faker->randomElement(['M', 'F']),
                    'date_naissance' => $faker->date(),
                    'profession' => $faker->jobTitle(),
                    'phonenumber' => $faker->phoneNumber(),
                    'email' => $faker->unique()->safeEmail(),
                    'pays' => 'Côte d\'Ivoire',
                    'ville' => $faker->city(),
                    'photo' => 'logo.png',
                    'description' => $faker->paragraph(3, true),
                    'data' => null,
                    'is_active' => true,
                ]);

                // Associer à une étape et une catégorie aléatoires
                DB::table('candidat_etap_category_campagnes')->insert([
                    'candidat_etap_id' => Str::upper(Str::random(8)),
                    'candidat_id' => $candidat->candidat_id,
                    'campagne_id' => $campagne->campagne_id,
                    'etape_id' => $etapes->random()->etape_id,
                    'category_id' => $categories->random()->category_id,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
