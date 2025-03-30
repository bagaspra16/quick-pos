@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-white">Edit Profil</h1>
        <a href="{{ route('profile.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>
    
    <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="p-8">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label for="name" class="block text-gray-300 text-sm font-bold mb-2">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                           class="shadow appearance-none border rounded w-full py-3 px-4 bg-gray-700 border-gray-600 text-white leading-tight focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                           required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="email" class="block text-gray-300 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                           class="shadow appearance-none border rounded w-full py-3 px-4 bg-gray-700 border-gray-600 text-white leading-tight focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                           required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition-colors font-medium">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 