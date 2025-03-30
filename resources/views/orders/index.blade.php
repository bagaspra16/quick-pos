@extends('layouts.app')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold">Daftar Pesanan</h2>
    <a href="{{ route('orders.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
        <i class="fas fa-plus mr-2"></i> Buat Pesanan
    </a>
</div>

<div class="card rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-700">
                    <th class="px-6 py-3 text-left">ID Pesanan</th>
                    <th class="px-6 py-3 text-left">Meja</th>
                    <th class="px-6 py-3 text-left">Kasir</th>
                    <th class="px-6 py-3 text-left">Total</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Waktu</th>
                    <th class="px-6 py-3 text-left">Pembayaran</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse ($orders as $order)
                <tr class="hover:bg-gray-700">
                    <td class="px-6 py-4 font-medium">{{ substr($order->id, 0, 8) }}</td>
                    <td class="px-6 py-4">Meja {{ $order->table->number }}</td>
                    <td class="px-6 py-4">{{ $order->user->name ?? 'Pelanggan Mandiri' }}</td>
                    <td class="px-6 py-4">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @if($order->status == 'pending')
                            <span class="bg-yellow-600 text-white py-1 px-2 rounded-md text-xs">Menunggu</span>
                        @elseif($order->status == 'processing')
                            <span class="bg-blue-600 text-white py-1 px-2 rounded-md text-xs">Diproses</span>
                        @elseif($order->status == 'completed')
                            <span class="bg-green-600 text-white py-1 px-2 rounded-md text-xs">Selesai</span>
                        @else
                            <span class="bg-red-600 text-white py-1 px-2 rounded-md text-xs">Dibatalkan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4">
                        @if($order->payment)
                            <span class="bg-green-600 text-white py-1 px-2 rounded-md text-xs">Lunas</span>
                        @else
                            <span class="bg-yellow-600 text-white py-1 px-2 rounded-md text-xs">Belum Bayar</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('orders.show', $order) }}" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-gray-400">
                        Belum ada pesanan. Silakan buat pesanan baru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $orders->links() }}
</div>
@endsection 