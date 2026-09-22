<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriLaporan extends Model
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

    protected $table = 'kategori_laporan';

    protected $fillable = [
        'user_id',
        'nama_kategori',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subKategoriLaporan(): HasMany
    {
        return $this->hasMany(SubKategoriLaporan::class, 'kategori_id');
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'kategori_id');
    }
}
