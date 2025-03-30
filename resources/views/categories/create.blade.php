@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="mb-6">
    <a href="{{ route('categories.index') }}" class="text-blue-500 hover:text-blue-700">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Kategori
    </a>
</div>

<div class="card rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-semibold mb-6">Tambah Kategori Baru</h2>
    
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium mb-2">Nama Kategori <span class="text-red-500">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                   class="w-full bg-gray-700 border border-gray-600 rounded-md px-4 py-2 focus:outline-none focus:border-blue-500">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label for="description" class="block text-sm font-medium mb-2">Deskripsi</label>
            <textarea id="description" name="description" rows="3"
                      class="w-full bg-gray-700 border border-gray-600 rounded-md px-4 py-2 focus:outline-none focus:border-blue-500">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                Simpan Kategori
            </button>
        </div>
    </form>
</div>
@endsection 