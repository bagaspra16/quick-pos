<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Quick POS') }} - @yield('title', 'Dashboard')</title>
    
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            background-color: #0f172a;
            color: #f1f5f9;
            height: 100vh;
            overflow: hidden;
            font-family: 'Poppins', sans-serif;
        }
        
        .sidebar {
            background-color: #1e293b;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 16rem;
            overflow-y: auto;
            z-index: 40;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .navbar {
            background-color: #1e293b;
            position: fixed;
            top: 0;
            right: 0;
            left: 16rem;
            height: 4rem;
            z-index: 30;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            border-bottom: 1px solid #334155;
        }
        
        .navbar-left {
            display: flex;
            align-items: center;
        }
        
        .page-title {
            font-weight: 600;
            font-size: 1.25rem;
            letter-spacing: 0.5px;
            color: white;
            display: flex;
            align-items: center;
        }
        
        .page-title i {
            margin-right: 0.5rem;
            font-size: 1.1em;
            color: #3b82f6;
        }
        
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 0.625rem;
            background-color: rgba(51, 65, 85, 0.7);
            border-radius: 0.375rem;
            transition: all 0.2s ease;
            cursor: pointer;
            border: 1px solid rgba(71, 85, 105, 0.3);
            height: 2.5rem;
            position: relative;
        }
        
        .user-info:hover {
            background-color: rgba(71, 85, 105, 0.8);
            border-color: rgba(100, 116, 139, 0.4);
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        }
        
        .user-info:active {
            transform: translateY(0);
            box-shadow: none;
        }
        
        .user-info button {
            transition: all 0.2s ease;
            padding: 0;
            height: 100%;
            display: flex;
            align-items: center;
            background: transparent;
            border: none;
            outline: none;
            width: 100%;
        }
        
        #profileArrow {
            transition: transform 0.25s ease;
            margin-left: 0.25rem;
            font-size: 0.65rem;
            opacity: 0.7;
            color: #94a3b8;
        }
        
        .rotate-180 {
            transform: rotate(180deg);
        }
        
        .user-avatar {
            width: 1.75rem;
            height: 1.75rem;
            border-radius: 50%;
            background-color: #3b82f6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            text-transform: uppercase;
            font-size: 0.85rem;
            flex-shrink: 0;
        }
        
        .user-details {
            display: flex;
            flex-direction: column;
            max-width: 120px;
            overflow: hidden;
        }
        
        .user-name {
            font-weight: 500;
            line-height: 1;
            font-size: 0.875rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .user-role {
            font-size: 0.625rem;
            color: #cbd5e1;
            background-color: rgba(71, 85, 105, 0.7);
            padding: 0 0.375rem;
            border-radius: 3px;
            text-transform: capitalize;
            white-space: nowrap;
            margin-top: 1px;
        }
        
        .navbar-action {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .action-button {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background-color: #334155;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.2s ease;
        }
        
        .action-button:hover {
            background-color: #475569;
            transform: translateY(-2px);
        }
        
        .main-content {
            margin-left: 16rem;
            margin-top: 4rem;
            margin-bottom: 3.5rem;
            overflow-y: auto;
            height: calc(100vh - 7.5rem);
            padding: 1.5rem;
        }
        
        .footer {
            background-color: #1e293b;
            position: fixed;
            bottom: 0;
            left: 16rem;
            right: 0;
            padding: 1rem;
            text-align: center;
            border-top: 1px solid #334155;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
            height: 3.5rem;
            z-index: 30;
        }
        
        .content {
            background-color: #1e293b;
        }
        
        .btn-primary {
            background-color: #0284c7;
        }
        
        .btn-primary:hover {
            background-color: #0369a1;
        }
        
        .card {
            background-color: #1e293b;
            border: 1px solid #334155;
        }
        
        table {
            background-color: #1e293b;
            color: #f8fafc;
        }
        
        th {
            background-color: #334155;
        }
        
        .pagination li a {
            background-color: #334155;
            color: #f1f5f9;
        }
        
        .pagination li.active span {
            background-color: #0284c7;
            color: #f1f5f9;
        }
        
        /* Sembunyikan scrollbar tapi tetap bisa scroll */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        /* Notifications Dropdown Styles */
        .notification-dropdown {
            position: absolute;
            top: 3.5rem;
            right: 1rem;
            width: 320px;
            background-color: #1e293b;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border: 1px solid #334155;
            z-index: 50;
            visibility: hidden;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
        }

        .notification-dropdown.show {
            visibility: visible;
            opacity: 1;
            transform: translateY(0);
        }

        .notification-item {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #334155;
            cursor: pointer;
            transition: background-color 0.2s ease;
            position: relative;
        }

        .notification-item:hover {
            background-color: #334155;
        }
        
        .notification-content {
            display: flex;
            width: 100%;
        }
        
        .notification-wrapper {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            width: 100%;
            position: relative;
            padding-right: 5px;
        }

        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #334155;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ef4444;
            color: white;
            border-radius: 9999px;
            font-size: 0.75rem;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Close button styles */
        .close-notification {
            border-radius: 50%;
            width: 26px;
            height: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            background-color: rgba(255, 255, 255, 0.1);
            opacity: 0;
            margin-left: 5px;
            flex-shrink: 0;
            position: relative;
            cursor: pointer;
            z-index: 10;
        }
        
        .notification-item:hover .close-notification {
            opacity: 1;
        }
        
        .close-notification:hover {
            background-color: rgba(239, 68, 68, 0.2);
            transform: scale(1.1);
            color: #ef4444;
            box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.1);
        }
        
        .close-notification:active {
            transform: scale(0.95);
        }
        
        /* Clear all button */
        #clearAllNotifications {
            padding: 3px 8px;
            border-radius: 4px;
            transition: all 0.2s ease;
            background-color: rgba(59, 130, 246, 0.1);
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }
        
        #clearAllNotifications:hover {
            background-color: rgba(59, 130, 246, 0.2);
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        #clearAllNotifications:active {
            transform: translateY(0);
            box-shadow: none;
        }
        
        .notification-count {
            background-color: rgba(59, 130, 246, 0.1);
            border-radius: 4px;
            padding: 1px 6px;
            font-weight: 600;
        }
        
        /* Modal Styles */
        .modal-backdrop {
            transition: opacity 0.3s ease;
        }
        
        #modalContent {
            transition: all 0.3s ease;
        }
        
        .scale-95 {
            transform: scale(0.95);
        }
        
        .scale-100 {
            transform: scale(1);
        }
        
        .opacity-0 {
            opacity: 0;
        }
        
        .opacity-100 {
            opacity: 1;
        }
        
        #logoutModal {
            transition: visibility 0.3s, opacity 0.3s;
        }
        
        /* User profile dropdown styling - updated to match notification style */
        #userDropdown {
            position: absolute;
            top: 3.5rem;
            right: 0;
            width: 300px;
            background-color: #1e293b;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border: 1px solid #334155;
            z-index: 50;
            visibility: hidden;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        #userDropdown.show {
            visibility: visible;
            opacity: 1;
            transform: translateY(0);
        }
        
        .profile-dropdown-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #334155;
        }
        
        .profile-dropdown-header h3 {
            font-weight: 600;
            font-size: 1rem;
            color: white;
            display: flex;
            align-items: center;
        }
        
        .profile-dropdown-header h3 i {
            margin-right: 0.5rem;
            color: #3b82f6;
        }
        
        .profile-dropdown-item {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #334155;
            display: flex;
            align-items: center;
            transition: background-color 0.2s ease;
            cursor: pointer;
        }
        
        .profile-dropdown-item:last-child {
            border-bottom: none;
        }
        
        .profile-dropdown-item:hover {
            background-color: #334155;
        }
        
        .profile-dropdown-item i {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            transition: transform 0.2s ease;
            flex-shrink: 0;
        }
        
        .profile-dropdown-item:hover i {
            transform: translateX(2px);
        }
        
        .profile-item-content {
            display: flex;
            flex-direction: column;
        }
        
        .profile-item-content span:first-child {
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .profile-item-content span:last-child {
            font-size: 0.75rem;
            color: #94a3b8;
            margin-top: 2px;
        }
        
        .profile-dropdown-item.profile i {
            background-color: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }
        
        .profile-dropdown-item.edit i {
            background-color: rgba(34, 197, 94, 0.1);
            color: #22c55e;
        }
        
        .profile-dropdown-item.password i {
            background-color: rgba(168, 85, 247, 0.1);
            color: #a855f7;
        }
        
        .profile-dropdown-item.logout i {
            background-color: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }
        
        .profile-dropdown-item.logout {
            background-color: rgba(239, 68, 68, 0.05);
        }
        
        .profile-dropdown-item.logout:hover {
            background-color: rgba(239, 68, 68, 0.1);
        }
        
        .profile-dropdown-item.logout .profile-item-content span:first-child {
            color: #ef4444;
        }
        
        .profile-avatar-wrapper {
            display: flex;
            padding: 1rem;
            background-color: #2d3748;
            border-bottom: 1px solid #334155;
            align-items: center;
        }
        
        .profile-avatar-large {
            width: 3.5rem;
            height: 3.5rem;
            background-color: #3b82f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: 600;
            margin-right: 1rem;
            flex-shrink: 0;
        }
        
        .profile-info {
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        
        .profile-info-name {
            font-weight: 600;
            font-size: 1.1rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .profile-info-role {
            display: inline-block;
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
            background-color: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            border-radius: 4px;
            margin-top: 0.25rem;
            text-transform: capitalize;
        }
        
        /* Additional refinements for user profile dropdown */
        .profile-dropdown-footer {
            padding: 0.75rem 1rem;
            background-color: #2d3748;
            border-top: 1px solid #334155;
            text-align: center;
            font-size: 0.75rem;
            color: #94a3b8;
        }
        
        .profile-dropdown-footer a {
            color: #3b82f6;
            transition: color 0.2s ease;
        }
        
        .profile-dropdown-footer a:hover {
            color: #60a5fa;
            text-decoration: underline;
        }
        
        .profile-action-btn {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            background-color: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            font-size: 0.75rem;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }
        
        .profile-action-btn:hover {
            background-color: rgba(59, 130, 246, 0.2);
            transform: translateY(-1px);
        }
        
        .profile-action-btn:active {
            transform: translateY(0);
        }
        
        .online-status {
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 50%;
            background-color: #10b981;
            margin-left: 0.25rem;
            position: relative;
        }
        
        .online-status::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: #10b981;
            animation: pulse 1.5s infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }
            70% {
                transform: scale(2);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 0;
            }
        }
        
        .profile-dropdown-item .action-icon {
            margin-left: auto;
            color: #94a3b8;
            opacity: 0;
            transition: all 0.2s ease;
            font-size: 0.75rem;
        }
        
        .profile-dropdown-item:hover .action-icon {
            opacity: 1;
            transform: translateX(0);
        }
    </style>
    
    @yield('styles')
</head>
<body class="min-h-screen bg-gray-900 text-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @auth
        <div class="sidebar hide-scrollbar">
            <div class="flex items-center justify-center space-x-2 px-4 py-6">
                <i class="fas fa-cash-register text-blue-500 text-3xl"></i>
                <span class="text-xl font-bold">Quick POS</span>
            </div>
            
            <nav class="mt-6 px-2">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('tables.index') }}" class="flex items-center space-x-2 mt-3 py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('tables.*') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                    <i class="fas fa-chair"></i>
                    <span>Meja</span>
                </a>
                
                <a href="{{ route('products.index') }}" class="flex items-center space-x-2 mt-3 py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('products.*') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                    <i class="fas fa-utensils"></i>
                    <span>Produk</span>
                </a>
                
                <a href="{{ route('categories.index') }}" class="flex items-center space-x-2 mt-3 py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('categories.*') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                    <i class="fas fa-tags"></i>
                    <span>Kategori</span>
                </a>
                
                <a href="{{ route('orders.index') }}" class="flex items-center space-x-2 mt-3 py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('orders.*') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Pesanan</span>
                </a>
                
                <a href="{{ route('payments.index') }}" class="flex items-center space-x-2 mt-3 py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('payments.*') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Pembayaran</span>
                </a>
            </nav>
        </div>
        @endauth
        
        <!-- Content -->
        <div class="flex-1">
            @auth
            <!-- Navbar -->
            <header class="navbar">
                <div class="navbar-left">
                    <h1 class="page-title">
                        @if(request()->routeIs('dashboard'))
                            <i class="fas fa-chart-line"></i>
                        @elseif(request()->routeIs('tables.*'))
                            <i class="fas fa-chair"></i>
                        @elseif(request()->routeIs('products.*'))
                            <i class="fas fa-utensils"></i>
                        @elseif(request()->routeIs('categories.*'))
                            <i class="fas fa-tags"></i>
                        @elseif(request()->routeIs('orders.*'))
                            <i class="fas fa-clipboard-list"></i>
                        @elseif(request()->routeIs('payments.*'))
                            <i class="fas fa-money-bill-wave"></i>
                        @else
                            <i class="fas fa-bars"></i>
                        @endif
                        @yield('title', 'Dashboard')
                    </h1>
                </div>
                
                <div class="navbar-right">
                    <div class="navbar-action">
                        <div class="relative">
                            <button id="notificationBtn" class="action-button" title="Notifikasi">
                            <i class="fas fa-bell"></i>
                                <span class="notification-badge" style="display: none;">0</span>
                            </button>
                            <div id="notificationDropdown" class="notification-dropdown">
                                <div class="notification-header">
                                    <h3 class="font-semibold">Notifikasi</h3>
                                    <div class="flex items-center">
                                        <span class="text-xs text-gray-400 mr-3"><span class="notification-count text-blue-400">{{ $activeOrdersCount + $activeTablesCount + count($recentOrders) }}</span> baru</span>
                                        <button id="clearAllNotifications" class="text-xs text-blue-400 hover:text-blue-300">
                                            <i class="fas fa-broom mr-1"></i>Clear All
                                        </button>
                                    </div>
                                </div>
                                
                                @if($activeOrdersCount > 0)
                                <a href="{{ route('orders.index') }}" class="block notification-link">
                                    <div class="notification-item">
                                        <div class="notification-wrapper">
                                            <div class="notification-content">
                                                <div class="bg-blue-500/20 p-2 rounded-full mr-3 flex-shrink-0">
                                                    <i class="fas fa-clipboard-list text-blue-500"></i>
                                                </div>
                                                <div>
                                                    <p class="font-medium">Pesanan Aktif</p>
                                                    <p class="text-sm text-gray-400">{{ $activeOrdersCount }} pesanan sedang diproses</p>
                                                </div>
                                            </div>
                                            <button class="close-notification text-gray-400 hover:text-white p-1" data-notification-type="orders">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </a>
                                @endif
                                
                                @if($activeTablesCount > 0)
                                <a href="{{ route('tables.index') }}" class="block notification-link">
                                    <div class="notification-item">
                                        <div class="notification-wrapper">
                                            <div class="notification-content">
                                                <div class="bg-purple-500/20 p-2 rounded-full mr-3 flex-shrink-0">
                                                    <i class="fas fa-chair text-purple-500"></i>
                                                </div>
                                                <div>
                                                    <p class="font-medium">Meja Terpakai</p>
                                                    <p class="text-sm text-gray-400">{{ $activeTablesCount }} meja sedang digunakan</p>
                                                </div>
                                            </div>
                                            <button class="close-notification text-gray-400 hover:text-white p-1" data-notification-type="tables">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </a>
                                @endif
                                
                                @foreach($recentOrders as $order)
                                <a href="{{ route('orders.show', $order) }}" class="block notification-link">
                                    <div class="notification-item">
                                        <div class="notification-wrapper">
                                            <div class="notification-content">
                                                <div class="bg-{{ $order->status == 'pending' ? 'yellow' : ($order->status == 'processing' ? 'blue' : 'green') }}-500/20 p-2 rounded-full mr-3 flex-shrink-0">
                                                    <i class="fas fa-clipboard-check text-{{ $order->status == 'pending' ? 'yellow' : ($order->status == 'processing' ? 'blue' : 'green') }}-500"></i>
                                                </div>
                                                <div>
                                                    <p class="font-medium">Pesanan #{{ substr($order->id, 0, 8) }}</p>
                                                    <p class="text-sm text-gray-400">Meja {{ $order->table->number }} - Status: 
                                                        <span class="text-{{ $order->status == 'pending' ? 'yellow' : ($order->status == 'processing' ? 'blue' : 'green') }}-500">
                                                            {{ $order->status == 'pending' ? 'Menunggu' : ($order->status == 'processing' ? 'Diproses' : 'Selesai') }}
                                                        </span>
                                                    </p>
                                                    <p class="text-xs text-gray-500 mt-1">{{ $order->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                            <button class="close-notification text-gray-400 hover:text-white p-1" data-notification-id="{{ $order->id }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                                
                                <div class="p-2 text-center">
                                    <a href="{{ route('orders.index') }}" class="text-blue-500 hover:text-blue-400 text-sm">Lihat Semua Pesanan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="user-info relative user-dropdown-wrapper">
                        <button id="userProfileBtn" class="flex items-center space-x-2 cursor-pointer focus:outline-none">
                            <div class="user-avatar">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="user-details">
                                <span class="user-name">{{ Auth::user()->name }}</span>
                                <span class="user-role">{{ Auth::user()->role }}</span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 transition-transform" id="profileArrow"></i>
                        </button>
                        
                        <!-- User Profile Dropdown -->
                        <div id="userDropdown" class="hidden">
                            <div class="profile-dropdown-header">
                                <h3><i class="fas fa-user-circle"></i> Akun Saya</h3>
                            </div>
                            
                            <div class="profile-avatar-wrapper">
                                <div class="profile-avatar-large">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="profile-info">
                                    <span class="profile-info-name">{{ Auth::user()->name }} <span class="online-status"></span></span>
                                    <span class="profile-info-role">{{ Auth::user()->role }}</span>                        
                                </div>
                            </div>
                            
                            <a href="{{ route('profile.index') }}" class="profile-dropdown-item profile">
                                <i class="fas fa-user-circle"></i>
                                <div class="profile-item-content">
                                    <span>Profil Saya</span>
                                    <span>Lihat informasi profil Anda</span>
                                </div>
                                <i class="fas fa-chevron-right action-icon"></i>
                            </a>
                            
                            <a href="{{ route('profile.edit') }}" class="profile-dropdown-item edit">
                                <i class="fas fa-edit"></i>
                                <div class="profile-item-content">
                                    <span>Edit Profil</span>
                                    <span>Ubah nama dan email Anda</span>
                                </div>
                                <i class="fas fa-chevron-right action-icon"></i>
                            </a>
                            
                            <a href="{{ route('profile.change-password') }}" class="profile-dropdown-item password">
                                <i class="fas fa-key"></i>
                                <div class="profile-item-content">
                                    <span>Ubah Password</span>
                                    <span>Perbarui password Anda</span>
                                </div>
                                <i class="fas fa-chevron-right action-icon"></i>
                            </a>
                            
                            <a id="logoutBtnDropdown" class="profile-dropdown-item logout">
                                <i class="fas fa-sign-out-alt"></i>
                                <div class="profile-item-content">
                                    <span>Logout</span>
                                    <span>Keluar dari aplikasi</span>
                                </div>
                                <i class="fas fa-chevron-right action-icon"></i>
                            </a>
                            
                            <div class="profile-dropdown-footer">
                                <p>&copy; {{ date('Y') }} Quick POS. <a href="#">Bantuan</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            @endauth
            
            <!-- Main Content -->
            <main class="main-content hide-scrollbar">
                @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-6" id="successAlert">
                    {{ session('success') }}
                </div>
                <script>
                    setTimeout(function() {
                        $('#successAlert').fadeOut('slow');
                    }, 3000);
                </script>
                @endif
                
                @if(session('error'))
                <div class="bg-red-500 text-white p-4 rounded mb-6" id="errorAlert">
                    {{ session('error') }}
                </div>
                <script>
                    setTimeout(function() {
                        $('#errorAlert').fadeOut('slow');
                    }, 5000);
                </script>
                @endif
                
                @yield('content')
            </main>
            
            <!-- Footer fixed di paling bawah -->
            <footer class="footer">
                <p>&copy; {{ date('Y') }} Quick POS. All rights reserved.</p>
            </footer>
        </div>
    </div>
    
    @yield('scripts')
    
    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 hidden backdrop-blur-sm">
        <div class="bg-gray-800 rounded-lg shadow-xl p-6 w-80 border border-gray-700 transform transition-all scale-95 opacity-0" id="modalContent">
            <div class="text-center mb-4">
                <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-sign-out-alt text-red-600 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-white">Konfirmasi Logout</h3>
                <p class="text-sm text-gray-400 mt-2">Apakah Anda yakin ingin keluar dari sistem?</p>
            </div>
            <div class="flex justify-center space-x-4 mt-6">
                <button id="cancelLogout" class="px-4 py-2.5 bg-gray-700 text-white rounded-md hover:bg-gray-600 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium">
                    <i class="fas fa-times mr-1.5"></i>Batal
                </button>
                <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2.5 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 font-medium">
                        <i class="fas fa-sign-out-alt mr-1.5"></i>Ya, Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Add JavaScript for notifications -->
    <script>
        $(document).ready(function() {
            // Modal Logout
            const logoutModal = document.getElementById('logoutModal');
            const modalContent = document.getElementById('modalContent');
            const logoutBtnDropdown = document.getElementById('logoutBtnDropdown');
            const cancelLogout = document.getElementById('cancelLogout');
            
            // Function to open modal
            function openLogoutModal() {
                logoutModal.classList.remove('hidden');
                // Wait a bit for the display block to take effect
                setTimeout(() => {
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                }, 10);
            }
            
            // Function to close modal
            function closeLogoutModal() {
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
                
                // Wait for animation to finish before hiding
                setTimeout(() => {
                    logoutModal.classList.add('hidden');
                }, 200);
            }
            
            // Event listeners
            logoutBtnDropdown.addEventListener('click', openLogoutModal);
            cancelLogout.addEventListener('click', closeLogoutModal);
            
            // Close when clicking outside
            logoutModal.addEventListener('click', function(e) {
                if (e.target === logoutModal) {
                    closeLogoutModal();
                }
            });
            
            // Close with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !logoutModal.classList.contains('hidden')) {
                    closeLogoutModal();
                }
            });
            
            // User Profile Dropdown
            const userProfileBtn = document.getElementById('userProfileBtn');
            const userDropdown = document.getElementById('userDropdown');
            const profileArrow = document.getElementById('profileArrow');
            
            // Toggle profile dropdown
            userProfileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                
                // Toggle visibility
                const isVisible = userDropdown.classList.contains('show');
                
                if (isVisible) {
                    // Close dropdown with animation
                    closeProfileDropdown();
                } else {
                    // Open dropdown with animation
                    openProfileDropdown();
                }
            });
            
            // Function to open profile dropdown
            function openProfileDropdown() {
                // Remove hidden class first
                userDropdown.classList.remove('hidden');
                
                // Add tiny delay for animation
                setTimeout(() => {
                    userDropdown.classList.add('show');
                    profileArrow.classList.add('rotate-180');
                }, 10);
            }
            
            // Function to close profile dropdown
            function closeProfileDropdown() {
                userDropdown.classList.remove('show');
                profileArrow.classList.remove('rotate-180');
                
                // Wait for animation to complete before hiding
                setTimeout(() => {
                    userDropdown.classList.add('hidden');
                }, 300);
            }
            
            // Close profile dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!userProfileBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                    closeProfileDropdown();
                }
            });
            
            // Close with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !userDropdown.classList.contains('hidden')) {
                    closeProfileDropdown();
                }
            });
            
            // Inisialisasi notifikasi saat halaman dimuat
            initializeNotifications();
            
            // Toggle notification dropdown
            $('#notificationBtn').on('click', function(e) {
                e.stopPropagation();
                $('#notificationDropdown').toggleClass('show');
            });
            
            // Close dropdown when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#notificationDropdown, #notificationBtn').length) {
                    $('#notificationDropdown').removeClass('show');
                }
            });
            
            // Use event delegation for close buttons (works with dynamically added elements)
            $(document).on('click', '.close-notification', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const $this = $(this);
                const $notificationItem = $this.closest('.notification-item');
                
                // Get notification type or ID
                const notificationType = $this.data('notification-type');
                const notificationId = $this.data('notification-id');
                
                // Animation to hide the notification
                $notificationItem.fadeOut(300, function() {
                    $(this).closest('a.notification-link').remove();
                    
                    // Update notification badge count
                    updateNotificationCount();
                    
                    // Store dismissed notification in localStorage to prevent reappearing
                    if (notificationType) {
                        localStorage.setItem(`dismissed_${notificationType}`, Date.now());
                    } else if (notificationId) {
                        // Store dismissed order notification
                        const dismissedOrders = JSON.parse(localStorage.getItem('dismissed_orders') || '[]');
                        dismissedOrders.push(notificationId);
                        localStorage.setItem('dismissed_orders', JSON.stringify(dismissedOrders));
                    }
                });
            });
            
            // Clear all notifications at once
            $('#clearAllNotifications').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Fade out all notification items
                $('.notification-item').fadeOut(300, function() {
                    $('.notification-link').remove();
                    
                    // Update notification badge count
                    updateNotificationCount();
                    
                    // Store a timestamp in localStorage to mark all current notifications as read
                    localStorage.setItem('all_notifications_cleared', Date.now());
                    
                    // Store current notification IDs as dismissed
                    const currentOrderIds = [];
                    $('[data-notification-id]').each(function() {
                        currentOrderIds.push($(this).data('notification-id'));
                    });
                    
                    if (currentOrderIds.length > 0) {
                        const dismissedOrders = JSON.parse(localStorage.getItem('dismissed_orders') || '[]');
                        const updatedDismissedOrders = [...new Set([...dismissedOrders, ...currentOrderIds])];
                        localStorage.setItem('dismissed_orders', JSON.stringify(updatedDismissedOrders));
                    }
                    
                    // Also store type notifications as dismissed
                    localStorage.setItem('dismissed_orders_time', Date.now());
                    localStorage.setItem('dismissed_tables', Date.now());
                    
                    // Also clear the dropdown display
                    $('#notificationDropdown').removeClass('show');
                });
            });
            
            // Function to update notification count badge
            function updateNotificationCount() {
                const visibleNotifications = $('.notification-item:visible').length;
                
                if (visibleNotifications > 0) {
                    // Update badge count
                    if ($('.notification-badge').length) {
                        $('.notification-badge').text(visibleNotifications).show();
                    } else {
                        $('#notificationBtn').append('<span class="notification-badge">' + visibleNotifications + '</span>');
                    }
                    
                    // Update header count
                    $('.notification-header span.text-xs').html('<span class="notification-count text-blue-400">' + visibleNotifications + '</span> baru');
                } else {
                    // Remove badge if no notifications
                    $('.notification-badge').hide();
                    
                    // Update header
                    $('.notification-header span.text-xs').html('<span class="notification-count text-gray-500">0</span> baru');
                }
                
                // Also remove empty notification sections to keep things clean
                if ($('.notification-link:visible').length === 0) {
                    $('.p-2.text-center').addClass('mt-4').html('<p class="text-gray-400 text-sm">Tidak ada notifikasi baru.</p>');
                }
            }
            
            // Initialize notifications on page load
            function initializeNotifications() {
                // Hide any notifications that have been dismissed
                filterDismissedNotifications();
                
                // Check if we need fresh notifications (e.g. if all were cleared but now there are new ones)
                checkForNewNotificationsSinceLastVisit();
                
                // Update the notification count
                updateNotificationCount();
            }
            
            // Filter out notifications that have been dismissed
            function filterDismissedNotifications() {
                // Get dismissed data
                const dismissedOrders = localStorage.getItem('dismissed_orders') 
                    ? JSON.parse(localStorage.getItem('dismissed_orders')) : [];
                const dismissedOrdersTime = localStorage.getItem('dismissed_orders_time');
                const dismissedTablesTime = localStorage.getItem('dismissed_tables');
                const allClearedTime = localStorage.getItem('all_notifications_cleared');
                
                // If all previously cleared, hide everything
                if (allClearedTime) {
                    // Hide all notifications initially
                    $('.notification-link').hide();
                    return;
                }
                
                // Hide orders summary if dismissed
                if (dismissedOrdersTime) {
                    $('[data-notification-type="orders"]').closest('.notification-link').hide();
                }
                
                // Hide tables summary if dismissed
                if (dismissedTablesTime) {
                    $('[data-notification-type="tables"]').closest('.notification-link').hide();
                }
                
                // Hide individual order notifications that were dismissed
                if (dismissedOrders.length > 0) {
                    dismissedOrders.forEach(orderId => {
                        $(`[data-notification-id="${orderId}"]`).closest('.notification-link').hide();
                    });
                }
            }
            
            // Check if there are new notifications since last visit or clearing
            function checkForNewNotificationsSinceLastVisit() {
                const allClearedTime = localStorage.getItem('all_notifications_cleared');
                const lastVisit = localStorage.getItem('last_page_visit');
                
                // Store the current visit time
                localStorage.setItem('last_page_visit', Date.now());
                
                // If we cleared all notifications and it's been more than 5 minutes since last visit,
                // we should check for new notifications that may have come in
                if (allClearedTime && lastVisit) {
                    const clearTime = parseInt(allClearedTime);
                    const visitTime = parseInt(lastVisit);
                    const fiveMinutes = 5 * 60 * 1000; // 5 minutes in milliseconds
                    
                    if (Date.now() - visitTime > fiveMinutes) {
                        // It's been a while since last visit, let's fetch fresh notifications
                        $.ajax({
                            url: '{{ route("api.notifications") }}',
                            method: 'GET',
                            success: function(response) {
                                const lastOrderUpdated = response.orderUpdate * 1000; // convert to JS timestamp
                                const lastTableUpdated = response.tableUpdate * 1000; // convert to JS timestamp
                                
                                // If there are newer notifications than when we last cleared
                                if (lastOrderUpdated > clearTime || lastTableUpdated > clearTime) {
                                    // Clear the flag so notifications show up
                                    localStorage.removeItem('all_notifications_cleared');
                                    
                                    // Reload to show new notifications
                                    location.reload();
                                }
                            }
                        });
                    }
                }
            }
            
            // Auto update notifications every 30 seconds
            setInterval(function() {
                $.ajax({
                    url: '{{ route("api.notifications") }}',
                    method: 'GET',
                    success: function(response) {
                        // Handle notification refresh logic
                        refreshNotifications(response);
                    }
                });
            }, 30000);
            
            // Function to refresh notifications from the server
            function refreshNotifications(response) {
                // Get all dismissed notification IDs and other dismissal info
                const dismissedOrders = localStorage.getItem('dismissed_orders') 
                    ? JSON.parse(localStorage.getItem('dismissed_orders')) : [];
                const dismissedOrdersTime = localStorage.getItem('dismissed_orders_time');
                const dismissedTablesTime = localStorage.getItem('dismissed_tables');
                const allClearedTime = localStorage.getItem('all_notifications_cleared');
                
                // Check timestamp of last clear vs notifications
                let hasNewNotifications = false;
                
                // Count any new notifications since last clearAll
                if (allClearedTime) {
                    const clearTime = parseInt(allClearedTime);
                    const lastOrderUpdated = response.orderUpdate * 1000; // convert to JS timestamp
                    const lastTableUpdated = response.tableUpdate * 1000; // convert to JS timestamp
                    
                    // Check if there are newer notifications than the clear time
                    if (lastOrderUpdated > clearTime || lastTableUpdated > clearTime) {
                        hasNewNotifications = true;
                        
                        // If notifications are significantly newer, remove the clear flag
                        // so they actually show up in the UI
                        if (Math.max(lastOrderUpdated, lastTableUpdated) > clearTime + 60000) { // 1 minute newer
                            localStorage.removeItem('all_notifications_cleared');
                            
                            // Should trigger a page reload to get fresh notifications
                            // or implement dynamic HTML refresh here
                            if ($('.notification-link:visible').length === 0) {
                                location.reload(); // Simple solution: just reload the page
                                return;
                            }
                        }
                    }
                }
                
                // Calculate how many notifications should be shown
                let displayCount = 0;
                
                // Only count active orders if not dismissed or there are new ones
                if (!dismissedOrdersTime || hasNewNotifications) {
                    displayCount += response.activeOrdersCount;
                }
                
                // Only count active tables if not dismissed or there are new ones
                if (!dismissedTablesTime || hasNewNotifications) {
                    displayCount += response.activeTablesCount;
                }
                
                // Only count recent orders that weren't dismissed
                if (response.recentOrders && response.recentOrders.length > 0) {
                    // Filter out dismissed individual order notifications
                    const undismissedOrders = response.recentOrders.filter(order => 
                        !dismissedOrders.includes(order.id)
                    );
                    
                    // Check for orders newer than last clear time
                    if (allClearedTime && !hasNewNotifications) {
                        const clearTime = parseInt(allClearedTime);
                        
                        // Filter for orders with updated_at newer than clear time
                        const newOrders = undismissedOrders.filter(order => {
                            // Convert order.updated_at to timestamp
                            const orderTime = new Date(order.updated_at).getTime();
                            return orderTime > clearTime;
                        });
                        
                        if (newOrders.length > 0) {
                            hasNewNotifications = true;
                            displayCount += newOrders.length;
                            
                            // Remove the clear flag if we have new orders
                            localStorage.removeItem('all_notifications_cleared');
                            
                            // Should trigger a page reload for new content
                            if ($('.notification-link:visible').length === 0) {
                                location.reload();
                                return;
                            }
                        }
                    } else {
                        displayCount += undismissedOrders.length;
                    }
                }
                
                // Update the badge with filtered count
                if (displayCount > 0) {
                    if ($('.notification-badge').length) {
                        $('.notification-badge').text(displayCount).show();
                    } else {
                        $('#notificationBtn').append('<span class="notification-badge">' + displayCount + '</span>');
                    }
                    
                    // Update header count
                    $('.notification-header span.text-xs').html('<span class="notification-count text-blue-400">' + displayCount + '</span> baru');
                } else {
                    // Remove badge if no notifications
                    $('.notification-badge').hide();
                    
                    // Update header
                    $('.notification-header span.text-xs').html('<span class="notification-count text-gray-500">0</span> baru');
                }
                
                // Store current update times for future comparison
                localStorage.setItem('last_notification_check', Date.now());
                localStorage.setItem('last_order_update', response.orderUpdate);
                localStorage.setItem('last_table_update', response.tableUpdate);
            }
        });
    </script>
</body>
</html> 