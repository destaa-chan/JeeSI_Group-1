<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lamaran', function (Blueprint $table) {
            $table->id('id_lamaran');
            $table->foreignId('id_alumni')->constrained('alumni', 'id_alumni')->cascadeOnDelete();
            $table->foreignId('id_lowongan')->constrained('lowongan', 'id_lowongan')->cascadeOnDelete();
            $table->foreignId('id_portofolio')->nullable()->constrained('portofolio', 'id_portofolio')->nullOnDelete();
            $table->text('cover_letter');
            $table->enum('status_lamaran', ['terkirim', 'dilihat', 'diundang', 'diterima', 'ditolak']);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lamaran');
    }
};
