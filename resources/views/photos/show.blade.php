@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm rounded-4 border-0">
                <!-- Photo Display -->
                <div class="photo-container">
                    @php
                        $imageUrl = $photo->image_url;
                        // Jika path dari Android (mengandung storage/storage)
                        if (str_contains($imageUrl, 'storage/storage')) {
                            $imageUrl = str_replace('storage/storage', 'storage', $imageUrl);
                        }
                        // Jika path relatif
                        if (!str_starts_with($imageUrl, 'http')) {
                            $imageUrl = asset($imageUrl);
                        }
                    @endphp
                    <img src="{{ $imageUrl }}" 
                         class="card-img-top rounded-top-4" 
                         alt="{{ $photo->title }}"
                         onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                </div>
                
                <div class="card-body p-4">
                    <!-- Title & Description -->
                    <h3 class="card-title mb-2">{{ $photo->title }}</h3>
                    <p class="text-muted mb-4">{{ $photo->description }}</p>
                    
                    <!-- Action Buttons -->
                    <div class="action-buttons mb-4">
                        <!-- Like Button -->
                        <button type="button" 
                                class="btn-action like-btn {{ Auth::check() && $photo->isLikedBy(Auth::user()) ? 'liked' : '' }}"
                                data-photo-id="{{ $photo->id }}"
                                onclick="{{ Auth::check() ? 'toggleLike()' : 'redirectToLogin()' }}">
                            <i class="fas fa-heart"></i>
                            <span class="likes-count">{{ $photo->likes->count() }}</span>
                        </button>

                        <!-- Comment Button -->
                        <button class="btn-action" onclick="{{ Auth::check() ? '' : 'redirectToLogin()' }}">
                            <i class="fas fa-comment"></i>
                            <span>{{ $photo->comments->count() }}</span>
                        </button>

                        <!-- Share Button -->
                        <button class="btn-action" onclick="sharePhoto()">
                            <i class="fas fa-share-alt"></i>
                            <span>Share</span>
                        </button>
                    </div>

                    <!-- Comments Section -->
                    <div class="comments-section">
                        <h5 class="section-title">Comments</h5>
                        
                        <!-- Comment Input (Only for Authenticated Users) -->
                        @auth
                        <div class="comment-input-container mb-4">
                            <div class="comment-input-wrapper">
                                <textarea id="commentContent" 
                                          class="form-control" 
                                          rows="1" 
                                          placeholder="Add a comment..."></textarea>
                                <button onclick="postComment()" class="btn-send">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                        @endauth

                        <!-- Comments List -->
                        <div class="comments-list">
                            @foreach($photo->comments as $comment)
                            <div class="comment-item" data-comment-id="{{ $comment->id }}">
                                <div class="comment-content">
                                    <div class="comment-header">
                                        <strong>{{ $comment->user->name }}</strong>
                                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="comment-text mb-0">{{ $comment->content }}</p>
                                    
                                    @if(Auth::check() && Auth::id() === $comment->user_id)
                                    <div class="comment-actions">
                                        <button class="btn-icon edit-comment" onclick="editComment({{ $comment->id }}, '{{ addslashes($comment->content) }}')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-icon delete-comment" onclick="deleteComment({{ $comment->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Photo Container */
.photo-container {
    aspect-ratio: 4/3;
    overflow: hidden;
    background: #f8f9fa;
}

.photo-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 20px;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.btn-action {
    background: none;
    border: none;
    padding: 8px 12px;
    display: flex;
    align-items: center;
    gap: 8px;
    color: #666;
    transition: all 0.3s ease;
}

.btn-action:hover {
    transform: scale(1.1);
    color: var(--color-accent);
}

.like-btn.liked {
    color: #dc3545;
}

/* Comments Section */
.section-title {
    color: var(--color-accent);
    font-weight: 600;
    margin-bottom: 20px;
}

.comment-input-container {
    margin-bottom: 20px;
}

.comment-input-wrapper {
    position: relative;
}

.btn-send {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--color-accent);
    padding: 0;
}

.comment-item {
    margin-bottom: 15px;
}

.comment-content {
    background: #f8f9fa;
    padding: 12px;
    border-radius: 12px;
    position: relative;
}

.comment-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 5px;
}

.comment-text {
    color: #444;
}

.comment-actions {
    position: absolute;
    right: 12px;
    bottom: 12px;
    display: flex;
    gap: 8px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.comment-content:hover .comment-actions {
    opacity: 1;
}

.btn-icon {
    background: none;
    border: none;
    padding: 4px;
    color: #666;
    transition: all 0.3s ease;
}

.btn-icon:hover {
    color: var(--color-accent);
    transform: scale(1.1);
}

.btn-icon.delete-comment:hover {
    color: #dc3545;
}

/* Animations */
@keyframes likeAnimation {
    0% { transform: scale(1); }
    50% { transform: scale(1.3); }
    100% { transform: scale(1); }
}

.like-btn.liked i {
    animation: likeAnimation 0.3s ease-in-out;
}

.comment-item {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add CSRF token to all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

// Toggle Like
function toggleLike() {
    @auth
    const photoId = {{ $photo->id }};
    $.ajax({
        url: '{{ secure_url("/photos/{$photo->id}/like") }}',
        type: 'POST',
        success: function(response) {
            if (response.success) {
                const likeBtn = document.querySelector('.like-btn');
                const likesCount = likeBtn.querySelector('.likes-count');
                
                if (response.liked) {
                    likeBtn.classList.add('liked');
                    Swal.fire({
                        icon: 'success',
                        title: 'Photo liked!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    likeBtn.classList.remove('liked');
                    Swal.fire({
                        icon: 'success',
                        title: 'Photo unliked!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                
                likesCount.textContent = response.likesCount;
            } else {
                Swal.fire('Error', response.message || 'Failed to process like', 'error');
            }
        },
        error: function(xhr) {
            console.error('Like error:', xhr);
            Swal.fire('Error', 'Failed to process like. Please try again.', 'error');
        }
    });
    @else
    redirectToLogin();
    @endauth
}

// Post Comment
function postComment() {
    const content = document.getElementById('commentContent').value.trim();
    if (!content) {
        Swal.fire('Warning', 'Please write something!', 'warning');
        return;
    }

    $.ajax({
        url: '{{ secure_url("/photos/{$photo->id}/comment") }}',
        type: 'POST',
        data: { content: content },
        success: function(response) {
            if (response.success) {
                const commentsList = document.querySelector('.comments-list');
                const newComment = createCommentElement(response.comment);
                commentsList.insertAdjacentHTML('afterbegin', newComment);
                
                document.getElementById('commentContent').value = '';
                
                const commentCount = document.querySelector('.fa-comment').nextElementSibling;
                commentCount.textContent = parseInt(commentCount.textContent) + 1;
                
                Swal.fire({
                    icon: 'success',
                    title: 'Comment posted!',
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                Swal.fire('Error', response.message || 'Failed to post comment', 'error');
            }
        },
        error: function(xhr) {
            console.error('Comment error:', xhr);
            Swal.fire('Error', 'Failed to post comment. Please try again.', 'error');
        }
    });
}

// Helper function to create comment element
function createCommentElement(comment) {
    const currentUserId = {{ Auth::id() ?? 'null' }};
    const deleteButton = comment.user.id === currentUserId ? 
        `<button class="btn btn-link text-danger p-0" onclick="deleteComment(${comment.id})">
            <i class="fas fa-trash"></i>
        </button>` : '';

    return `
        <div class="comment-item d-flex align-items-start mb-3" data-comment-id="${comment.id}">
            <div class="avatar me-3">
                <div class="initials-avatar">
                    ${getInitials(comment.user.name)}
                </div>
            </div>
            <div class="comment-content flex-grow-1">
                <div class="d-flex justify-content-between">
                    <strong>${comment.user.name}</strong>
                    ${deleteButton}
                </div>
                <p class="mb-0">${comment.content}</p>
            </div>
        </div>
    `;
}

// Helper function to get initials
function getInitials(name) {
    return name.split(' ')
        .map(word => word[0])
        .join('')
        .toUpperCase()
        .substring(0, 2);
}

// Redirect to login
function redirectToLogin() {
    Swal.fire({
        title: 'Login Required',
        text: 'Please login to perform this action',
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Login',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '{{ route("login") }}';
        }
    });
}

// Edit Comment
function editComment(commentId, content) {
    Swal.fire({
        title: 'Edit Comment',
        input: 'textarea',
        inputValue: content,
        showCancelButton: true,
        confirmButtonText: 'Update',
        cancelButtonText: 'Cancel',
        showLoaderOnConfirm: true,
        preConfirm: (newContent) => {
            return $.ajax({
                url: '{{ secure_url("/comments") }}/' + commentId,
                type: 'PUT',
                data: { content: newContent }
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const commentElement = document.querySelector(`[data-comment-id="${commentId}"] .comment-text`);
            commentElement.textContent = result.value.content;
            
            Swal.fire({
                icon: 'success',
                title: 'Comment updated!',
                showConfirmButton: false,
                timer: 1500
            });
        }
    }).catch(error => {
        console.error('Edit error:', error);
        Swal.fire('Error', 'Failed to update comment', 'error');
    });
}

// Delete Comment
function deleteComment(commentId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ secure_url("/comments") }}/' + commentId,
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`);
                        commentElement.remove();
                        
                        // Update comment count
                        const commentCount = document.querySelector('.fa-comment').nextElementSibling;
                        commentCount.textContent = parseInt(commentCount.textContent) - 1;
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Comment deleted!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        throw new Error(response.message);
                    }
                },
                error: function(xhr) {
                    console.error('Delete error:', xhr);
                    Swal.fire('Error', 'Failed to delete comment', 'error');
                }
            });
        }
    });
}
</script>
@endsection