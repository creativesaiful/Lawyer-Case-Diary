@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2>Case Details: {{ $caseDiary->case_number }}</h2>
    <hr>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header text-center font-weight-bold fs-3"> {{  $caseDiary->court->court_name }}</div>
                <div class="card-header text-center font-weight-bold fs-5"> {{  $caseDiary->case_number }}</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th >Plaintiff</th>
                                <th >Defendant</th>
                                <th >Lawyer Side</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $caseDiary->plaintiff_name }}</td>
                                <td>{{ $caseDiary->defendant_name }}</td>
                                <td>{{ $caseDiary->lawyer_side }}</td>
                                
                            </tr>

                             <tr>
                                <th  colspan="3"> {{  $caseDiary->details }}</th>
                           
                            </tr>
                        </tbody>

                         
                           
                         
             


                    </table>

                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th >Date</th>
                                <th >Short Order</th>
                                <th >Comments</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dates as $date)
                            <tr>
                                <td>{{ $date->next_date ? $date->next_date->format('d-m-Y') : 'N/A' }}</td>
                                <td>{{ $date->short_order }}</td>
                                <td>{{ $date->comments }}</td>   
                            </tr>
                            @endforeach
                            

                            
                        </tbody>

                         
                           
                         
             


                    </table>
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