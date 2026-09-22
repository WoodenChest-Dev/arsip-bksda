<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tabel sub kategori arsip laporan (dinamis per user).
     * - user_id: foreign key isolasi data multi-user.
     * - kategori_id: relasi ke tabel kategori_laporan (cascade: saat kategori
     *   dihapus, sub kategorinya ikut terhapus).
     * - nama_sub_kategori: nama sub kategori.
     */
    public function up(): void
    {
        Schema::create('sub_kategori_laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('kategori_id')->constrained('kategori_laporan')->cascadeOnDelete();
            $table->string('nama_sub_kategori', 255);
            $table->timestamps();

            // Mencegah duplikasi sub kategori dalam lingkup user + kategori yang sama
            $table->unique(['user_id', 'kategori_id', 'nama_sub_kategori'], 'subkategori_user_kategori_nama_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_kategori_laporan');
    }
};