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

            // UBAH DI SINI: Sekarang terhubung langsung ke tempat industrinya (Grup Besar)
            $table->foreignId('industri_id')->constrained('industris')->cascadeOnDelete();

            // Siapa yang mengirim pesan (Siswa / Guru / Mentor)
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
