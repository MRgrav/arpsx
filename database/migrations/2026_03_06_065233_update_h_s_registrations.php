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
            $table->string('pen_number')->nullable();
            $table->string('apaar_id')->nullable();
            $table->bigInteger('parents_contact_number')->nullable();
            $table->bigInteger('whatsapp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('h_s_registrations', function (Blueprint $table) {
            $table->dropColumn(['pen_number', 'apaar_id', 'parents_contact_number', 'whatsapp']);
        });
    }
};
