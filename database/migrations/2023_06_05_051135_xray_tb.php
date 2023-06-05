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
        Schema::create('xray_table', function (Blueprint $table) {
            $table->id();
            $table->string('case_No');
            $table->date('referred_by');
            $table->string('room_bed');
            $table->string('clinical_impression');
            $table->string('type_examination');
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
