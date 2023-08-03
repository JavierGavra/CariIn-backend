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
        Schema::create('recruit_workers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id');
            $table->foreignId('job_id');
            $table->text('description');
            $table->string('worker_message')->nullable();
            $table->enum('reply_status', ['menunggu', 'diterima', 'ditolak']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruit_workers');
    }
};
