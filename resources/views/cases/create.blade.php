@extends('layouts.app') 
@section('title', 'Add Case')


@section('content')
<div class="container">
    <h1>Add Case</h1>
    <form method="POST" action="{{ route('cases.store') }}">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Add Case</button>
    </form>
</div>
@endsection
