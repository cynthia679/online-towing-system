@extends('layouts.app')

@section('title', 'Manage Drivers')

@section('content')
<div class="container">
    <h2 class="mb-4">Pending Drivers</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registered At</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($drivers as $driver)
                    <tr>
                        <td>{{ $driver->name }}</td>
                        <td>{{ $driver->email }}</td>
                        <td>{{ $driver->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <span class="badge
                                @if($driver->status === 'pending') bg-warning
                                @elseif($driver->status === 'approved') bg-success
                                @elseif($driver->status === 'rejected') bg-danger
                                @else bg-secondary @endif">
                                {{ ucfirst($driver->status) }}
                            </span>
                        </td>
                        <td>
                            @if($driver->status === 'pending')
                                <form action="{{ route('admin.drivers.approve', $driver->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                </form>

                                <form action="{{ route('admin.drivers.reject', $driver->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                </form>
                            @else
                                <span class="text-muted">No action</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No drivers pending approval.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
