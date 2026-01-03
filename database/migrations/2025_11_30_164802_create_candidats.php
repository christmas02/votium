<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidats', function (Blueprint $table) {
            $table->uuid('candidat_id')->primary();
            $table->string('name');
            $table->date('date_naissance');
            $table->string('phonenumber');
            $table->string('email');
            $table->string('categorie')->nullable();
            $table->text('galerie');
            $table->text('data');
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
        Schema::dropIfExists('candidats');
    }
}
