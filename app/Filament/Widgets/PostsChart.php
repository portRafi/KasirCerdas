<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\DataTransaksi;
use App\Models\PenjualanBarang;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class PostsChart extends ChartWidget
{   
    protected static string $color = 'info';
    protected static ?string $heading = 'Order Per Bulan';
    protected function getData(): array 
    {
        $data = Trend::model(Datatransaksi::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();

        return [
            'datasets' => [
                [
                        'label' => 'Blog posts created',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
           'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
