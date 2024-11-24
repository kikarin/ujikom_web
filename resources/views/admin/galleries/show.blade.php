@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-image"></i> {{ $gallery->title }}</h1>
        <a href="{{ route('dashboard.galleries.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Galleries
        </a>
    </div>

    <!-- Alert for Success or Error -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="fas fa-images"></i> Photos</h2>
        <a href="{{ route('dashboard.photos.create', ['gallery_id' => $gallery->id]) }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Photo
        </a>
    </div>

    @if($gallery->photos->isEmpty())
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> No photos available in this gallery.
        </div>
    @else
        <div class="row g-3">
            @foreach($gallery->photos as $photo)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $photo->full_image_url }}" class="card-img-top" alt="{{ $photo->title }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $photo->title }}</h5>
                            <p class="card-text">{{ $photo->description }}</p>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('dashboard.photos.edit', $photo->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('dashboard.photos.destroy', $photo->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this photo?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
