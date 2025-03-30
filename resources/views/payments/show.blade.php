@extends('layouts.app')

@section('title', 'Detail Pembayaran')

@section('content')
<div class="mb-6">
    <a href="{{ route('payments.index') }}" class="text-blue-500 hover:text-blue-700">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Pembayaran
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="card rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-2xl font-semibold">Pembayaran #{{ substr($payment->id, 0, 8) }}</h2>
                    <p class="text-gray-400">{{ $payment->created_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    @if($payment->status == 'completed')
                        <span class="bg-green-600 text-white py-1 px-3 rounded-full text-sm">Selesai</span>
                    @elseif($payment->status == 'pending')
                        <span class="bg-yellow-600 text-white py-1 px-3 rounded-full text-sm">Menunggu</span>
                    @elseif($payment->status == 'refunded')
                        <span class="bg-red-600 text-white py-1 px-3 rounded-full text-sm">Dikembalikan</span>
                    @else
                        <span class="bg-red-600 text-white py-1 px-3 rounded-full text-sm">Gagal</span>
                    @endif
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-gray-800 p-4 rounded-md">
                    <h3 class="font-medium mb-2">Informasi Pesanan</h3>
                    <table class="w-full text-sm">
                        <tr>
                            <td class="py-1 text-gray-400">ID Pesanan:</td>
                            <td class="py-1 text-right">{{ substr($payment->order_id, 0, 8) }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 text-gray-400">Meja:</td>
                            <td class="py-1 text-right">Meja {{ $payment->order->table->number }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 text-gray-400">Jumlah Item:</td>
                            <td class="py-1 text-right">{{ $payment->order->items->count() }} item</td>
                        </tr>
                        <tr>
                            <td class="py-1 text-gray-400">Status Pesanan:</td>
                            <td class="py-1 text-right">
                                @if($payment->order->status == 'pending')
                                    Menunggu
                                @elseif($payment->order->status == 'processing')
                                    Diproses
                                @elseif($payment->order->status == 'completed')
                                    Selesai
                                @else
                                    Dibatalkan
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                
                <div class="bg-gray-800 p-4 rounded-md">
                    <h3 class="font-medium mb-2">Informasi Pembayaran</h3>
                    <table class="w-full text-sm">
                        <tr>
                            <td class="py-1 text-gray-400">Total:</td>
                            <td class="py-1 text-right font-medium">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 text-gray-400">Metode:</td>
                            <td class="py-1 text-right">
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
                            </td>
                        </tr>
                        @if($payment->payment_method == 'cash')
                        <tr>
                            <td class="py-1 text-gray-400">Diterima:</td>
                            <td class="py-1 text-right">Rp{{ number_format($payment->received_amount, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 text-gray-400">Kembalian:</td>
                            <td class="py-1 text-right">Rp{{ number_format($payment->change_amount, 0, ',', '.') }}</td>
                        </tr>
                        @else
                        <tr>
                            <td class="py-1 text-gray-400">ID Transaksi:</td>
                            <td class="py-1 text-right">{{ $payment->transaction_id }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="py-1 text-gray-400">Kasir:</td>
                            <td class="py-1 text-right">{{ $payment->user->name }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <h3 class="font-semibold mb-4">Detail Item</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-800">
                            <th class="px-4 py-2 text-left">Item</th>
                            <th class="px-4 py-2 text-left">Tipe</th>
                            <th class="px-4 py-2 text-left">Harga</th>
                            <th class="px-4 py-2 text-left">Jumlah</th>
                            <th class="px-4 py-2 text-left">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @foreach($payment->order->items as $item)
                        <tr class="hover:bg-gray-800">
                            <td class="px-4 py-3">
                                <div>
                                    <p class="font-medium">{{ $item->product->name }}</p>
                                    @if($item->notes)
                                    <p class="text-sm text-gray-400">Catatan: {{ $item->notes }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="bg-{{ $item->product->type == 'food' ? 'green' : 'orange' }}-600 text-white py-0.5 px-2 rounded-md text-xs">
                                    {{ $item->product->type == 'food' ? 'Makanan' : 'Minuman' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">{{ $item->quantity }}</td>
                            <td class="px-4 py-3">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-800 font-bold">
                            <td colspan="4" class="px-4 py-3 text-right">Total:</td>
                            <td class="px-4 py-3">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
    <div class="lg:col-span-1">
        <div class="card rounded-lg shadow-md p-6 sticky top-6">
            <h3 class="font-semibold mb-4">Tindakan</h3>
            
            <a href="{{ route('payments.receipt', $payment) }}" target="_blank" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-md mb-3">
                <i class="fas fa-print mr-2"></i> Cetak Struk
            </a>
            
            <a href="{{ route('orders.show', $payment->order_id) }}" class="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-2 px-4 rounded-md mb-3">
                <i class="fas fa-eye mr-2"></i> Lihat Pesanan
            </a>
            
            <a href="{{ route('payments.index') }}" class="block w-full bg-gray-600 hover:bg-gray-700 text-white text-center py-2 px-4 rounded-md">
                Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
@endsection