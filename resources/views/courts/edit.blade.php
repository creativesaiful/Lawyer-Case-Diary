@extends('layouts.app')
@section('content')

    <div class="container">
        <h2>Edit Court</h2>
        <form method="POST" action="{{ route('courts.update', $court->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="court_name">Court Name</label>
                <input type="text" class="form-control" id="court_name" name="court_name" value="{{ $court->court_name }}" required>

                @error('court_name')
                    <div class="text-danger">{{ $message }}</div>
                    
                @enderror
            </div>
            <div class="form-group">
                <label for="judge_name">Judge Name</label>
                <input type="text" class="form-control" id="judge_name" name="judge_name" value="{{ $court->judge_name }}">
                @error('judge_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>            
            <button type="submit" class="btn btn-primary">Update Court</button>
        </form>
    </div>


@endsection
       