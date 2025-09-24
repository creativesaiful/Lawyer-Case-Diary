@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2>Case Details: {{ $caseDiary->case_number }}</h2>
    <hr>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Case Information</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Case Number:</strong> {{ $caseDiary->case_number }}</li>
                        <li class="list-group-item"><strong>Court:</strong> {{ $caseDiary->court_name }}</li>
                        <li class="list-group-item"><strong>Plaintiff:</strong> {{ $caseDiary->plaintiff_name }}</li>
                        <li class="list-group-item"><strong>Defendant:</strong> {{ $caseDiary->defendant_name }}</li>
                        <li class="list-group-item"><strong>Client Mobile:</strong> <a href="tel:{{ $caseDiary->client_mobile }}">{{ $caseDiary->client_mobile }}</a></li>
                        <li class="list-group-item"><strong>Lawyer Side:</strong> {{ $caseDiary->lawyer_side }}</li>
                        <li class="list-group-item"><strong>Next Date:</strong> {{ $caseDiary->next_date ? $caseDiary->next_date->format('d M, Y') : 'N/A' }}</li>
                        <li class="list-group-item"><strong>Short Order:</strong> {{ $caseDiary->short_order ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>Details:</strong> {{ $caseDiary->details ?? 'N/A' }}</li>
                    </ul>
                </div>
            </div>
            
            <div class="card mb-3">
                <div class="card-header">Comments</div>
                <div class="card-body">
                    @forelse($comments as $comment)
                        <div class="card mb-2">
                            <div class="card-body p-2">
                                <small class="text-muted">{{ $comment->user->name }} on {{ $comment->created_at->format('d M, Y h:i A') }}</small>
                                <p class="mb-0">{{ $comment->comment_text }}</p>
                            </div>
                        </div>
                    @empty
                        <p>No comments yet.</p>
                    @endforelse
                    
                    <form action="{{ route('comment.add', $caseDiary) }}" method="POST">
                        @csrf
                        <div class="input-group mt-3">
                            <textarea name="comment_text" class="form-control" placeholder="Add a comment..." required></textarea>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Generate Applications</div>
                <div class="card-body">
                    <form action="{{ route('generate.docx', $caseDiary) }}" method="POST">
                        @csrf
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="applications[]" value="time_extension" id="time_extension">
                            <label class="form-check-label" for="time_extension">Time Extension</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="applications[]" value="attendance" id="attendance">
                            <label class="form-check-label" for="attendance">Attendance</label>
                        </div>
                        <button type="submit" class="btn btn-success mt-3">Generate MS Word</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection