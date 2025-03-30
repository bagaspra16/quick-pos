@extends('layouts.app')

@section('title', 'Tambah Meja')

@section('content')
<div class="mb-6">
    <a href="{{ route('tables.index') }}" class="text-blue-500 hover:text-blue-700">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Meja
    </a>
</div>

<div class="card rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-semibold mb-6">Tambah Meja Baru</h2>
    
    <form action="{{ route('tables.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label for="number" class="block text-sm font-medium mb-2">Nomor Meja <span class="text-red-500">*</span></label>
            <input type="text" id="number" name="number" value="{{ old('number') }}" required
                   class="w-full bg-gray-700 border border-gray-600 rounded-md px-4 py-2 focus:outline-none focus:border-blue-500">
            @error('number')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-4">
            <label for="capacity" class="block text-sm font-medium mb-2">Kapasitas <span class="text-red-500">*</span></label>
            <input type="number" id="capacity" name="capacity" value="{{ old('capacity', 4) }}" min="1" required
                   class="w-full bg-gray-700 border border-gray-600 rounded-md px-4 py-2 focus:outline-none focus:border-blue-500">
            @error('capacity')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label for="status" class="block text-sm font-medium mb-2">Status <span class="text-red-500">*</span></label>
            <select id="status" name="status" required
                    class="w-full bg-gray-700 border border-gray-600 rounded-md px-4 py-2 focus:outline-none focus:border-blue-500">
                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>Terpakai</option>
                <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>Dipesan</option>
            </select>
            @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                Simpan Meja
            </button>
        </div>
    </form>
</div>
@endsection 