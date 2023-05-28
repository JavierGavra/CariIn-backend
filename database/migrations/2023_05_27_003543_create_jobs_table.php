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
            $table->enum('time_type', ['Full time', 'Part time']);
            $table->bigInteger('salary');
            $table->enum('gender', ["male", "female"]);
            $table->enum('education', ["SMP", "SMA", "SMK"]);
            $table->integer('minimum_age');
            $table->integer('maximum_age');
            $table->text('description');
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
