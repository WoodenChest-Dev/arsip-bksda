<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tabel utama arsip laporan (standar BKSDA).
     * - user_id: isolasi data multi-user — setiap user hanya melihat datanya
     *   sendiri.
     * - kategori_id / sub_kategori_id: relasi ke kategori & sub kategori
     *   (restrict on delete agar data laporan tidak hilang saat kategori
     *   dihapus — user harus memindah/menghapus laporannya dulu).
     * - tanggal_dokumen: DATE internal (YYYY-MM-DD), dikonversi ke
     *   DD-MM-YYYY pada layer UI.
     * - softDeletes(): menambah kolom deleted_at nullable untuk fitur
     *   Tong Sampah & restore (Tahap 8).
     * - Index pada kolom yang sering dipakai filter/search untuk performa.
     */
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Metadata arsip standar BKSDA
            $table->string('nomor_arsip', 255);
            $table->string('kode_klasifikasi', 255)->nullable();
            $table->string('index_arsip', 255);
            $table->text('ringkasan_jenis_arsip')->nullable();
            $table->enum('tingkat_perkembangan', ['Asli', 'Copy'])->nullable();
            $table->string('kurun_waktu', 100)->nullable();
            $table->string('jumlah_satuan', 100)->nullable();
            $table->string('kondisi', 50)->nullable();
            $table->string('lokasi_box', 255)->nullable();
            $table->string('keterangan_nasib_akhir', 50)->nullable();

            // Kategori & sub kategori
            $table->foreignId('kategori_id')->nullable()->constrained('kategori_laporan')->restrictOnDelete();
            $table->foreignId('sub_kategori_id')->nullable()->constrained('sub_kategori_laporan')->restrictOnDelete();

            // Tanggal dokumen (internal DATE YYYY-MM-DD; konversi DD-MM-YYYY di UI)
            $table->date('tanggal_dokumen')->nullable();

            // Path dokumen asli (PDF/Excel hasil upload/parsing)
            $table->string('file_path', 512)->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Index untuk global search & filter (Tahap 5)
            $table->index(['user_id', 'nomor_arsip'], 'idx_laporan_user_nomor');
            $table->index(['user_id', 'kurun_waktu'], 'idx_laporan_user_kurun');
            $table->index(['user_id', 'kondisi'], 'idx_laporan_user_kondisi');
            $table->index(['user_id', 'lokasi_box'], 'idx_laporan_user_lokasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};