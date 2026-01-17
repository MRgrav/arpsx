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
        Schema::table('ragistrations', function (Blueprint $table) {
            //
            $table->string('parents_category_b')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ragistrations', function (Blueprint $table) {
            //
            $table->dropColumn('parents_category_b');
        });
    }
};
