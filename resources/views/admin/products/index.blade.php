@extends('layouts.admin')
@section('title', 'Products')
@section('content')

<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Product List</h2>
        <a href="{{ route('admin.products.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Add Product
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="py-3 px-4">Image</th>
                    <th class="py-3 px-4">Name</th>
                    <th class="py-3 px-4">Category</th>
                    <th class="py-3 px-4">Price</th>
                    <th class="py-3 px-4">Stock</th>
                    <th class="py-3 px-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-4">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            class="h-12 w-12 object-cover rounded border">
                        @else
                        <div class="h-12 w-12 bg-gray-200 rounded border flex items-center justify-center text-xs text-gray-400">
                            No img
                        </div>
                        @endif
                    </td>
                    <td class="py-3 px-4">{{ $product->name }}</td>
                    <td class="py-3 px-4">{{ $product->category?->name ?? 'No Category' }}</td>
                    <td class="py-3 px-4">₱{{ number_format($product->price, 2) }}</td>
                    <td class="py-3 px-4">
                        <span class="{{ $product->stock <= 5 ? 'text-red-600 font-bold' : '' }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}"
                                class="bg-blue-400 text-black px-3 py-1 rounded hover:bg-blue-600 text-sm">
                                Edit
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                onsubmit="return confirm('Delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-6 text-center text-gray-400">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>

@endsection