<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tabel pengaturan instansi (1 baris per user).
     * - user_id: foreign key isolasi multi-user, dibuat unique karena satu
     *   user hanya memiliki SATU profil instansi (untuk Kop Surat dinamis).
     * - nama_instansi: nama instansi pengguna arsip.
     * - alamat: alamat instansi.
     * - nomor_telepon: nomor telepon instansi.
     * - logo_path: path file logo instansi (untuk header Kop Surat).
     */
    public function up(): void
    {
        Schema::create('pengaturan_instansi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('nama_instansi', 255);
            $table->text('alamat')->nullable();
            $table->string('nomor_telepon', 50)->nullable();
            $table->string('logo_path', 512)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_instansi');
    }
};