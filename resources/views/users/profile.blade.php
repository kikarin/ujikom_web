@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center">
                <!-- Profile Avatar -->
                <div class="d-flex justify-content-center align-items-center mb-4">
                    <div class="profile-avatar">
                        <div class="avatar-circle">
                            <i class="fas fa-user fa-3x avatar-icon"></i>
                        </div>
                    </div>
                </div>

                <!-- User Profile Details -->
                <div class="profile-details mt-4">
                    <!-- Name Detail -->
                    <div class="profile-detail mb-3">
                        <label class="detail-label">Name</label>
                        <div class="detail-value" data-detail="name">{{ $user->name }}</div>
                    </div>

                    <!-- Email Detail -->
                    <div class="profile-detail mb-3">
                        <label class="detail-label">Email</label>
                        <div class="detail-value" data-detail="email">{{ $user->email }}</div>
                    </div>

                    <!-- Edit Profile Button -->
                    <div class="text-center mt-4">
                        <button class="btn btn-primary btn-edit" onclick="toggleEditMode()">Edit Profile</button>
                    </div>
                </div>
            </div>

            <!-- Edit Form (Initially Hidden) -->
            <div id="editForm" class="profile-edit-form mt-4 d-none">
                <div class="form-group mb-3">
                    <label for="name" class="detail-label">Name</label>
                    <input type="text" id="name" class="form-control" value="{{ $user->name }}">
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="detail-label">Email</label>
                    <input type="email" id="email" class="form-control" value="{{ $user->email }}">
                </div>

                <div class="d-flex justify-content-around mt-4">
                    <button class="btn btn-primary" onclick="saveProfile()">Save Changes</button>
                    <button class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
/* Profile Avatar Styling */
.profile-avatar {
    margin-top: 20px;
}

.avatar-circle {
    width: 100px;
    height: 100px;
    background-color: #4A6FA5;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.avatar-icon {
    color: white;
}

/* Profile Details Styling */
.profile-details {
    background-color: #EBF1F6;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.profile-detail {
    padding: 10px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    margin-bottom: 1rem;
}

.detail-label {
    font-weight: bold;
    color: #4A6FA5;
    font-size: 0.9rem;
}

.detail-value {
    font-size: 1.1rem;
    color: #333;
    margin-top: 5px;
}

/* Edit Button */
.btn-edit {
    background-color: #4A6FA5;
    color: white;
    border-radius: 30px;
    padding: 10px 20px;
    font-weight: bold;
}

/* Edit Form */
.profile-edit-form {
    background-color: #EBF1F6;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.profile-edit-form .form-control {
    border-radius: 8px;
    border: 1px solid #4A6FA5;
}
</style>

<!-- JavaScript for Edit and Save Functionality -->
<script>
// Toggle Edit Mode
function toggleEditMode() {
    document.querySelector('.profile-details').classList.add('d-none');
    document.getElementById('editForm').classList.remove('d-none');
}

// Cancel Edit
function cancelEdit() {
    document.getElementById('editForm').classList.add('d-none');
    document.querySelector('.profile-details').classList.remove('d-none');
}

// Save Profile via AJAX
function saveProfile() {
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;

    // Menggunakan jQuery AJAX dengan secure_url
    $.ajax({
        url: '{{ secure_url("/profile/update") }}', // Gunakan secure_url
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            name: name,
            email: email
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Update tampilan
                document.querySelector('[data-detail="name"]').textContent = name;
                document.querySelector('[data-detail="email"]').textContent = email;
                
                // Sembunyikan form edit
                cancelEdit();
                
                // Tampilkan pesan sukses
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Update failed',
                    text: response.message
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', {xhr, status, error});
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Failed to update profile. Please try again.'
            });
        }
    });
}
</script>

<!-- Pastikan jQuery dan SweetAlert2 dimuat dengan HTTPS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
