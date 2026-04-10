@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Add Category</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categories.store') }}" method="POST"
          class="bg-white p-6 rounded shadow space-y-4 max-w-2xl">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
            <input name="name" value="{{ old('name') }}" placeholder="Category Name"
                   class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" placeholder="Category description..."
                      class="w-full border rounded p-2" rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="flex gap-3">
            <button class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Save</button>
            <a href="{{ route('admin.categories.index') }}"
               class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">Cancel</a>
        </div>
    </form>
</div>
@endsection