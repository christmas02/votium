<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\Campagne;
use App\Models\Customer;

class SaveCampagneTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_save_a_campagne_successfully()
    {
        // 1. Préparer les données nécessaires
        $customer = Customer::factory()->create();

        $data = [
            'name' => 'Campagne Test',
            'campagne_id' => Str::uuid(),
            'description' => str_repeat('Lorem ipsum ', 50), // texte long
            'image_couverture' => 'image.png',
            'customer_id' => $customer->id,
            'text_cover_isActive' => 0,
            'inscription_isActive' => 0,
            'inscription_date_debut' => now()->toDateString(),
            'inscription_date_fin' => now()->addDays(5)->toDateString(),
            'afficher_montant_pourcentage' => 'clair',
            'ordonner_candidats_votes_decroissants' => 0,
            'quantite_vote' => 1,
            'color_primaire' => '#000000',
            'color_secondaire' => '#FFFFFF',
            'heure_debut_inscription' => '08:00',
            'heure_fin_inscription' => '18:00',
            'identifiants_personnalises_isActive' => 0,
            'is_active' => 1,
            'condition_participation' => 'condition.pdf',
        ];

        // 2. Action : sauvegarde
        Campagne::create($data);

        // 3. Assertions : vérifications
        $this->assertDatabaseHas('campagnes', [
            'name' => 'Campagne Test',
            'customer_id' => $customer->id,
            'is_active' => 1,
        ]);
    }
}
