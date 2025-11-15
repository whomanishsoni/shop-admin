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
        Schema::table('payment_gateways', function (Blueprint $table) {
            $table->dropColumn('config');
            $table->dropColumn('api_key');
            $table->dropColumn('api_secret');
            $table->enum('mode', ['test', 'live'])->default('test')->after('gateway_key');
            $table->string('test_key_id')->nullable()->after('mode');
            $table->string('test_key_secret')->nullable()->after('test_key_id');
            $table->string('live_key_id')->nullable()->after('test_key_secret');
            $table->string('live_key_secret')->nullable()->after('live_key_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_gateways', function (Blueprint $table) {
            $table->dropColumn(['mode', 'test_key_id', 'test_key_secret', 'live_key_id', 'live_key_secret']);
            $table->string('api_key')->nullable()->after('gateway_key');
            $table->string('api_secret')->nullable()->after('api_key');
            $table->json('config')->nullable()->after('status');
        });
    }
};
