@extends('layouts.app')



@section('content')
    <div class="container">
        <div class="">
            <div class="card p-3">
                <h3>
                    Date:
                    @if ($selectedDate instanceof \Carbon\Carbon)
                        {{ $selectedDate->format('d-m-Y') }}
                    @else
                        {{ \Carbon\Carbon::parse($selectedDate)->format('d-m-Y') }}
                    @endif
                </h3>

                <div class="mb-3 ">
                    <form id="date-filter-form" class="row justify-content-between" action="{{ route('dashboard') }}"
                        method="GET">
                        <div class="col-md-8 mb-2 row justify-content-between">
                            <div class="col-md-8">
                                <input type="date" id="date-filter" name="selected_date" class="form-control"
                                    value="{{ $selectedDate instanceof \Carbon\Carbon ? $selectedDate->format('d-m-Y') : $selectedDate }}">
                            </div>
                            <div class="col-md-4">
                                <input type="submit" value="Filter" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>

                @if ($todayCases->isEmpty())
                    <p>No cases scheduled for today.</p>
                @else
                    <div class="table-responsive">
                        <table id="today-cases-table" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="select-all"></th>
                                    <th>মামলা নং</th>
                                    <th>কোর্ট </th>
                                    <th>বাদী</th>
                                    <th>বিবাদী</th>
                                    <th>মোবাইল</th>
                                    <th>স্টেজ</th>
                                    <th>পঃ তাং</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($todayCases as $case)
                              
                                    <tr>
                                        <td>
                                            <input type="checkbox"
                                                onchange="toggleSelection(this, '{{ $case->caseDiary->client_mobile }}')">
                                        </td>
                                        <td>{{ $case->caseDiary->case_number }}</td>
                                        <td>{{ $case->caseDiary->court->court_name }}</td>
                                        <td>{{ $case->caseDiary->plaintiff_name }}</td>
                                        <td>{{ $case->caseDiary->defendant_name }}</td>
                                        <td>
                                            <a href="tel:{{ $case->caseDiary->client_mobile }}">
                                                {{ $case->caseDiary->client_mobile }}
                                            </a>
                                        </td>
                                        <td>{{ $case->short_order }}</td>
                                        <td>

                                            {{-- Now we have to search the database date table, are there set a next date for this case  --}}
                                            @php
                                                $nextDate = \App\Models\Date::where('case_id', $case->case_id)
                                                    ->where('next_date', '>', today())
                                                    ->orderBy('next_date', 'asc')
                                                    ->first();
                                            @endphp




                                            @if ($nextDate)
                                                {{ $nextDate->next_date->format('m-d-Y') }}
                                            @else
                                                <span class="text-danger">Not Set</span>
                                            @endif
                                        </td>
                                        <td>


                                            @if ($nextDate)
                                                <a href="{{ route('cases.date-edit', $nextDate->id) }}"
                                                    class="btn btn-sm btn-danger">Edit</a>
                                            @else
                                                <a href="{{ route('cases.date-update', $case) }}"
                                                    class="btn btn-sm btn-success">Update</a>
                                            @endif


                                            <a href="{{ route('cases.show', $case->case_id) }}" class="btn btn-sm btn-info">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <button class="btn btn-success mt-3" onclick="showSmsModal()">
                        Send SMS to Selected
                    </button>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#today-cases-table').DataTable({
                dom: 'Bfrtip',
                paging: true,
                pageLength: 25,
                lengthChange: true,
                info: true,
                buttons: [{
                        extend: 'pdfHtml5',
                        text: '📄 Export PDF',
                        className: 'btn btn-danger btn-sm',
                        exportOptions: {
                            columns: ':not(:first-child):not(:last-child)'
                            // exclude checkbox + Actions
                        }
                    },
                    {
                        extend: 'print',
                        text: '🖨️ Print Table',
                        className: 'btn btn-success btn-sm',
                        exportOptions: {
                            columns: ':not(:first-child):not(:last-child)'
                        }
                    }
                ]
            });
        });
    </script>
@endpush
