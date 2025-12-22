<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampagnes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campagnes', function (Blueprint $table) {
            $table->id();
            $table->string('campagne_id');
            $table->string('name');
            $table->longText('description');
            $table->string('image_couverture');
            $table->string('customer_id');
            $table->boolean('text_cover_isActive')->default(false);
            $table->boolean('inscription_isActive')->default(false);
            $table->string('inscription_date_debut')->nullable();
            $table->string('inscription_date_fin')->nullable();
            $table->time('heure_debut_inscription')->nullable();
            $table->time('heure_fin_inscription')->nullable();
            $table->string('identifiants_personnalises_isActive');
            $table->string('afficher_montant_pourcentage')->default('clair'); //clair,
            $table->string('ordonner_candidats_votes_decroissants');
            $table->string('quantite_vote');
            $table->string('color_primaire');
            $table->string('color_secondaire');
            $table->string('condition_participation');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campagnes');
    }
}
