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
        Schema::create('h_s_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('stream')->nullable();
            $table->decimal('pre_borad_percentage', 6, 2)->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('last_school')->nullable();
            $table->bigInteger('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('reason_of_interest')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('h_s_registrations');
    }
};
