<?php

namespace Database\Seeders;

use App\Enums\FoodCategory;
use App\Models\Food;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Makanan
        $makanan = [
            ['name' => 'Nasi Goreng Spesial', 'description' => 'Nasi goreng dengan telur, ayam, dan udang', 'price' => 28000],
            ['name' => 'Mie Ayam Bakso', 'description' => 'Mie ayam dengan bakso dan pangsit', 'price' => 22000],
            ['name' => 'Gado-gado Jakarta', 'description' => 'Sayuran segar dengan bumbu kacang khas Jakarta', 'price' => 20000],
            ['name' => 'Sate Ayam (10 tusuk)', 'description' => 'Sate ayam dengan bumbu kacang dan lontong', 'price' => 25000],
            ['name' => 'Ayam Penyet', 'description' => 'Ayam goreng penyet dengan sambal terasi', 'price' => 24000],
            ['name' => 'Ikan Bakar Kecap', 'description' => 'Ikan bakar dengan bumbu kecap manis', 'price' => 30000],
            ['name' => 'Rendang Daging', 'description' => 'Rendang daging sapi dengan nasi putih', 'price' => 32000],
            ['name' => 'Sop Buntut', 'description' => 'Sop buntut dengan sayuran segar', 'price' => 35000],
            ['name' => 'Bakso Malang', 'description' => 'Bakso dengan mie, tahu, dan siomay', 'price' => 18000],
            ['name' => 'Nasi Padang', 'description' => 'Nasi dengan lauk pauk khas Padang', 'price' => 26000],
        ];

        foreach ($makanan as $food) {
            Food::create([
                'name' => $food['name'],
                'description' => $food['description'],
                'price' => $food['price'],
                'category' => FoodCategory::MAKANAN,
                'is_available' => true,
            ]);
        }

        // Minuman
        $minuman = [
            ['name' => 'Es Teh Manis', 'description' => 'Teh manis dingin segar', 'price' => 6000],
            ['name' => 'Es Jeruk Nipis', 'description' => 'Jeruk nipis segar dengan es', 'price' => 8000],
            ['name' => 'Kopi Hitam Panas', 'description' => 'Kopi hitam original tanpa gula', 'price' => 8000],
            ['name' => 'Kopi Susu', 'description' => 'Kopi dengan susu segar', 'price' => 10000],
            ['name' => 'Jus Alpukat', 'description' => 'Jus alpukat segar dengan susu', 'price' => 15000],
            ['name' => 'Jus Mangga', 'description' => 'Jus mangga segar', 'price' => 12000],
            ['name' => 'Es Campur', 'description' => 'Minuman es campur dengan berbagai topping', 'price' => 14000],
            ['name' => 'Air Mineral', 'description' => 'Air mineral botol 600ml', 'price' => 5000],
            ['name' => 'Teh Tarik', 'description' => 'Teh tarik khas Malaysia', 'price' => 9000],
            ['name' => 'Cappuccino', 'description' => 'Kopi cappuccino dengan foam susu', 'price' => 18000],
        ];

        foreach ($minuman as $food) {
            Food::create([
                'name' => $food['name'],
                'description' => $food['description'],
                'price' => $food['price'],
                'category' => FoodCategory::MINUMAN,
                'is_available' => true,
            ]);
        }
    }
}
