<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sample data to insert into the products table
        $products = [
            [
                'name' => 'Gold coffee',
                'profit_margin' => 25.00,
                'shipping_cost' => 10.00,
                'enabled' => true,
            ],
            // [
            //     'name' => 'Arabic coffee',
            //     'profit_margin' => 15.00,
            //     'shipping_cost' => 10.00,
            //     'enabled' => true,
            // ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Insert the sample data into the products table
        // DB::table('products')->insert($products);
    }
}
