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
        Schema::create('praktek_kerja_lapangans', function (Blueprint $table) {
            $table->id(); // Default primary key
            $table->foreignId('siswa_id')->constrained('siswas')->cascadeOnDelete();
            $table->foreignId('industri_id')->constrained('industris')->cascadeOnDelete();
            $table->foreignId('guru_pembimbing_id')->constrained('guru_pembimbings')->cascadeOnDelete();
            $table->foreignId('pembimbing_industri_id')->constrained('pembimbing_industris')->cascadeOnDelete();
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->string('status_magang')->default('Aktif'); // Aktif, Selesai, Batal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('praktek_kerja_lapangans');
    }
};
