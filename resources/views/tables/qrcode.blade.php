@extends('layouts.app')

@section('title', 'QR Code Meja')

@section('content')
<div class="mb-6">
    <a href="{{ route('tables.index') }}" class="text-blue-500 hover:text-blue-700">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Meja
    </a>
</div>

<div class="card rounded-lg shadow-md p-6">
    <div class="flex flex-col items-center justify-center">
        <h2 class="text-2xl font-semibold mb-2">QR Code: Meja {{ $table->number }}</h2>
        <p class="text-gray-400 mb-6">Kapasitas: {{ $table->capacity }} orang</p>
        
        <div class="bg-white p-4 rounded-lg mb-4">
            {!! $qrCode !!}
        </div>
        
        <div class="text-sm text-gray-400 mb-6 text-center">
            <p>Scan QR code ini untuk melihat menu dan melakukan pemesanan.</p>
            <p>URL: {{ route('menu.table', $table->barcode) }}</p>
        </div>
        
        <div class="flex space-x-4">
            <a href="{{ route('tables.print-qrcode', $table) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                <i class="fas fa-print mr-2"></i> Cetak QR Code
            </a>
            <button id="downloadQR" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                <i class="fas fa-download mr-2"></i> Download QR Code
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Download QR Code as image
        $('#downloadQR').on('click', function() {
            const svg = document.querySelector('svg');
            const svgData = new XMLSerializer().serializeToString(svg);
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            const img = new Image();
            
            img.onload = function() {
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.fillStyle = 'white';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(img, 0, 0);
                
                const a = document.createElement('a');
                a.download = 'meja-{{ $table->number }}-qrcode.png';
                a.href = canvas.toDataURL('image/png');
                a.click();
            };
            
            img.src = 'data:image/svg+xml;base64,' + btoa(svgData);
        });
    });
</script>
@endsection 