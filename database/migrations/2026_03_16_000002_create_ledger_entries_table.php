<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgerEntriesTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('ledger_entries')) return;
        Schema::create('ledger_entries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('transaction_id');
            $table->string('account_type'); // processing_partner | customer | platform
            $table->uuid('account_id')->nullable();
            $table->string('entry_type'); // processing_fee | customer_credit | platform_revenue
            $table->decimal('amount', 15, 2);
            $table->text('description')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('transaction_id');
            $table->index('account_type');
            $table->index('entry_type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ledger_entries');
    }
}
