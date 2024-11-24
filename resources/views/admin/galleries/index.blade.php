@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-images"></i> Manage Galleries</h1>
        <a href="{{ route('dashboard.galleries.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Create New Gallery
        </a>
    </div>

    <div class="row">
        @foreach($galleries as $gallery)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $gallery->title }}</h5>
                    <p class="card-text">
                        <small class="text-muted">
                            Photos: {{ $gallery->photos->count() }}
                        </small>
                    </p>
                </div>
                <div class="card-footer bg-transparent border-top-0">
                    <div class="btn-group w-100">
                        <a href="{{ route('dashboard.galleries.show', $gallery->id) }}" 
                           class="btn btn-outline-primary">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('dashboard.galleries.edit', $gallery->id) }}" 
                           class="btn btn-outline-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('dashboard.galleries.destroy', $gallery->id) }}" 
                              method="POST" 
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-outline-danger" 
                                    onclick="return confirm('Are you sure you want to delete this gallery?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
