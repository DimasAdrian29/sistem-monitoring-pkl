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
        Schema::create('guru_pembimbings', function (Blueprint $table) {
            $table->id(); // Menggunakan default primary key
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nama');
            $table->string('nip')->unique(); // Digunakan juga sebagai Username & Password
            $table->string('jenis_kelamin');
            $table->string('agama')->nullable();
            $table->text('alamat')->nullable();
            $table->string('jurusan');
            $table->string('nomor_telepon')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_pembimbings');
    }
};
