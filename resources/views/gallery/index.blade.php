@extends('layouts.app')

@section('content')
<div class="container py-1 mt-1">
    <!-- Search Bar -->
    <div class="row mt-5">
        <div class="col-md-8 mx-auto">
            <div class="search-container">
                <input type="text" 
                       id="searchGallery" 
                       class="form-control search-input" 
                       placeholder="Search Gallery...">
                <i class="fas fa-search search-icon"></i>
            </div>
        </div>
    </div>

    <!-- Gallery Section -->
    <div class="row g-4">
        @forelse($galleries as $gallery)
            <div class="gallery-section mb-5 animate__animated animate__fadeInUp" data-aos="fade-up">
                <h2 class="gallery-title mb-4">{{ $gallery->title }}</h2>
                @if ($gallery->photos->isNotEmpty())
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                        @foreach($gallery->photos as $photo)
                            <div class="col" data-aos="fade-up" data-aos-duration="800" data-aos-delay="{{ $loop->index * 100 }}">
                                <div class="photo-card h-100">
                                    <div class="photo-wrapper">
                                        @php
                                            $imageUrl = $photo->image_url;
                                            if (str_contains($imageUrl, 'storage/storage')) {
                                                $imageUrl = str_replace('storage/storage', 'storage', $imageUrl);
                                            }
                                            if (!str_starts_with($imageUrl, 'http')) {
                                                $imageUrl = asset($imageUrl);
                                            }
                                        @endphp
                                        <img src="{{ $imageUrl }}" 
                                             class="img-fluid" 
                                             alt="{{ $photo->title }}"
                                             loading="lazy"
                                             onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                                        <div class="photo-overlay">
                                            <h5 class="photo-title">{{ $photo->title }}</h5>
                                            <a href="{{ route('photos.show', $photo->id) }}" 
                                               class="btn btn-light btn-sm">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center">No photos available.</p>
                @endif
            </div>
        @empty
            <div class="col-12 text-center empty-state">
                <i class="fas fa-images fa-3x mb-3"></i>
                <p>No galleries available.</p>
            </div>
        @endforelse
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
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #666;
}

/* Gallery Section */
.gallery-title {
    color: var(--color-accent);
    font-weight: 600;
    font-size: 1.75rem;
    margin-bottom: 1.5rem;
    transition: color 0.3s ease;
}

.gallery-title:hover {
    color: var(--color-start);
}

/* Photo Card */
.photo-card {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.photo-wrapper {
    position: relative;
    aspect-ratio: 4/3;
    overflow: hidden;
}

.photo-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.photo-overlay {
    position: absolute;
    inset: 0;
    background: rgba(68, 100, 150, 0.85);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

/* Hover effect for photo cards */
.photo-card:hover {
    transform: translateY(-10px);
    box-shadow: 0px 15px 40px rgba(0, 0, 0, 0.15);
}

.photo-card:hover .photo-overlay {
    opacity: 1;
}

.photo-card:hover img {
    transform: scale(1.1);
}

.photo-title {
    color: white;
    text-align: center;
    margin-bottom: 1rem;
    padding: 0 1rem;
}

/* Empty State */
.empty-state {
    color: #666;
    padding: 3rem;
}

/* Responsive */
@media (max-width: 768px) {
    .gallery-title {
        font-size: 1.25rem;
    }
    
    .photo-title {
        font-size: 1rem;
    }
}

/* Animations */
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(30px); }
    100% { opacity: 1; transform: translateY(0); }
}

/* Apply animations to photo cards */
.photo-card {
    animation: fadeInUp 0.5s ease-out;
}

/* Hover effect for photo cards */
.photo-card:hover {
    transform: scale(1.05);
    box-shadow: 0px 15px 40px rgba(0, 0, 0, 0.15);
}

.photo-overlay a {
    background-color: #446496;
    color: white;
}
</style>

<script>
// Search Gallery Filter
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchGallery');
    const gallerySections = document.querySelectorAll('.gallery-section');

    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        let hasResults = false;

        gallerySections.forEach(section => {
            const title = section.querySelector('.gallery-title').textContent.toLowerCase();
            const photos = section.querySelectorAll('.photo-title');
            let sectionHasMatch = false;

            // Check gallery title
            if (title.includes(searchTerm)) {
                sectionHasMatch = true;
            }

            // Check photo titles
            photos.forEach(photo => {
                if (photo.textContent.toLowerCase().includes(searchTerm)) {
                    sectionHasMatch = true;
                }
            });

            if (sectionHasMatch) {
                section.style.display = 'block';
                hasResults = true;
            } else {
                section.style.display = 'none';
            }
        });

        // Show/hide empty state
        const emptyState = document.querySelector('.empty-state');
        if (emptyState) {
            emptyState.style.display = hasResults ? 'none' : 'block';
        }
    });
});

// Initialize AOS (Animate On Scroll)
AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true
});
</script>
@endsection
