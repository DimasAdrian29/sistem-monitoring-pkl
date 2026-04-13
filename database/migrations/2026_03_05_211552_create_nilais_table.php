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
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            // Relasi ke PKL (untuk tahu siswa mana yang dinilai)
            $table->foreignId('praktek_kerja_lapangan_id')->constrained('praktek_kerja_lapangans')->cascadeOnDelete();

            // Relasi Opsional jika ingin merekam spesifik siapa penginputnya
            $table->foreignId('pembimbing_industri_id')->nullable()->constrained('pembimbing_industris')->cascadeOnDelete();
            $table->foreignId('guru_pembimbing_id')->nullable()->constrained('guru_pembimbings')->cascadeOnDelete();

            // ==========================================
            // TAMBAHKAN ->nullable() DI SINI
            // ==========================================
            $table->integer('aspek_soft_skills')->nullable()->comment('Menerapkan Soft skills yang dibutuhkan dunia kerja');
            $table->integer('aspek_norma_k3lh')->nullable()->comment('Menerapkan norma, POS dan K3LH');
            $table->integer('aspek_kompetensi_teknis')->nullable()->comment('Menerapkan kompetensi teknis');
            $table->integer('aspek_wawasan_bisnis')->nullable()->comment('Memahami alur bisnis dan wawasan wirausaha');
            $table->integer('aspek_penyusunan_laporan')->nullable()->comment('Menyusun laporan PKL');
            $table->integer('aspek_presentasi')->nullable()->comment('Mempresentasikan hasil pelaksanaan PKL');

            // Catatan
            $table->text('catatan_pembimbing_industri')->nullable();
            $table->text('catatan_guru_pembimbing')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
