@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="mb-6">
    <a href="{{ route('orders.index') }}" class="text-blue-500 hover:text-blue-700">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Pesanan
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="card rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h2 class="text-2xl font-semibold">Pesanan #{{ substr($order->id, 0, 8) }}</h2>
                    <p class="text-gray-400">{{ $order->created_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    @if($order->status == 'pending')
                        <span class="bg-yellow-600 text-white py-1 px-3 rounded-full text-sm">Menunggu</span>
                    @elseif($order->status == 'processing')
                        <span class="bg-blue-600 text-white py-1 px-3 rounded-full text-sm">Diproses</span>
                    @elseif($order->status == 'completed')
                        <span class="bg-green-600 text-white py-1 px-3 rounded-full text-sm">Selesai</span>
                    @else
                        <span class="bg-red-600 text-white py-1 px-3 rounded-full text-sm">Dibatalkan</span>
                    @endif
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-gray-800 p-4 rounded-md">
                    <h3 class="font-medium mb-2">Informasi Pesanan</h3>
                    <table class="w-full text-sm">
                        <tr>
                            <td class="py-1 text-gray-400">Meja:</td>
                            <td class="py-1 text-right">Meja {{ $order->table->number }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 text-gray-400">Kasir:</td>
                            <td class="py-1 text-right">{{ $order->user->name ?? 'Pelanggan Mandiri' }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 text-gray-400">Total:</td>
                            <td class="py-1 text-right font-medium">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 text-gray-400">Waktu Pesan:</td>
                            <td class="py-1 text-right">{{ $order->ordered_at ? $order->ordered_at->format('d/m/Y H:i') : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 text-gray-400">Waktu Selesai:</td>
                            <td class="py-1 text-right">{{ $order->completed_at ? $order->completed_at->format('d/m/Y H:i') : '-' }}</td>
                        </tr>
                    </table>
                </div>
                
                <div class="bg-gray-800 p-4 rounded-md">
                    <h3 class="font-medium mb-2">Pembayaran</h3>
                    @if($order->payment)
                        <table class="w-full text-sm">
                            <tr>
                                <td class="py-1 text-gray-400">Status:</td>
                                <td class="py-1 text-right">
                                    <span class="bg-green-600 text-white py-0.5 px-2 rounded-md text-xs">Lunas</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-1 text-gray-400">Metode:</td>
                                <td class="py-1 text-right">
                                    @if($order->payment->payment_method == 'cash')
                                        Tunai
                                    @elseif($order->payment->payment_method == 'debit')
                                        Kartu Debit
                                    @elseif($order->payment->payment_method == 'credit')
                                        Kartu Kredit
                                    @elseif($order->payment->payment_method == 'qris')
                                        QRIS
                                    @else
                                        Lainnya
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="py-1 text-gray-400">Total Bayar:</td>
                                <td class="py-1 text-right">Rp{{ number_format($order->payment->amount, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="py-1 text-gray-400">Diterima:</td>
                                <td class="py-1 text-right">Rp{{ number_format($order->payment->received_amount, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="py-1 text-gray-400">Kembalian:</td>
                                <td class="py-1 text-right">Rp{{ number_format($order->payment->change_amount, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                        <div class="mt-4 text-center">
                            <a href="{{ route('payments.receipt', $order->payment) }}" target="_blank" class="text-blue-500 hover:text-blue-700">
                                <i class="fas fa-print mr-1"></i> Cetak Struk
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-400 mb-4">Pesanan ini belum dibayar</p>
                            @if($order->status != 'cancelled')
                            <a href="{{ route('payments.create', $order) }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
                                <i class="fas fa-money-bill-wave mr-2"></i> Proses Pembayaran
                            </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            
            @if($order->notes)
            <div class="bg-gray-800 p-4 rounded-md mb-6">
                <h3 class="font-medium mb-2">Catatan</h3>
                <p class="text-gray-300">{{ $order->notes }}</p>
            </div>
            @endif
            
            <h3 class="font-semibold mb-4">Item Pesanan</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-800">
                            <th class="px-4 py-2 text-left">Item</th>
                            <th class="px-4 py-2 text-left">Tipe</th>
                            <th class="px-4 py-2 text-left">Harga</th>
                            <th class="px-4 py-2 text-left">Jumlah</th>
                            <th class="px-4 py-2 text-left">Subtotal</th>
                            <th class="px-4 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @foreach($order->items as $item)
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
                                <span class="bg-{{ $item->product->type == 'food' ? 'green' : 'yellow' }}-600 text-white py-0.5 px-2 rounded-md text-xs">
                                    {{ $item->product->type == 'food' ? 'Makanan' : 'Minuman' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">{{ $item->quantity }}</td>
                            <td class="px-4 py-3">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                @if($order->status != 'cancelled')
                                <form action="{{ route('orderItems.updateStatus', $item) }}" method="POST">
                                    @csrf
                                    <select name="status" class="bg-gray-700 border-gray-600 rounded-md text-xs py-1 pr-6" onchange="this.form.submit()">
                                        <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="preparing" {{ $item->status == 'preparing' ? 'selected' : '' }}>Dimasak</option>
                                        <option value="ready" {{ $item->status == 'ready' ? 'selected' : '' }}>Siap</option>
                                        <option value="served" {{ $item->status == 'served' ? 'selected' : '' }}>Disajikan</option>
                                        <option value="cancelled" {{ $item->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </form>
                                @else
                                <span class="bg-red-600 text-white py-0.5 px-2 rounded-md text-xs">Dibatalkan</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-800 font-bold">
                            <td colspan="4" class="px-4 py-3 text-right">Total:</td>
                            <td colspan="2" class="px-4 py-3">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
    <div class="lg:col-span-1">
        <div class="card rounded-lg shadow-md p-6 sticky top-6">
            <h3 class="font-semibold mb-4">Tindakan</h3>
            
            @if($order->status != 'cancelled' && $order->status != 'completed')
            <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="mb-4">
                @csrf
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium mb-2">Ubah Status Pesanan</label>
                    <select id="status" name="status" class="w-full bg-gray-700 border border-gray-600 rounded-md px-4 py-2">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
                    Perbarui Status
                </button>
            </form>
            @endif
            
            @if(!$order->payment && $order->status != 'cancelled')
            <a href="{{ route('payments.create', $order) }}" class="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-2 px-4 rounded-md mb-3">
                <i class="fas fa-money-bill-wave mr-2"></i> Proses Pembayaran
            </a>
            @endif
            
            @if($order->payment)
            <a href="{{ route('payments.receipt', $order->payment) }}" target="_blank" class="block w-full bg-purple-600 hover:bg-purple-700 text-white text-center py-2 px-4 rounded-md mb-3">
                <i class="fas fa-print mr-2"></i> Cetak Struk
            </a>
            @endif
            
            <a href="{{ route('orders.index') }}" class="block w-full bg-gray-600 hover:bg-gray-700 text-white text-center py-2 px-4 rounded-md">
                Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
@endsection 