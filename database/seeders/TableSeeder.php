<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TableSeeder extends Seeder
{
    public function run()
    {
        // Generate 15 tables with different capacities
        for ($i = 1; $i <= 15; $i++) {
            $capacity = $i <= 5 ? 2 : ($i <= 10 ? 4 : 6);
            
            Table::create([
                'id' => Str::uuid()->toString(),
                'number' => $i,
                'capacity' => $capacity,
                'status' => 'available',
                'barcode' => Str::uuid()->toString(),
            ]);
        }
    }
}