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
        Schema::create('forum_chats', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke sesi PKL tertentu
            $table->foreignId('praktek_kerja_lapangan_id')->constrained('praktek_kerja_lapangans')->cascadeOnDelete();
            // Siapa yang mengirim pesan (Siswa/Guru/Pembimbing Industri)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->text('isi_pesan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_chats');
    }
};
