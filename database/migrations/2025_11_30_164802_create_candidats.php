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
            $table->string('email')->nullable();
            $table->string('phonenumber')->nullable();
            $table->string('sexe')->nullable();
            $table->string('date_naissance')->nullable();
            $table->string('ville')->nullable();
            $table->string('pays')->nullable();
            $table->string('profession')->nullable();
            $table->text('photo');
            $table->text('description')->nullable();
            $table->text('data')->nullable();
            $table->string('is_active')->default(true);
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
