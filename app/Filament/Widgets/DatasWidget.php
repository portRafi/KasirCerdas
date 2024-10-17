<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Barang;
use App\Models\MetodePembayaran;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class DatasWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalBarang = Barang::where([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id],
        ])->count();
        $totalKasir = User::where([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id],
            // ['role', '=', 'kasir'],
        ])->count();
        $totalMPAktif = MetodePembayaran::where([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id],
            ['is_Active', '=', true],
        ])->count();

        return [
            Stat::make('Jumlah Barang', $totalBarang)
                ->description('Total Barang di database')
                ->descriptionIcon('heroicon-s-archive-box', IconPosition::Before)
                ->color($totalBarang < 5 ? 'danger' : ($totalBarang <= 10 ? 'warning' : 'success')),
            Stat::make('Jumlah Akun Kasir', $totalKasir)
                ->description('Total Akun Kasir di database')
                ->descriptionIcon('heroicon-m-user-plus', IconPosition::Before)
                ->color('success'),
            Stat::make('Metode Pembayaran Aktif', $totalMPAktif)
                ->description('Metode Pembayaran Aktif')
                ->descriptionIcon('heroicon-m-banknotes', IconPosition::Before)
                ->color($totalMPAktif > 0 ? 'success' : 'danger'),
        ];
    }
}
