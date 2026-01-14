<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
            Schema::create('driver_financial_transactions', function (Blueprint $table) {
        $table->id();
        $table->uuid('transaction_uuid')->unique();
        $table->uuid('driver_uuid');
        $table->uuid('trip_uuid')->nullable();
        $table->string('driver_name');
        $table->string('organisation_name');
        $table->timestamp('reported_at')->nullable();
        $table->decimal('summary_amount', 10, 2)->default(0);

        $table->json('earnings_json');
        $table->json('trip_balance_json');
        $table->json('raw_row_json')->nullable();

        $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_financial_transactions');
    }
};
