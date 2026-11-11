<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->id('id_perusahaan');
            $table->foreignId('id_user')->unique()->constrained('users', 'id_user')->cascadeOnDelete();
            $table->string('nama_perusahaan');
            $table->text('alamat');
            $table->text('deskripsi');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perusahaan');
    }
};
