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
        Schema::create('field_practices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id');
            $table->foreignId('worker_id');
            $table->string('cv_file');
            $table->string('portfolio_file');
            $table->string('application_letter_file');
            $table->string('student_evidence_file');
            $table->string('educational_institution');
            $table->text('description');
            $table->enum('confirmed_status', ["mengirim", "direview", "wawancara", "diterima", "ditolak"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_practices');
    }
};
