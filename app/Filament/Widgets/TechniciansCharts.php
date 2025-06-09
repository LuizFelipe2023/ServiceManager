<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Technician;

class TechniciansCharts extends ChartWidget
{
    protected static ?string $heading = 'Technicians by Specialization';

    protected function getData(): array
    {
        $specializations = Technician::select('specialization')
            ->distinct()
            ->pluck('specialization')
            ->toArray();

        $totalCounts = [];

        foreach ($specializations as $spec) {
            $totalCounts[] = Technician::where('specialization', $spec)->count();
        }

        return [
            'labels' => $specializations,
            'datasets' => [
                [
                    'label' => 'Total Technicians',
                    'data' => $totalCounts,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.7)', // teal
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
