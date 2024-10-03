<?php
namespace Tests\Feature;

use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalesFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function logged_in_user_can_add_a_sale_record()
    {
        // Step 1: Create a user and log them in
        $user = User::factory()->create();
        $this->actingAs($user); // Log in the user

        // Step 2: Create a product
        $product = Product::factory()->create([
            'name' => 'Sample Coffee',
            'profit_margin' => 0.25, // 25%
            'shipping_cost' => 10.00,
        ]);

        // Step 3: Define sale data
        $saleData = [
            'product_id' => $product->id,
            'quantity' => 15,
            'unit_cost' => 4.50,
            'user_id' => $user->id, // Include user_id
        ];

        // Step 4: Simulate the sale record submission
        $response = $this->post(route('coffee.add'), $saleData);

        // Step 5: Assert the response is a redirect (or whatever is expected)
        $response->assertRedirect(); // Adjust if you expect a specific redirect

        // Step 6: Assert that the sale record is in the database
        $this->assertDatabaseHas('sales', [
            'product_id' => $product->id,
            'quantity' => 15,
            'unit_cost' => 4.50,
            'user_id' => $user->id, // Verify user_id
        ]);
    }
}
