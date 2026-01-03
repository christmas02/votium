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
            $table->id();
            $table->string('candidat_id')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->string('sexe');
            $table->string('date_naissance');
            $table->string('profession');
            $table->string('telephone');
            $table->string('email')->unique();
            $table->string('pays');
            $table->string('ville');
            $table->string('photo')->nullable();
            $table->text('description');
            $table->text('data')->nullable();
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
        Schema::dropIfExists('candidats');
    }
}
