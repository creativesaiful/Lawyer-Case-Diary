@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h2>Update Next Date for Case: {{ $caseDiary->case_number }}</h2>
    <hr>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('cases.date-update.post', $caseDiary) }}" method="POST">
                @csrf
                @method('post')

                <div class="mb-3">
                    <label for="next_date" class="form-label">Next Date</label>
                    <input type="date" id="next_date" name="next_date" class="form-control" value="" required>
                    @error('next_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="short_order" class="form-label">Short Order</label>
                    <input type="text" id="short_order" name="short_order" class="form-control" value="{{ old('short_order', $caseDiary->short_order) }}">
                    @error('short_order')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="comments" class="form-label"> Comments</label>
                    <textarea id="comments" name="comments" class="form-control" rows="4">{{ old('comments') }}</textarea>
                    @error('comments')  
                        <div class="text-danger">{{ $message }}</div>                
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Date</button>
                <a href="{{ route('cases.show', $caseDiary) }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

</div>
@endsection