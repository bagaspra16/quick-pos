@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-white">Profil Saya</h1>
        <div class="flex space-x-3">
            <a href="{{ route('profile.edit') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                <i class="fas fa-edit mr-2"></i>Edit Profil
            </a>
            <a href="{{ route('profile.change-password') }}" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition-colors">
                <i class="fas fa-key mr-2"></i>Ubah Password
            </a>
        </div>
    </div>
    
    <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="p-8">
            <div class="flex items-center space-x-6">
                <div class="w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center text-4xl font-bold text-white">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white">{{ $user->name }}</h2>
                    <p class="text-gray-400 mt-1">{{ $user->role }}</p>
                </div>
            </div>
            
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-700 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-white mb-2">Informasi Akun</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-gray-400 text-sm">Email</p>
                            <p class="text-white">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">ID Pengguna</p>
                            <p class="text-white">{{ substr($user->id, 0, 8) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Bergabung Sejak</p>
                            <p class="text-white">{{ $user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-700 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold text-white mb-2">Aktivitas Terbaru</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-gray-400 text-sm">Login Terakhir</p>
                            <p class="text-white">{{ now()->format('d M Y H:i') }}</p>
                        </div>
                        @if($user->orders->count() > 0)
                        <div>
                            <p class="text-gray-400 text-sm">Pesanan Terakhir</p>
                            <p class="text-white">{{ $user->orders->sortByDesc('created_at')->first()->created_at->format('d M Y H:i') }}</p>
                        </div>
                        @endif
                        @if($user->payments->count() > 0)
                        <div>
                            <p class="text-gray-400 text-sm">Pembayaran Terakhir</p>
                            <p class="text-white">{{ $user->payments->sortByDesc('created_at')->first()->created_at->format('d M Y H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 