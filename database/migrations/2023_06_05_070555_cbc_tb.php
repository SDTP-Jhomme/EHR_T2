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
        Schema::create('cbc_table', function (Blueprint $table) {
            $table->id();
            $table->string('age');
            $table->string('hemoglobin');
            $table->string('hematocrit');
            $table->string('wbc');
            $table->string('rbc');
            $table->string('mcv');
            $table->string('mch');
            $table->string('mchc');
            $table->string('platelet');
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
