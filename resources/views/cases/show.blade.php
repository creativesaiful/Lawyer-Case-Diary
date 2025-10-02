@extends('layouts.app')

@section('content')
    <div class="container-fluid py-3">
        <h2 class="mb-3">Case Details: <span class="text-primary">{{ $caseDiary->case_number }}</span></h2>
        <hr>

        <div class="row g-3">
            <!-- Case Information -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-3">
                    <div class="card-header text-center bg-primary text-white fs-5">
                        {{ $caseDiary->court->court_name }}
                    </div>
                    <div class="card-header text-center bg-light fs-6">
                        Case Number: {{ $caseDiary->case_number }}
                    </div>
                    <div class="card-body p-3">
                        <!-- Main Details Table -->
                        <table class="table table-bordered table-striped mb-3">
                            <thead class="table-light">
                                <tr>
                                    <th>বাদী</th>
                                    <th>বিবাদী</th>
                                    <th>আইনজীবীর পক্ষ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $caseDiary->plaintiff_name }}</td>
                                    <td>{{ $caseDiary->defendant_name }}</td>
                                    <td>{{ $caseDiary->lawyer_side === 'Plaintiff' ? 'বাদী' : 'বিবাদী' }}</td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-center">{{ $caseDiary->details }}</th>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Case Dates Table -->
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>তারিখ</th>
                                    <th>স্টেজ</th>
                                    <th>মন্তব্য</th>
                                    <th>আপডেট কারী</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dates as $date)
                                    <tr>
                                        <td>{{ $date->next_date ? $date->next_date->format('d-m-Y') : 'N/A' }}</td>
                                        <td>{{ $date->short_order }}</td>
                                        <td>{{ $date->comments }}</td>
                                        <td>{{ Str::limit($date->user->name, 10) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Generate Applications -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-success text-white fs-6">Generate Applications</div>
                    <div class="card-body">
                        <form action="{{ route('cases.generate.docx', $caseDiary->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="short_order" value="{{ $dates[0]->short_order }}">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="applications[]" value="time_extension"
                                    id="time_extension">
                                <label class="form-check-label" for="time_extension">সময়ের দরখাস্ত</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="applications[]" value="attendance"
                                    id="attendance">
                                <label class="form-check-label" for="attendance">হাজিরা</label>
                            </div>
                            <button type="submit" class="btn btn-success w-100 mt-3">Generate MS Word</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
