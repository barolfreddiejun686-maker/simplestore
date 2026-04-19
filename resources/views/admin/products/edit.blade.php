@extends('layouts.admin')

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

    {{-- Show current saved image --}}
    @if($product->image)
    <div class="mb-2" id="currentImageWrapper">
        <p class="text-xs text-gray-500 mb-1">Current image:</p>
        <img src="{{ Storage::url($product->image) }}"
            alt="Current product image"
            class="h-32 w-32 object-cover rounded border">
    </div>
    @endif

    <input type="file" name="image" accept="image/*"
        id="imageInput"
        class="w-full border rounded p-2 text-sm text-gray-500">
    <p class="text-xs text-gray-400 mt-1">Max 2MB. JPG, PNG, GIF allowed. Leave blank to keep current image.</p>

    {{-- Preview for newly selected image --}}
    <div id="imagePreview" class="mt-2 hidden">
        <p class="text-xs text-gray-500 mb-1">New image preview:</p>
        <img id="previewImg" src="" alt="Preview"
            class="h-32 w-32 object-cover rounded border">
    </div>
    

    <button class="bg-green-600 text-black px-4 py-2 rounded hover:bg-green-700">Update</button>
</form>

<script>
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const currentImageWrapper = document.getElementById('currentImageWrapper');

        if (!file) {
            preview.classList.add('hidden');
            return;
        }

        // Hide the current image once a new one is selected
        if (currentImageWrapper) {
            currentImageWrapper.classList.add('hidden');
        }

        previewImg.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
    });
</script>
@endsection