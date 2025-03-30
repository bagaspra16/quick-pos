@extends('layouts.app')

@section('title', 'Buat Pesanan')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style>
    .select2-container--default .select2-selection--single {
        background-color: #374151;
        border-color: #4B5563;
        color: white;
        height: 42px;
        display: flex;
        align-items: center;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: white;
        line-height: normal;
    }
    .select2-dropdown {
        background-color: #374151;
        border-color: #4B5563;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #2563EB;
    }
    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #1D4ED8;
    }
    .select2-results__option {
        color: white;
    }
    .select2-search__field {
        background-color: #4B5563;
        color: white;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 42px;
    }
</style>
@endsection

@section('content')
<div class="mb-6">
    <a href="{{ route('orders.index') }}" class="text-blue-500 hover:text-blue-700">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Pesanan
    </a>
</div>

<div class="card rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-semibold mb-6">Buat Pesanan Baru</h2>
    
    <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
        @csrf
        
        <div class="mb-6">
            <label for="table_id" class="block text-sm font-medium mb-2">Pilih Meja <span class="text-red-500">*</span></label>
            <select id="table_id" name="table_id" required class="w-full bg-gray-700 border border-gray-600 rounded-md px-4 py-2">
                <option value="">-- Pilih meja --</option>
                @foreach($tables as $table)
                <option value="{{ $table->id }}">Meja {{ $table->number }} (Kapasitas: {{ $table->capacity }} orang)</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-6">
            <label class="block text-sm font-medium mb-2">Pilih Menu <span class="text-red-500">*</span></label>
            
            <div class="flex flex-wrap gap-4 mb-4">
                <button type="button" data-filter="all" class="filter-btn bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                    Semua
                </button>
                <button type="button" data-filter="food" class="filter-btn bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                    Makanan
                </button>
                <button type="button" data-filter="drink" class="filter-btn bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                    Minuman
                </button>
            </div>            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($products as $product)
                <div class="product-card bg-gray-800 rounded-lg shadow-sm overflow-hidden" data-type="{{ $product->type }}">
                    <div class="relative h-40">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-700">
                            <i class="fas {{ $product->type == 'food' ? 'fa-utensils' : 'fa-mug-hot' }} text-4xl text-gray-500"></i>
                        </div>
                        @endif
                        <div class="absolute top-2 right-2">
                            <span class="bg-{{ $product->type == 'food' ? 'green' : 'yellow' }}-600 text-white py-0.5 px-1.5 rounded-md text-xs">
                                {{ $product->type == 'food' ? 'Makanan' : 'Minuman' }}
                            </span>
                        </div>
                    </div>
                    <div class="p-3">
                        <h3 class="font-medium">{{ $product->name }}</h3>
                        <div class="flex justify-between items-center mt-2">
                            <p class="text-blue-500 font-bold">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                            <button type="button" class="add-product bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded-md text-sm"
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    data-price="{{ $product->price }}"
                                    data-type="{{ $product->type }}">
                                <i class="fas fa-plus mr-1"></i> Tambah
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="mt-6 mb-6">
            <h3 class="text-xl font-semibold mb-3">Pesanan</h3>
            <div class="bg-gray-800 rounded-lg p-4" id="selectedProducts">
                <div id="emptyCart" class="text-center py-4 text-gray-400">
                    <i class="fas fa-shopping-cart text-3xl mb-2"></i>
                    <p>Belum ada item yang dipilih</p>
                </div>
                <div id="productList" class="hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-700">
                                    <th class="px-4 py-2 text-left">Item</th>
                                    <th class="px-4 py-2 text-left">Harga</th>
                                    <th class="px-4 py-2 text-center">Jumlah</th>
                                    <th class="px-4 py-2 text-left">Subtotal</th>
                                    <th class="px-4 py-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="cartItems">
                                <!-- Items will be added here dynamically -->
                            </tbody>
                            <tfoot>
                                <tr class="border-t border-gray-700 font-bold">
                                    <td colspan="3" class="px-4 py-2 text-right">Total:</td>
                                    <td class="px-4 py-2" id="totalAmount">Rp0</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mb-6">
            <label for="notes" class="block text-sm font-medium mb-2">Catatan Pesanan</label>
            <textarea id="notes" name="notes" rows="3"
                      class="w-full bg-gray-700 border border-gray-600 rounded-md px-4 py-2 focus:outline-none focus:border-blue-500"
                      placeholder="Tambahkan catatan untuk pesanan ini..."></textarea>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                Simpan Pesanan
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('#table_id').select2({
            placeholder: "Pilih meja",
            allowClear: true
        });
        
        // Filter products
        $('.filter-btn').on('click', function() {
            $('.filter-btn').removeClass('bg-blue-600').addClass('bg-gray-700');
            $(this).removeClass('bg-gray-700').addClass('bg-blue-600');
            
            const filter = $(this).data('filter');
            
            if (filter === 'all') {
                $('.product-card').show();
            } else {
                $('.product-card').hide();
                $(`.product-card[data-type="${filter}"]`).show();
            }
        });
        
        // Cart functionality
        let cartItems = [];
        let totalAmount = 0;
        
        // Add to cart
        $('.add-product').on('click', function() {
            const productId = $(this).data('id');
            const productName = $(this).data('name');
            const productPrice = $(this).data('price');
            const productType = $(this).data('type');
            
            // Check if product already in cart
            const existingItemIndex = cartItems.findIndex(item => item.product_id === productId);
            
            if (existingItemIndex !== -1) {
                // Increment quantity
                cartItems[existingItemIndex].quantity += 1;
            } else {
                // Add new item
                cartItems.push({
                    product_id: productId,
                    name: productName,
                    price: productPrice,
                    type: productType,
                    quantity: 1,
                    notes: ''
                });
            }
            
            // Update cart UI
            updateCart();
            
            // Show animation
            $(this).html('<i class="fas fa-check mr-1"></i> Ditambah').removeClass('bg-blue-600').addClass('bg-green-600');
            
            setTimeout(() => {
                $(this).html('<i class="fas fa-plus mr-1"></i> Tambah').removeClass('bg-green-600').addClass('bg-blue-600');
            }, 1000);
        });
        
        // Update cart
        function updateCart() {
            const cartItemsContainer = $('#cartItems');
            cartItemsContainer.empty();
            
            if (cartItems.length === 0) {
                $('#emptyCart').show();
                $('#productList').hide();
                totalAmount = 0;
            } else {
                $('#emptyCart').hide();
                $('#productList').show();
                
                totalAmount = 0;
                
                cartItems.forEach((item, index) => {
                    const subtotal = item.price * item.quantity;
                    totalAmount += subtotal;
                    
                    const itemRow = `
                        <tr class="border-b border-gray-700">
                            <td class="px-4 py-3">
                                <div>
                                    <p class="font-medium">${item.name}</p>
                                    <input type="hidden" name="products[${index}][id]" value="${item.product_id}">
                                    <input type="text" name="products[${index}][notes]" value="${item.notes}" placeholder="Catatan item..." 
                                        class="item-note mt-1 w-full bg-gray-700 border-gray-600 rounded-md px-2 py-1 text-sm" data-index="${index}">
                                </div>
                            </td>
                            <td class="px-4 py-3">Rp${item.price.toLocaleString('id-ID')}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center">
                                    <button type="button" class="decrement-item bg-gray-700 hover:bg-gray-600 text-white w-8 h-8 rounded-l-md flex items-center justify-center" data-index="${index}">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" name="products[${index}][quantity]" value="${item.quantity}" min="1" 
                                        class="quantity-input bg-gray-700 border-0 text-center w-12 h-8" data-index="${index}">
                                    <button type="button" class="increment-item bg-gray-700 hover:bg-gray-600 text-white w-8 h-8 rounded-r-md flex items-center justify-center" data-index="${index}">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="px-4 py-3">Rp${subtotal.toLocaleString('id-ID')}</td>
                            <td class="px-4 py-3 text-center">
                                <button type="button" class="remove-item text-red-500 hover:text-red-700" data-index="${index}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    
                    cartItemsContainer.append(itemRow);
                });
                
                // Setup event handlers for cart items
                $('.increment-item').on('click', function() {
                    const index = $(this).data('index');
                    cartItems[index].quantity += 1;
                    updateCart();
                });
                
                $('.decrement-item').on('click', function() {
                    const index = $(this).data('index');
                    if (cartItems[index].quantity > 1) {
                        cartItems[index].quantity -= 1;
                        updateCart();
                    }
                });
                
                $('.quantity-input').on('change', function() {
                    const index = $(this).data('index');
                    const value = parseInt($(this).val());
                    if (!isNaN(value) && value > 0) {
                        cartItems[index].quantity = value;
                        updateCart();
                    }
                });
                
                $('.remove-item').on('click', function() {
                    const index = $(this).data('index');
                    cartItems.splice(index, 1);
                    updateCart();
                });
                
                $('.item-note').on('change', function() {
                    const index = $(this).data('index');
                    cartItems[index].notes = $(this).val();
                });
            }
            
            // Update total
            $('#totalAmount').text('Rp' + totalAmount.toLocaleString('id-ID'));
        }
        
        // Form submission
        $('#orderForm').on('submit', function(e) {
            if (cartItems.length === 0) {
                e.preventDefault();
                alert('Mohon tambahkan minimal 1 item ke pesanan.');
                return false;
            }
            
            if (!$('#table_id').val()) {
                e.preventDefault();
                alert('Mohon pilih meja terlebih dahulu.');
                return false;
            }
            
            return true;
        });
    });
</script>
@endsection 