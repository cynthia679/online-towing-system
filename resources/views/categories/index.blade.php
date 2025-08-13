@extends('layouts.app')

@section('content')
<div class="container">

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom:1rem;">
            {{ session('success') }}
        </div>
    @endif

    <h2>All Categories</h2>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger" style="margin-bottom:1rem;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- A. Form to Add New Category --}}
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Category Name:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            <button type="submit">Add Category</button>
        </div>
    </form>

    <hr>

    {{-- B. List Existing Categories --}}
    @if(count($categories) > 0)
        <ul>
            @foreach($categories as $category)
                <li>
                    {{ $category->name }}
                    (Status: {{ $category->status }})

                    {{-- Delete Form --}}
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p>No categories found.</p>
    @endif
</div>
@endsection
