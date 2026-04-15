<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sertifikats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('praktek_kerja_lapangan_id')
                  ->constrained('praktek_kerja_lapangans')
                  ->cascadeOnDelete();
            $table->string('url_sertifikat')->nullable(); // path file PDF
            $table->timestamp('dicetak_pada')->nullable(); // kapan dicetak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sertifikats');
    }
};
