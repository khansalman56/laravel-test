<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    /**
     * Show the form for adding a new sale.
     *
     * @return \Illuminate\Http\Response
     */
    public function showDetail()
    {
        // Ensure the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to add sales.');
        }

        // Fetch the products specific to the logged-in user
        $products = Product::all();
        $sales = Sale::with('product')->where("user_id", Auth::id())->get();

        // Return a view with the form to add a sale
        return view('coffee_sales', compact('products', 'sales'));
    }

    /**
     * Store a new sale in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'required|numeric|min:1',
        ]);

        // Fetch the product
        $product = Product::find($validated['product_id']);

        // If the product exists, calculate cost and selling price
        if ($product) {
            $calculated = Sale::calculateCostAndSellingPrice($product, $validated['quantity'], $validated['unit_cost']);
            // dd($calculated, $validated['quantity'], $validated['unit_cost']);
            // Insert the sale into the database
            Sale::create([
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'unit_cost' => $validated['unit_cost'],
                'cost' => $calculated['cost'],
                'selling_price' => $calculated['selling_price'],
                'user_id' => Auth::id(), // Ensure this is the logged-in user
            ]);

            return redirect()->route('coffee.sales')->with('success', 'Sale added successfully.');
        }

        return back()->with('error', 'Failed to add the sale.');
    }
}
