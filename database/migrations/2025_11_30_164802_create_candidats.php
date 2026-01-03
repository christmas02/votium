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
            $table->string('email');
            $table->string('phonenumber');
            $table->string('sexe');
            $table->date('date_naissance');
            $table->date('ville');
            $table->date('pays');
            $table->string('profession');
            $table->text('photo');
            $table->text('description');
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
