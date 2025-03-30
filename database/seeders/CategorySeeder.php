<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Makanan Utama',
                'description' => 'Menu makanan utama'
            ],
            [
                'name' => 'Makanan Ringan',
                'description' => 'Menu makanan ringan dan camilan'
            ],
            [
                'name' => 'Minuman Dingin',
                'description' => 'Menu minuman dingin yang menyegarkan'
            ],
            [
                'name' => 'Minuman Panas',
                'description' => 'Menu minuman panas yang menghangatkan'
            ],
            [
                'name' => 'Dessert',
                'description' => 'Menu pencuci mulut dan hidangan penutup'
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'id' => Str::uuid()->toString(),
                'name' => $category['name'],
                'description' => $category['description'],
            ]);
        }
    }
}