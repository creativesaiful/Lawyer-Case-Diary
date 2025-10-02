<div class="table-responsive">
    <table id="cases-table" class="table table-striped table-hover">
        <thead>
            <tr>
                <th><input type="checkbox" id="select-all"></th>
                <th>মামলা নং</th>
                <th>কোর্ট</th>
                <th>বাদী</th>
                <th>বিবাদী</th>
                <th>মোবাইল</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cases as $case)
                <tr>
                    <td><input type="checkbox" onchange="toggleSelection(this, '{{ $case->client_mobile }}')"></td>
                    <td>{{ $case->case_number }}</td>
                    <td>{{ $case->court->court_name }}</td>
                    <td>{{ $case->plaintiff_name }}</td>
                    <td>{{ $case->defendant_name }}</td>
                    <td>
                        <a href="tel:{{ $case->client_mobile }}">{{ $case->client_mobile }}</a>
                    </td>
                    <td>
                        <a href="{{ route('cases.show', $case) }}" class="btn btn-sm btn-info">View</a>
                        {{-- <a href="{{ route('cases.date-update', $case) }}" class="btn btn-sm btn-warning">Update</a> --}}
                        @if(auth()->user()->role === 'lawyer')
                        <a href="{{ route('cases.edit', $case) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('cases.destroy', $case) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No cases found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
