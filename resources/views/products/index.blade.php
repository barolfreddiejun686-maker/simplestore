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
          class="mb-6 bg-white p-4 rounded-2xl shadow-sm flex flex-col sm:flex-row gap-3">

        <!-- Search -->
        <input type="text"
            name="search"
            placeholder="🔍 Search products..."
            value="{{ request('search') }}"
            class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-400 outline-none">

        <!-- Category -->
        <select name="category"
            class="px-4 py-2 border rounded-xl focus:ring-2 focus:ring-blue-400 outline-none">
            <option value="">All Categories</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}"
                @selected(request('category')==$category->id)>
                {{ $category->name }}
            </option>
            @endforeach
        </select>

        <button type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded-xl hover:bg-blue-700 transition">
            Filter
        </button>
    </form>

    <!-- 🛒 Product Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">

        @forelse($products as $product)
        <div 
            x-data="{ qty: 1, added: false }"
            class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition transform hover:-translate-y-1 overflow-hidden"
        >

            <!-- Image -->
            @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}"
                class="w-full h-40 object-cover">
            @else
            <div class="flex items-center justify-center h-40 bg-gray-100 text-gray-400">
                No Image
            </div>
            @endif

            <!-- Body -->
            <div class="p-4">

                <h5 class="font-semibold text-gray-800 truncate">
                    {{ $product->name }}
                </h5>

                <p class="text-sm text-gray-400 mb-2">
                    {{ $product->category?->name ?? 'No Category' }}
                </p>

                <!-- Actions -->
                <div class="flex items-center justify-between mb-3">
                    <a href="{{ route('products.show', $product) }}"
                        class="text-blue-500 text-sm hover:underline">
                        View
                    </a>
                </div>

                <!-- 🧮 Quantity Stepper -->
                <div class="flex items-center justify-between mb-3">
                    <button type="button"
                        @click="if(qty>1) qty--"
                        class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">
                        -
                    </button>

                    <input type="number"
                        x-model="qty"
                        min="1"
                        class="w-12 text-center border rounded">

                    <button type="button"
                        @click="qty++"
                        class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">
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
        <!-- Empty State -->
        <div class="col-span-full text-center py-20">
            <p class="text-gray-400 text-lg">No products found 😢</p>
        </div>
        @endforelse

    </div>

    <!-- 📄 Pagination -->
    <div class="mt-8">
        {{ $products->links() }}
    </div>

</div>
@endsection