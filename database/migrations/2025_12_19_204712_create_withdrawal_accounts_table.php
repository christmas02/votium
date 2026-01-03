<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawal_accounts', function (Blueprint $table) {
            $table->uuid('withdrawal_account_id')->primary();
            $table->string('phone_number');
            $table->string('account_name');
            $table->string('payment_methode');
            $table->string('payment_methode_icon');
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
        Schema::dropIfExists('withdrawal_accounts');
    }
}
