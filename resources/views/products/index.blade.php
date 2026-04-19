@extends('layouts.app')

@section('content')
<div
    x-data="{ loading: false }"
    class="max-w-7xl mx-auto px-4 py-8"
>

    <!-- 🛍️ Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <h2 class="text-3xl font-black text-gray-800">Products</h2>
    </div>

    <!-- 🔍 Search + Filter -->
    <form method="GET" action="{{ route('products.index') }}"
        class="mb-6 bg-white p-4 rounded-2xl shadow-sm flex items-center gap-3">

        <!-- Search -->
        <input type="text"
            name="search"
            placeholder="🔍 Search products..."
            value="{{ request('search') }}"
            class="flex-1 h-11 px-4 border border-gray-200 rounded-xl
                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">

        <!-- Category -->
        <select name="category"
            onchange="this.form.submit()"
            class="w-56 h-11 px-4 border border-gray-200 rounded-xl
                   focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            <option value="">All Categories</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}"
                @selected(request('category') == $category->id)>
                {{ $category->name }}
            </option>
            @endforeach
        </select>

        <!-- Button -->
        <button type="submit"
            class="h-11 px-6 bg-blue-600 text-white rounded-xl
                   hover:bg-blue-700 transition font-medium whitespace-nowrap">
            Filter
        </button>

    </form>

    <!-- 🛒 Product Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">

        @forelse($products as $product)
        <div
            x-data="{ qty: 1, added: false }"
            class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition transform hover:-translate-y-1 overflow-hidden flex flex-col"
        >

            <!-- Image — fixed height, consistent resolution -->
            @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}"
                alt="{{ $product->name }}"
                class="w-full h-48 object-cover">
            @else
            <div class="flex items-center justify-center w-full h-48 bg-gray-100 text-gray-400 text-sm">
                No Image
            </div>
            @endif

            <!-- Body -->
            <div class="p-4 flex flex-col flex-1">

                <h5 class="font-semibold text-gray-800 truncate mb-1">
                    {{ $product->name }}
                </h5>

                <p class="text-xs text-gray-400 mb-1">
                    {{ $product->category?->name ?? 'No Category' }}
                </p>

                <!-- Price -->
                <p class="text-blue-600 font-bold text-sm mb-3">
                    ₱{{ number_format($product->price, 2) }}
                </p>

                <!-- View Details -->
                <a href="{{ route('products.show', $product) }}"
                    class="text-blue-500 text-sm hover:underline mb-3">
                    View Details
                </a>

                <!-- Spacer pushes stepper + button to bottom -->
                <div class="flex-1"></div>

                <!-- 🧮 Quantity Stepper -->
                <div class="flex items-center justify-between gap-2 mb-3">
                    <button type="button"
                        @click="if(qty > 1) qty--"
                        class="w-8 h-8 flex items-center justify-center bg-gray-200 rounded-lg hover:bg-gray-300 text-lg font-bold">
                        −
                    </button>

                    <input type="number"
                        x-model="qty"
                        min="1"
                        class="w-12 h-8 text-center border rounded-lg text-sm">

                    <button type="button"
                        @click="qty++"
                        class="w-8 h-8 flex items-center justify-center bg-gray-200 rounded-lg hover:bg-gray-300 text-lg font-bold">
                        +
                    </button>
                </div>

                <!-- 🛒 Add to Cart -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST"
                    @submit="added=true; setTimeout(()=>added=false,2000)">
                    @csrf
                    <input type="hidden" name="quantity" :value="qty">
                    <button type="submit"
                        class="w-full py-2 rounded-xl text-sm font-medium transition"
                        :class="added
                            ? 'bg-green-500 text-white'
                            : 'bg-green-600 hover:bg-green-700 text-white'">
                        <span x-show="!added">Add to Cart</span>
                        <span x-show="added">✔ Added!</span>
                    </button>
                </form>

            </div>
        </div>

        @empty
        <div class="col-span-full text-center py-20">
            <p class="text-gray-400 text-lg">No products found 😢</p>
        </div>
        @endforelse

    </div>

    <!-- 📄 Pagination -->
    <div class="mt-8">
        {{ $products->appends(request()->query())->links() }}
    </div>

</div>
@endsection