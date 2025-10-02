@extends('layouts.app')
@section('content')
 
    <div class="container">
        <h2>Add New Court</h2>
        <form method="POST" action="{{ route('courts.store') }}">
            @csrf
            <div class="row mb-3">
            <div class="form-group col-md-6">
                <label for="court_name">কোর্টের নাম</label>
                <input type="text" class="form-control" id="court_name" name="court_name" required>

                @error('court_name')
                    <div class="text-danger">{{ $message }}</div>
                    
                @enderror
            </div>
            <div class="form-group col-md-6 mb-3">
                <label for="judge_name">বিচারক</label>
                <input type="text" class="form-control" id="judge_name" name="judge_name">
                @error('judge_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>            
            <button type="submit" class="btn btn-primary">Add Court</button>
        </div>
        </form>
    </div>  



@endsection
       