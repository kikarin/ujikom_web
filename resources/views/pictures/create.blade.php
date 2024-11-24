@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-upload"></i> Add Pictures to Album</h1>
        <a href="{{ route('albums.show', $albumId) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Album
        </a>
    </div>

    <!-- Alert for Errors -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Whoops!</strong> There were some problems with your input.
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-images"></i> Upload Pictures</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('pictures.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="album_id" value="{{ $albumId }}">

                <!-- File Input -->
                <div class="mb-3">
                    <label for="images" class="form-label">Choose Images</label>
                    <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple required>
                    <small class="text-muted">Maximum file size: 50MB per image</small>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-upload"></i> Upload Pictures
                    </button>
                    <a href="{{ route('albums.show', $albumId) }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Image Preview -->
    <div id="imagePreview" class="row mt-4"></div>
</div>

@push('scripts')
<script>
    // Preview images before upload
    document.getElementById('images').addEventListener('change', function(event) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = ''; // Clear previous previews

        Array.from(event.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'col-md-4 mb-3';
                div.innerHTML = `
                    <div class="card shadow-sm">
                        <img src="${e.target.result}" class="card-img-top" alt="Preview Image" style="height: 200px; object-fit: cover;">
                    </div>
                `;
                preview.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    });
</script>
@endpush
@endsection
