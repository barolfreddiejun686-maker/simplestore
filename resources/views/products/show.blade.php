@extends('layouts.app')

@section('content')
<div class="container">

    <a href="{{ route('products.index') }}" class="btn btn-secondary mb-3">
        ← Back to Products
    </a>

    <div class="card" style="max-width:500px; margin:auto;">

        {{-- Product Image --}}
        @if($product->image)
        <img src="{{ asset('storage/' . $product->image) }}"
            alt="Product Image"
            style="width:100%; height:250px; object-fit:cover;">
        @else
        {{-- Fallback --}}
        <div class="img-fallback">
            <svg width="60" height="60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14" />
            </svg>
            <p>No Image Available</p>
        </div>
        @endif

        <div class="card-body">

            <h3>{{ $product->name }}</h3>

            <p>
                <strong>Category:</strong>
                {{ $product->category?->name ?? 'No Category' }}
            </p>

            {{-- Optional fields (if you have them) --}}
            @if(!empty($product->description))
            <p>
                <strong>Description:</strong><br>
                {{ $product->description }}
            </p>
            @endif

            @if(!empty($product->price))
            <p>
                <strong>Price:</strong> ₱{{ number_format($product->price, 2) }}
            </p>
            @endif

        </div>
        {{-- Actions --}}
        <div class="mt-6 flex flex-col sm:flex-row gap-3">

            <!-- 🛒 Add to Cart -->
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                @csrf

                <input type="hidden" name="quantity" value="1">

                <button type="submit"
                    class="w-full py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    🛒 Add to Cart
                </button>
            </form>

            <!-- ⚡ Buy Now / Checkout -->
            <form action="{{ route('checkout.direct', $product->id) }}" method="POST" class="flex-1">
                @csrf

                <input type="hidden" name="quantity" value="1">

                <button type="submit"
                    class="w-full py-3 bg-blue-600 text-black rounded-lg hover:bg-gray-800 transition">
                    ⚡ Buy Now
                </button>
            </form>

        </div>
    </div>

</div>

{{-- Styles --}}
<style>
    .img-fallback {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 250px;
        background: #f3f4f6;
        color: #9ca3af;
        flex-direction: column;
    }
</style>
@endsection