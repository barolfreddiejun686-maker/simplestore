@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">My Cart</h2>

    {{-- Success / Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(count($cart) > 0)

        <table class="table table-bordered w-full">
            <thead>
                <tr>
                    <th class="py-3 px-4">Image</th>
                    <th class="py-3 px-4">Product</th>
                    <th class="py-3 px-4">Price</th>
                    <th width="150">Quantity</th>
                    <th class="py-3 px-4">Subtotal</th>
                    <th >Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($cart as $id => $item)
                    <tr>

                        {{-- Image --}}
                        <td>
                            @if($item['image'])
                                <img src="{{ asset('storage/' . $item['image']) }}"
                                     width="60"
                                     height="60"
                                     style="object-fit:cover;">
                            @else
                                <div class="img-fallback">
                                    No Image
                                </div>
                            @endif
                        </td>

                        {{-- Product Name --}}
                        <td>
                            {{ $item['name'] }}
                        </td>

                        {{-- Price --}}
                        <td>
                            ₱{{ number_format($item['price'], 2) }}
                        </td>

                        {{-- Quantity Update --}}
                        <td>
                            <form action="{{ route('cart.update', $id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <input type="number"
                                       name="quantity"
                                       value="{{ $item['quantity'] }}"
                                       min="1"
                                       class="form-control mb-1">

                                <button type="submit" class="btn btn-sm btn-primary w-100">
                                    Update
                                </button>
                            </form>
                        </td>

                        {{-- Subtotal --}}
                        <td>
                            ₱{{ number_format($item['subtotal'], 2) }}
                        </td>

                        {{-- Remove --}}
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger w-100">
                                    Remove
                                </button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Total --}}
        <div class="text-end">
            <h4>Total: ₱{{ number_format($total, 2) }}</h4>
        </div>

        {{-- Actions --}}
        <div class="d-flex justify-content-between mt-3">

            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-warning">
                    Clear Cart
                </button>
            </form>

            <a href="{{ route('orders.index') }}" class="btn btn-success">
                Proceed to Checkout
            </a>

        </div>

    @else
        <p>Your cart is empty.</p>
    @endif

</div>

{{-- Styles --}}
<style>
.img-fallback {
    width: 60px;
    height: 60px;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 12px;
}
</style>

@endsection