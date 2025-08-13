@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="container mt-5 text-center">
    <h1 class="mb-3">Welcome to the Online Vehicle Towing System</h1>
    <p class="mb-4">Manage vehicle towing operations efficiently and effortlessly.</p>

    <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">View Categories</a>
</div>
@endsection
