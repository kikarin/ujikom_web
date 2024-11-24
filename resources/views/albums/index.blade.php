@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Albums</h1>

    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-12 col-md-8 mx-auto">
            <div class="search-container">
                <input type="text" 
                       id="searchAlbums" 
                       class="form-control search-input" 
                       placeholder="Search Albums...">
                <i class="fas fa-search search-icon"></i>
            </div>
        </div>
    </div>

    <!-- Album Grid -->
    <div class="row album-container">
        @forelse ($albums as $album)
            <div class="col-sm-6 col-md-4 col-lg-3 album-card mb-4">
                <div class="card h-100 shadow-sm rounded-4 border-0">
                    @if($album->pictures->isNotEmpty())
                        <img src="{{ $album->pictures->first()->image_url }}" 
                             class="card-img-top rounded-top-4" 
                             alt="Album Cover"
                             style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" 
                             style="height: 200px; border-radius: .5rem .5rem 0 0;">
                            <span>No Images</span>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $album->title }}</h5>
                        <p class="card-text">
                            <small class="text-muted">
                                {{ $album->pictures->count() }} photos
                            </small>
                        </p>
                        <a href="{{ route('albums.show', $album->id) }}" class="btn btn-primary w-100">View Album</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center py-4">
                    <i class="fas fa-info-circle fa-3x mb-3"></i>
                    <p class="mb-0">No albums available.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Loading Spinner -->
    <div id="loadingSpinner" class="d-none text-center py-4">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

<style>
/* Search Styling */
.search-container {
    position: relative;
    margin-bottom: 2rem;
}

.search-input {
    padding: 1rem 1rem 1rem 3rem;
    border-radius: 12px;
    border: 1px solid #ddd;
    transition: all 0.3s ease;
}

.search-input:focus {
    box-shadow: 0 0 0 2px rgba(68, 100, 150, 0.2);
    border-color: #446496;
}

.search-icon {
    position: absolute;
    left: 1rem; /* Position icon inside input */
    top: 50%;
    transform: translateY(-50%);
    color: #666;
    pointer-events: none; /* Prevent icon from blocking input */
}

/* Album Card Styling */
.album-card .card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.album-card .card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.card-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #333;
}

.card-text {
    font-size: 0.9rem;
    color: #666;
}

.btn-primary {
    background-color: #446496;
    border-color: #446496;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.btn-primary:hover {
    background-color: #355e85;
    transform: translateY(-2px);
}

/* Empty State */
.alert-info {
    background-color: #f8f9fa;
    border: 1px solid #e0e0e0;
    color: #666;
}

.alert-info i {
    color: #446496;
}

/* Loading Spinner */
#loadingSpinner {
    display: none;
}

/* Responsive Adjustments */
@media (max-width: 576px) {
    .search-input {
        padding-left: 2.5rem;
    }

    .search-icon {
        left: 0.75rem;
    }
}

@media (min-width: 577px) and (max-width: 991px) {
    .album-card {
        margin-bottom: 2rem;
    }
}

@media (min-width: 992px) {
    .album-card {
        margin-bottom: 2.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchAlbums');
    const albumCards = document.querySelectorAll('.album-card');
    const loadingSpinner = document.getElementById('loadingSpinner');

    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();

        // Show the loading spinner while filtering
        loadingSpinner.classList.remove('d-none');
        
        // Simulate a slight delay for better UX
        setTimeout(() => {
            albumCards.forEach(card => {
                const title = card.querySelector('.card-title').textContent.toLowerCase();
                card.style.display = title.includes(searchTerm) ? 'block' : 'none';
            });

            // Hide the loading spinner after filtering
            loadingSpinner.classList.add('d-none');
        }, 300);
    });
});
</script>
@endsection
