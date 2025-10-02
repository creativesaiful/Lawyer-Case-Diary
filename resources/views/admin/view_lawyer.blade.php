@extends('layouts.app')

@push('styles')
<style>
    .profile-card {
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        border-radius: 12px;
        padding: 20px;
        transition: transform 0.2s;
    }

    .profile-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }

    .profile-img {
        width: 100%;
        height: auto;
        border-radius: 50%;
        object-fit: cover;
    }

    .status-badge {
        font-size: 0.85rem;
        padding: 0.35em 0.6em;
        border-radius: 10px;
    }

    @media (max-width: 768px) {
        .profile-card {
            text-align: center;
        }
    }
</style>
@endpush

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <!-- Profile Image -->
        <div class="col-md-4 mb-3 mb-md-0 d-flex justify-content-center">
            <img src="{{ asset('assets/img/profile.jpg') }}" alt="Profile Image" class="profile-img">
        </div>

        <!-- Profile Details -->
        <div class="col-md-8">
            <div class="profile-card bg-white">
                <h3 class="text-center mb-2">{{ $lawyer->name }}</h3>
                <h6 class="text-center text-muted mb-3">Bar Number: {{ $lawyer->bar_number }}</h6>

                <div class="row mb-2">
                    <div class="col-sm-6"><strong>Mobile:</strong> {{ $lawyer->mobile }}</div>
                    <div class="col-sm-6"><strong>Chamber No:</strong> {{ $lawyer->chamber->chamber_no }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-sm-12"><strong>Address:</strong> {{ $lawyer->address }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-sm-6">
                        <strong>Status:</strong>
                        @if($lawyer->approved)
                            <span class="badge bg-success status-badge">Approved</span>
                        @else
                            <span class="badge bg-warning status-badge text-dark">Pending</span>
                        @endif
                    </div>
                    <div class="col-sm-6"><strong>Total Staff:</strong> {{ $totalStaff }}</div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <strong>Total Cases:</strong> {{ $totalCases }} 
                        <span class="text-muted">(Plaintiffs: {{ $plaintiffParties }}, Defendants: {{ $defendantParties }})</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
