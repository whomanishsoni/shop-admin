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
        Schema::table('transactions', function (Blueprint $table) {
            // Only add columns that don't already exist
            if (!Schema::hasColumn('transactions', 'fee')) {
                $table->decimal('fee', 10, 2)->nullable()->after('currency'); // Gateway fee if available
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'gateway_order_id',
                'payment_mode',
                'bank_name',
                'card_type',
                'card_network',
                'wallet_name',
                'gateway_response',
                'currency',
                'fee'
            ]);
        });
    }
};
