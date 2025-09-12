@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="container">
    <h2>{{ $category->name }}</h2>

    @if($towingRequests->count() > 0)
        <h4 class="mt-4">Available Towing Services:</h4>
        <ul class="list-group">
            @foreach($towingRequests as $request)
                <li class="list-group-item">
                    Request #{{ $request->id }} - {{ $request->client->name ?? 'Client' }}
                </li>
            @endforeach
        </ul>
    @else
        <p>No towing requests available under this category yet.</p>
    @endif

    <a href="{{ route('categories.index') }}" class="btn btn-secondary mt-3">Back to All Categories</a>
</div>
@endsection
