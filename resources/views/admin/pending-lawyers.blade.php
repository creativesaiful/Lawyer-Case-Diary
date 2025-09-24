@extends('layouts.app'
)
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h2>List of Pending Lawyers with action buttons</h2>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Pending Lawyers') }}</div>
                <div class="card-body">
                    @if($pendingLawyers->isEmpty())
                        <p>No pending lawyers at the moment.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingLawyers as $lawyer)
                                    <tr>
                                        <td>{{ $lawyer->name }}</td>
                                        <td>{{ $lawyer->email }}</td>
                                        <td>
                                            <form action=" {{ route('admin.approve.user', $lawyer->id)}} " method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                            </form>
                                            <form action=" " method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>



        
    </div>
</div>
@endsection