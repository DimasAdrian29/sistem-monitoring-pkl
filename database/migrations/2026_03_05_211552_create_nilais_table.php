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
            // Relasi ke Pembimbing Industri (untuk tahu siapa yang memberi nilai)
            $table->foreignId('pembimbing_industri_id')->constrained('pembimbing_industris')->cascadeOnDelete();

            $table->integer('disiplin');
            $table->integer('tanggung_jawab');
            $table->integer('kompetensi_teknis');
            $table->decimal('nilai_akhir', 5, 2);
            $table->text('catatan_pembimbing')->nullable();
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
