@extends('layouts.app')

{{-- css --}}
@push('styles')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css"
        rel="stylesheet">

    <style>
        a.lawyer-link:hover {
            color: #0d6efd;
 
            text-decoration: underline;
        }
    </style>
@endpush


@section('content')
    <div class="container">
        <h1>All Lawyers</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Chamber No</th>
                    <th>Bar Number</th>
                    <th>Payment</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lawyers as $lawyer)
                    <tr>
                        <td>

                            <a href="{{ route('admin.lawyers.view', $lawyer->id) }}"
                                class="lawyer-link text-decoration-none">
                                {{ $lawyer->name }}
                            </a>
                        </td>
                        <td>{{ $lawyer->mobile }}</td>
                        <td>{{ $lawyer->chamber->chamber_no }}</td>
                        <td>{{ $lawyer->bar_number }}</td>
                        <td>YES</td>
                        <td>
                            <input type="checkbox" class="lawyer-status-toggle" data-lawyer-id="{{ $lawyer->id }}"
                                {{ $lawyer->approved ? 'checked' : '' }} data-toggle="switchbutton" data-onlabel="Active"
                                data-offlabel="Inactive" data-onstyle="success" data-offstyle="danger">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

{{-- js --}}
@push('scripts')
    <script>
        $(document).on('change', '.lawyer-status-toggle', function() {
            let lawyerId = $(this).data('lawyer-id');
            let status = $(this).prop('checked') ? 1 : 0;

            $.ajax({
                url: "{{ route('admin.lawyers.toggleStatus') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    lawyer_id: lawyerId,
                    status: status
                },
                success: function(response) {
                    toastr.success(response.message);
                },
                error: function() {
                    toastr.error('Something went wrong!');
                }
            });
        });
    </script>
@endpush
