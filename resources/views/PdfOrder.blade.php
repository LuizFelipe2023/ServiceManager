<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Service Request Form - {{ $order->id }}</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            line-height: 1.4;
        }
        body {
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        header {
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 15px 0;
            text-transform: uppercase;
            flex-grow: 1;
        }
        .header-info {
            text-align: right;
            padding-left: 20px;
        }
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .section-title {
            background-color: #f2f2f2;
            padding: 5px 8px;
            font-size: 14px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .two-columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .three-columns {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            min-width: 120px;
            vertical-align: top;
        }
        .info-value {
            display: inline-block;
            width: calc(100% - 130px);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        table th {
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            vertical-align: top;
        }
        .signature-area {
            display: flex;
            justify-content: space-between;
            margin-top: 60px;
        }
        .signature-box {
            width: 48%;
            display: inline-block;
        }
        .signature-line {
            border-top: 1px solid #000;
            height: 1px;
            width: 100%;
            margin-bottom: 5px;
            padding-top: 30px;
        }
        .signature-label {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
        }
        .footer {
            border-top: 1px solid #000;
            padding-top: 10px;
            text-align: center;
            font-size: 10px;
            margin-top: 30px;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 11px;
            text-transform: capitalize;
        }
        .status-aberta { background-color: #d4edda; color: #155724; }
        .status-em_andamento { background-color: #fff3cd; color: #856404; }
        .status-concluida { background-color: #cce5ff; color: #004085; }
        .status-cancelada { background-color: #f8d7da; color: #721c24; }
        .prioridade-baixa { background-color: #e2e3e5; color: #383d41; }
        .prioridade-media { background-color: #d1ecf1; color: #0c5460; }
        .prioridade-alta { background-color: #ffeeba; color: #856404; }
        .prioridade-urgente { background-color: #f5c6cb; color: #721c24; }
        .text-area {
            min-height: 80px;
            border: 1px solid #eee;
            padding: 5px;
            margin-top: 5px;
            white-space: pre-wrap;
        }
        .technicians-list {
            padding: 8px;
            border: 1px solid #eee;
            min-height: 40px;
        }
    </style>
</head>

<body>
    <header>
        <h1 class="title">SERVICE REQUEST FORM</h1>
        <div class="header-info">
            <p><strong>Request ID:</strong> {{ $order->id }}</p>
            <p><strong>Date Generated:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </header>

    <div class="section">
        <div class="section-title">Basic Information</div>
        <div class="two-columns">
            <div class="info-item">
                <span class="info-label">Client:</span>
                <span class="info-value">{{ $order->client->name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Service Type:</span>
                <span class="info-value">{{ $order->service_type }}</span>
            </div>
            <div class="info-item" style="grid-column: 1 / -1;">
                <div class="info-label">Description:</div>
                <div class="text-area">{{ $order->description }}</div>
            </div>
        </div>
    </div>

    <div class="section two-columns" style="gap: 30px;">
        <div>
            <div class="section-title">Scheduling</div>
            <div class="two-columns">
                <div class="info-item">
                    <span class="info-label">Start Date:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($order->start_date)->format('d/m/Y H:i') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">End Date:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($order->end_date)->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        <div>
            <div class="section-title">Status & Priority</div>
            <div class="two-columns">
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="badge status-{{ strtolower(str_replace(' ', '_', $order->status)) }}">
                            {{ $order->status }}
                        </span>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Priority:</span>
                    <span class="info-value">
                        <span class="badge prioridade-{{ strtolower($order->priority) }}">
                            {{ $order->priority }}
                        </span>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Approval Status:</span>
                    <span class="info-value">{{ $order->approval_status }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Payment Status:</span>
                    <span class="info-value">{{ $order->payment_status }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Financial Information</div>
        <div class="two-columns">
            <div class="info-item">
                <span class="info-label">Estimated Hours:</span>
                <span class="info-value">{{ $order->estimated_hours }} hours</span>
            </div>
            <div class="info-item">
                <span class="info-label">Actual Hours:</span>
                <span class="info-value">{{ $order->actual_hours }} hours</span>
            </div>
            <div class="info-item">
                <span class="info-label">Cost Estimate:</span>
                <span class="info-value">${{ number_format($order->cost_estimate, 2, ',', '.') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Final Cost:</span>
                <span class="info-value">${{ number_format($order->final_cost, 2, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Additional Information</div>
        <div>
            <div class="info-item">
                <span class="info-label">Location:</span>
                <span class="info-value">{{ $order->location }}</span>
            </div>
            <div class="info-item">
                <div class="info-label">Equipment Needed:</div>
                <div class="text-area">{{ $order->equipment_needed }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Notes:</div>
                <div class="text-area">{{ $order->notes }}</div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Assigned Technicians</div>
        <div class="technicians-list">
            {{ $order->technicians->pluck('full_name')->implode(', ') ?: 'No technicians assigned' }}
        </div>
    </div>

    <div class="signature-area">
        <div class="signature-box">
            <div class="signature-line"></div>
            <div class="signature-label">Client Signature</div>
        </div>
        <div class="signature-box">
            <div class="signature-line"></div>
            <div class="signature-label">Service Manager Signature</div>
        </div>
    </div>

    <div class="footer">
        <p>This document was automatically generated on {{ now()->format('d/m/Y H:i') }}</p>
        <p>Service Request ID: {{ $order->id }} | Page 1 of 1</p>
    </div>
</body>

</html>