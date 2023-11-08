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
        Schema::create('citizens', function (Blueprint $table) {
            $table->id();
            $table->string('pin')->unique();
            $table->year('pin_year');
            $table->bigInteger('pin_series');
            $table->string('forename');
            $table->string('midname');
            $table->string('surname');
            $table->string('suffix')->nullable();
            $table->date('birthdate');
            $table->foreignId('gender_id');
            $table->string('vicinity');
            $table->string('barangay');
            $table->foreignId('profile_id');
            $table->string('avatar')->nullable();
            $table->string('info_status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citizens');
    }
};
