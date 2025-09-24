<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th><input type="checkbox" id="select-all"></th>
                <th>Case No.</th>
                <th>Court</th>
                <th>Client Mobile</th>
                <th>Next Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cases as $case)
                <tr>
                    <td><input type="checkbox" onchange="toggleSelection(this, '{{ $case->client_mobile }}')"></td>
                    <td>{{ $case->case_number }}</td>
                    <td>{{ $case->court_name }}</td>
                    <td>
                        <a href="tel:{{ $case->client_mobile }}">{{ $case->client_mobile }}</a>
                    </td>
                    <td>{{ $case->next_date ? $case->next_date->format('d M, Y') : 'N/A' }}</td>
                    <td>
                        <a href="{{ route('cases.show', $case) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('cases.edit', $case) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('cases.destroy', $case) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No cases found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<button class="btn btn-success mt-3" onclick="showSmsModal()">Send SMS to Selected</button>