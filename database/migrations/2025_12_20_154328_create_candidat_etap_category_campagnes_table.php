<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatEtapCategoryCampagnesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidat_etap_category_campagnes', function (Blueprint $table) {
            $table->uuid('candidat_etap_id')->primary();
            $table->string('campagne_id');
            $table->string('candidat_id');
            $table->string('etape_id');
            $table->string('category_id');
            $table->string('is_active');
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
        Schema::dropIfExists('candidat_etap_category_campagnes');
    }
}
