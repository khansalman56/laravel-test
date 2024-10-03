<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\Product;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Input data for the sales
        $sales = [
            [
                'product_id' => 1, // Assuming product with ID 1 exists
                'quantity' => 10,
                'unit_cost' => 5.00,
            ],
            // [
            //     'product_id' => 2, // Assuming product with ID 2 exists
            //     'quantity' => 20,
            //     'unit_cost' => 4.50,
            // ],
        ];

        foreach ($sales as $saleData) {
            // Fetch the product based on product_id
            $product = Product::find($saleData['product_id']);
            // If the product exists, calculate cost and selling price
            if ($product) {
                $calculated = Sale::calculateCostAndSellingPrice($product, $saleData['quantity'], $saleData['unit_cost']);
                // dd($calculated);
                // Insert sale with calculated values
                Sale::create([
                    'product_id' => $saleData['product_id'],
                    'quantity' => $saleData['quantity'],
                    'unit_cost' => $saleData['unit_cost'],
                    'selling_price' => $calculated['selling_price'],
                    'user_id' => 1,
                ]);
            }
        }
    }
}
