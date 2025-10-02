@extends('layouts.app')
@section('content')

{{-- list of courts with name, judge name, edit, delete --}}

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">কোর্টের নাম</th>
            <th scope="col">বিচারক</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($courts as $key => $court )
        <tr>
            <th scope="row">{{ $key + 1 }}</th>
            <td>{{ $court->court_name }}</td>
            <td>{{ $court->judge_name }}</td>
            <td>
                <a href="{{ route('courts.edit', $court->id) }}" class="btn btn-primary btn-sm">Edit</a>
                <form action="{{ route('courts.destroy', $court->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>

@endsection
       