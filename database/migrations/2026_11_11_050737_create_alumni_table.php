<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->id('id_alumni');
            $table->foreignId('id_user')->unique()->constrained('users', 'id_user')->cascadeOnDelete();
            $table->string('nama_lengkap');
            $table->string('nim')->unique();
            $table->string('program_studi');
            $table->string('pendidikan');
            $table->text('kompetensi');
            $table->text('minat_studi');
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
