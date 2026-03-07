<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('h_s_registrations', function (Blueprint $table) {
            $table->string('reference_number')->nullable();
            $table->string('payment_screenshot')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('h_s_registrations', function (Blueprint $table) {
            $table->dropColumn(['reference_number', 'payment_screenshot']);
        });
    }
};
