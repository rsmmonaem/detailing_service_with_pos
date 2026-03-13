<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $receipt['license_plate'] }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            line-height: 1.2;
            margin: 0;
            padding: 2mm 4.5mm;
            width: 57mm;
            box-sizing: border-box;
            background: #fff;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .logo {
            max-width: 40mm;
            max-height: 20mm;
            margin-bottom: 5px;
        }
        .company-name {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .divider {
            border-bottom: 1px dashed #000;
            margin: 8px 0;
        }
        .item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 14px;
            margin-top: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 10px;
        }
        @media print {
            body { padding: 2mm 4.5mm; width: 57mm; box-sizing: border-box; }
            @page { margin: 0; size: 57mm auto; }
        }
    </style>
</head>
<body>
    <div class="header">
        @if($receipt['company_logo'])
            <img src="{{ asset('storage/' . $receipt['company_logo']) }}" class="logo">
        @endif
        <div class="company-name">{{ $receipt['company_name'] }}</div>
        <div style="font-size: 10px;">{{ $receipt['company_address'] }}</div>
    </div>

    <div class="divider"></div>

    <div class="item-row">
        <span>Date:</span>
        <span>{{ $receipt['date'] }}</span>
    </div>
    <div class="item-row">
        <span>Plate:</span>
        <span style="font-weight: bold;">{{ $receipt['license_plate'] }}</span>
    </div>
    @if($receipt['customer_name'])
    <div class="item-row">
        <span>Name:</span>
        <span>{{ $receipt['customer_name'] }}</span>
    </div>
    @endif

    <div class="divider"></div>

    <div class="item-row" style="font-weight: bold;">
        <span>{{ $receipt['service_type'] }}</span>
        <span>{{ $receipt['currency_symbol'] }} {{ number_format($receipt['amount'], 2) }}</span>
    </div>

    <div class="divider"></div>

    <div class="total-row">
        <span>TOTAL:</span>
        <span>{{ $receipt['currency_symbol'] }} {{ number_format($receipt['amount'], 2) }}</span>
    </div>

    <div class="item-row" style="margin-top: 5px;">
        <span>Paid via:</span>
        <span>{{ $receipt['payment_method'] }}</span>
    </div>

    <div class="footer">
        <p>THANK YOU!</p>
        <p>PLEASE COME AGAIN</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
            
            // Listen for the print dialog closing
            window.onafterprint = function() {
                window.close();
            };

            // Alternative check for browsers that don't support onafterprint well
            setTimeout(function() {
                // If the tab is still open after 2 seconds AND the focus returns, 
                // it might mean they cancelled or finished.
                window.onfocus = function() {
                    window.close();
                };
            }, 2000);
        };
    </script>
</body>
</html>
