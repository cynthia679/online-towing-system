@extends('layouts.app')

@section('title', 'Request Towing Service')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">Request Towing Service</div>
            <div class="card-body">

                {{-- Display validation errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('towing.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="pickup_location" class="form-label">Pickup Location</label>
                        <input type="text" name="pickup_location" id="pickup_location" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="destination" class="form-label">Destination</label>
                        <input type="text" name="destination" id="destination" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="vehicle_type" class="form-label">Vehicle Type</label>
                        <input type="text" name="vehicle_type" id="vehicle_type" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" name="phone" id="phone" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description (optional)</label>
                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                    </div>

                    {{-- Price is handled in controller, so no input for now --}}

                    <button type="submit" class="btn btn-primary w-100">Submit Request</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
