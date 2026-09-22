<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laporan extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted(): void
    {
        static::addGlobalScope('user_isolation', function (Builder $query) {
            if (auth()->check()) {
                $query->where('user_id', auth()->id());
            }
        });

        static::creating(function ($model) {
            if (auth()->check()) {
                $model->user_id = auth()->id();
            }
        });
    }

    protected $table = 'laporan';

    protected $fillable = [
        'user_id',
        'nomor_arsip',
        'kode_klasifikasi',
        'index_arsip',
        'ringkasan_jenis_arsip',
        'tingkat_perkembangan',
        'kurun_waktu',
        'jumlah_satuan',
        'kondisi',
        'lokasi_box',
        'keterangan_nasib_akhir',
        'kategori_id',
        'sub_kategori_id',
        'tanggal_dokumen',
        'file_path',
    ];

    protected $casts = [
        'tanggal_dokumen' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kategoriLaporan(): BelongsTo
    {
        return $this->belongsTo(KategoriLaporan::class, 'kategori_id');
    }

    public function subKategoriLaporan(): BelongsTo
    {
        return $this->belongsTo(SubKategoriLaporan::class, 'sub_kategori_id');
    }
}
