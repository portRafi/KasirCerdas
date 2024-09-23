<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use App\Models\Barang;
use App\Models\MetodePembayaran;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class DatasWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalBarang = Barang::count();
        $totalAkun = User::count();
        $totalMPAktif = MetodePembayaran::where('is_Active', true)->count();
        
        return [
            Stat::make('Jumlah Barang', $totalBarang)
                ->description('Total Barang dalam database')
                ->descriptionIcon('heroicon-s-archive-box', IconPosition::Before)
                ->color($totalBarang < 5 ? 'danger' : 'success'),
            Stat::make('Jumlah Akun Kasir', $totalAkun)
                ->description('Total Akun Kasir dalam database')
                ->descriptionIcon('heroicon-m-user-plus', IconPosition::Before)
                ->color('success'),
            Stat::make('Metode Pembayaran Aktif', $totalMPAktif)
                ->description('Metode Pembayaran Aktif')
                ->descriptionIcon('heroicon-m-banknotes', IconPosition::Before)
                ->color($totalMPAktif > 0 ? 'success' : 'danger'),
        ];
    }
}
