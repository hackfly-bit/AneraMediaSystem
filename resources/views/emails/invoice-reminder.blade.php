<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengingat Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f59e0b;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f8fafc;
            padding: 30px;
            border: 1px solid #e2e8f0;
        }
        .invoice-details {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #f59e0b;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .label {
            font-weight: bold;
            color: #4a5568;
        }
        .value {
            color: #2d3748;
        }
        .amount {
            font-size: 1.2em;
            font-weight: bold;
            color: #f59e0b;
        }
        .warning-box {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .warning-text {
            color: #92400e;
            font-weight: bold;
            font-size: 1.1em;
        }
        .footer {
            background-color: #2d3748;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 0 0 8px 8px;
            font-size: 0.9em;
        }
        .button {
            display: inline-block;
            background-color: #f59e0b;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: bold;
        }
        .button:hover {
            background-color: #d97706;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔔 Pengingat Pembayaran Invoice</h1>
    </div>
    
    <div class="content">
        <p>Halo <strong>{{ $client->name }}</strong>,</p>
        
        <p>Ini adalah pengingat bahwa invoice untuk proyek <strong>{{ $project->name }}</strong> akan jatuh tempo dalam <strong>{{ $daysUntilDue }} hari</strong>.</p>
        
        <div class="warning-box">
            <div class="warning-text">
                ⏰ Invoice akan jatuh tempo pada: {{ $invoice->due_date->format('d F Y') }}
            </div>
        </div>
        
        <div class="invoice-details">
            <div class="detail-row">
                <span class="label">Nomor Invoice:</span>
                <span class="value">{{ $invoice->invoice_number }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Tanggal Invoice:</span>
                <span class="value">{{ $invoice->invoice_date->format('d F Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Tanggal Jatuh Tempo:</span>
                <span class="value">{{ $invoice->due_date->format('d F Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Proyek:</span>
                <span class="value">{{ $project->name }}</span>
            </div>
            @if($invoice->payment_sequence > 1)
            <div class="detail-row">
                <span class="label">Pembayaran:</span>
                <span class="value">Tahap {{ $invoice->payment_sequence }} ({{ $invoice->payment_percentage }}%)</span>
            </div>
            @endif
            <div class="detail-row">
                <span class="label">Total Amount:</span>
                <span class="value amount">{{ $invoice->formatted_total }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Status:</span>
                <span class="value">{{ $invoice->status_indonesian }}</span>
            </div>
        </div>
        
        @if($invoice->notes)
        <div style="margin: 20px 0; padding: 15px; background-color: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px;">
            <strong>Catatan:</strong><br>
            {{ $invoice->notes }}
        </div>
        @endif
        
        <p>Untuk menghindari keterlambatan pembayaran, mohon segera lakukan pembayaran sebelum tanggal jatuh tempo. Jika Anda memiliki pertanyaan atau memerlukan bantuan, jangan ragu untuk menghubungi kami.</p>
        
        <p>Terima kasih atas perhatian dan kerjasamanya!</p>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim secara otomatis dari sistem invoice kami.<br>
        Jika Anda memiliki pertanyaan, silakan hubungi tim support kami.</p>
    </div>
</body>
</html>