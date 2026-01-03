<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Candidat;
use App\Models\Campagne;
use App\Models\Etape;
use App\Models\CategoryCampagne as Category;
use App\Models\CandidatEtapCategoryCampagne;
use Illuminate\Support\Facades\DB;

class CandidatSeeder extends Seeder
{
    public function run()
    {
        $campagnes = Campagne::all();
        $etapes    = Etape::all();
        $categories = Category::all();
        $faker = \Faker\Factory::create('fr_FR');
        foreach ($campagnes as $campagne) {

            // Créer 5 candidats par campagne
            for ($i = 1; $i <= 5; $i++) {

                $candidat = Candidat::create([
                    'candidat_id' => 'CAN-' . Str::upper(Str::random(8)),
                    'nom' => $faker->lastName(),
                    'prenom' => $faker->firstName(),
                    'sexe' => $faker->randomElement(['M', 'F']),
                    'date_naissance' => $faker->date(),
                    'profession' => $faker->jobTitle(),
                    'telephone' => $faker->phoneNumber(),
                    'email' => $faker->unique()->safeEmail(),
                    'pays' => 'Côte d\'Ivoire',
                    'ville' => $faker->city(),
                    'photo' => 'logo.png',
                    'description' => $faker->paragraph(3, true),
                    'is_active' => true,
                ]);

                // Associer à une étape et une catégorie aléatoires
                DB::table('candidat_etap_category_campagnes')->insert([
                    'candidat_id' => $candidat->candidat_id,
                    'campagne_id' => $campagne->campagne_id,
                    'etape_id' => $etapes->random()->etape_id,
                    'category_id' => $categories->random()->category_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
