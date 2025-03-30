<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print QR Code - Meja {{ $table->number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
        }
        
        .container {
            width: 300px;
            padding: 20px;
            border: 1px solid #ddd;
            text-align: center;
        }
        
        .qr-container {
            background: white;
            padding: 15px;
            margin: 15px 0;
        }
        
        h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        p {
            color: #555;
            font-size: 14px;
            margin-top: 0;
        }
        
        .footer {
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .container {
                border: none;
            }
            
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Meja {{ $table->number }}</h1>
        <p>Kapasitas: {{ $table->capacity }} orang</p>
        
        <div class="qr-container">
            {!! $qrCode !!}
        </div>
        
        <div class="footer">
            <p>Scan QR code ini untuk melihat menu dan melakukan pemesanan.</p>
        </div>
        
        <button class="print-button" onclick="window.print()">Cetak</button>
    </div>
    
    <script>
        window.onload = function() {
            // Auto print when loaded
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html> 