@extends('layouts.app')

@section('title', 'Manajemen Meja')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold">Daftar Meja</h2>
    <a href="{{ route('tables.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
        <i class="fas fa-plus mr-2"></i> Tambah Meja
    </a>
</div>

<div class="card rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-700">
                    <th class="px-6 py-3 text-left">Nomor</th>
                    <th class="px-6 py-3 text-left">Kapasitas</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Barcode</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse ($tables as $table)
                <tr class="hover:bg-gray-700">
                    <td class="px-6 py-4 font-medium">Meja {{ $table->number }}</td>
                    <td class="px-6 py-4">{{ $table->capacity }} orang</td>
                    <td class="px-6 py-4">
                        @if($table->status == 'available')
                            <span class="bg-green-600 text-white py-1 px-2 rounded-md text-xs">Tersedia</span>
                        @elseif($table->status == 'occupied')
                            <span class="bg-red-600 text-white py-1 px-2 rounded-md text-xs">Terpakai</span>
                        @else
                            <span class="bg-yellow-600 text-white py-1 px-2 rounded-md text-xs">Dipesan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ substr($table->barcode, 0, 8) }}...</td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('tables.qrcode', $table) }}" class="text-blue-500 hover:text-blue-700 mr-2" title="Lihat QR Code">
                            <i class="fas fa-qrcode"></i>
                        </a>
                        <a href="{{ route('tables.edit', $table) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('tables.destroy', $table) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus meja ini?')">
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
                    <td colspan="5" class="px-6 py-4 text-center text-gray-400">
                        Belum ada meja. Silakan tambahkan meja baru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $tables->links() }}
</div>
@endsection 