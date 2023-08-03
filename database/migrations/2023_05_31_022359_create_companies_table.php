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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('profile_image')->nullable();
            $table->string('field');
            $table->date('founding_date')->nullable();
            $table->enum('user_type', ['pemilik', 'pengelola','hrd'])->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->string('outside_image')->nullable();
            $table->string('inside_image')->nullable();
            $table->string('url')->nullable();
            $table->integer('employees');
            $table->enum('confirmed_status', ["menunggu", "diterima", "ditolak", "diblokir"]);
            $table->string('role', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
