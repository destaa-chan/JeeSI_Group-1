<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portofolio', function (Blueprint $table) {
            $table->id('id_portofolio');
            $table->foreignId('id_alumni')->constrained('alumni', 'id_alumni')->cascadeOnDelete();
            $table->string('nama_portofolio');
            $table->text('deskripsi');
            $table->string('file_portofolio');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portofolio');
    }
};
