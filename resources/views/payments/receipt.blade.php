<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 20px;
            color: #000;
            font-size: 12px;
        }
        
        .receipt {
            width: 300px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .header h1 {
            font-size: 18px;
            margin: 5px 0;
        }
        
        .header p {
            margin: 5px 0;
        }
        
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            text-align: left;
            padding: 3px 0;
        }
        
        .right {
            text-align: right;
        }
        
        .center {
            text-align: center;
        }
        
        .footer {
            margin-top: 20px;
            text-align: center;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h1>QUICK POS</h1>
            <p>Jl. Contoh No. 123, Kota</p>
            <p>Telp: 0123-4567-8910</p>
        </div>
        
        <div class="divider"></div>
        
        <table>
            <tr>
                <td>No. Struk</td>
                <td class="right">{{ substr($payment->id, 0, 8) }}</td>
            </tr>
            <tr>
                <td>Kasir</td>
                <td class="right">{{ $payment->user->name }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td class="right">{{ $payment->created_at->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td>Waktu</td>
                <td class="right">{{ $payment->created_at->format('H:i:s') }}</td>
            </tr>
            <tr>
                <td>Meja</td>
                <td class="right">{{ $payment->order->table->number }}</td>
            </tr>
        </table>
        
        <div class="divider"></div>
        
        <table>
            @foreach($payment->order->items as $item)
            <tr>
                <td colspan="3">{{ $item->product->name }}</td>
            </tr>
            <tr>
                <td>{{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                <td></td>
                <td class="right">Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
            </tr>
            @if($item->notes)
            <tr>
                <td colspan="3" style="font-style: italic; font-size: 10px;">Note: {{ $item->notes }}</td>
            </tr>
            @endif
            @endforeach
        </table>
        
        <div class="divider"></div>
        
        <table>
            <tr>
                <td>Subtotal</td>
                <td class="right">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
            </tr>
            @if($payment->payment_method == 'cash')
            <tr>
                <td>Tunai</td>
                <td class="right">Rp{{ number_format($payment->received_amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Kembalian</td>
                <td class="right">Rp{{ number_format($payment->change_amount, 0, ',', '.') }}</td>
            </tr>
            @endif
        </table>
        
        <div class="divider"></div>
        
        <p>Metode Pembayaran:
            @if($payment->payment_method == 'cash')
                Tunai
            @elseif($payment->payment_method == 'debit')
                Kartu Debit
            @elseif($payment->payment_method == 'credit')
                Kartu Kredit
            @elseif($payment->payment_method == 'qris')
                QRIS
            @else
                Lainnya
            @endif
            
            @if($payment->payment_method != 'cash' && $payment->transaction_id)
                <br>ID: {{ $payment->transaction_id }}
            @endif
        </p>
        
        <div class="divider"></div>
        
        <div class="footer">
            <p>Terima kasih atas kunjungan Anda!</p>
            <p>Silahkan datang kembali</p>
        </div>
        
        <button class="no-print" onclick="window.print()">Cetak Struk</button>
    </div>
    
    <script>
        // Auto print when loaded
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>