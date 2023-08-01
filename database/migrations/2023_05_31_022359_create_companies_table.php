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
            $table->string('profile_image');
            $table->string('field');
            $table->date('founding_date');
            $table->enum('user_type', ['pemilik', 'pengelola','hrd']);
            $table->string('location');
            $table->text('description');
            $table->string('outside_image');
            $table->string('inside_image');
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
