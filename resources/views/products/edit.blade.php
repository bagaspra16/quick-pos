@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="mb-6">
    <a href="{{ route('products.index') }}" class="text-blue-500 hover:text-blue-700">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Produk
    </a>
</div>

<div class="card rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-semibold mb-6">Edit Produk</h2>
    
    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium mb-2">Nama Produk <span class="text-red-500">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required
                   class="w-full bg-gray-700 border border-gray-600 rounded-md px-4 py-2 focus:outline-none focus:border-blue-500">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium mb-2">Deskripsi</label>
            <textarea id="description" name="description" rows="3"
                      class="w-full bg-gray-700 border border-gray-600 rounded-md px-4 py-2 focus:outline-none focus:border-blue-500">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="price" class="block text-sm font-medium mb-2">Harga <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">Rp</span>
                    <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" min="0" step="1000" required
                           class="w-full bg-gray-700 border border-gray-600 rounded-md pl-10 px-4 py-2 focus:outline-none focus:border-blue-500">
                </div>
                @error('price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="category_id" class="block text-sm font-medium mb-2">Kategori <span class="text-red-500">*</span></label>
                <select id="category_id" name="category_id" required
                        class="w-full bg-gray-700 border border-gray-600 rounded-md px-4 py-2 focus:outline-none focus:border-blue-500">
                    <option value="">Pilih kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="type" class="block text-sm font-medium mb-2">Tipe <span class="text-red-500">*</span></label>
                <select id="type" name="type" required
                        class="w-full bg-gray-700 border border-gray-600 rounded-md px-4 py-2 focus:outline-none focus:border-blue-500">
                    <option value="food" {{ old('type', $product->type) == 'food' ? 'selected' : '' }}>Makanan</option>
                    <option value="drink" {{ old('type', $product->type) == 'drink' ? 'selected' : '' }}>Minuman</option>
                </select>
                @error('type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-2">Ketersediaan</label>
                <div class="flex items-center space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="available" value="1" {{ old('available', $product->available) == 1 ? 'checked' : '' }} class="bg-gray-700 border-gray-600">
                        <span class="ml-2">Tersedia</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="available" value="0" {{ old('available', $product->available) === 0 ? 'checked' : '' }} class="bg-gray-700 border-gray-600">
                        <span class="ml-2">Tidak Tersedia</span>
                    </label>
                </div>
                @error('available')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mb-6">
            @if($product->image)
            <div class="mb-2">
                <label class="block text-sm font-medium mb-2">Gambar Saat Ini</label>
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded">
            </div>
            @endif
            
            <label for="image" class="block text-sm font-medium mb-2">{{ $product->image ? 'Ganti Gambar' : 'Gambar Produk' }}</label>
            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg"
                   class="w-full bg-gray-700 border border-gray-600 rounded-md px-4 py-2">
            <p class="text-xs text-gray-400 mt-1">Format yang diperbolehkan: JPG, JPEG, PNG. Ukuran maksimum: 2MB.</p>
            @error('image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                Perbarui Produk
            </button>
        </div>
    </form>
</div>
@endsection 