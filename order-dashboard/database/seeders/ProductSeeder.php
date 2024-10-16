<?php

namespace Database\Seeders;

use App\Models\Price;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'name' => 'Product 1',
                'price' => [
                    'base' => 100,
                    'tax_rate' => 0.18,
                    'discount_rate' => 0.10,
                    'currency' => 'TRY',
                ]
            ],
            [
                'name' => 'Product 2',
                'price' => [
                    'base' => 200,
                    'tax_rate' => 0.20,
                    'discount_rate' => 0.15,
                    'currency' => 'TRY',
                ]
            ],
            [
                'name' => 'Product 3',
                'price' => [
                    'base' => 300,
                    'tax_rate' => 0.15,
                    'discount_rate' => 0.05,
                    'currency' => 'TRY',
                ]
            ],
            [
                'name' => 'Product 4',
                'price' => [
                    'base' => 400,
                    'tax_rate' => 0.25,
                    'discount_rate' => 0.00,
                    'currency' => 'TRY',
                ]
            ]
        ];

        foreach ($products as $productData) {
            $product = Product::create(['name' => $productData['name']]);
            Price::create([
                'product_id' => $product->id,
                'base' => $productData['price']['base'],
                'tax_rate' => $productData['price']['tax_rate'],
                'discount_rate' => $productData['price']['discount_rate'],
                'currency' => $productData['price']['currency'],
            ]);
        }
    }
}
