<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $mainFoodCategory = Category::where('name', 'Makanan Utama')->first();
        $snackCategory = Category::where('name', 'Makanan Ringan')->first();
        $coldDrinkCategory = Category::where('name', 'Minuman Dingin')->first();
        $hotDrinkCategory = Category::where('name', 'Minuman Panas')->first();
        $dessertCategory = Category::where('name', 'Dessert')->first();

        // Makanan Utama
        $mainFoods = [
            ['name' => 'Nasi Goreng Spesial', 'price' => 25000, 'description' => 'Nasi goreng dengan telur, ayam, dan sayuran'],
            ['name' => 'Mie Goreng', 'price' => 22000, 'description' => 'Mie goreng dengan telur dan sayuran'],
            ['name' => 'Ayam Bakar', 'price' => 30000, 'description' => 'Ayam bakar dengan bumbu special'],
            ['name' => 'Soto Ayam', 'price' => 20000, 'description' => 'Soto ayam dengan nasi dan emping'],
            ['name' => 'Beef Burger', 'price' => 35000, 'description' => 'Burger dengan daging sapi tebal dan sayuran segar'],
        ];

        foreach ($mainFoods as $food) {
            Product::create([
                'id' => Str::uuid()->toString(),
                'name' => $food['name'],
                'description' => $food['description'],
                'price' => $food['price'],
                'category_id' => $mainFoodCategory->id,
                'type' => 'food',
                'available' => true,
            ]);
        }

        // Makanan Ringan
        $snacks = [
            ['name' => 'Kentang Goreng', 'price' => 15000, 'description' => 'Kentang goreng renyah'],
            ['name' => 'Onion Rings', 'price' => 18000, 'description' => 'Cincin bawang goreng yang renyah'],
            ['name' => 'Chicken Wings', 'price' => 25000, 'description' => 'Sayap ayam dengan saus BBQ'],
        ];

        foreach ($snacks as $snack) {
            Product::create([
                'id' => Str::uuid()->toString(),
                'name' => $snack['name'],
                'description' => $snack['description'],
                'price' => $snack['price'],
                'category_id' => $snackCategory->id,
                'type' => 'food',
                'available' => true,
            ]);
        }

        // Minuman Dingin
        $coldDrinks = [
            ['name' => 'Es Teh', 'price' => 8000, 'description' => 'Teh dingin dengan es batu'],
            ['name' => 'Es Jeruk', 'price' => 10000, 'description' => 'Jeruk peras dengan es batu'],
            ['name' => 'Lemon Tea', 'price' => 12000, 'description' => 'Teh dengan lemon dan es batu'],
            ['name' => 'Cola', 'price' => 10000, 'description' => 'Minuman cola dengan es batu'],
        ];

        foreach ($coldDrinks as $drink) {
            Product::create([
                'id' => Str::uuid()->toString(),
                'name' => $drink['name'],
                'description' => $drink['description'],
                'price' => $drink['price'],
                'category_id' => $coldDrinkCategory->id,
                'type' => 'drink',
                'available' => true,
            ]);
        }

        // Minuman Panas
        $hotDrinks = [
            ['name' => 'Kopi Hitam', 'price' => 10000, 'description' => 'Kopi hitam panas'],
            ['name' => 'Cappuccino', 'price' => 15000, 'description' => 'Kopi cappuccino dengan foam susu'],
            ['name' => 'Teh Panas', 'price' => 8000, 'description' => 'Teh hangat'],
        ];

        foreach ($hotDrinks as $drink) {
            Product::create([
                'id' => Str::uuid()->toString(),
                'name' => $drink['name'],
                'description' => $drink['description'],
                'price' => $drink['price'],
                'category_id' => $hotDrinkCategory->id,
                'type' => 'drink',
                'available' => true,
            ]);
        }

        // Dessert
        $desserts = [
            ['name' => 'Es Krim Vanilla', 'price' => 12000, 'description' => 'Es krim vanilla dengan topping'],
            ['name' => 'Pancake', 'price' => 18000, 'description' => 'Pancake dengan sirup maple dan buah'],
            ['name' => 'Pudding Coklat', 'price' => 15000, 'description' => 'Pudding coklat dengan saus coklat'],
        ];

        foreach ($desserts as $dessert) {
            Product::create([
                'id' => Str::uuid()->toString(),
                'name' => $dessert['name'],
                'description' => $dessert['description'],
                'price' => $dessert['price'],
                'category_id' => $dessertCategory->id,
                'type' => 'food',
                'available' => true,
            ]);
        }
    }
}