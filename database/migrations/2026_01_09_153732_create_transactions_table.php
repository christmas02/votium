<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('transaction_id')->primary();
            $table->string('vote_id');
            $table->string('transaction_id_partner')->nullable();
            $table->string('payment_method');
            $table->string('amount_paid');
            $table->string('currency');
            $table->string('country');
            $table->string('telephone');
            $table->string('api_processing');
            $table->text('response_check_payment')->nullable();
            $table->string('comment');
            $table->text('response_init_payment')->nullable();
            $table->string('is_ecriture_comptable')->default(0);
            $table->string('status')->default('pending');
            $table->date('date_transaction')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
