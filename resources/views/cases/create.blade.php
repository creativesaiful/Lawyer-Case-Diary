@extends('layouts.app') 
@section('title', 'Add Case')

{{-- $table->string('case_number');
            $table->string('court_name');
            $table->string('plaintiff_name');
            $table->string('defendant_name');
            $table->string('client_mobile');
            $table->string('lawyer_side')->comment('Plaintiff / Defendant / Both / Other');
            $table->date('next_date')->nullable();
            $table->text('short_order')->nullable();
            $table->longText('details')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps(); --}}

@section('content')
<div class="container">
    <h1>Add Case</h1>
    <form action="{{ route('cases.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="court_id" class="form-label">Court Name</label>
            <select class="form-select" id="court_id" name="court_id" required>
                @foreach($courts as $court)
                    <option value="{{ $court->id }}">{{ $court->court_name }}</option>
                @endforeach
            </select>
            @error('court_id')
                <div class="text-danger">{{ $message }}</div>
                
            @enderror
            
        </div>
        <div class="mb-3">
            <label for="case_number" class="form-label">Case Number</label>
            <input type="text" class="form-control" id="case_number" name="case_number" required>
            @error('case_number')
                <div class="text-danger">{{ $message }}</div>
                
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="plaintiff_name" class="form-label">Plaintiff Name</label>
            <input type="text" class="form-control" id="plaintiff_name" name="plaintiff_name" required>

            @error('plaintiff_name')
                <div class="text-danger">{{ $message }}</div>
                
            @enderror
        </div>        
        <div class="mb-3">
            <label for="defendant_name" class="form-label">Defendant Name</label>
            <input type="text" class="form-control" id="defendant_name" name="defendant_name" required>

            @error('defendant_name')
                <div class="text-danger">{{ $message }}</div>
                
            @enderror
        </div>        
        <div class="mb-3">
            <label for="client_mobile" class="form-label">Client Mobile</label>
            <input type="tel" class="form-control" id="client_mobile" name="client_mobile" required>

            @error('client_mobile')
                <div class="text-danger">{{ $message }}</div>                
            @enderror
        </div>
        <div class="mb-3">
            <label for="lawyer_side" class="form-label">Lawyer Side</label>
            <select class="form-select" id="lawyer_side" name="lawyer_side" required>
                <option value="Plaintiff">Plaintiff</option>
                <option value="Defendant">Defendant</option>
                <option value="Both">Both</option>
                <option value="Other">Other</option>
            </select>

            @error('lawyer_side')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
   
         
        <div class="mb-3">
            <label for="details" class="form-label">Details</label>
            <textarea class="form-control" id="details" name="details"></textarea>
            @error('details')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Add Case</button>
    </form>
    
</div>
@endsection
