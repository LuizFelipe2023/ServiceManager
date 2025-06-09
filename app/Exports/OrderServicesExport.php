<?php

namespace App\Exports;

use App\Models\OrderService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderServicesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return OrderService::with('client') 
            ->get()
            ->map(function ($order) {
                return [
                    'ID' => $order->id,
                    'Client' => $order->client->name ?? 'N/A',
                    'Service Type' => $order->service_type,
                    'Status' => $order->status,
                    'Priority' => $order->priority,
                    'Start Date' => $order->start_date,
                    'End Date' => $order->end_date,
                    'Payment Status' => $order->payment_status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Client',
            'Service Type',
            'Status',
            'Priority',
            'Start Date',
            'End Date',
            'Payment Status',
        ];
    }
}

