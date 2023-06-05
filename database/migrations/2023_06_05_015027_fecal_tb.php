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
        Schema::create('fecalysis_table', function (Blueprint $table) {
            $table->id();
            $table->string('requestBy');
            $table->date('requestDate');
            $table->string('color');
            $table->string('consistency');
            $table->string('occult');
            $table->string('otherOccult');
            $table->string('pus');
            $table->string('rbc');
            $table->string('fat');
            $table->string('ova');
            $table->string('larva');
            $table->string('adult');
            $table->string('cyst');
            $table->string('trophozoites');
            $table->string('otherTrophozoites');
            $table->text('remarks');
            $table->string('pathologist');
            $table->string('technologist');
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
