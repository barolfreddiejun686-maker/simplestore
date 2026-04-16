@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Categories</h1>
    <a href="{{ route('admin.categories.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg">
        + Add Category
    </a>
</div>

<div class="bg-white p-6 rounded-lg shadow">
    <table class="w-full text-left">
        <thead>
            <tr class="border-b">
                <th class="text-left py-2">Name</th>
                <th class="text-left py-2">Description</th>
                <th class="text-left py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr class="border-b">
                <td class="py-2">{{ $category->name }}</td>
                <td class="py-2">{{ $category->description }}</td>
                <td class="py-2 flex gap-2">
                    <a href="{{ route('admin.categories.edit', $category) }}"
                       class="text-blue-600">Edit</a>

                    <form action="{{ route('admin.categories.destroy', $category) }}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600"
                                onclick="return confirm('Delete this category?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection