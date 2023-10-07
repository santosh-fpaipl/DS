<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products =[
            [
                'name' => 'product1',
                'sid' => 'product1',
                'moq' => 10,
                'hsncode' => 'AAA123',
                'gstrate' => 5,
                'options' => [
                    [
                        'name' => 'green',
                        'sid' => 'green1',
                        'image' => public_path('storage\assets\fabric1a.jpg'),
                    ],
                    [
                        'name' => 'blue',
                        'sid' => 'blue1',
                        'image' => public_path('storage\assets\fabric1b.jpg'),
                    ],
                ],
                'ranges' => [
                    [
                        'name' => 'S',
                        'sid' => 'S1',
                        'mrp' => 100,
                        'price' => 80,
                    ],
                    [
                        'name' => 'M',
                        'sid' => 'M1',
                        'mrp' => 200,
                        'price' => 160,
                    ],
                    [
                        'name' => 'L',
                        'sid' => 'L1',
                        'mrp' => 300,
                        'price' => 240,
                    ],
                ],
            ],
            
        ];

        foreach($products as $product){

           // $this->command->info($product);

            $newProduct = \App\Models\Product::create([
                'name' => $product['name'],
                'sid' => $product['sid'],
                'moq' => $product['moq'],
                'hsncode' => $product['hsncode'],
                'gstrate' => $product['gstrate'],
                'tags' => $product['name'].",".$product['sid'].",".$product['moq'].",".$product['hsncode'].",".$product['gstrate'],

            ]);

            foreach($product['options'] as $option){
                $product_option = \App\Models\Option::create([
                    'name' => $option['name'],
                    'sid' => $option['sid'],
                    'product_id' => $newProduct->id,
                ]);

                $product_option->addSingleMediaToModal($option['image']);
            }

            foreach($product['ranges'] as $range){
                \App\Models\Range::create([
                    'name' => $range['name'],
                    'sid' => $range['sid'],
                    'mrp' => $range['mrp'],
                    'price' => $range['price'],
                    'product_id' => $newProduct->id,
                ]);
            }
        }
    }
}