<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengaturanInstansi extends Model
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

    protected $table = 'pengaturan_instansi';

    protected $fillable = [
        'user_id',
        'nama_instansi',
        'alamat',
        'nomor_telepon',
        'logo_path',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
