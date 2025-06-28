<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="pdf-creator" content="{{ config('app.name') }}">
    <meta name="invoice-id" content="{{ $invoice->id }}">
    <title>{{ config('app.company_name') }} - Invoice {{ $invoice->invoice_number }}</title>
    <style>
    :root {
        --primary-color: #2c3e50;
        --secondary-color: #667eea;
        --accent-color: #764ba2;
        --text-color: #4a5568;
    }

    .company-logo {
        max-height: 80px;
        margin-bottom: 1.5rem;
    }

    .security-features {
        position: absolute;
        top: 20px;
        right: 40px;
        text-align: right;
        font-size: 12px;
        color: var(--primary-color);
    }

    .qr-code {
        margin-top: 2rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        text-align: center;
    }

    .bank-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-top: 1rem;
    }
        @page {
            margin: 0;
            size: A4;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            color: #2c3e50;
            line-height: 1.6;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            min-height: 100vh;
            position: relative;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            /* background: url('data:image/svg+xml;charset=utf-8,{!! "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><circle cx='50' cy='50' r='2' fill='white' opacity='0.05'/></svg>" !!}') repeat; */
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% { transform: translateX(0) translateY(0); }
            100% { transform: translateX(-100px) translateY(-100px); }
        }

        .company-info {
            position: relative;
            z-index: 2;
        }

        .company-name {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .company-details {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 20px;
        }

        .invoice-title {
            font-size: 28px;
            font-weight: 300;
            letter-spacing: 3px;
            text-align: center;
            margin-top: 20px;
            padding: 15px;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            backdrop-filter: blur(10px);
        }

        .content {
            padding: 40px;
        }

        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            gap: 40px;
        }

        .client-info, .invoice-details {
            flex: 1;
            background: #f8f9fa;
            padding: 25px;
            border-radius: 12px;
            border-left: 4px solid #667eea;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .section-title {
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 15px;
            color: #667eea;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 8px;
        }

        .info-row {
            margin-bottom: 8px;
            font-size: 14px;
        }

        .info-row strong {
            color: #2c3e50;
            font-weight: 600;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .items-table th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 18px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .items-table td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
            font-size: 14px;
        }

        .items-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .items-table tbody tr:last-child td {
            border-bottom: none;
        }

        .text-right {
            text-align: right;
        }

        .total-section {
            margin-left: auto;
            width: 350px;
            background: #f8f9fa;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 15px;
        }

        .total-row:not(.final) {
            border-bottom: 1px solid #e9ecef;
        }

        .total-row.final {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 700;
            font-size: 20px;
            margin: 15px -25px -25px -25px;
            padding: 20px 25px;
            border-radius: 0 0 12px 12px;
        }

        .notes {
            margin-top: 40px;
            padding: 25px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            border-left: 6px solid #667eea;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .notes .section-title {
            margin-bottom: 15px;
        }

        .status {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status.pending {
            background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
            color: #d63031;
        }

        .status.paid {
            background: linear-gradient(135deg, #00b894 0%, #00cec9 100%);
            color: white;
        }

        .status.overdue {
            background: linear-gradient(135deg, #e17055 0%, #d63031 100%);
            color: white;
        }

        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 12px;
            opacity: 0.8;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120px;
            color: rgba(102, 126, 234, 0.03);
            font-weight: 900;
            z-index: 0;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="watermark">{{ $invoice->status === 'draft' ? 'DRAFT' : 'INVOICE' }}</div>

    <div class="invoice-container">
        <div class="header">
            <div class="company-info">
                <div class="header-content">
        @if(config('app.company_logo'))
        <img src="{{ config('app.company_logo') }}" class="company-logo" alt="{{ config('app.company_name') }}">
        @endif
        <div class="company-info">
            <div class="company-name">{{ config('app.company_name') }}</div>
            <div class="company-legal">
                NPWP: {{ config('app.company_tax_id') }}<br>
                Izin Usaha: {{ config('app.business_license') }}
            </div>
                <div class="company-details">
                    {{ config('app.company_address') }}<br>
                    Telp: {{ config('app.company_phone') }} | Email: {{ config('app.company_email') }}
                </div>
                <div class="company-details">
                    123 Business Street<br>
                    City, State 12345<br>
                    📧 contact@company.com | 📞 +1 (555) 123-4567
                </div>
                <div class="invoice-title">INVOICE</div>
            </div>
        </div>

        <div class="content">
            <div class="invoice-info">
                <div class="client-info">
                    <div class="section-title">Bill To:</div>
                    <div class="info-row"><strong>{{ $invoice->client->name }}</strong></div>
                    @if($invoice->client->company)
                        <div class="info-row">{{ $invoice->client->company }}</div>
                    @endif
                    <div class="info-row">{{ $invoice->client->email }}</div>
                    @if($invoice->client->phone)
                        <div class="info-row">{{ $invoice->client->phone }}</div>
                    @endif
                    @if($invoice->client->address)
                        <div class="info-row">{{ $invoice->client->address }}</div>
                    @endif
                </div>

                <div class="invoice-details">
                    <div class="section-title">Invoice Details:</div>
                    <div class="info-row"><strong>Invoice #:</strong> {{ $invoice->invoice_number }}</div>
                    <div class="info-row"><strong>Issue Date:</strong> {{ $invoice->issue_date->format('d/m/Y') }}</div>
                    <div class="info-row"><strong>Due Date:</strong> {{ $invoice->due_date->format('d/m/Y') }}</div>
                    <div class="info-row"><strong>Status:</strong>
                        <span class="status {{ $invoice->status }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </div>
                    @if($invoice->project)
                        <div class="info-row"><strong>Project:</strong> {{ $invoice->project->name }}</div>
                    @endif
                </div>
            </div>

            @if($invoice->invoiceItems->count() > 0)
            <table class="items-table" aria-describedby="invoiceItems">
    <caption class="sr-only">Daftar item invoice</caption>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th class="text-right">Quantity</th>
                        <th class="text-right">Unit Price</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->invoiceItems as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td class="text-right">{{ number_format($item->quantity, 0) }}</td>
                        <td class="text-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            <div class="total-section">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span>Rp {{ number_format($invoice->invoiceItems->sum('total_price'), 0, ',', '.') }}</span>
                </div>
                @if($invoice->tax_amount > 0)
                <div class="total-row">
                    <span>Tax:</span>
                    <span>Rp {{ number_format($invoice->tax_amount, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="total-row final">
                    <span>Total:</span>
                    <span>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>

            @if($invoice->notes)
            <div class="notes">
                <div class="section-title">Notes:</div>
                <p>{{ $invoice->notes }}</p>
            </div>
            @endif
        </div>

        <div class="footer">
            <div class="payment-instructions">
                <h4>Instruksi Pembayaran:</h4>
                <p>{{ config('app.payment_instructions') }}</p>
                <div class="bank-details">
                    @foreach(config('app.bank_accounts') as $bank)
                    <div class="bank-account">
                        {{ $bank['bank_name'] }}<br>
                        {{ $bank['account_number'] }}<br>
                        a.n {{ $bank['account_name'] }}
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="legal-disclaimer">
                {{ config('app.invoice_disclaimer') }}
            </div>
        </div>
    </div>
</body>
</html>
