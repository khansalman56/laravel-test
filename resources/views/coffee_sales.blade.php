<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New ☕️ Sales') }}
        </h2>
    </x-slot>

    <div class="container">
        <h2 class="mb-4">Record New Sale</h2>
    
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
        <!-- Sales Form -->
        <form action="{{ route('coffee.add') }}" method="POST">
            @csrf
    
            <!-- Product Select Dropdown -->
            @if(count($products) > 1)
                <div class="mb-3">
                    <label for="product" class="form-label">Product</label>
                    <select class="form-select" name="product_id" id="product" required>
                        <option value="">Select a Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
            @elseif (count($products) > 0)
                <input type="hidden" id="product_id" name="product_id" value="{{$products[0]->id}}" required>
            @endif
    
            <!-- Quantity -->
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity" min="1" required>
            </div>
    
            <!-- Unit Cost -->
            <div class="mb-3">
                <label for="unit_cost" class="form-label">Unit Cost</label>
                <input type="number" step="0.01" class="form-control" id="unit_cost" name="unit_cost" placeholder="Enter unit cost in £" required>
            </div>
    
            <!-- Selling Price (Calculated Automatically, Optional Field) -->
            <div class="mb-3">
                <label for="selling_price" class="form-label">Selling Price</label>
                <input type="text" class="form-control" id="selling_price" name="selling_price" readonly placeholder="Calculated automatically after submission">
            </div>
    
            <!-- Submit Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Record Sale</button>
            </div>
        </form>

        <!-- Sales Records Table -->
        @if($sales->isNotEmpty())
            <h3 class="mb-4">Recorded Sales</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        @if(count($products) > 1)
                            <th scope="col">Product Name</th>
                        @endif
                        <th scope="col">Quantity</th>
                        <th scope="col">Cost (£)</th>
                        <th scope="col">Selling Price (£)</th>
                        <th scope="col">Sold at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                        <tr>
                            @if(count($products) > 1)
                                <td>{{ $sale->product->name }}</td>
                            @endif
                            <td>{{ $sale->quantity }}</td>
                            <td>{{ number_format($sale->unit_cost, 2) }}</td>
                            <td>{{ number_format($sale->selling_price, 2) }}</td>
                            <td>{{ $sale->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No sales recorded yet.</p>
        @endif
    </div>

    <script>
        document.getElementById('quantity').addEventListener('input', calculateSellingPrice);
        document.getElementById('unit_cost').addEventListener('input', calculateSellingPrice);

        function calculateSellingPrice() {
            const quantity = parseFloat(document.getElementById('quantity').value) || 0;
            const unitCost = parseFloat(document.getElementById('unit_cost').value) || 0;
            const profitMargin = 0.25; // Example profit margin
            const shippingCost = 10; // Example shipping cost
            
            // Calculate cost and selling price
            const cost = quantity * unitCost;
            const sellingPrice = (cost / (1 - profitMargin)) + shippingCost;

            // Update the selling price field
            document.getElementById('selling_price').value = sellingPrice.toFixed(2);
        }
    </script>
</x-app-layout>
