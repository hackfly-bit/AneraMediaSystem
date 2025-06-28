<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Baru Dibuat</title>
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
            background-color: #3b82f6;
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
            border-left: 4px solid #3b82f6;
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
            color: #3b82f6;
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
            background-color: #3b82f6;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: bold;
        }
        .button:hover {
            background-color: #2563eb;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Invoice Baru Telah Dibuat</h1>
    </div>
    
    <div class="content">
        <p>Halo <strong>{{ $client->name }}</strong>,</p>
        
        <p>Kami telah membuat invoice baru untuk proyek <strong>{{ $project->name }}</strong>. Berikut adalah detail invoice:</p>
        
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
        
        <p>Silakan lakukan pembayaran sebelum tanggal jatuh tempo. Jika Anda memiliki pertanyaan mengenai invoice ini, jangan ragu untuk menghubungi kami.</p>
        
        <p>Terima kasih atas kepercayaan Anda!</p>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim secara otomatis dari sistem invoice kami.<br>
        Jika Anda memiliki pertanyaan, silakan hubungi tim support kami.</p>
    </div>
</body>
</html>