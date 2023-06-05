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
        Schema::create('urinalysis_table', function (Blueprint $table) {
            $table->id();
            $table->string('age')->nullable();
            $table->string('requestDate')->nullable();
            $table->string('color')->nullable();
            $table->string('transparency')->nullable();
            $table->string('gravity')->nullable();
            $table->string('ph')->nullable();
            $table->string('sugar')->nullable();
            $table->string('protein')->nullable();
            $table->string('pregnancy')->nullable();
            $table->string('pus')->nullable();
            $table->string('rbc')->nullable();
            $table->string('cast')->nullable();
            $table->string('urates')->nullable();
            $table->string('uric')->nullable();
            $table->string('cal')->nullable();
            $table->string('epith')->nullable();
            $table->string('mucus')->nullable();
            $table->string('otherOthers')->nullable();
            $table->string('pathologist')->nullable();
            $table->string('technologist')->nullable();
            $table->timestamps();
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
