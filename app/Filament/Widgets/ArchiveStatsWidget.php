<?php

namespace App\Filament\Widgets;

use App\Models\Laporan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ArchiveStatsWidget extends BaseWidget
{
    protected ?string $heading = 'Ringkasan Arsip';

    protected function getStats(): array
    {
        $query = Laporan::query();

        return [
            Stat::make('Total Arsip', number_format($query->count(), 0, ',', '.'))
                ->description('Seluruh laporan terdaftar')
                ->color('primary'),
            Stat::make('Berkas Musnah', number_format((clone $query)->where('keterangan_nasib_akhir', 'MUSNAH')->count(), 0, ',', '.'))
                ->description('Status nasib akhir MUSNAH')
                ->color('danger'),
            Stat::make('Berkas Permanen', number_format((clone $query)->where('keterangan_nasib_akhir', 'PERMANEN')->count(), 0, ',', '.'))
                ->description('Status nasib akhir PERMANEN')
                ->color('success'),
        ];
    }
}
