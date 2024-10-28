<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Barang;
use App\Models\MetodePembayaran;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Carbon\Carbon;

class DatasWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $startDate = !is_null($this->filters['startDate'] ?? null) ?
            Carbon::parse($this->filters['startDate']) : null;

        $endDate = !is_null($this->filters['endDate'] ?? null) ?
            Carbon::parse($this->filters['endDate']) : null;

        $totalBarang = Barang::whereBetween([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id],
            [$startDate, $endDate]
        ])->count();
        $totalKasir = User::whereBetween([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id],
            [$startDate, $endDate]
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
                ->color($totalBarang < 5 ? 'danger' : ($totalBarang <= 10 ? 'warning' : 'success'))
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('Jumlah Akun Kasir', $totalKasir)
                ->description('Total Akun Kasir di database')
                ->descriptionIcon('heroicon-m-user-plus', IconPosition::Before)
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('Metode Pembayaran Aktif', $totalMPAktif)
                ->description('Metode Pembayaran Aktif')
                ->descriptionIcon('heroicon-m-banknotes', IconPosition::Before)
                ->color($totalMPAktif > 0 ? 'success' : 'danger')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
        ];
    }
}
