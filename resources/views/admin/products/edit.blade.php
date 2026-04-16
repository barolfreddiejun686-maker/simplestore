@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Product</h1>

<form action="{{ route('admin.products.update', $product) }}"
      method="POST"
      class="bg-white p-6 rounded shadow space-y-4">
    @csrf
    @method('PUT')

    <input name="name" value="{{ $product->name }}" class="w-full border p-2 space-y-4">

    <select name="category_id" class="w-full border p-2 space-y-4">
        @foreach($categories as $category)
            <option value="{{ $category->id }}"
                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>

    <input type="number" name="price" value="{{ $product->price }}" class="w-full border p-2">

    <input type="number" name="stock" value="{{ $product->stock }}" class="w-full border p-2">

    <textarea name="description" class="w-full border p-2">{{ $product->description }}</textarea>

    <button class="bg-green-600 text-white px-4 py-2">Update</button>
</form>
@endsection