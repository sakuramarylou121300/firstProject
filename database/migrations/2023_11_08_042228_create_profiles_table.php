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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('livelihood_status_id');
            $table->foreignId('family_income_range_id');
            $table->foreignId('tenurial_status_id');
            $table->foreignId('kayabe_kard_type_id');
            $table->foreignId('dependent_range_id');
            $table->integer('total_dependents');
            $table->integer('family_vulnerability');
            $table->string('identity_card_no')->nullable();;
            $table->string('medication');
            $table->string('remarks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
