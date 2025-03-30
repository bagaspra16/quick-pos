<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::paginate(10);
        return view('tables.index', compact('tables'));
    }

    public function create()
    {
        return view('tables.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:50|unique:tables,number',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:available,occupied,reserved',
        ]);

        // Generate unique barcode
        $barcode = Str::uuid()->toString();
        $validated['barcode'] = $barcode;

        Table::create($validated);

        return redirect()->route('tables.index')
            ->with('success', 'Meja berhasil ditambahkan!');
    }

    public function edit(Table $table)
    {
        return view('tables.edit', compact('table'));
    }

    public function update(Request $request, Table $table)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:50|unique:tables,number,'.$table->id,
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:available,occupied,reserved',
        ]);

        $table->update($validated);

        return redirect()->route('tables.index')
            ->with('success', 'Meja berhasil diperbarui!');
    }

    public function destroy(Table $table)
    {
        $table->delete();

        return redirect()->route('tables.index')
            ->with('success', 'Meja berhasil dihapus!');
    }

    public function showQrCode(Table $table)
    {
        $qrCode = QrCode::size(300)->generate(route('menu.table', $table->barcode));
        
        return view('tables.qrcode', compact('table', 'qrCode'));
    }

    public function printQrCode(Table $table)
    {
        $qrCode = QrCode::size(300)->generate(route('menu.table', $table->barcode));
        
        return view('tables.print_qrcode', compact('table', 'qrCode'));
    }
} 