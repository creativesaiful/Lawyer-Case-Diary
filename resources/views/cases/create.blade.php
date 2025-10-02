@extends('layouts.app') 
@section('title', 'Add Case')


@section('content')
<div class="container">
    <h2>নতুন মামলা</h2>
    <form action="{{ route('cases.store') }}" method="POST">
        @csrf

        <div class="row">
        <div class="mb-3 col-md-6">
            <label for="court_id" class="form-label">কোর্টের নাম</label>
            <select class="form-select" id="court_id" name="court_id" required>
                @foreach($courts as $court)
                    <option value="{{ $court->id }}">{{ $court->court_name }}</option>
                @endforeach
            </select>
            @error('court_id')
                <div class="text-danger">{{ $message }}</div>
                
            @enderror
            
        </div>
       <div class="mb-3 col-md-6">
            <label for="case_number" class="form-label">মামালা নং</label>
            <input type="text" class="form-control" id="case_number" name="case_number" required>
            @error('case_number')
                <div class="text-danger">{{ $message }}</div>
                
            @enderror
        </div>
        
        <div class="mb-3 col-md-6">
            <label for="plaintiff_name" class="form-label">বাদী</label>
            <input type="text" class="form-control" id="plaintiff_name" name="plaintiff_name" required>

            @error('plaintiff_name')
                <div class="text-danger">{{ $message }}</div>
                
            @enderror
        </div>        
       <div class="mb-3 col-md-6">
            <label for="defendant_name" class="form-label">বিবাদী</label>
            <input type="text" class="form-control" id="defendant_name" name="defendant_name" required>

            @error('defendant_name')
                <div class="text-danger">{{ $message }}</div>
                
            @enderror
        </div>        
      <div class="mb-3 col-md-6">
            <label for="client_mobile" class="form-label">মোবাইল</label>
            <input type="tel" class="form-control" id="client_mobile" name="client_mobile" required>

            @error('client_mobile')
                <div class="text-danger">{{ $message }}</div>                
            @enderror
        </div>
       <div class="mb-3 col-md-6">
            <label for="lawyer_side" class="form-label">আইনজীবীর পক্ষ</label>
            <select class="form-select" id="lawyer_side" name="lawyer_side" required>
                <option value="Plaintiff">বাদী</option>
                <option value="Defendant">বিবাদী</option>
 
            </select>

            @error('lawyer_side')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- next date input --}}
        <div class="mb-3 col-md-6">
            <label for="next_date" class="form-label">পরবর্তী তারিখ</label>
            <input type="date" class="form-control" id="next_date" name="next_date" required>
            @error('next_date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label for="short_order" class="form-label"> সক্ষিপ্ত আদেশ</label>
            <input type="text" class="form-control" id="short_order" name="short_order" required>
            @error('short_order')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
         
      <div class="mb-3 col-md-6">
            <label for="details" class="form-label">মন্তব্য</label>
            <textarea class="form-control" id="details" name="details"></textarea>
            @error('details')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">নতুন মামলা সংযোজন</button>
        </div>
    </form>
    
</div>
@endsection
