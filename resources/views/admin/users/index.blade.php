@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-users"></i> Manage Users</h1>
        <form action="{{ route('users.index') }}" method="GET" class="d-flex">
            <input type="text" id="searchInput" class="form-control me-2" placeholder="Search by username" value="{{ request('search') }}">
            <button type="button" class="btn btn-primary" onclick="filterTable()">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    <!-- Display Success or Error Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header" style="background-color: var(--color-accent); color: #fff;">
            <h5 class="mb-0"><i class="fas fa-list"></i> User List</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered" id="userTable">
                <thead class="table-primary">
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 30%;"><i class="fas fa-user"></i> Name</th>
                        <th style="width: 30%;"><i class="fas fa-envelope"></i> Email</th>
                        <th style="width: 20%;"><i class="fas fa-cogs"></i> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="user-row">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <div class="d-flex justify-content-around">
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this user?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Filter table based on search input
    function filterTable() {
        const searchValue = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#userTable tbody tr');

        rows.forEach(row => {
            const nameCell = row.querySelector('td:nth-child(2)');
            const nameText = nameCell ? nameCell.textContent.toLowerCase() : '';

            if (nameText.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Automatically filter on input change
    document.getElementById('searchInput').addEventListener('input', function() {
        filterTable();
    });
</script>

@endsection
