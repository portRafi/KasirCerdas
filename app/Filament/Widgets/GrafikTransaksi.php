<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\DataTransaksi;
use App\Models\PenjualanBarang;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class GrafikTransaksi extends ChartWidget
{   
    protected static string $color = 'info';
    protected static ?string $heading = 'Order Per Bulan';
    protected function getData(): array 
    {
        $data = Trend::model(DataTransaksi::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();

        return [
            'datasets' => [
                [

                    'label' => 'Jumlah Transaksi',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
