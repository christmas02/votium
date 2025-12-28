<?php

namespace Database\Seeders;

use App\Models\Campagne;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class EtapeSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('fr_FR');

        // Récupérer toutes les campagnes existantes
        $campagnes = Campagne::pluck('campagne_id');

        foreach ($campagnes as $campagneId) {

            // 2 étapes par campagne
            for ($i = 1; $i <= 2; $i++) {

                $dateDebut = $faker->dateTimeBetween('-10 days', '+10 days');
                $dateFin   = (clone $dateDebut)->modify('+' . rand(5, 15) . ' days');

                $prixVote = $faker->randomElement([100, 200, 500, 1000]);

                DB::table('etapes')->insert([
                    'etape_id' => (string) Str::uuid(),
                    'campagne_id' => $campagneId,

                    'name' => $i === 1 ? 'Phase de présélection' : 'Phase finale',
                    'description' => $faker->paragraph(2),

                    'date_debut' => $dateDebut->format('Y-m-d'),
                    'date_fin' => $dateFin->format('Y-m-d'),
                    'heure_debut' => $faker->time('H:i'),
                    'heure_fin' => $faker->time('H:i'),

                    'type_eligibility' => $i === 1 ? 'top' : null,
                    'seuil_selection' => $i === 1 ? (string) $faker->numberBetween(5, 50) : null,

                    'prix_vote' => (string) $prixVote,

                    // Packages générés automatiquement
                    'package' => json_encode([
                        ['vote' => 10, 'montant' => 10 * $prixVote],
                        ['vote' => 25, 'montant' => 25 * $prixVote],
                        ['vote' => 50, 'montant' => 50 * $prixVote],
                    ]),

                    'renitialisation' => null,
                    'is_active' => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
