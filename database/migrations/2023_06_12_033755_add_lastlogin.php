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
        Schema::table('client_info', function (Blueprint $table) {
            $table->string('last_login');
        });
        Schema::table('teacher_data', function (Blueprint $table) {
            $table->string('last_login');
        });
        Schema::table('nurse_data', function (Blueprint $table) {
            $table->string('last_login');
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
