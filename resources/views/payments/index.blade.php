@extends('layouts.app')

@section('title', 'Manajemen Pembayaran')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold">Riwayat Pembayaran</h2>
</div>

<div class="card rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-700">
                    <th class="px-6 py-3 text-left">ID Pembayaran</th>
                    <th class="px-6 py-3 text-left">ID Pesanan</th>
                    <th class="px-6 py-3 text-left">Meja</th>
                    <th class="px-6 py-3 text-left">Kasir</th>
                    <th class="px-6 py-3 text-left">Jumlah</th>
                    <th class="px-6 py-3 text-left">Metode</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Waktu</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse ($payments as $payment)
                <tr class="hover:bg-gray-700">
                    <td class="px-6 py-4 font-medium">{{ substr($payment->id, 0, 8) }}</td>
                    <td class="px-6 py-4">{{ substr($payment->order_id, 0, 8) }}</td>
                    <td class="px-6 py-4">Meja {{ $payment->order->table->number }}</td>
                    <td class="px-6 py-4">{{ $payment->user->name }}</td>
                    <td class="px-6 py-4">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @if($payment->payment_method == 'cash')
                            <span class="bg-green-600 text-white py-1 px-2 rounded-md text-xs">Tunai</span>
                        @elseif($payment->payment_method == 'debit')
                            <span class="bg-blue-600 text-white py-1 px-2 rounded-md text-xs">Kartu Debit</span>
                        @elseif($payment->payment_method == 'credit')
                            <span class="bg-purple-600 text-white py-1 px-2 rounded-md text-xs">Kartu Kredit</span>
                        @elseif($payment->payment_method == 'qris')
                            <span class="bg-yellow-600 text-white py-1 px-2 rounded-md text-xs">QRIS</span>
                        @else
                            <span class="bg-gray-600 text-white py-1 px-2 rounded-md text-xs">Lainnya</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($payment->status == 'completed')
                            <span class="bg-green-600 text-white py-1 px-2 rounded-md text-xs">Selesai</span>
                        @elseif($payment->status == 'pending')
                            <span class="bg-yellow-600 text-white py-1 px-2 rounded-md text-xs">Menunggu</span>
                        @elseif($payment->status == 'refunded')
                            <span class="bg-red-600 text-white py-1 px-2 rounded-md text-xs">Dikembalikan</span>
                        @else
                            <span class="bg-red-600 text-white py-1 px-2 rounded-md text-xs">Gagal</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('payments.show', $payment) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('payments.receipt', $payment) }}" target="_blank" class="text-green-500 hover:text-green-700">
                            <i class="fas fa-print"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-4 text-center text-gray-400">
                        Belum ada riwayat pembayaran.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $payments->links() }}
</div>
@endsection 