@extends('layouts.app')

@section('content')
<div 
    x-data="cartHandler()"
    class="max-w-6xl mx-auto px-4 py-8"
>

    <!-- 🛒 Header -->
    <h2 class="text-3xl font-black text-gray-800 mb-6">My Cart</h2>

    <!-- Alerts -->
    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-xl">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-xl">
        {{ session('error') }}
    </div>
    @endif

    @if(count($cart) > 0)

    <div class="grid lg:grid-cols-3 gap-6">

        <!-- 🧾 Cart Items -->
        <div class="lg:col-span-2 space-y-4">

            @foreach($cart as $id => $item)
            <div 
                x-data="{ qty: {{ $item['quantity'] }} }"
                class="bg-white rounded-2xl shadow-sm p-4 flex gap-4 items-center hover:shadow-md transition"
            >

                <!-- Image -->
                @if($item['image'])
                <img src="{{ asset('storage/' . $item['image']) }}"
                    class="w-20 h-20 object-cover rounded-lg">
                @else
                <div class="w-20 h-20 bg-gray-100 flex items-center justify-center text-gray-400 text-xs rounded-lg">
                    No Image
                </div>
                @endif

                <!-- Info -->
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-800">
                        {{ $item['name'] }}
                    </h3>

                    <p class="text-gray-400 text-sm">
                        ₱{{ number_format($item['price'], 2) }}
                    </p>

                    <!-- Quantity Stepper -->
                    <div class="flex items-center gap-2 mt-2">

                        <button 
                            @click="if(qty>1) qty--"
                            class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">
                            -
                        </button>

                        <input type="number"
                            x-model="qty"
                            min="1"
                            class="w-14 text-center border rounded">

                        <button 
                            @click="qty++"
                            class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">
                            +
                        </button>

                        <!-- Update -->
                        <form action="{{ route('cart.update', $id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="quantity" :value="qty">

                            <button type="submit"
                                class="ml-2 text-blue-500 text-sm hover:underline">
                                Update
                            </button>
                        </form>

                    </div>
                </div>

                <!-- Subtotal -->
                <div class="text-right">
                    <p class="font-bold text-gray-800">
                        ₱{{ number_format($item['subtotal'], 2) }}
                    </p>

                    <!-- Remove -->
                    <form action="{{ route('cart.remove', $id) }}" method="POST"
                        onsubmit="return confirm('Remove this item?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="text-red-500 text-sm hover:underline mt-2">
                            Remove
                        </button>
                    </form>
                </div>

            </div>
            @endforeach

        </div>

        <!-- 💳 Summary -->
        <div class="bg-white rounded-2xl shadow-md p-6 h-fit sticky top-6">

            <h3 class="font-semibold text-gray-800 mb-4">Order Summary</h3>

            <div class="flex justify-between mb-2 text-gray-600">
                <span>Items</span>
                <span>{{ count($cart) }}</span>
            </div>

            <div class="flex justify-between mb-4 text-lg font-bold">
                <span>Total</span>
                <span class="text-green-600">
                    ₱{{ number_format($total, 2) }}
                </span>
            </div>

            <!-- Checkout -->
            <a href="{{ route('checkout.index') }}"
                class="block w-full text-center bg-blue-600 text-white py-3 rounded-xl font-medium hover:bg-blue-700 transition mb-3">
                Proceed to Checkout
            </a>

            <!-- Clear Cart -->
            <form action="{{ route('cart.clear') }}" method="POST"
                onsubmit="return confirm('Clear entire cart?')">
                @csrf
                @method('DELETE')

                <button type="submit"
                    class="w-full py-2 text-sm text-red-500 border border-red-300 rounded-xl hover:bg-red-50 transition">
                    Clear Cart
                </button>
            </form>

        </div>

    </div>

    @else

    <!-- 💤 Empty State -->
    <div class="text-center py-20">
        <p class="text-gray-400 text-lg mb-4">Your cart is empty 🛒</p>

        <a href="{{ route('products.index') }}"
            class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition">
            Start Shopping
        </a>
    </div>

    @endif

</div>

<!-- Alpine Helper -->
<script>
function cartHandler() {
    return {
        loading: false
    }
}
</script>
@endsection