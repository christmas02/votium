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
            $table->id();
            $table->string('candidat_id');
            $table->string('campagne_id');
            $table->string('etape_id');
            $table->string('category_id');
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
        Schema::dropIfExists('candidat_etap_category_campagnes');
    }
}
