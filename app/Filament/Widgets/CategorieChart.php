<?php

namespace App\Filament\Widgets;

use App\Models\Categorie;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class CategorieChart extends ChartWidget
{
    protected static ?string $heading = 'Catégorie/Sous_Catégorie';
    protected static ?int $sort=2;

    protected function getData(): array
    {
        $data = Trend::model(Categorie::class)
        ->between(
            start: now()->startOfMonth(),
            end: now()->endOfMonth(),
        )
        ->perDay()
        ->count();

    return [
        'datasets' => [
            [
                'label' => 'Catégorie/Sous_Catégorie',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];

    }

    protected function getType(): string
    {
        return 'line';
    }
}
