@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-calendar-alt"></i> Manage Agendas</h1>
        <a href="{{ route('dashboard.agendas.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Add New Agenda
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-list"></i> Agenda List</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th style="width: 25%;">Title</th>
                        <th style="width: 40%;">Description</th>
                        <th style="width: 20%;">Event Date</th>
                        <th style="width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($agendas as $agenda)
                        <tr>
                            <td>{{ $agenda->title }}</td>
                            <td>{{ Str::limit($agenda->description, 50) }}</td>
                            <td>{{ $agenda->event_date ? $agenda->event_date->format('F d, Y') : 'N/A' }}</td>
                            <td>
                                <div class="d-flex justify-content-around">
                                    <a href="{{ route('dashboard.agendas.edit', $agenda) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('dashboard.agendas.destroy', $agenda) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this agenda?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No agendas found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
