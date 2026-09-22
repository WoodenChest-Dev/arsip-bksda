<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tabel kategori arsip laporan (dinamis per user).
     * - user_id: foreign key isolasi data multi-user (setiap user hanya
     *   melihat kategorinya sendiri).
     * - nama_kategori: nama kategori arsip, di-unique per kombinasi user
     *   agar satu user tidak punya kategori duplikat.
     */
    public function up(): void
    {
        Schema::create('kategori_laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('nama_kategori', 255);
            $table->timestamps();

            // Mencegah duplikasi nama kategori dalam lingkup user yang sama
            $table->unique(['user_id', 'nama_kategori'], 'kategori_user_nama_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_laporan');
    }
};