<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubKategoriLaporan extends Model
{
    use HasFactory;

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

    protected $table = 'sub_kategori_laporan';

    protected $fillable = [
        'user_id',
        'kategori_id',
        'nama_sub_kategori',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kategoriLaporan(): BelongsTo
    {
        return $this->belongsTo(KategoriLaporan::class, 'kategori_id');
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'sub_kategori_id');
    }
}
