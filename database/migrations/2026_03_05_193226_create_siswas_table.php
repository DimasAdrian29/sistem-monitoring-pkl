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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nama');
            $table->string('nisn')->unique();

            // Tambahkan ->nullable() di sini
            $table->string('jenis_kelamin')->nullable();

            $table->string('agama')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kelas');
            $table->string('jurusan');
            $table->string('nomor_telepon')->nullable();
            $table->string('nomor_telepon_wali')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
