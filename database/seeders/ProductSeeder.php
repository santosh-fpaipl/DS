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
                'name' => 'Cut Out Long Slip Dress',
                'sid' => 'cut_out_long_slip_dress',
                'moq' => 10,
                'hsncode' => 'AAA123',
                'gstrate' => 5,
                'options' => [
                    [
                        'name' => 'green',
                        'sid' => 'green1',
                        'image' => public_path('storage\assets\green.jpg'),
                    ],
                    [
                        'name' => 'blue',
                        'sid' => 'blue1',
                        'image' => public_path('storage\assets\blue.jpg'),
                    ],
                ],
                'ranges' => [
                    [
                        'name' => 'Free',
                        'sid' => 'free',
                        'mrp' => 100,
                        'price' => 80,
                    ],
                    // [
                    //     'name' => 'M',
                    //     'sid' => 'M1',
                    //     'mrp' => 200,
                    //     'price' => 160,
                    // ],
                    // [
                    //     'name' => 'L',
                    //     'sid' => 'L1',
                    //     'mrp' => 300,
                    //     'price' => 240,
                    // ],
                ],
            ],
            [
                'name' => 'product2',
                'sid' => 'product2',
                'moq' => 10,
                'hsncode' => 'AAA1234',
                'gstrate' => 5,
                'options' => [
                    [
                        'name' => 'green',
                        'sid' => 'green2',
                        'image' => public_path('storage\assets\green.jpg'),
                    ],
                    [
                        'name' => 'blue',
                        'sid' => 'blue2',
                        'image' => public_path('storage\assets\blue.jpg'),
                    ],
                ],
                'ranges' => [
                    [
                        'name' => 'Free',
                        'sid' => 'free1',
                        'mrp' => 200,
                        'price' => 160,
                    ],
                    // [
                    //     'name' => 'M',
                    //     'sid' => 'M2',
                    //     'mrp' => 200,
                    //     'price' => 160,
                    // ],
                    // [
                    //     'name' => 'L',
                    //     'sid' => 'L2',
                    //     'mrp' => 300,
                    //     'price' => 240,
                    // ],
                ],
            ],
            // [
            //     'name' => 'product3',
            //     'sid' => 'product3',
            //     'moq' => 10,
            //     'hsncode' => 'AAA123',
            //     'gstrate' => 5,
            //     'options' => [
            //         [
            //             'name' => 'green',
            //             'sid' => 'green3',
            //             'image' => public_path('storage\assets\fabric1a.jpg'),
            //         ],
            //         [
            //             'name' => 'blue',
            //             'sid' => 'blue3',
            //             'image' => public_path('storage\assets\fabric1b.jpg'),
            //         ],
            //     ],
            //     'ranges' => [
            //         [
            //             'name' => 'S',
            //             'sid' => 'S3',
            //             'mrp' => 100,
            //             'price' => 80,
            //         ],
            //         [
            //             'name' => 'M',
            //             'sid' => 'M3',
            //             'mrp' => 200,
            //             'price' => 160,
            //         ],
            //         [
            //             'name' => 'L',
            //             'sid' => 'L3',
            //             'mrp' => 300,
            //             'price' => 240,
            //         ],
            //     ],
            // ],
            // [
            //     'name' => 'product4',
            //     'sid' => 'product4',
            //     'moq' => 10,
            //     'hsncode' => 'AAA123',
            //     'gstrate' => 5,
            //     'options' => [
            //         [
            //             'name' => 'green',
            //             'sid' => 'green4',
            //             'image' => public_path('storage\assets\fabric1a.jpg'),
            //         ],
            //         [
            //             'name' => 'blue',
            //             'sid' => 'blue4',
            //             'image' => public_path('storage\assets\fabric1b.jpg'),
            //         ],
            //     ],
            //     'ranges' => [
            //         [
            //             'name' => 'S',
            //             'sid' => 'S4',
            //             'mrp' => 100,
            //             'price' => 80,
            //         ],
            //         [
            //             'name' => 'M',
            //             'sid' => 'M4',
            //             'mrp' => 200,
            //             'price' => 160,
            //         ],
            //         [
            //             'name' => 'L',
            //             'sid' => 'L4',
            //             'mrp' => 300,
            //             'price' => 240,
            //         ],
            //     ],
            // ],
            
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