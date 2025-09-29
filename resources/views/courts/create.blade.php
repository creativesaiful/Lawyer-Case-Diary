@extends('layouts.app')
@section('content')

    {{-- $table->string('court_name');
            $table->string('judge_name')->nullable(); --}}

    <div class="container">
        <h2>Add New Court</h2>
        <form method="POST" action="{{ route('courts.store') }}">
            @csrf
            <div class="form-group">
                <label for="court_name">Court Name</label>
                <input type="text" class="form-control" id="court_name" name="court_name" required>

                @error('court_name')
                    <div class="text-danger">{{ $message }}</div>
                    
                @enderror
            </div>
            <div class="form-group">
                <label for="judge_name">Judge Name</label>
                <input type="text" class="form-control" id="judge_name" name="judge_name">
                @error('judge_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>            
            <button type="submit" class="btn btn-primary">Add Court</button>
        </form>
    </div>  



@endsection
       