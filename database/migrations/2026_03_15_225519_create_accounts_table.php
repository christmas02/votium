<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('accounts')) return;
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('account_id')->primary();
            $table->uuid('customer_id');
            $table->string('account_number')->unique();
            $table->decimal('balance', 15, 2)->default(0);
            $table->decimal('balance_after', 15, 2)->default(0);
            $table->decimal('balance_before', 15, 2)->default(0);
            $table->string('account_type')->nullable();
            $table->string('status')->default('active');
            $table->string('billing_rate');
            $table->timestamps();

            // Contrainte de clé étrangère
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
