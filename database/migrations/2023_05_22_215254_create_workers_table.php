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
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('profile_image')->nullable();
            $table->string('backdrop_image')->nullable();
            $table->enum('gender', ["pria", "wanita"])->nullable();
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->date('born_date')->nullable();
            $table->string('interested')->nullable();
            $table->text('description')->nullable();
            $table->boolean('company_visible')->default(false);
            $table->enum('status', ['bekerja', 'tidak_bekerja'])->default('tidak_bekerja');
            $table->string('role', 10)->default('worker');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workers');
    }
};
