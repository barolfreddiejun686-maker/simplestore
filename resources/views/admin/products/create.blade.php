@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Add Product</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST"
          enctype="multipart/form-data"
          class="bg-white p-6 rounded shadow space-y-4 max-w-2xl">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
            <input name="name" value="{{ old('name') }}" placeholder="Product Name"
                   class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select name="category_id" class="w-full border rounded p-2">
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Price (₱)</label>
            <input type="number" name="price" value="{{ old('price') }}"
                   placeholder="0.00" class="w-full border rounded p-2" step="0.01" min="0">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
            <input type="number" name="stock" value="{{ old('stock') }}"
                   placeholder="0" class="w-full border rounded p-2" min="0">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" placeholder="Product description..."
                      class="w-full border rounded p-2" rows="3">{{ old('description') }}</textarea>
        </div>

        {{-- ===== IMAGE FIELD ===== --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Image</label>
            <input type="file" name="image" accept="image/*"
                   id="imageInput"
                   class="w-full border rounded p-2 text-sm text-gray-500">
            <p class="text-xs text-gray-400 mt-1">Max 2MB. JPG, PNG, GIF allowed.</p>
            <div id="imagePreview" class="mt-2 hidden">
                <p class="text-xs text-gray-500 mb-1">Preview:</p>
                <img id="previewImg" src="" alt="Preview"
                     class="h-32 w-32 object-cover rounded border">
            </div>
        </div>
        {{-- ====================== --}}

        <div class="flex gap-3">
            <button class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Save</button>
            <a href="{{ route('admin.products.index') }}"
               class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">Cancel</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection