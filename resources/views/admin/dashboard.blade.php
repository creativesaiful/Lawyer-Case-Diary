@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card p-3 text-center">
                <h6>Total Lawyers</h6>
                <h3> {{ $totalLawyers }}  </h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card p-3 text-center">
                <h6>Acive Lawyers</h6>
                <h3>{{ $activeLawyers }}</h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card p-3 text-center">
                <h6> Pending Lawyers</h6>
                <h3> {{ $pendingLawyers }}</h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card p-3 text-center">
                <h6> Total Staff</h6>
                <h3> {{$totalStaff}}</h3>
            </div>
        </div>
    </div>

    <!-- Charts -->
    
   
</div>


@endsection
 

