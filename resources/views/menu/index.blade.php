<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Meja {{ $table->number }}</title>
    
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        body {
            background-color: #0f172a;
            color: #f1f5f9;
        }
        
        .card {
            background-color: #1e293b;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            border-color: rgba(59, 130, 246, 0.5);
        }
        
        .category-filter::-webkit-scrollbar {
            height: 6px;
        }
        
        .category-filter::-webkit-scrollbar-track {
            background: #1e293b;
        }
        
        .category-filter::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 10px;
        }
        
        .menu-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #0284c7;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 0.8rem;
            font-weight: bold;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }

        .product-image {
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .glass-effect {
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #475569 0%, #334155 100%);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #334155 0%, #1e293b 100%);
            transform: translateY(-2px);
        }

        /* Navbar Styles */
        .navbar-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            transition: all 0.3s ease;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Container width adjustment */
        .container {
            max-width: 100%;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        @media (min-width: 640px) {
            .container {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }

        /* Navbar Icons */
        .nav-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            position: relative;
            background: rgba(59, 130, 246, 0.1);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }
        
        /* Table Icon Styles */
        .table-icon {
            position: relative;
            overflow: visible;
        }
        
        .table-info {
            position: absolute;
            bottom: -2px;
            right: -2px;
            background: #8B5CF6;
            color: white;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            font-size: 0.7rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #0f172a;
        }
        
        /* Tooltip Styles */
        .tooltip-content {
            visibility: hidden;
            opacity: 0;
            position: absolute;
            bottom: -70px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(8px);
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            white-space: nowrap;
            transition: all 0.2s ease;
            z-index: 60;
        }
        
        .tooltip-content::before {
            content: '';
            position: absolute;
            top: -6px;
            left: 50%;
            transform: translateX(-50%);
            border-width: 0 6px 6px 6px;
            border-style: solid;
            border-color: transparent transparent rgba(30, 41, 59, 0.95) transparent;
        }
        
        .nav-icon:hover .tooltip-content {
            visibility: visible;
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
        
        /* Responsive adjustments */
        @media (max-width: 640px) {
            .nav-icon {
                width: 36px;
                height: 36px;
            }
            
            .nav-icon i {
                font-size: 1rem;
            }
            
            .table-info {
                width: 16px;
                height: 16px;
                font-size: 0.65rem;
            }
        }
        
        .nav-icon.table-icon {
            background: rgba(139, 92, 246, 0.1);
            border-color: rgba(139, 92, 246, 0.2);
        }
        
        .nav-icon.table-icon:hover {
            background: rgba(139, 92, 246, 0.2);
            border-color: rgba(139, 92, 246, 0.3);
        }
        
        .nav-icon.table-icon i {
            color: #8B5CF6;
        }
        
        .nav-icon.status-icon {
            background: rgba(34, 197, 94, 0.1);
            border-color: rgba(34, 197, 94, 0.2);
        }
        
        .nav-icon.status-icon:hover {
            background: rgba(34, 197, 94, 0.2);
            border-color: rgba(34, 197, 94, 0.3);
        }
        
        .nav-icon.status-icon i {
            color: #22C55E;
        }
        
        .menu-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #EF4444;
            width: 20px;
            height: 20px;
            font-size: 0.75rem;
            border: 2px solid #0f172a;
        }

        @media (max-width: 768px) {
            /* Remove the code that makes navbar position absolute on mobile */
            /* Prevent scrolling when mobile menu is active */
            body.mobile-menu-active {
                overflow: hidden;
                position: fixed;
                width: 100%;
            }
        }

        .navbar-scrolled {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
            height: 100vh;
            overflow-y: auto;
        }

        .mobile-menu.active {
            transform: translateX(0);
        }

        /* Modal Styles - Add class for body when modal is active */
        .body-modal-open {
            overflow: hidden;
            position: fixed;
            width: 100%;
            height: 100%;
        }

        /* Cart Modal Styles */
        .cart-modal-content {
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            margin: 1rem;
            max-width: 42rem;
            width: 100%;
        }

        .cart-items-container {
            flex: 1;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #475569 #1e293b;
            max-height: calc(90vh - 13rem);
            padding: 1rem;
        }

        .cart-items-container::-webkit-scrollbar {
            width: 4px;
        }

        .cart-items-container::-webkit-scrollbar-track {
            background: #1e293b;
            border-radius: 2px;
        }

        .cart-items-container::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 2px;
        }

        .cart-items-container::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        .cart-summary {
            position: sticky;
            bottom: 0;
            background: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem;
            margin-top: auto;
            border-radius: 0 0 1rem 1rem;
        }

        /* Order Status Modal Styles */
        .status-modal-content {
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            margin: 1rem;
            max-width: 42rem;
            width: 100%;
        }

        .status-items-container {
            flex: 1;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #475569 #1e293b;
            max-height: calc(90vh - 10rem);
            padding: 1rem;
        }

        .status-items-container::-webkit-scrollbar {
            width: 4px;
        }

        .status-items-container::-webkit-scrollbar-track {
            background: #1e293b;
            border-radius: 2px;
        }

        .status-items-container::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 2px;
        }

        .status-items-container::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        @media (max-width: 768px) {
            .cart-modal-content,
            .status-modal-content {
                height: 100vh;
                max-height: 100vh;
                margin: 0;
                border-radius: 0;
            }

            .cart-items-container {
                max-height: calc(100vh - 15rem);
                padding: 1rem;
            }

            .status-items-container {
                max-height: calc(100vh - 12rem);
                padding: 1rem;
            }

            .cart-summary {
                padding: 1rem;
                padding-bottom: calc(1rem + env(safe-area-inset-bottom));
                border-radius: 0;
            }

            /* Improve mobile modal headers */
            .modal-header {
                position: sticky;
                top: 0;
                background: rgba(30, 41, 59, 0.95);
                backdrop-filter: blur(10px);
                z-index: 10;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }
        }

        /* Modal Animation and Transition */
        .modal-slide-up {
            animation: slideUp 0.3s ease-out;
        }
        
        .modal-slide-down {
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        @keyframes slideDown {
            from {
                transform: translateY(0);
                opacity: 1;
            }
            to {
                transform: translateY(100%);
                opacity: 0;
            }
        }

        /* Status Item Styles */
        .status-item {
            background: rgba(30, 41, 59, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            opacity: 1;
            transform: translateY(0);
        }

        .status-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Cart Item Styles */
        .cart-item {
            background: rgba(30, 41, 59, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 0.75rem;
            transition: all 0.3s ease;
        }

        .cart-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Cart and Status Modal Close Animation */
        .modal-close {
            transition: all 0.3s ease-in-out;
        }
        
        .modal-close.closing {
            transform: translateY(100%);
            opacity: 0;
        }
        
        @media (min-width: 768px) {
            .modal-close.closing {
                transform: translateY(2rem);
                opacity: 0;
            }
        }

        /* Modal Background Transition */
        .modal-backdrop {
            transition: background-color 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-900 min-h-screen">
    <!-- Navbar -->
    <nav class="navbar-container">
        <div class="glass-effect">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo and Brand -->
                    <div class="flex items-center">
                        <div class="bg-blue-600 p-2 rounded-lg mr-2 sm:mr-3">
                            <i class="fas fa-utensils text-white text-xl sm:text-2xl"></i>
                        </div>
                        <h1 class="text-lg sm:text-xl font-bold text-white truncate">Digital Menu</h1>
                    </div>

                    <!-- Navigation Icons -->
                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <button type="disabled" class="nav-icon table-icon group relative" 
                                title="Meja {{ $table->number }} ({{ $table->capacity }} Orang)">
                            <i class="fas fa-chair"></i>
                            <div class="table-info">
                                <span class="table-number">{{ $table->number }}</span>
                            </div>
                            <!-- Tooltip -->
                            <div class="tooltip-content">
                                <div class="text-sm font-medium">Meja {{ $table->number }}</div>
                                <div class="text-xs text-gray-300">Kapasitas: {{ $table->capacity }} Orang</div>
                            </div>
                        </button>
                        <button id="cartBtn" class="nav-icon" title="Keranjang">
                            <i class="fas fa-shopping-cart"></i>
                            <span id="cartCount" class="menu-badge hidden">0</span>
                        </button>
                        @if($activeOrder)
                        <button id="orderStatusBtn" class="nav-icon status-icon" title="Status Pesanan">
                            <i class="fas fa-clock"></i>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </nav>
    
    <main class="container mx-auto px-4 pt-20 pb-8">
        <!-- Category Filter -->
        <div class="category-filter mb-8 overflow-x-auto pb-2">
            <div class="flex space-x-3 min-w-max">
                <button data-category="all" class="category-btn btn-primary text-white px-6 py-2.5 rounded-lg text-sm font-medium">
                    <i class="fas fa-th-large mr-2"></i>Semua
                </button>
                @foreach($categories as $category)
                <button data-category="{{ $category->id }}" class="category-btn btn-secondary text-white px-6 py-2.5 rounded-lg text-sm font-medium">
                    <i class="fas fa-{{ $category->icon ?? 'tag' }} mr-2"></i>{{ $category->name }}
                </button>
                @endforeach
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($categories as $category)
                @foreach($category->products as $product)
                <div data-category="{{ $category->id }}" class="product-card card rounded-xl shadow-lg overflow-hidden group">
                    <div class="relative h-48 overflow-hidden">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-700 to-gray-800">
                            <i class="fas {{ $product->type == 'food' ? 'fa-utensils' : 'fa-mug-hot' }} text-4xl text-gray-400"></i>
                        </div>
                        @endif
                        <div class="absolute top-3 right-3">
                            <span class="bg-{{ $product->type == 'food' ? 'green' : 'yellow' }}-600 py-1.5 px-3 rounded-full text-xs font-medium shadow-lg">
                                {{ $product->type == 'food' ? 'Makanan' : 'Minuman' }}
                            </span>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold text-white">{{ $product->name }}</h3>
                            <span class="text-sm text-gray-400">{{ $category->name }}</span>
                        </div>
                        <p class="text-blue-400 font-bold text-xl mb-4">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                        <button 
                            class="add-to-cart w-full btn-primary text-white py-2.5 rounded-lg transition-all duration-300 flex items-center justify-center group"
                            data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-price="{{ $product->price }}"
                            data-type="{{ $product->type }}"
                        >
                            <i class="fas fa-plus mr-2"></i>
                            <span>Tambah ke Keranjang</span>
                        </button>
                    </div>
                </div>
                @endforeach
            @endforeach
        </div>
        
        <!-- Empty State -->
        <div id="emptyState" class="hidden text-center py-20">
            <div class="bg-gray-800 rounded-2xl p-8 max-w-md mx-auto">
            <i class="fas fa-search text-gray-500 text-5xl mb-4"></i>
                <h3 class="text-xl font-semibold mb-2 text-white">Tidak ada menu ditemukan</h3>
                <p class="text-gray-400 mb-6">Coba pilih kategori lain atau cari menu lainnya</p>
                <button class="btn-secondary text-white px-6 py-2.5 rounded-lg">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                </button>
            </div>
        </div>
    </main>
    
    <!-- Cart Modal -->
    <div id="cartModal" class="fixed inset-0 z-50 overflow-hidden bg-black/80 backdrop-blur-sm flex justify-center items-end md:items-center hidden modal-backdrop">
        <div class="glass-effect w-full md:max-w-lg rounded-t-2xl md:rounded-2xl shadow-xl cart-modal-content modal-slide-up modal-close">
            <div class="modal-header border-b border-gray-700/50 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-white flex items-center">
                        <i class="fas fa-shopping-cart mr-3"></i>
                        Keranjang Pesanan
                    </h3>
                    <button id="closeCartBtn" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div id="cartItems" class="cart-items-container">
                <!-- Cart items will be added here -->
            </div>
            <div class="cart-summary">
                <div class="flex justify-between font-semibold text-lg mb-4">
                    <span class="text-white">Total:</span>
                    <span id="cartTotal" class="text-blue-400">Rp0</span>
                </div>
                <div class="mb-4">
                    <label for="orderNotes" class="block text-sm font-medium mb-2 text-gray-300">Catatan Pesanan:</label>
                    <textarea id="orderNotes" rows="2" class="w-full px-4 py-3 text-white bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none" placeholder="Tambahkan catatan untuk pesanan Anda..."></textarea>
                </div>
                <button id="placeOrderBtn" class="w-full btn-primary text-white py-3 rounded-lg font-medium shadow-lg">
                    <i class="fas fa-check mr-2"></i>Pesan Sekarang
                </button>
            </div>
        </div>
    </div>
    
    <!-- Order Confirmation Modal -->
    <div id="confirmationModal" class="fixed inset-0 z-50 overflow-auto bg-black/80 backdrop-blur-sm flex justify-center items-center hidden">
        <div class="glass-effect w-full max-w-md mx-4 rounded-2xl shadow-xl p-8">
            <div class="text-center">
                <div class="bg-green-500/20 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-check-circle text-green-500 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold mb-2 text-white">Pesanan Berhasil!</h3>
                <p class="text-gray-400 mb-6">Pesanan Anda telah diterima dan sedang diproses.</p>
                <button id="closeConfirmationBtn" class="w-full btn-primary text-white py-3 rounded-lg font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Menu
                </button>
            </div>
        </div>
    </div>
    
    <!-- Order Status Modal -->
    <div id="orderStatusModal" class="fixed inset-0 z-50 overflow-hidden bg-black/80 backdrop-blur-sm flex justify-center items-end md:items-center hidden modal-backdrop">
        <div class="glass-effect w-full md:max-w-lg rounded-t-2xl md:rounded-2xl shadow-xl status-modal-content modal-slide-up modal-close">
            <div class="modal-header border-b border-gray-700/50 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-white flex items-center">
                        <i class="fas fa-clock mr-3"></i>
                        Status Pesanan
                    </h3>
                    <button id="closeStatusBtn" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="px-6 py-4">
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="font-medium text-white">Status:</span>
                        <span id="orderStatusBadge" class="bg-yellow-600 py-1.5 px-4 rounded-lg text-sm font-medium shadow-lg">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Menunggu
                        </span>
                    </div>
                    <div class="w-full bg-gray-700 rounded-full h-3 shadow-inner overflow-hidden">
                        <div id="orderStatusProgress" class="bg-blue-600 h-3 rounded-full transition-all duration-500 shadow-lg" style="width: 25%"></div>
                    </div>
                </div>
            </div>
            <div id="orderStatusItems" class="status-items-container">
                    <!-- Status items will be added here -->
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
            const cart = [];
            let activeOrder = null;
            
            // Navbar scroll effect
            $(window).scroll(function() {
                if ($(this).scrollTop() > 0) {
                    $('.navbar-container').addClass('navbar-scrolled');
                } else {
                    $('.navbar-container').removeClass('navbar-scrolled');
                }
            });

            // Sync cart count between desktop and mobile
            function updateCartCount() {
                const count = cart.reduce((total, item) => total + item.quantity, 0);
                
                if (count > 0) {
                    $('#cartCount').text(count).removeClass('hidden').addClass('animate-bounce');
                    setTimeout(() => {
                        $('#cartCount').removeClass('animate-bounce');
                    }, 1000);
                } else {
                    $('#cartCount').text(0).addClass('hidden');
                }
            }
            
            // Check if there's an active order
            @if($activeOrder)
                activeOrder = {
                    id: '{{ $activeOrder->id }}',
                    status: '{{ $activeOrder->status }}'
                };
                checkOrderStatus();
                
                // Handle click events for both desktop and mobile status buttons
                $('#orderStatusBtn').on('click', function() {
                    $('#orderStatusModal').removeClass('hidden').addClass('animate-fade-in');
                    $('body').addClass('body-modal-open');
                    updateOrderStatus();
                });
            @endif
            
            // Filter products by category with animation
            $('.category-btn').on('click', function() {
                $('.category-btn').removeClass('btn-primary').addClass('btn-secondary');
                $(this).removeClass('btn-secondary').addClass('btn-primary');
                
                const category = $(this).data('category');
                
                if (category === 'all') {
                    $('.product-card').fadeIn(300);
                } else {
                    $('.product-card').fadeOut(300);
                    $('.product-card[data-category="' + category + '"]').fadeIn(300);
                }
                
                // Check if there are visible products
                if ($('.product-card:visible').length === 0) {
                    $('#emptyState').fadeIn(300);
                } else {
                    $('#emptyState').fadeOut(300);
                }
            });
            
            // Add to cart with animation
            $('.add-to-cart').on('click', function() {
                const productId = $(this).data('id');
                const productName = $(this).data('name');
                const productPrice = $(this).data('price');
                const productType = $(this).data('type');
                
                // Check if product already in cart
                const existingItem = cart.find(item => item.product_id === productId);
                
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({
                        product_id: productId,
                        name: productName,
                        price: productPrice,
                        type: productType,
                        quantity: 1,
                        notes: ''
                    });
                }
                
                updateCartCount();
                
                // Show success animation
                const $btn = $(this);
                $btn.html('<i class="fas fa-check mr-2"></i><span>Ditambahkan</span>')
                    .removeClass('btn-primary')
                    .addClass('bg-green-600 hover:bg-green-700');
                
                setTimeout(() => {
                    $btn.html('<i class="fas fa-plus mr-2"></i><span>Tambah ke Keranjang</span>')
                        .removeClass('bg-green-600 hover:bg-green-700')
                        .addClass('btn-primary');
                }, 1500);
            });
            
            // Cart button with animation
            $('#cartBtn').on('click', function() {
                if (cart.length === 0) {
                    showToast('Keranjang belanja kosong. Silakan tambahkan menu terlebih dahulu.');
                    return;
                }
                
                renderCart();
                $('#cartModal').removeClass('hidden').addClass('animate-fade-in');
                $('body').addClass('body-modal-open');
            });
            
            // Close modals with animation
            $('#closeCartBtn, #closeConfirmationBtn, #closeStatusBtn').on('click', function() {
                const $modal = $(this).closest('.fixed');
                const $modalContent = $(this).closest('.modal-close');
                
                // Add closing animation class
                $modalContent.addClass('closing');
                $modal.css('background-color', 'rgba(0, 0, 0, 0)');
                
                // Animate background fade out
                $modal.css('background-color', 'rgba(0, 0, 0, 0)');
                $modal.css('backdrop-filter', 'blur(0px)');
                
                // Animate content slide down
                $modalContent
                    .removeClass('modal-slide-up')
                    .addClass('modal-slide-down');
                
                // Remove modal after animation completes
                setTimeout(() => {
                    $modal.addClass('hidden');
                    $modalContent
                        .removeClass('modal-slide-down closing')
                        .addClass('modal-slide-up');
                    $modal.css({
                        'background-color': 'rgba(0, 0, 0, 0.8)',
                        'backdrop-filter': 'blur(10px)'
                    });
                    $('body').removeClass('body-modal-open');
                }, 300);
            });
            
            // Place order with loading state
            $('#placeOrderBtn').on('click', function() {
                if (cart.length === 0) {
                    showToast('Keranjang belanja kosong. Silakan tambahkan menu terlebih dahulu.');
                    return;
                }
                
                const $btn = $(this);
                $btn.prop('disabled', true)
                    .html('<i class="fas fa-spinner fa-spin mr-2"></i><span>Memproses...</span>');
                
                const orderItems = cart.map(item => ({
                    product_id: item.product_id,
                    quantity: item.quantity,
                    notes: item.notes
                }));
                
                $.ajax({
                    url: '{{ route("menu.placeOrder", $table->barcode) }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        items: orderItems,
                        notes: $('#orderNotes').val()
                    },
                    success: handleOrderSuccess,
                    error: function(xhr) {
                        showToast('Terjadi kesalahan. Silakan coba lagi.');
                        $btn.prop('disabled', false)
                            .html('<i class="fas fa-check mr-2"></i><span>Pesan Sekarang</span>');
                    }
                });
            });
            
            // Helper functions
            function renderCart() {
                const cartContainer = $('#cartItems');
                cartContainer.empty();
                
                if (cart.length === 0) {
                    cartContainer.html(`
                        <div class="text-center py-8">
                            <i class="fas fa-shopping-cart text-gray-500 text-4xl mb-4"></i>
                            <p class="text-gray-400">Keranjang kosong</p>
                        </div>
                    `);
                    $('#cartTotal').text('Rp0');
                    return;
                }
                
                let total = 0;
                
                cart.forEach((item, index) => {
                    const itemTotal = item.price * item.quantity;
                    total += itemTotal;
                    
                    const itemElement = `
                        <div class="flex justify-between items-start mb-4 pb-4 border-b border-gray-700/50 animate-fade-in">
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <span class="font-semibold text-white">${item.name}</span>
                                    <span class="ml-2 text-xs bg-${item.type === 'food' ? 'green' : 'yellow'}-600 py-1 px-2 rounded-full">
                                        ${item.type === 'food' ? 'Makanan' : 'Minuman'}
                                    </span>
                                </div>
                                <p class="text-blue-400">Rp${item.price.toLocaleString('id-ID')}</p>
                                <div class="mt-2">
                                    <input type="text" class="item-note w-full b bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-sm text-white placeholder-white-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                        placeholder="Catatan untuk item ini..." 
                                        value="${item.notes}" 
                                        data-index="${index}">
                                </div>
                            </div>
                            <div class="flex items-center ml-4">
                                <button class="decrement-item bg-gray-700/50 hover:bg-gray-600 text-white w-8 h-8 rounded-l-lg flex items-center justify-center transition-colors" data-index="${index}">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <span class="bg-gray-700/50 text-white w-10 h-8 flex items-center justify-center">${item.quantity}</span>
                                <button class="increment-item bg-gray-700/50 hover:bg-gray-600 text-white w-8 h-8 rounded-r-lg flex items-center justify-center transition-colors" data-index="${index}">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button class="remove-item ml-2 bg-red-600/50 hover:bg-red-700 text-white w-8 h-8 rounded-lg flex items-center justify-center transition-colors" data-index="${index}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    `;
                    
                    cartContainer.append(itemElement);
                });
                
                $('#cartTotal').text('Rp' + total.toLocaleString('id-ID'));
                
                // Setup event handlers for cart items
                $('.increment-item').on('click', function() {
                    const index = $(this).data('index');
                    cart[index].quantity += 1;
                    renderCart();
                    updateCartCount();
                });
                
                $('.decrement-item').on('click', function() {
                    const index = $(this).data('index');
                    if (cart[index].quantity > 1) {
                        cart[index].quantity -= 1;
                        renderCart();
                        updateCartCount();
                    }
                });
                
                $('.remove-item').on('click', function() {
                    const index = $(this).data('index');
                    $(this).closest('.animate-fade-in').addClass('animate-fade-out');
                    setTimeout(() => {
                    cart.splice(index, 1);
                    renderCart();
                    updateCartCount();
                    }, 300);
                });
                
                $('.item-note').on('change', function() {
                    const index = $(this).data('index');
                    cart[index].notes = $(this).val();
                });
            }
            
            function checkOrderStatus() {
                if (!activeOrder) return;
                
                updateOrderStatus();
                
                // Set interval to check status periodically
                setInterval(updateOrderStatus, 30000); // every 30 seconds
            }
            
            function updateOrderStatus() {
                $.ajax({
                    url: '{{ route("menu.status", $table->barcode) }}',
                    method: 'GET',
                    success: function(response) {
                        if (response.status === 'no_order') {
                            activeOrder = null;
                            $('#orderStatusBtn').fadeOut(300, function() {
                                $(this).remove();
                            });
                            return;
                        }
                        
                        const order = response.order;
                        const items = response.items;
                        
                        // Update progress bar with animation
                        let progress = 25;
                        let statusText = '<i class="fas fa-spinner fa-spin mr-2"></i>Menunggu';
                        let statusClass = 'bg-yellow-600';
                        
                        if (order.status === 'processing') {
                            progress = 50;
                            statusText = '<i class="fas fa-cog fa-spin mr-2"></i>Diproses';
                            statusClass = 'bg-blue-600';
                        } else if (order.status === 'completed') {
                            progress = 100;
                            statusText = '<i class="fas fa-check mr-2"></i>Selesai';
                            statusClass = 'bg-green-600';
                        } else if (order.status === 'cancelled') {
                            progress = 100;
                            statusText = '<i class="fas fa-times mr-2"></i>Dibatalkan';
                            statusClass = 'bg-red-600';
                        }
                        
                        $('#orderStatusProgress').css('width', progress + '%');
                        $('#orderStatusBadge')
                            .removeClass('bg-yellow-600 bg-blue-600 bg-green-600 bg-red-600')
                            .addClass(statusClass)
                            .html(statusText);
                        
                        // Update items with animation
                        const statusContainer = $('#orderStatusItems');
                        statusContainer.empty();
                        
                        items.forEach(item => {
                            let itemStatus = '';
                            let itemStatusClass = '';
                            let itemIcon = '';
                            
                            switch(item.status) {
                                case 'pending':
                                    itemStatus = 'Menunggu';
                                    itemStatusClass = 'bg-yellow-600';
                                    itemIcon = 'fa-spinner fa-spin';
                                    break;
                                case 'preparing':
                                    itemStatus = 'Dimasak';
                                    itemStatusClass = 'bg-blue-600';
                                    itemIcon = 'fa-fire';
                                    break;
                                case 'ready':
                                    itemStatus = 'Siap';
                                    itemStatusClass = 'bg-green-600';
                                    itemIcon = 'fa-check';
                                    break;
                                case 'served':
                                    itemStatus = 'Disajikan';
                                    itemStatusClass = 'bg-indigo-600';
                                    itemIcon = 'fa-utensils';
                                    break;
                                case 'cancelled':
                                    itemStatus = 'Dibatalkan';
                                    itemStatusClass = 'bg-red-600';
                                    itemIcon = 'fa-times';
                                    break;
                            }
                            
                            const itemElement = `
                                <div class="status-item p-4 rounded-lg mb-4 animate-fade-in">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-2">
                                                <span class="font-medium text-white text-lg">${item.product.name}</span>
                                                <span class="ml-2 text-xs bg-gray-700 py-1 px-2 rounded-lg text-gray-300">
                                                    x${item.quantity}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-400">
                                                ${item.notes ? item.notes : 'Tidak ada catatan'}
                                            </p>
                                        </div>
                                        <span class="${itemStatusClass} py-2 px-4 rounded-lg text-sm font-medium shadow-lg ml-4 flex items-center">
                                            <i class="fas ${itemIcon} mr-2"></i>
                                            ${itemStatus}
                                        </span>
                                    </div>
                                </div>
                            `;
                            
                            statusContainer.append(itemElement);
                        });
                        
                        // If order is completed, replace status button with new order button
                        if (order.status === 'completed' || order.status === 'cancelled') {
                            $('#orderStatusBtn').fadeOut(300, function() {
                                $(this).replaceWith(`
                                    <button id="newOrderBtn" class="ml-2 btn-primary text-white px-4 py-2 rounded-lg font-medium animate-fade-in shadow-lg">
                                        <i class="fas fa-plus mr-2"></i>Pesan Baru
                                    </button>
                                `);
                            
                            $('#newOrderBtn').on('click', function() {
                                activeOrder = null;
                                location.reload();
                                });
                            });
                        }
                    }
                });
            }

            function showToast(message) {
                const toast = $(`
                    <div class="fixed bottom-4 right-4 bg-gray-800 text-white px-6 py-3 rounded-lg shadow-lg animate-fade-in z-50">
                        <i class="fas fa-exclamation-circle mr-2"></i>${message}
                    </div>
                `);
                
                $('body').append(toast);
                
                setTimeout(() => {
                    toast.removeClass('animate-fade-in').addClass('animate-fade-out');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }, 3000);
            }

            // Update place order success handler
            function handleOrderSuccess(response) {
                $('#cartModal').removeClass('animate-fade-in').addClass('animate-fade-out');
                setTimeout(() => {
                    $('#cartModal').addClass('hidden').removeClass('animate-fade-out');
                    $('#confirmationModal').removeClass('hidden').addClass('animate-fade-in');
                }, 300);
                
                // Reset cart
                cart.length = 0;
                updateCartCount();
                
                // Set active order
                activeOrder = {
                    id: response.order,
                    status: 'pending'
                };
                
                // Show order status button if not exists
                if ($('#orderStatusBtn').length === 0) {
                    location.reload();
                }
            }
        });
    </script>
</body>
</html> 