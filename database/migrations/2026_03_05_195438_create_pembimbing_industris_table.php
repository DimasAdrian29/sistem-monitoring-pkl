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
        Schema::create('pembimbing_industris', function (Blueprint $table) {
            $table->id();

            // Perbaikan: Gunakan standar bawaan Laravel yang otomatis mencari kolom 'id' di tabel 'industris'
            $table->foreignId('industri_id')->constrained('industris')->cascadeOnDelete();

            // Relasi ke tabel User
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->string('nama');
            $table->string('jabatan');
            $table->string('jenis_kelamin');
            $table->string('agama');
            $table->text('alamat');
            $table->string('nomor_telepon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembimbing_industris');
    }
};
