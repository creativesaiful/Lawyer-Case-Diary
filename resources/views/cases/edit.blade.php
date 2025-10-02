@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <h2>Update Case: {{ $caseDiary->case_number }}</h2>
    <hr>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('cases.update', $caseDiary) }}" method="POST">
                @csrf
                @method('PUT')

                 <div class="mb-3">
            <label for="court_id" class="form-label">কোর্টের নাম</label>
            <select class="form-select" id="court_id" name="court_id" required>
                @foreach($courts as $court)
                    <option value="{{ $court->id }}" {{ $caseDiary->court_id == $court->id ? 'selected' : '' }}>{{ $court->court_name }}</option>
                @endforeach
            </select>
            @error('court_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>  

                <div class="mb-3">
                    <label for="case_number" class="form-label"> মামলা নং</label>
                    <input type="text" id="case_number" name="case_number" class="form-control" value="{{ old('case_number', $caseDiary->case_number) }}" required>
                    @error('case_number')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="plaintiff_name" class="form-label">বাদী</label>
                    <input type="text" id="plaintiff_name" name="plaintiff_name" class="form-control" value="{{ old('plaintiff_name', $caseDiary->plaintiff_name) }}" required>
                    @error('plaintiff_name')    
                        <div class="text-danger">{{ $message }}</div>                
                    @enderror
                </div>  
                <div class="mb-3">
                    <label for="defendant_name" class="form-label">বিবাদী</label>
                    <input type="text" id="defendant_name" name="defendant_name" class="form-control" value="{{ old('defendant_name', $caseDiary->defendant_name) }}" required>
                    @error('defendant_name')    
                        <div class="text-danger">{{ $message }}</div>                
                    @enderror
                </div>  
                <div class="mb-3">
                    <label for="client_mobile" class="form-label">মোবাইল</label>
                    <input type="text" id="client_mobile" name="client_mobile" class="form-control" value="{{ old('client_mobile', $caseDiary->client_mobile) }}" required>
                    @error('client_mobile')    
                        <div class="text-danger">{{ $message }}</div>                
                    @enderror
                </div>  
                <div class="mb-3">
                    <label for="lawyer_side" class="form-label">আইনজীবীর পক্ষ</label>
                    <select class="form-select" id="lawyer_side" name="lawyer_side" required>
                        <option value="Plaintiff" {{ $caseDiary->lawyer_side === 'Plaintiff' ? 'selected' : '' }}>বাদী</option>
                        <option value="Defendant" {{ $caseDiary->lawyer_side === 'Defendant' ? 'selected' : '' }}>বিবাদী</option>
                         
                    </select>    
                    @error('lawyer_side')    
                        <div class="text-danger">{{ $message }}</div>                
                    @enderror    
                </div>      
                <div class="mb-3">
                    <label for="details" class="form-label">মন্তব্য</label>
                    <textarea id="details" name="details" class="form-control" rows="4">{{ old('details', $caseDiary->details) }}</textarea>
                    @error('details')    
                        <div class="text-danger">{{ $message }}</div>                
                    @enderror    
                </div>      
                  
                <button type="submit" class="btn btn-primary">Update Case</button>
            </form> 
        </div>
    </div>
</div>
@endsection