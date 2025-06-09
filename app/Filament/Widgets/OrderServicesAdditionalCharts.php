<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\OrderService;
use Illuminate\Support\Facades\DB;

class OrderServicesAdditionalCharts extends ChartWidget
{
     protected static ?string $heading = 'Orders by Payment Status';

    protected function getData(): array
    {
        $paymentStatuses = ['unpaid', 'partial', 'paid'];
        $paymentCounts = [];
        foreach ($paymentStatuses as $status) {
            $paymentCounts[] = OrderService::where('payment_status', $status)->count();
        }

        $ordersByMonth = OrderService::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $ordersCountsByMonth = [];
        foreach (range(1, 12) as $m) {
            $ordersCountsByMonth[] = $ordersByMonth[$m] ?? 0;
        }

        return [
            'labels' => $paymentStatuses,
            'datasets' => [
                [
                    'label' => 'Orders by Payment Status',
                    'data' => $paymentCounts,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.7)', // vermelho
                ],
            ],
            'extra' => [
                'monthlyOrders' => [
                    'labels' => $months,
                    'datasets' => [
                        [
                            'label' => 'Orders Created This Year',
                            'data' => $ordersCountsByMonth,
                            'backgroundColor' => 'rgba(54, 162, 235, 0.7)', // azul
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar'; 
    }
}
