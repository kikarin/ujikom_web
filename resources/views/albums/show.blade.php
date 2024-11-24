@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $album->title }}</h1>
        @auth
            @if(Auth::id() === $album->user_id)
                <a href="{{ route('pictures.create', ['album_id' => $album->id]) }}" 
                   class="btn btn-primary">
                    Add Pictures
                </a>
            @endif
        @endauth
    </div>

    <!-- Success message if exists -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Display pictures -->
    <div class="row g-4">
        @forelse ($album->pictures as $picture)
            <div class="col-md-4">
                <div class="card h-100">
                    <img src="{{ $picture->image_url }}" 
                         class="card-img-top" 
                         alt="Picture"
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Link to full image view page -->
                            <a href="{{ route('pictures.show', $picture->id) }}" class="btn btn-outline-primary">
                                View Full
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No pictures in this album yet.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
