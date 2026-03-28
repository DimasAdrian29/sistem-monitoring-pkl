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
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id(); // Default primary key

            // Relasi ke tabel PKL
            $table->foreignId('praktek_kerja_lapangan_id')->constrained('praktek_kerja_lapangans')->cascadeOnDelete();

            $table->date('tanggal');
            $table->text('kegiatan');
            $table->string('foto')->nullable(); // Boleh kosong jika tidak ada foto
            $table->string('status_validasi')->default('Menunggu'); // Menunggu, Disetujui, Ditolak
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};
