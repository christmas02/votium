<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcritureComptableTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecriture_comptable_transactions', function (Blueprint $table) {
            $table->uuid('ecriture_comptable_id')->primary();
            $table->string('transaction_id');
            $table->string('account');
            $table->string('debit');
            $table->string('credit');
            $table->string('description');
            $table->string('date_ecriture');
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
        Schema::dropIfExists('ecriture_comptable_transactions');
    }
}
