@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>{{ $picture->title ?? 'Full Picture' }}</h3>
                </div>
                <div class="card-body text-center">
                    <!-- Image Display -->
                    <img src="{{ $picture->image_url }}" 
                         class="img-fluid" 
                         alt="{{ $picture->title ?? 'Full Picture' }}" 
                         style="max-width: 100%; max-height: 80vh;">
                </div>
                <div class="card-footer text-center">
                    <!-- Back to Album Button -->
                    <a href="{{ route('albums.show', $picture->album_id) }}" 
                       class="btn btn-secondary mt-2">
                        Back to Album
                    </a>

                    <!-- Download Button -->
                    <a href="{{ filter_var($picture->image_url, FILTER_VALIDATE_URL) ? $picture->image_url : Storage::url(str_replace('/storage/', 'public/', $picture->image_url)) }}" 
                       class="btn btn-success mt-2" 
                       download="{{ basename($picture->image_url) }}">
                        Download Image
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Image Viewing (for better full-screen view) -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ $picture->image_url }}" 
                     class="img-fluid" 
                     alt="{{ $picture->title ?? 'Full Picture' }}">
            </div>
        </div>
    </div>
</div>
@endsection
