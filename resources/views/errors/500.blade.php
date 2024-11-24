@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-1">500</h1>
            <h2>Internal Server Error</h2>
            <p>We're experiencing some technical difficulties. Please try again later.</p>
            <a href="{{ route('home') }}" class="btn btn-primary">Return Home</a>
        </div>
    </div>
</div>
@endsection 