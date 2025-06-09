<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Clients Report</title>
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
            word-break: break-word;
        }

        thead th {
            background-color: #34495e;
            color: white;
            padding: 6px;
            font-size: 10px;
            text-align: left;
        }

        tbody td {
            padding: 6px;
            font-size: 9px;
            border: 1px solid #ccc;
            word-wrap: break-word;
            word-break: break-word;
        }

        /* Definindo larguras fixas menores para cada coluna */
        th:nth-child(1),
        td:nth-child(1) {
            width: 4%;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 20%;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 25%;
            overflow-wrap: anywhere;
        }

        th:nth-child(4),
        td:nth-child(4) {
            width: 15%;
        }

        th:nth-child(5),
        td:nth-child(5) {
            width: 10%;
        }

        th:nth-child(6),
        td:nth-child(6) {
            width: 8%;
            text-align: center;
        }

        th:nth-child(7),
        td:nth-child(7) {
            width: 18%;
        }

        /* Estilo booleano */
        td.boolean {
            font-weight: 600;
            color: #27ae60;
            text-align: center;
        }

        td.boolean.false {
            color: #c0392b;
        }
    </style>

</head>

<body>
    <h1>Clients Report</h1>
    <p class="subtitle">Generated on {{ now()->format('F d, Y - H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th style="width:5%;">ID</th>
                <th style="width:25%;">Name</th>
                <th style="width:25%;">Email</th>
                <th style="width:15%;">Phone</th>
                <th style="width:10%;">Type</th>
                <th style="width:10%;">Active</th>
                <th style="width:10%;">Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->phone ?? '-' }}</td>
                    <td>{{ ucfirst($client->type) }}</td>
                    <td class="boolean {{ $client->active ? '' : 'false' }}">
                        {{ $client->active ? 'Yes' : 'No' }}
                    </td>
                    <td>{{ $client->created_at->format('M d, Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Page <span class="pageNumber"></span> of <span class="totalPages"></span>
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $font = $fontMetrics->getFont("Helvetica", "normal");
            $size = 10;
            $pageText = "Page {PAGE_NUM} of {PAGE_COUNT}";
            $x = $pdf->get_width() - 80;
            $y = $pdf->get_height() - 30;
            $pdf->page_text($x, $y, $pageText, $font, $size, array(0.5, 0.5, 0.5));
        }
    </script>
</body>

</html>