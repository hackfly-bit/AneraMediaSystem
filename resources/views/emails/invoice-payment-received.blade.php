<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Diterima</title>
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
            background-color: #059669;
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
            border-left: 4px solid #059669;
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
            color: #059669;
        }
        .success-box {
            background-color: #d1fae5;
            border: 2px solid #059669;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .success-text {
            color: #065f46;
            font-weight: bold;
            font-size: 1.2em;
        }
        .checkmark {
            background-color: #059669;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2em;
            margin-bottom: 15px;
        }
        .footer {
            background-color: #2d3748;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 0 0 8px 8px;
            font-size: 0.9em;
        }
        .thank-you-section {
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>✅ Pembayaran Berhasil Diterima</h1>
    </div>
    
    <div class="content">
        <p>Halo <strong>{{ $client->name }}</strong>,</p>
        
        <div class="success-box">
            <div class="checkmark">✓</div>
            <div class="success-text">
                PEMBAYARAN BERHASIL DITERIMA
            </div>
            <p style="margin: 10px 0; color: #065f46;">
                Terima kasih! Pembayaran untuk invoice <strong>{{ $invoice->invoice_number }}</strong> telah kami terima.
            </p>
        </div>
        
        <p>Kami dengan senang hati mengkonfirmasi bahwa pembayaran untuk proyek <strong>{{ $project->name }}</strong> telah berhasil diterima pada tanggal <strong>{{ $paymentDate->format('d F Y') }}</strong>.</p>
        
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
                <span class="label">Tanggal Pembayaran:</span>
                <span class="value">{{ $paymentDate->format('d F Y') }}</span>
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
                <span class="label">Jumlah Dibayar:</span>
                <span class="value amount">{{ $invoice->formatted_total }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Status:</span>
                <span class="value" style="color: #059669; font-weight: bold;">LUNAS</span>
            </div>
        </div>
        
        @if($invoice->notes)
        <div style="margin: 20px 0; padding: 15px; background-color: #fff3cd; border-left: 4px solid #ffc107; border-radius: 4px;">
            <strong>Catatan Invoice:</strong><br>
            {{ $invoice->notes }}
        </div>
        @endif
        
        <div class="thank-you-section">
            <h3 style="color: #065f46; margin-top: 0;">🙏 Terima Kasih!</h3>
            <p style="color: #047857; margin-bottom: 0;">
                Kami sangat menghargai pembayaran tepat waktu Anda. Kerjasama yang baik seperti ini memungkinkan kami untuk terus memberikan layanan terbaik.
            </p>
        </div>
        
        <div style="background-color: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px; padding: 20px; margin: 20px 0;">
            <h4 style="color: #0c4a6e; margin-top: 0;">Langkah Selanjutnya:</h4>
            <ul style="color: #0369a1; margin-bottom: 0;">
                <li>Invoice ini telah ditandai sebagai "Lunas" dalam sistem kami</li>
                <li>Anda akan menerima receipt/kwitansi dalam email terpisah</li>
                <li>Jika ada pertanyaan, jangan ragu untuk menghubungi kami</li>
            </ul>
        </div>
        
        <p>Sekali lagi, terima kasih atas kepercayaan dan kerjasama Anda. Kami berharap dapat terus bekerja sama dengan Anda di proyek-proyek mendatang!</p>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim secara otomatis dari sistem invoice kami.<br>
        Jika Anda memiliki pertanyaan, silakan hubungi tim support kami.</p>
    </div>
</body>
</html>