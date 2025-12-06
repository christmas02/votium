<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('user_id');
            $table->string('entreprise');
            $table->string('pays_siege');
            $table->string('email')->unique();
            $table->string('phonenumber');
            $table->string('adresse');
            $table->string('link_facebook')->nullable();
            $table->string('link_instagram')->nullable();
            $table->string('link_twitter')->nullable();
            $table->string('link_youtube')->nullable();
            $table->string('logo')->default('logo.png');
            $table->string('link_linkedin')->nullable();
            $table->string('link_website')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
