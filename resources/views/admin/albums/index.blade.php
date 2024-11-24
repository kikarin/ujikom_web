@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-book"></i> Manage Albums</h1>
        <a href="{{ route('dashboard.albums.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Album
        </a>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-accent text-white">
            <h5 class="mb-0"><i class="fas fa-list"></i> Album List</h5>
        </div>
        <div class="card-body">

            <!-- Albums Table -->
            <table class="table table-hover table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Owner</th>
                        <th>Pictures Count</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($albums as $album)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $album->title }}</td>
                            <td>{{ $album->user->name ?? 'No Owner' }}</td>
                            <td>{{ $album->pictures->count() }}</td>
                            <td>
                                <div class="d-flex justify-content-around">
                                    <a href="{{ route('dashboard.albums.show', $album->id) }}" class="btn btn-info btn-sm" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('dashboard.albums.edit', $album->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('dashboard.albums.destroy', $album->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this album?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No albums found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>


        </div>
    </div>
</div>
@endsection
