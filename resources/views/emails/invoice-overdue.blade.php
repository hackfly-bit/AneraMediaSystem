<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Terlambat</title>
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
            background-color: #dc2626;
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
            border-left: 4px solid #dc2626;
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
            color: #dc2626;
        }
        .urgent-box {
            background-color: #fee2e2;
            border: 2px solid #dc2626;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .urgent-text {
            color: #991b1b;
            font-weight: bold;
            font-size: 1.2em;
        }
        .overdue-days {
            background-color: #dc2626;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            display: inline-block;
            margin: 10px 0;
            font-weight: bold;
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
            background-color: #dc2626;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: bold;
        }
        .button:hover {
            background-color: #b91c1c;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🚨 INVOICE TERLAMBAT</h1>
    </div>
    
    <div class="content">
        <p>Halo <strong>{{ $client->name }}</strong>,</p>
        
        <div class="urgent-box">
            <div class="urgent-text">
                ⚠️ PEMBAYARAN TERLAMBAT ⚠️
            </div>
            <div class="overdue-days">
                {{ $daysPastDue }} hari terlambat
            </div>
            <p style="margin: 10px 0; color: #991b1b;">
                Invoice untuk proyek <strong>{{ $project->name }}</strong> telah melewati tanggal jatuh tempo.
            </p>
        </div>
        
        <p>Invoice ini seharusnya dibayar pada tanggal <strong>{{ $invoice->due_date->format('d F Y') }}</strong>, namun hingga saat ini pembayaran belum kami terima.</p>
        
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
                <span class="label">Hari Terlambat:</span>
                <span class="value" style="color: #dc2626; font-weight: bold;">{{ $daysPastDue }} hari</span>
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
                <span class="value" style="color: #dc2626; font-weight: bold;">{{ $invoice->status_indonesian }}</span>
            </div>
        </div>
        
        @if($invoice->notes)
        <div style="margin: 20px 0; padding: 15px; background-color: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px;">
            <strong>Catatan:</strong><br>
            {{ $invoice->notes }}
        </div>
        @endif
        
        <div style="background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 20px; margin: 20px 0;">
            <h3 style="color: #991b1b; margin-top: 0;">Tindakan yang Diperlukan:</h3>
            <ul style="color: #7f1d1d; margin: 0;">
                <li>Segera lakukan pembayaran untuk menghindari denda keterlambatan</li>
                <li>Hubungi kami jika ada kendala dalam pembayaran</li>
                <li>Konfirmasi pembayaran setelah transfer dilakukan</li>
            </ul>
        </div>
        
        <p><strong>Mohon segera lakukan pembayaran atau hubungi kami untuk membahas solusi pembayaran.</strong> Kami menghargai kerjasama Anda dalam menyelesaikan masalah ini.</p>
        
        <p>Jika pembayaran sudah dilakukan, mohon abaikan email ini dan konfirmasi pembayaran kepada kami.</p>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim secara otomatis dari sistem invoice kami.<br>
        Untuk pertanyaan mendesak, silakan hubungi tim support kami segera.</p>
    </div>
</body>
</html>