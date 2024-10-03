<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    // Specify the attributes that can be mass assigned
    protected $fillable = [
        'product_id',
        'quantity',
        'unit_cost',
        'selling_price',
        'user_id', 
    ];

    // Define the relationship between Sale and Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Method to calculate Cost and Selling Price, taking profit margin and shipping cost from the product
    public static function calculateCostAndSellingPrice($product, $quantity, $unitCost)
    {
        $profitMargin = $product->profit_margin / 100;  // // Convert profit margin from percentage to decimal (e.g., 25% -> 0.25)
        $shippingCost = $product->shipping_cost;  // Fetch shipping cost from product

        // Calculate the cost
        $cost = $quantity * $unitCost;

        // Calculate the selling price
        $sellingPrice = ($cost / (1 - $profitMargin)) + $shippingCost;

        return [
            'cost' => round($cost, 2),
            'selling_price' => round($sellingPrice, 2),
        ];
    }
}
