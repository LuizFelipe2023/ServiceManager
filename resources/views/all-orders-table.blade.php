<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Service Orders Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 40px;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background-color: #f8f9fa;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background-color: #eaeaea;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #f6f6f6;
        }

        .status-completed {
            color: #28a745;
            font-weight: bold;
        }

        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }

        .status-cancelled {
            color: #dc3545;
            font-weight: bold;
        }

        .priority-low {
            color: #6c757d;
        }

        .priority-medium {
            color: #17a2b8;
        }

        .priority-high {
            color: #fd7e14;
        }

        .priority-emergency {
            color: #dc3545;
        }
    </style>
</head>

<body>
    <h2>Service Orders Report</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Service Type</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Payment</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->client->name ?? '-' }}</td>
                    <td>{{ $order->service_type }}</td>
                    <td class="status-{{ $order->status }}">
                        {{ ucwords(str_replace('_', ' ', $order->status)) }}
                    </td>
                    <td class="priority-{{ $order->priority }}">
                        {{ ucfirst($order->priority) }}
                    </td>
                    <td>{{ \Carbon\Carbon::parse($order->start_date)->format('M j, Y H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->end_date)->format('M j, Y H:i') }}</td>
                    <td>{{ ucfirst($order->payment_status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
