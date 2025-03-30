@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-400">Total Penjualan Hari Ini</p>
                <h3 class="text-2xl font-bold">Rp{{ number_format($totalSalesDay, 0, ',', '.') }}</h3>
            </div>
            <div class="rounded-full p-3 bg-blue-600 bg-opacity-20">
                <i class="fas fa-money-bill-wave text-blue-500 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="card rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-400">Total Pesanan Hari Ini</p>
                <h3 class="text-2xl font-bold">{{ $totalOrdersDay }}</h3>
            </div>
            <div class="rounded-full p-3 bg-green-600 bg-opacity-20">
                <i class="fas fa-clipboard-list text-green-500 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="card rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-400">Meja Tersedia</p>
                <h3 class="text-2xl font-bold">
                    @php
                        $availableTables = $tableStatus->where('status', 'available')->first();
                    @endphp
                    {{ $availableTables ? $availableTables->total : 0 }}
                </h3>
            </div>
            <div class="rounded-full p-3 bg-purple-600 bg-opacity-20">
                <i class="fas fa-chair text-purple-500 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="card rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-400">Meja Terpakai</p>
                <h3 class="text-2xl font-bold">
                    @php
                        $occupiedTables = $tableStatus->where('status', 'occupied')->first();
                    @endphp
                    {{ $occupiedTables ? $occupiedTables->total : 0 }}
                </h3>
            </div>
            <div class="rounded-full p-3 bg-yellow-600 bg-opacity-20">
                <i class="fas fa-users text-yellow-500 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- ROW 1: Charts -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Penjualan Mingguan -->
    <div class="card rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold mb-4">Grafik Penjualan Mingguan</h3>
        <canvas id="salesChart" height="250"></canvas>
    </div>
    
    <!-- Perbandingan Makanan vs Minuman -->
    <div class="card rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold mb-4">Perbandingan Penjualan Kategori</h3>
        <canvas id="categoryComparisonChart" height="250"></canvas>
    </div>
</div>

<!-- ROW 2: Charts -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Penggunaan Meja -->
    <div class="card rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold mb-4">Status Meja</h3>
        <canvas id="tableStatusChart" height="200"></canvas>
    </div>
    
    <!-- Perbandingan Metode Pembayaran -->
    <div class="card rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold mb-4">Metode Pembayaran</h3>
        <canvas id="paymentMethodChart" height="200"></canvas>
    </div>
    
    <!-- Penjualan per Jam -->
    <div class="card rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold mb-4">Penjualan per Jam</h3>
        <canvas id="hourlyRevenueChart" height="200"></canvas>
    </div>
</div>

<!-- ROW 3: Charts and Tables -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Tren Bulanan -->
    <div class="lg:col-span-2 card rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold mb-4">Tren Penjualan Bulanan</h3>
        <canvas id="monthlyTrendChart" height="200"></canvas>
    </div>
    
    <!-- Produk Terlaris -->
    <div class="card rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold mb-4">Produk Terlaris Hari Ini</h3>
        
        @if($topProducts->isNotEmpty())
            <div class="space-y-4">
                @foreach($topProducts as $item)
                <div class="flex items-center justify-between p-3 bg-gray-700 bg-opacity-30 rounded">
                    <div class="flex items-center space-x-3">
                        <div class="bg-blue-600 p-2 rounded">
                            <i class="fas {{ $item->product->type == 'food' ? 'fa-utensils' : 'fa-mug-hot' }} text-white"></i>
                        </div>
                        <div>
                            <p class="font-medium">{{ $item->product->name }}</p>
                            <p class="text-sm text-gray-400">{{ $item->product->category->name }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="font-bold text-blue-400">{{ $item->total }}</span>
                        <p class="text-sm text-gray-400">Terjual</p>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center text-gray-400 py-6">
                <i class="fas fa-info-circle text-3xl mb-2"></i>
                <p>Belum ada produk terjual hari ini</p>
            </div>
        @endif
    </div>
</div>

<!-- ROW 4: Additional Insights -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Rata-rata Nilai Pesanan -->
    <div class="card rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold mb-4">Rata-rata Nilai Pesanan (30 Hari Terakhir)</h3>
        <canvas id="averageOrderValueChart" height="250"></canvas>
    </div>
    
    <!-- Kinerja Meja -->
    <div class="card rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold mb-4">Kinerja Meja (Penjualan per Meja)</h3>
        <canvas id="tablePerformanceChart" height="250"></canvas>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
    // Konfigurasi Chart Umum
    Chart.defaults.color = '#f1f5f9';
    Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.1)';
    
    // 1. Sales Chart (Penjualan Mingguan)
        const salesData = {
            labels: [
                @foreach($lastWeekSales as $sale)
                    '{{ \Carbon\Carbon::parse($sale->date)->format('d/m') }}',
                @endforeach
            ],
            datasets: [{
                label: 'Penjualan',
                data: [
                    @foreach($lastWeekSales as $sale)
                        {{ $sale->total }},
                    @endforeach
                ],
                backgroundColor: 'rgba(2, 132, 199, 0.2)',
                borderColor: 'rgba(2, 132, 199, 1)',
                borderWidth: 2,
                pointBackgroundColor: '#fff',
                tension: 0.4
            }]
        };
        
    new Chart(
        document.getElementById('salesChart'),
        {
            type: 'line',
            data: salesData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Penjualan: Rp' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        }
    );
    
    // 2. Category Comparison Chart (Makanan vs Minuman)
    new Chart(
        document.getElementById('categoryComparisonChart'),
        {
            type: 'bar',
            data: {
                labels: [
                    @php
                        $dates = [];
                        $foodData = [];
                        $drinkData = [];
                        
                        // Get all unique dates
                        $uniqueDates = $categorySales->pluck('date')->unique()->sort()->values();
                        
                        foreach($uniqueDates as $date) {
                            $formattedDate = \Carbon\Carbon::parse($date)->format('d/m');
                            echo "'{$formattedDate}',";
                            
                            // Get food data for this date
                            $foodSale = $categorySales->where('date', $date)->where('type', 'food')->first();
                            $foodTotal = $foodSale ? $foodSale->total : 0;
                            $foodData[] = $foodTotal;
                            
                            // Get drink data for this date
                            $drinkSale = $categorySales->where('date', $date)->where('type', 'drink')->first();
                            $drinkTotal = $drinkSale ? $drinkSale->total : 0;
                            $drinkData[] = $drinkTotal;
                        }
                    @endphp
                ],
                datasets: [
                    {
                        label: 'Makanan',
                        data: [
                            @foreach($foodData as $value)
                                {{ $value }},
                            @endforeach
                        ],
                        backgroundColor: 'rgba(16, 185, 129, 0.7)',
                        borderColor: 'rgb(16, 185, 129)',
                        borderWidth: 1
                    },
                    {
                        label: 'Minuman',
                        data: [
                            @foreach($drinkData as $value)
                                {{ $value }},
                            @endforeach
                        ],
                        backgroundColor: 'rgba(59, 130, 246, 0.7)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': Rp' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        }
    );
    
    // 3. Table Status Chart (Pie Chart)
    new Chart(
        document.getElementById('tableStatusChart'),
        {
            type: 'doughnut',
            data: {
                labels: ['Tersedia', 'Terpakai', 'Dipesan'],
                datasets: [{
                    data: [
                        {{ $tableStatus->where('status', 'available')->first() ? $tableStatus->where('status', 'available')->first()->total : 0 }},
                        {{ $tableStatus->where('status', 'occupied')->first() ? $tableStatus->where('status', 'occupied')->first()->total : 0 }},
                        {{ $tableStatus->where('status', 'reserved')->first() ? $tableStatus->where('status', 'reserved')->first()->total : 0 }}
                    ],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.7)',  // Hijau
                        'rgba(239, 68, 68, 0.7)',   // Merah
                        'rgba(245, 158, 11, 0.7)'   // Kuning
                    ],
                    borderColor: [
                        'rgb(16, 185, 129)',
                        'rgb(239, 68, 68)',
                        'rgb(245, 158, 11)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        }
    );
    
    // 4. Payment Method Chart (Pie Chart)
    new Chart(
        document.getElementById('paymentMethodChart'),
        {
            type: 'pie',
            data: {
                labels: [
                    @foreach($paymentMethods as $method)
                        @if($method->payment_method == 'cash')
                            'Tunai',
                        @elseif($method->payment_method == 'debit')
                            'Kartu Debit',
                        @elseif($method->payment_method == 'credit')
                            'Kartu Kredit',
                        @elseif($method->payment_method == 'qris')
                            'QRIS',
                        @else
                            'Lainnya',
                        @endif
                    @endforeach
                ],
                datasets: [{
                    data: [
                        @foreach($paymentMethods as $method)
                            {{ $method->count }},
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(37, 99, 235, 0.7)',   // Biru
                        'rgba(16, 185, 129, 0.7)',  // Hijau
                        'rgba(236, 72, 153, 0.7)',  // Pink
                        'rgba(245, 158, 11, 0.7)',  // Kuning
                        'rgba(107, 114, 128, 0.7)'  // Abu-abu
                    ],
                    borderColor: [
                        'rgb(37, 99, 235)',
                        'rgb(16, 185, 129)',
                        'rgb(236, 72, 153)',
                        'rgb(245, 158, 11)',
                        'rgb(107, 114, 128)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let percentage = (context.raw / context.dataset.data.reduce((a, b) => a + b, 0)) * 100;
                                return context.label + ': ' + context.raw + ' (' + percentage.toFixed(1) + '%)';
                            }
                        }
                    }
                }
            }
        }
    );
    
    // 5. Hourly Revenue Chart
    new Chart(
        document.getElementById('hourlyRevenueChart'),
        {
            type: 'bar',
            data: {
                labels: [
                    @foreach($hourlySales as $sale)
                        '{{ sprintf("%02d:00", $sale->hour) }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Penjualan per Jam',
                    data: [
                        @foreach($hourlySales as $sale)
                            {{ $sale->total }},
                        @endforeach
                    ],
                    backgroundColor: 'rgba(124, 58, 237, 0.7)',
                    borderColor: 'rgb(124, 58, 237)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return 'Rp' + (value / 1000000).toFixed(1) + 'M';
                                } else if (value >= 1000) {
                                    return 'Rp' + (value / 1000).toFixed(0) + 'K';
                                }
                                return 'Rp' + value;
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Penjualan: Rp' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        }
    );
    
    // 6. Monthly Trend Chart
    new Chart(
        document.getElementById('monthlyTrendChart'),
        {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Penjualan {{ date("Y") }}',
                    data: [
                        @if($monthlySales->count() > 0)
                            @for($i = 1; $i <= 12; $i++)
                                @php
                                    $monthData = $monthlySales->where('year', date('Y'))->where('month', $i)->first();
                                    echo $monthData ? $monthData->total : '0';
                                @endphp,
                            @endfor
                        @else
                            0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0
                        @endif
                    ],
                    borderColor: 'rgba(16, 185, 129, 1)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.4
                },
                @if(isset($lastYearMonthlySales) && $lastYearMonthlySales->count() > 0)
                {
                    label: 'Penjualan {{ date("Y")-1 }}',
                    data: [
                        @for($i = 1; $i <= 12; $i++)
                            @php
                                $monthData = $lastYearMonthlySales->where('month', $i)->first();
                                echo $monthData ? $monthData->total : '0';
                            @endphp,
                        @endfor
                    ],
                    borderColor: 'rgba(59, 130, 246, 1)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4
                }
                @endif
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return 'Rp' + (value / 1000000).toFixed(1) + 'M';
                                } else if (value >= 1000) {
                                    return 'Rp' + (value / 1000).toFixed(0) + 'K';
                                }
                                return 'Rp' + value;
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': Rp' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        }
    );
    
    // 7. Average Order Value Chart
    new Chart(
        document.getElementById('averageOrderValueChart'),
        {
            type: 'line',
            data: {
                labels: [
                    @foreach($averageOrderValue as $item)
                        '{{ \Carbon\Carbon::parse($item->date)->format('d/m') }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Rata-rata Nilai Pesanan',
                    data: [
                        @foreach($averageOrderValue as $item)
                            {{ $item->average }},
                        @endforeach
                    ],
                    borderColor: 'rgba(236, 72, 153, 1)',
                    backgroundColor: 'rgba(236, 72, 153, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: false,
                        ticks: {
                            callback: function(value) {
                                return 'Rp' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tanggal (30 hari terakhir)'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rata-rata: Rp' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        }
    );
    
    // 8. Table Performance Chart
    new Chart(
        document.getElementById('tablePerformanceChart'),
        {
            type: 'bar',
            data: {
                labels: [
                    @foreach($tablePerformance as $item)
                        'Meja {{ $item->table->number }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Penjualan per Meja',
                    data: [
                        @foreach($tablePerformance as $item)
                            {{ $item->total }},
                        @endforeach
                    ],
                    backgroundColor: 'rgba(245, 158, 11, 0.7)',
                    borderColor: 'rgb(245, 158, 11)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return 'Rp' + (value / 1000000).toFixed(1) + 'M';
                                } else if (value >= 1000) {
                                    return 'Rp' + (value / 1000).toFixed(0) + 'K';
                                }
                                return 'Rp' + value;
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Penjualan: Rp' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        }
    );
    });
</script>
@endsection 