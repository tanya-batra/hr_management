@extends(request()->ajax() ? 'layouts.ajax' : 'layouts.app')

@section('content')
    <div class="dashboard-card mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="dashboard-card-title mb-0"><i class="fa fa-users text-primary me-2"></i> Employees List</h5>
            <a href="{{ route('employees.create') }}" class="btn btn-primary ajax-link">
                <i class="fa fa-user-plus me-1"></i> Add Employee
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-uppercase" style="font-size: 0.85rem;">
                    <tr>
                        <th>Profile</th>
                        <th>EMP ID</th>
                        <th>Name & Email</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Join Date</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $emp)
                        <tr>
                            <td>
                                @if ($emp->profile)
                                    <img src="{{ asset($emp->profile) }}" class="rounded-circle shadow-sm" width="45"
                                        height="45" style="object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-primary fw-bold"
                                        style="width: 45px; height: 45px;">
                                        {{ strtoupper(substr($emp->first_name, 0, 1)) }}
                                    </div>
                                @endif
                            </td>
                            <td class="fw-bold text-muted">{{ $emp->employee_id }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $emp->first_name }} {{ $emp->last_name }}</div>
                                <div class="text-muted" style="font-size: 12px;"><i
                                        class="fa fa-envelope me-1"></i>{{ $emp->email }}</div>
                            </td>
                            <td><span class="badge bg-info text-dark">{{ $emp->department->name ?? 'N/A' }}</span></td>
                            <td class="text-muted">{{ $emp->position ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($emp->join_date)->format('d M, Y') }}</td>
                            <td>
                                <span
                                    class="badge {{ $emp->status == 'Active' ? 'bg-success' : 'bg-danger' }}">{{ $emp->status }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('employees.offerLetter', $emp->id) }}"
                                    class="btn btn-sm btn-light text-success border me-1" title="Offer Letter">
                                    <i class="fa fa-file-pdf"></i>
                                </a>
                                <a href="{{ route('employees.edit', $emp->id) }}"
                                    class="btn btn-sm btn-light text-primary border ajax-link me-1" title="Edit"><i
                                        class="fa fa-edit"></i></a>
                                <form action="{{ route('employees.destroy', $emp->id) }}" method="POST"
                                    class="d-inline ajax-form delete-form">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-light text-danger border delete-btn"
                                        title="Delete"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted"><i
                                    class="fa fa-users fs-1 d-block mb-2"></i>No Employees Found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $('.delete-btn').click(function() {
            let form = $(this).closest('form');
            Swal.fire({
                    title: 'Delete Employee?',
                    text: "This will remove the employee permanently.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Yes, delete!'
                })
                .then((result) => {
                    if (result.isConfirmed) form.submit();
                });
        });
    </script>
@endsection
