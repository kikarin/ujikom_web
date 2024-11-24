@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-edit"></i> Edit Photo</h1>
        <a href="{{ route('dashboard.galleries.show', $photo->gallery_id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Gallery
        </a>
    </div>

    <!-- Alert for Errors -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Whoops!</strong> There were some problems with your input.
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-accent text-white">
            <h5 class="mb-0"><i class="fas fa-image"></i> Edit Photo Details</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.photos.update', $photo->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="gallery_id" value="{{ $photo->gallery_id }}">

                <!-- Title Input -->
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $photo->title) }}" required>
                </div>

                <!-- Description Input -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" placeholder="Enter photo description">{{ old('description', $photo->description) }}</textarea>
                </div>

                <!-- Current Image Preview -->
                <div class="mb-3">
                    <label for="current_image" class="form-label">Current Image</label>
                    <div class="mb-2">
                        <img src="{{ asset($photo->image_url) }}" alt="{{ $photo->title }}" class="img-thumbnail" style="max-height: 200px; object-fit: cover;">
                    </div>
                </div>

                <!-- Upload New Image -->
                <div class="mb-3">
                    <label for="image" class="form-label">Choose New Image</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <small class="text-muted">Leave this blank to keep the current image.</small>
                    <div class="mt-3">
                        <img id="imagePreview" src="" alt="New Image Preview" style="max-height: 200px; display: none; object-fit: cover;">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success me-2">
                        <i class="fas fa-save"></i> Update Photo
                    </button>
                    <a href="{{ route('dashboard.galleries.show', $photo->gallery_id) }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Preview Image Script -->
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
