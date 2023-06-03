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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('city');
            $table->enum('time_type', ['full time', 'part time']);
            $table->bigInteger('salary');
            $table->foreignId('company_id');
            $table->enum('gender', ["male", "female", "all"]);
            $table->enum('education', ["smp", "sma", "smk", "all"]);
            $table->integer('minimum_age');
            $table->integer('maximum_age');
            $table->text('description');
            $table->boolean('pkl_status');
            $table->enum('confirmed_status', ["accept", "reject", "waiting"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
