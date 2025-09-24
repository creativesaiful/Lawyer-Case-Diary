@extends('layouts.app')

@section('title', 'Staff List')
@section('content')
<div class="container">
    <h1>Staff List</h1>
    {{--Display the list of staff members in a table with Name and Mobile, Edit, Delete, Approve buttons --}}
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Mobile</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staffMembers as $staffMember)
                <tr>
                    <td>{{ $staffMember->name }}</td>
                    <td>{{ $staffMember->mobile }}</td>
                    <td>
                        <a href="{{ route('staff.edit', $staffMember->id) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('staff.destroy', $staffMember->id) }}" class="btn btn-danger">Delete</a>

                        @if(!$staffMember->is_approved)
                        <a href="{{ route('staff.inactive', $staffMember->id) }}" class="btn btn-success">Inactive</a>
                        @else
                        <a href="{{ route('staff.active', $staffMember->id) }}" class="btn btn-success">Active</a>
                        @endif

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>




</div>
@endsection