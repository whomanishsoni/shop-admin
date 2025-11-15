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
            $table->string('vpa')->nullable()->after('wallet_name'); // Virtual Payment Address for UPI
            $table->decimal('tax', 10, 2)->nullable()->after('fee'); // Tax amount
            $table->json('acquirer_data')->nullable()->after('tax'); // Acquirer data
            $table->string('error_code')->nullable()->after('acquirer_data'); // Error code
            $table->text('error_description')->nullable()->after('error_code'); // Error description
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['vpa', 'tax', 'acquirer_data', 'error_code', 'error_description']);
        });
    }
};
