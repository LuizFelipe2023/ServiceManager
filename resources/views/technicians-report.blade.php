<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Technicians Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            word-wrap: break-word;
        }
        thead th {
            background-color: #2c3e50;
            color: white;
            padding: 6px;
            font-size: 9px;
            text-align: left;
        }
        tbody td {
            padding: 6px;
            font-size: 8.5px;
            border: 1px solid #ddd;
            word-wrap: break-word;
            word-break: break-word;
        }
        th:nth-child(1), td:nth-child(1) { width: 4%; }
        th:nth-child(2), td:nth-child(2) { width: 12%; }
        th:nth-child(3), td:nth-child(3) { width: 12%; }
        th:nth-child(4), td:nth-child(4) { width: 25%; }
        th:nth-child(5), td:nth-child(5) { width: 15%; }
        th:nth-child(6), td:nth-child(6) { width: 8%; text-align: center; }
        th:nth-child(7), td:nth-child(7) { width: 10%; text-align: right; }
        th:nth-child(8), td:nth-child(8) { width: 14%; }
        .boolean-true {
            color: green;
            font-weight: bold;
            text-align: center;
        }
        .boolean-false {
            color: red;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Technicians Report</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Specialization</th>
                <th>Active</th>
                <th>Hourly Rate (USD)</th>
                <th>Certification Expiry</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($technicians as $tech)
                <tr>
                    <td>{{ $tech->id }}</td>
                    <td>{{ $tech->first_name }}</td>
                    <td>{{ $tech->last_name }}</td>
                    <td style="word-break: break-word;">{{ $tech->email }}</td>
                    <td>{{ $tech->specialization }}</td>
                    <td class="{{ $tech->active ? 'boolean-true' : 'boolean-false' }}">
                        {{ $tech->active ? 'Yes' : 'No' }}
                    </td>
                    <td style="text-align: right;">${{ number_format($tech->hourly_rate, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($tech->certification_expiry)->format('M d, Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
