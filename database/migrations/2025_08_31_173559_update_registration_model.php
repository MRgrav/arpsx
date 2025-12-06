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
        Schema::table('registrations', function (Blueprint $table) {

            $table->unsignedSmallInteger('total_subjects')->default(0);
            $table->unsignedSmallInteger('total_marks_obtained')->default(0);
            $table->unsignedSmallInteger('full_marks')->default(0);


            // Drop old subject, percentage, file upload, and date fields
            $table->dropColumn([
                'subject_1', 'subject_1_marks',
                'subject_2', 'subject_2_marks',
                'subject_3', 'subject_3_marks',
                'subject_4', 'subject_4_marks',
                'subject_5', 'subject_5_marks',
                'subject_6', 'subject_6_marks',
                'subject_7', 'subject_7_marks',
                'passport_photo', 'marksheet',
                'tc_certificate',
                'admission_sought_date'
            ]);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Remove new summary fields
            $table->dropColumn(['total_subjects', 'total_marks_obtained', 'full_marks']);

            // Restore old fields
            $table->string('subject_1')->nullable();
            $table->unsignedTinyInteger('subject_1_marks')->nullable();
            $table->string('subject_2')->nullable();
            $table->unsignedTinyInteger('subject_2_marks')->nullable();
            $table->string('subject_3')->nullable();
            $table->unsignedTinyInteger('subject_3_marks')->nullable();
            $table->string('subject_4')->nullable();
            $table->unsignedTinyInteger('subject_4_marks')->nullable();
            $table->string('subject_5')->nullable();
            $table->unsignedTinyInteger('subject_5_marks')->nullable();
            $table->string('subject_6')->nullable();
            $table->unsignedTinyInteger('subject_6_marks')->nullable();
            $table->string('subject_7')->nullable();
            $table->unsignedTinyInteger('subject_7_marks')->nullable();

            $table->string('passport_photo')->nullable();
            $table->string('marksheet')->nullable();
            $table->string('tc_certificate')->nullable();
            $table->date('admission_sought_date')->nullable();

        });
    }
};
