@extends('layouts.app')

@push('styles')
<!-- DataTables CSS -->



<style> 
/* Highlight color for matched search text */
.highlight {
    background-color: yellow;
    padding: 0 2px;
    border-radius: 3px;
}

/* Optional: make the custom search box bigger */
#search-input {
    font-size: 16px;
    height: 42px;
}
    #cases-table_filter {
    display: none; /* Hide default search box */
}

</style>
@endpush

@section('content')
<div class="container-fluid">
    <h2>Case Diaries</h2>
    <hr>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="row mb-3">
        <div class="col-md-6 mb-2">
            <div class="input-group mb-3">
                <input type="text" id="search-input" class="form-control" placeholder="🔍 Search cases...">
            </div>
        </div>

       
    </div>

    <div id="case-list-container">
        {{-- Make sure inside this partial table tag has id="cases-table" --}}
        @include('cases.partials.case-list-table')
    </div>
</div>

<!-- SMS Modal -->
<div class="modal fade" id="smsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send SMS to Clients</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="sms-form">
                    @csrf
                    <div class="mb-3">
                        <label for="sms-numbers" class="form-label">Recipients</label>
                        <input type="text" id="sms-numbers" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="sms-message" class="form-label">Message</label>
                        <textarea id="sms-message" class="form-control" rows="4" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="sendSms()">Send</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')



<script>
$(document).ready(function () {
    let table = $('#cases-table').DataTable({
        dom: 'Bfrtip',
        paging: true,
        pageLength: 10,
        lengthChange: true,
        info: true,
        searchHighlight: true,
        buttons: [
            {
                extend: 'pdfHtml5',
                text: '📄 Export PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: ':not(:last-child)'  // exclude last column (Actions)
                }
            },
            {
                extend: 'print',
                text: '🖨️ Print Table',
                className: 'btn btn-success btn-sm',
                exportOptions: {
                    columns: ':not(:last-child)'  // exclude last column (Actions)
                }
            }
        ]
    });

    // Custom search box
    $('#search-input').on('keyup', function () {
        table.search(this.value).draw();
    });
});

</script>
@endpush
