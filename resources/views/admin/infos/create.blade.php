@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-plus-circle"></i> Create New Informasi</h1>
        <a href="{{ route('dashboard.infos.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Infos
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
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-info-circle"></i> New Informasi Form</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.infos.store') }}">
                @csrf
                
                <!-- Title Input -->
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
                </div>

                <!-- Content Input -->
                <div class="mb-3">
                    <label for="content" class="form-label">Description</label>
                    <textarea class="form-control" name="content" id="content" rows="6" required>{{ old('content') }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success me-2">
                        <i class="fas fa-save"></i> Submit
                    </button>
                    <a href="{{ route('dashboard.infos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
