<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\OrderService;

class OrderServicesCharts extends ChartWidget
{
   protected static ?string $heading = 'Orders by Status';

    protected function getData(): array
    {
        $statuses = [
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];

        $statusCounts = [];
        foreach (array_keys($statuses) as $status) {
            $statusCounts[] = OrderService::where('status', $status)->count();
        }

        return [
            'labels' => array_values($statuses),
            'datasets' => [
                [
                    'label' => 'Orders by Status',
                    'data' => $statusCounts,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.7)',
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
