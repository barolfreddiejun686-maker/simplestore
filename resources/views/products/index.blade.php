@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">Products</h2>

    {{-- 🔍 Search + Filter --}}
    <form method="GET" action="{{ route('products.index') }}" class="mb-4">
        <div style="display:flex; gap:10px;">

            {{-- Search --}}
            <input type="text"
                name="search"
                placeholder="Search products..."
                value="{{ request('search') }}"
                class="form-control">

            {{-- Category Filter --}}
            <select name="category" class="form-control">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    @selected(request('category')==$category->id)>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    {{-- 🛍️ Product Grid --}}
    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap:20px;">

        @forelse($products as $product)
        <div class="card">

            {{-- Product Image --}}
            @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}"
                alt="Product Image"
                style="width:100%; height:150px; object-fit:cover;">
            @endif

            {{-- Fallback --}}
            <div class="img-fallback {{ $product->image ? 'hidden' : '' }}">
                <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14" />
                </svg>
                <p>No Image</p>
            </div>
            <div class="card-body">
                <h5>{{ $product->name }}</h5>

                <p>
                    {{ $product->category?->name ?? 'No Category' }}
                </p>

                <a href="{{ route('products.show', $product) }}"
                    class="btn btn-sm btn-primary">
                    View
                </a>

                {{-- 🛒 Add to Cart --}}
                <form action="{{ route('cart.add', $product->id) }}" method="POST" style="margin-top:10px;">
                    @csrf

                    <input type="number"
                        name="quantity"
                        value="1"
                        min="1"
                        class="form-control mb-2">

                    <button type="submit" class="btn btn-success btn-sm w-100">
                        Add to Cart
                    </button>
                </form>
            </div>

        </div>
        @empty
        <p>No products found.</p>
        @endforelse

    </div>

    {{-- 📄 Pagination --}}
    <div class="mt-4">
        {{ $products->links() }}
    </div>

</div>

<style>
    .hidden {
        display: none;
    }

    .img-fallback {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 150px;
        background: #f3f4f6;
        color: #9ca3af;
        flex-direction: column;
    }
</style>
@endsection