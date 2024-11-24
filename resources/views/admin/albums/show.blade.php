@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $album->title }}</h1>
        <div>
            <a href="{{ route('dashboard.pictures.create', ['album_id' => $album->id]) }}" 
               class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Pictures
            </a>
            <a href="{{ route('dashboard.albums.edit', $album->id) }}" 
   class="btn btn-warning">
   <i class="fas fa-edit"></i> Edit Album
</a>

        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('dashboard.pictures.bulk-delete') }}" method="POST">
        @csrf
        <input type="hidden" name="album_id" value="{{ $album->id }}">

        @if ($album->pictures->isNotEmpty())
            <!-- Bulk Delete Button (Top) -->
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <input type="checkbox" id="selectAll" class="form-check-input me-2">
                    <label for="selectAll" class="form-label">Select All</label>
                </div>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete the selected pictures?')">
                    <i class="fas fa-trash"></i> Delete Selected
                </button>
            </div>
        @endif

        <!-- Pictures Grid -->
        <div class="row g-4" id="picturesGrid">
            @forelse ($album->pictures as $picture)
                <div class="col-md-4 picture-card">
                    <div class="card h-100">
                        <img src="{{ $picture->image_url }}" 
                             class="card-img-top" 
                             alt="Picture"
                             style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="button" 
                                        class="btn btn-outline-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#imageModal{{ $picture->id }}">
                                    View Full
                                </button>
                                <input type="checkbox" name="picture_ids[]" value="{{ $picture->id }}" class="select-checkbox">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for Full Image -->
                <div class="modal fade" 
                     id="imageModal{{ $picture->id }}" 
                     tabindex="-1" 
                     aria-labelledby="imageModalLabel{{ $picture->id }}" 
                     aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" 
                                        class="btn-close" 
                                        data-bs-dismiss="modal" 
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="{{ $picture->image_url }}" 
                                     class="img-fluid" 
                                     alt="Full Picture">
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

        @if ($album->pictures->isNotEmpty())
            <!-- Bulk Delete Button (Bottom) -->
            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete the selected pictures?')">
                    <i class="fas fa-trash"></i> Delete Selected
                </button>
            </div>
        @endif
    </form>
</div>

@push('scripts')
<script>
    // Select All / Deselect All Feature
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.select-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Drag-to-Select Feature
    let isDragging = false;
    let startElement;

    const grid = document.getElementById('picturesGrid');

    grid.addEventListener('mousedown', function(e) {
        if (e.target.tagName === 'INPUT') {
            isDragging = true;
            startElement = e.target;
        }
    });

    grid.addEventListener('mousemove', function(e) {
        if (isDragging && e.target.tagName === 'INPUT') {
            e.target.checked = startElement.checked;
        }
    });

    grid.addEventListener('mouseup', function() {
        isDragging = false;
    });

    // Prevent text selection while dragging
    grid.addEventListener('selectstart', function(e) {
        if (isDragging) e.preventDefault();
    });
</script>
@endpush
@endsection
