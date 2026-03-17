<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiProcessingTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('api_processing')) return;
        Schema::create('api_processing', function (Blueprint $table) {
            $table->uuid('api_processing_id')->primary();
            $table->string('name');
            $table->string('payment_method');
            $table->string('api_key')->nullable();
            $table->decimal('processing_rate', 8, 6)->default(0);
            $table->string('currency')->nullable();
            $table->string('country')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('api_processing');
    }
}
