<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Client;

class ClientsChart extends ChartWidget
{
    protected static ?string $heading = 'Clients by Type';

    protected function getData(): array
    {
        $types = ['individual', 'company'];

        $totalClients = [];
        $recentClients = [];

        foreach ($types as $type) {
            $totalClients[] = Client::where('type', $type)->count();
            $recentClients[] = Client::where('type', $type)
                ->where('created_at', '>=', now()->subDays(30))
                ->count();
        }

        return [
            'labels' => ['Individual', 'Company'],
            'datasets' => [
                [
                    'label' => 'Total Clients',
                    'data' => $totalClients,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.7)', 
                ],
                [
                    'label' => 'Clients Registered Last 30 Days',
                    'data' => $recentClients,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.7)', 
                ],
            ],
        ];
    }
    protected function getType(): string
    {
        return 'bar';
    }
}
