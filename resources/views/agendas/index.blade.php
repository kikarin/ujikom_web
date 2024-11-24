@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <div class="search-container">
                <input type="text" 
                       id="searchAgenda" 
                       class="form-control search-input" 
                       placeholder="Search Agenda"
                       aria-label="Search Agenda">
                <i class="fas fa-search search-icon"></i>
            </div>
        </div>
    </div>

    <!-- Agenda Cards Container -->
    <div class="row g-4">
        @forelse($agendas as $agenda)
        <div class="col-12 col-sm-6 col-lg-4 animate__animated animate__fadeInUp agenda-card" data-aos="fade-up">
            <div class="agenda-card h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="agenda-title">{{ $agenda->title }}</h5>
                    <p class="agenda-date">Event Date: {{ \Carbon\Carbon::parse($agenda->event_date)->format('M j, Y') }}</p>
                    <div class="agenda-preview flex-grow-1">
                        {{ Str::limit($agenda->description, 100) }}
                    </div>
                    <button class="btn-view mt-3" onclick="showAgendaDetail('{{ $agenda->title }}', '{{ $agenda->description }}', '{{ $agenda->event_date }}')">
                        <i class="fas fa-calendar-alt me-2"></i>View Detail
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center empty-state">
            <i class="fas fa-calendar-times fa-3x mb-3"></i>
            <p>No agenda available.</p>
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

/* Agenda Card Styling */
.agenda-card {
    background: linear-gradient(135deg, #446496, #88A5DB);
    border-radius: 16px;
    padding: 1.5rem;
    height: 100%;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
}

.agenda-card:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
}

.card-body {
    display: flex;
    flex-direction: column;
    height: 100%;
    padding: 0;
}

.agenda-title {
    color: white;
    font-size: clamp(1.1rem, 2.5vw, 1.25rem);
    font-weight: bold;
    margin-bottom: 0.5rem;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
}

.agenda-date {
    color: rgba(255, 255, 255, 0.7);
    font-size: clamp(0.8rem, 2vw, 0.875rem);
    margin-bottom: 0.75rem;
}

.agenda-preview {
    background: rgba(0, 0, 0, 0.1);
    padding: 0.75rem;
    border-radius: 12px;
    color: white;
    font-size: clamp(0.9rem, 2vw, 1rem);
    margin-bottom: 1rem;
    flex-grow: 1;
    backdrop-filter: blur(5px);
}

.btn-view {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    transition: all 0.3s ease;
    width: 100%;
    text-align: center;
    font-size: clamp(0.875rem, 2vw, 1rem);
}

.btn-view:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
}

/* Empty State */
.empty-state {
    color: #666;
    padding: 3rem;
}

/* Responsive Adjustments */
@media (max-width: 576px) {
    .container {
        padding: 1rem;
    }
    
    .agenda-card {
        margin: 0;
        padding: 1rem;
    }

    .search-input {
        font-size: 0.9rem;
        padding: 0.75rem 0.75rem 0.75rem 2.5rem;
    }

    .search-icon {
        left: 0.75rem;
        font-size: 0.9rem;
    }
}

@media (min-width: 577px) and (max-width: 991px) {
    .agenda-card {
        padding: 1.25rem;
    }
}

/* Grid System Improvements */
.row {
    margin-right: -10px;
    margin-left: -10px;
}

.col-12, .col-sm-6, .col-lg-4 {
    padding-right: 10px;
    padding-left: 10px;
    display: flex;
}

.agenda-card {
    width: 100%;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchAgenda');
    const agendaCards = document.querySelectorAll('.col-12.col-sm-6.col-lg-4');

    searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        let hasResults = false;

        agendaCards.forEach(card => {
            const title = card.querySelector('.agenda-title').textContent.toLowerCase();
            const content = card.querySelector('.agenda-preview').textContent.toLowerCase();
            const date = card.querySelector('.agenda-date').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || content.includes(searchTerm) || date.includes(searchTerm)) {
                card.style.display = 'flex';
                hasResults = true;
            } else {
                card.style.display = 'none';
            }
        });

        // Show/hide empty state
        const emptyState = document.querySelector('.empty-state');
        if (emptyState) {
            emptyState.style.display = hasResults ? 'none' : 'block';
        }
    });
});

// Show Agenda Detail with custom styling
function showAgendaDetail(title, description, eventDate) {
    const formattedDate = new Date(eventDate).toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    Swal.fire({
        title: title,
        html: `
            <div class="agenda-detail">
                <p class="text-muted mb-3">Event Date: ${formattedDate}</p>
                <div class="content-container">
                    ${description}
                </div>
            </div>
        `,
        width: '600px',
        padding: '2rem',
        showCloseButton: true,
        showConfirmButton: false,
        customClass: {
            popup: 'swal2-show-animation',
            title: 'text-start fs-4 fw-bold',
            htmlContainer: 'text-start'
        }
    });
}
</script>
@endsection
