@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2>Case Diaries</h2>
    <hr>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="row mb-3">
        <div class="col-md-6 mb-2">
            <div class="input-group">
                <input type="text" id="search-input" class="form-control" placeholder="Search cases...">
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <input type="date" id="date-filter" class="form-control">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100" onclick="exportToPdf()">Export PDF</button>
        </div>
    </div>

    <div id="case-list-container">
        @include('cases.partials.case-list-table')
    </div>
</div>

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
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    // AJAX Search & Filter
    const searchInput = document.getElementById('search-input');
    const dateFilter = document.getElementById('date-filter');
    const caseListContainer = document.getElementById('case-list-container');
    let timeoutId;

    function fetchCases() {
        const query = searchInput.value;
        const date = dateFilter.value;

        axios.get('{{ route('cases.search') }}', {
            params: { query, date }
        })
        .then(response => {
            caseListContainer.innerHTML = response.data.html;
        })
        .catch(error => console.error(error));
    }
    
    searchInput.addEventListener('input', () => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(fetchCases, 300); // Debounce
    });
    
    dateFilter.addEventListener('change', fetchCases);

    // SMS Functionality
    let selectedCases = [];
    const smsModal = new bootstrap.Modal(document.getElementById('smsModal'));

    function toggleSelection(checkbox, mobile) {
        if (checkbox.checked) {
            selectedCases.push(mobile);
        } else {
            selectedCases = selectedCases.filter(item => item !== mobile);
        }
        document.getElementById('sms-numbers').value = selectedCases.join(', ');
    }

    function showSmsModal() {
        if (selectedCases.length > 0) {
            smsModal.show();
        } else {
            alert('Please select at least one case to send SMS.');
        }
    }

    function sendSms() {
        const message = document.getElementById('sms-message').value;
        const mobileNumbers = selectedCases;
        
        axios.post('{{ route('send.sms') }}', {
            mobile_numbers: mobileNumbers,
            message: message,
            _token: '{{ csrf_token() }}'
        })
        .then(response => {
            alert(response.data.success);
            smsModal.hide();
            selectedCases = [];
            document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
        })
        .catch(error => {
            alert(error.response.data.error || 'Failed to send SMS.');
        });
    }
    
    // PDF Export
    function exportToPdf() {
        const query = searchInput.value;
        const date = dateFilter.value;
        const url = '{{ route('cases.export.pdf') }}' + `?query=${query}&date=${date}`;
        window.open(url, '_blank');
    }
</script>
@endpush