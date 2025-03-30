@extends('layouts.app')

@section('title', 'Proses Pembayaran')

@section('content')
<div class="mb-6">
    <a href="{{ route('orders.show', $order) }}" class="text-blue-500 hover:text-blue-700">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Detail Pesanan
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="card rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold mb-6">Proses Pembayaran</h2>
            
            <div class="bg-gray-800 rounded-lg p-4 mb-6">
                <h3 class="font-medium mb-3">Ringkasan Pesanan</h3>
                <table class="w-full">
                    <tr>
                        <td class="py-1 text-gray-400">ID Pesanan:</td>
                        <td class="py-1 text-right">{{ substr($order->id, 0, 8) }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 text-gray-400">Meja:</td>
                        <td class="py-1 text-right">Meja {{ $order->table->number }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 text-gray-400">Jumlah Item:</td>
                        <td class="py-1 text-right">{{ $order->items->count() }} item</td>
                    </tr>
                    <tr>
                        <td class="py-1 text-gray-400">Total Pembayaran:</td>
                        <td class="py-1 text-right font-bold text-lg">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
            
            <form action="{{ route('payments.store', $order) }}" method="POST" id="paymentForm">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Metode Pembayaran <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <label class="payment-method cursor-pointer">
                            <input type="radio" name="payment_method" value="cash" class="hidden" checked>
                            <div class="border-2 border-gray-600 hover:border-blue-500 rounded-lg p-4 text-center method-cash">
                                <i class="fas fa-money-bill-wave text-2xl mb-2"></i>
                                <p>Tunai</p>
                            </div>
                        </label>
                        
                        <label class="payment-method cursor-pointer">
                            <input type="radio" name="payment_method" value="debit" class="hidden">
                            <div class="border-2 border-gray-600 hover:border-blue-500 rounded-lg p-4 text-center method-debit">
                                <i class="fas fa-credit-card text-2xl mb-2"></i>
                                <p>Kartu Debit</p>
                            </div>
                        </label>
                        
                        <label class="payment-method cursor-pointer">
                            <input type="radio" name="payment_method" value="credit" class="hidden">
                            <div class="border-2 border-gray-600 hover:border-blue-500 rounded-lg p-4 text-center method-credit">
                                <i class="far fa-credit-card text-2xl mb-2"></i>
                                <p>Kartu Kredit</p>
                            </div>
                        </label>
                        
                        <label class="payment-method cursor-pointer">
                            <input type="radio" name="payment_method" value="qris" class="hidden">
                            <div class="border-2 border-gray-600 hover:border-blue-500 rounded-lg p-4 text-center method-qris">
                                <i class="fas fa-qrcode text-2xl mb-2"></i>
                                <p>QRIS</p>
                            </div>
                        </label>
                    </div>
                </div>
                
                <div id="cashPaymentFields" class="mb-6">
                    <label for="received_amount" class="block text-sm font-medium mb-2">Jumlah Diterima <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">Rp</span>
                        <input type="number" id="received_amount" name="received_amount" min="{{ $order->total_amount }}" value="{{ $order->total_amount }}"
                               class="w-full bg-gray-700 border border-gray-600 rounded-md pl-10 px-4 py-2 focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="mt-2 p-3 bg-gray-800 rounded-md">
                        <div class="flex justify-between">
                            <span>Total Pembayaran:</span>
                            <span>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between font-medium">
                            <span>Kembalian:</span>
                            <span id="changeAmount">Rp0</span>
                        </div>
                    </div>
                </div>
                
                <div id="nonCashPaymentFields" class="mb-6 hidden">
                    <label for="transaction_id" class="block text-sm font-medium mb-2">ID Transaksi <span class="text-red-500">*</span></label>
                    <input type="text" id="transaction_id" name="transaction_id"
                           class="w-full bg-gray-700 border border-gray-600 rounded-md px-4 py-2 focus:outline-none focus:border-blue-500"
                           placeholder="Masukkan ID transaksi / referensi">
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                        Proses Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="lg:col-span-1">
        <div class="card rounded-lg shadow-md p-6 sticky top-6">
            <h3 class="font-semibold mb-4">Detail Item</h3>
            
            <div class="space-y-3 mb-6">
                @foreach($order->items as $item)
                <div class="flex justify-between items-start pb-2 border-b border-gray-700">
                    <div>
                        <p class="font-medium">{{ $item->product->name }}</p>
                        <p class="text-sm text-gray-400">{{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                        @if($item->notes)
                        <p class="text-xs text-gray-400 mt-1">Catatan: {{ $item->notes }}</p>
                        @endif
                    </div>
                    <p class="font-medium">Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
            
            <div class="border-t border-gray-700 pt-3">
                <div class="flex justify-between">
                    <span class="font-bold">Total</span>
                    <span class="font-bold">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Handle payment method selection
        $('.payment-method input').on('change', function() {
            $('.payment-method div').removeClass('border-blue-500').addClass('border-gray-600');
            $(this).closest('.payment-method').find('div').removeClass('border-gray-600').addClass('border-blue-500');
            
            const method = $(this).val();
            
            if (method === 'cash') {
                $('#cashPaymentFields').show();
                $('#nonCashPaymentFields').hide();
                $('#received_amount').prop('required', true);
                $('#transaction_id').prop('required', false);
            } else {
                $('#cashPaymentFields').hide();
                $('#nonCashPaymentFields').show();
                $('#received_amount').prop('required', false);
                $('#transaction_id').prop('required', true);
            }
        });
        
        // Calculate change amount
        $('#received_amount').on('input', function() {
            const totalAmount = {{ $order->total_amount }};
            const receivedAmount = parseFloat($(this).val()) || 0;
            const changeAmount = receivedAmount - totalAmount;
            
            if (changeAmount >= 0) {
                $('#changeAmount').text('Rp' + changeAmount.toLocaleString('id-ID'));
            } else {
                $('#changeAmount').text('Jumlah kurang');
            }
        });
        
        // Form validation
        $('#paymentForm').on('submit', function(e) {
            const method = $('input[name="payment_method"]:checked').val();
            
            if (method === 'cash') {
                const totalAmount = {{ $order->total_amount }};
                const receivedAmount = parseFloat($('#received_amount').val()) || 0;
                
                if (receivedAmount < totalAmount) {
                    e.preventDefault();
                    alert('Jumlah yang diterima tidak boleh kurang dari total pembayaran.');
                    return false;
                }
            } else {
                if (!$('#transaction_id').val().trim()) {
                    e.preventDefault();
                    alert('ID Transaksi tidak boleh kosong.');
                    return false;
                }
            }
            
            return true;
        });
    });
</script>
@endsection 