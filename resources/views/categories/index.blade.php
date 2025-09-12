@extends('layouts.app')

@section('title', 'All Categories')

@section('content')
    <h1>All Categories</h1>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Admin: Add Category form at the top --}}
    @auth
        @if(Auth::user()->role === 'admin')
            <div class="mb-4">
                <form action="{{ route('categories.store') }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="name" class="form-control" placeholder="New Category" required>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </form>
            </div>
        @endif
    @endauth

    {{-- Display Categories --}}
    @if($categories->count() > 0)
        <ul class="list-group">
            @foreach($categories as $category)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $category->name }}

                    {{-- Only show delete button for admin --}}
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        @endif
                    @endauth
                </li>
            @endforeach
        </ul>
    @else
        <p>No categories found.</p>
    @endif
@endsection
