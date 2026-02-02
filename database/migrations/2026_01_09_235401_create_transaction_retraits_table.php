<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionRetraitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_retraits', function (Blueprint $table) {
            $table->uuid('transactions_retraits_id')->primary();
            $table->string('withdrawal_account_id');
            $table->string('payment_method');
            $table->string('montant_payee');
            $table->string('currency');
            $table->string('telephone');
            $table->string('api_processing');
            $table->string('api_response');
            $table->string('commentaire');
            $table->string('status')->default('PENDING');
            $table->date('date_transaction');
            $table->date('date_processing')->nullable();
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
        Schema::dropIfExists('transaction_retraits');
    }
}
