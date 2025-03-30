@extends('layouts.app')

@section('title', 'Manajemen Produk')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold">Daftar Produk</h2>
    <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
        <i class="fas fa-plus mr-2"></i> Tambah Produk
    </a>
</div>

<div class="card rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-700">
                    <th class="px-6 py-3 text-left">Gambar</th>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-left">Kategori</th>
                    <th class="px-6 py-3 text-left">Tipe</th>
                    <th class="px-6 py-3 text-left">Harga</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse ($products as $product)
                <tr class="hover:bg-gray-700">
                    <td class="px-6 py-4">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded">
                        @else
                        <div class="w-12 h-12 flex items-center justify-center bg-gray-600 rounded">
                            <i class="fas {{ $product->type == 'food' ? 'fa-utensils' : 'fa-mug-hot' }} text-gray-400"></i>
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $product->name }}</td>
                    <td class="px-6 py-4">{{ $product->category->name }}</td>
                    <td class="px-6 py-4">
                        <span class="bg-{{ $product->type == 'food' ? 'green' : 'yellow' }}-600 text-white py-1 px-2 rounded-md text-xs">
                            {{ $product->type == 'food' ? 'Makanan' : 'Minuman' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="bg-{{ $product->available ? 'green' : 'red' }}-600 text-white py-1 px-2 rounded-md text-xs">
                            {{ $product->available ? 'Tersedia' : 'Tidak Tersedia' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('products.edit', $product) }}" class="text-blue-500 hover:text-blue-700 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-400">
                        Belum ada produk. Silakan tambahkan produk baru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $products->links() }}
</div>
@endsection 