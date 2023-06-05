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
        Schema::create('vaccine_table', function (Blueprint $table) {
            $table->id();
            $table->string('age');
            $table->string('vaccinationDate');
            $table->string('vaccineBatch');
            $table->string('healthcareProvider');
            $table->timestamps();
            $table->string('section');
            $table->foreignId('student_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
