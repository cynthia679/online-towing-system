@extends('layouts.app')

@section('title', 'All Categories')

@section('content')
    <h1>All Categories</h1>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Link to Create Category --}}
    <a href="{{ route('categories.create') }}" class="btn btn-success mb-3">Add New Category</a>

    {{-- Display Categories --}}
    @if(count($categories) > 0)
        <ul class="list-group">
            @foreach($categories as $category)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $category->name }}
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p>No categories found.</p>
    @endif
@endsection
