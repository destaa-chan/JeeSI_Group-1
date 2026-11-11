<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lowongan', function (Blueprint $table) {
            $table->id('id_lowongan');
            $table->foreignId('id_perusahaan')->constrained('perusahaan', 'id_perusahaan')->cascadeOnDelete();
            $table->string('posisi');
            $table->text('deskripsi');
            $table->text('kriteria_kandidat');
            $table->enum('status_verifikasi', ['pending', 'approved', 'rejected']);
            $table->text('catatan_admin');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lowongan');
    }
};
