<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryCampagnesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_campagnes', function (Blueprint $table) {
            $table->uuid('category_campagne_id')->primary();
            $table->string('name');
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
        Schema::dropIfExists('category_campagnes');
    }
}
