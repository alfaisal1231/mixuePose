<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'name' => 'Boba Sundae',
            'image' => 'https://mixue.co/wp-content/uploads/2023/01/Boba-Sundae.jpg',
            'barcode' => '1',
            'price' => '16000'
        ]);
        DB::table('products')->insert([
            'name' => 'Brown Sugar Pearl Milk tea',
            'barcode' => '20',
            'price' => '19000'
        ]);
        DB::table('products')->insert([
            'name' => 'Fresh Squeezed Lemonade',
            'barcode' => '3',
            'price' => '10000'
        ]);
    }
}
