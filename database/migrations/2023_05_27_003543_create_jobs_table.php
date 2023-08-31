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
            $table->string('cover_image');
            $table->string('backdrop_image');
            $table->string('location');
            $table->enum('time_type', ['full time', 'part time']);
            $table->bigInteger('salary');
            $table->foreignId('company_id');
            $table->enum('gender', ["pria", "wanita", "bebas"]);
            $table->enum('education', ["smp", "sma", "smk", "bebas"]);
            $table->integer('minimum_age');
            $table->integer('maximum_age')->nullable();
            $table->text('description');
            $table->boolean('pkl_status');
            $table->date('expired_date');
            $table->integer('worker_available')->nullable();
            $table->enum('confirmed_status', ["belum_terverifikasi", "terverifikasi", "ditolak"])->default("belum_terverifikasi");
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
