@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Categories content appears here -->
<div id="categoryHeaderContent" class="bg-light p-3 rounded shadow-sm" style="display: none;">
    <h5>All Categories</h5>
    <div id="categoryListArea">Loading...</div>
</div>

    <div class="container mt-4">
        <div class="text-center">
            <h1>Welcome to the Online Vehicle Towing System</h1>
            <p class="lead">Fast, reliable, and secure towing services across your region.</p>
        </div>

        <hr>

        <div class="row text-center mt-5">
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">🚗 Request a Tow</h5>
                        <p class="card-text">Need help? Submit a towing request and get assistance quickly.</p>
                        <a href="#" class="btn btn-primary">Request Tow</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">📋 View Categories</h5>
                        <p class="card-text">Explore vehicle types, service categories, and more.</p>
                        <a href="{{ route('categories.index') }}" class="btn btn-success">Browse Categories</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">📊 Dashboard</h5>
                        <p class="card-text">Manage towing records, view analytics, and monitor performance.</p>
                        <a href="{{ url('/dashboard') }}" class="btn btn-dark">Go to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
