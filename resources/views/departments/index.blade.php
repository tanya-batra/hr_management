@extends(request()->ajax() ? 'layouts.ajax' : 'layouts.app')

@section('content')

<div class="row mb-4">
    <div class="col-md-4">
        <div class="dashboard-card d-flex align-items-center mb-0" style="border-left: 4px solid #007bff;">
            <div class="flex-grow-1">
                <h6 class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 13px;">Total Departments</h6>
                <h3 class="mb-0 fw-bold">{{ $departments->count() }}</h3>
            </div>
            <div>
                <i class="fa fa-building fs-1 text-primary opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="dashboard-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="dashboard-card-title mb-0">Departments List</h5>
        <a href="{{ route('department.create') }}" class="btn btn-primary ajax-link">
            <i class="fa fa-plus-circle me-1"></i> Add New Department
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="30%">Department Name</th>
                    <th width="40%">Description</th>
                    <th width="15%">Created Date</th>
                    <th width="10%" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departments as $key => $dept)
                <tr>
                    <td class="text-muted">{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="fw-bold text-dark">{{ $dept->name }}</td>
                    <td class="text-muted">{{ \Illuminate\Support\Str::limit($dept->description, 60) ?: '-' }}</td>
                    <td>{{ $dept->created_at->format('d M, Y') }}</td>
                    <td class="text-center">
                        <a href="{{ route('department.edit', $dept->id) }}" class="btn btn-sm btn-light text-primary border ajax-link me-1" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form action="{{ route('department.destroy', $dept->id) }}" method="POST" class="d-inline ajax-form delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-light text-danger border delete-btn" title="Delete">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="fa fa-folder-open fs-1 d-block mb-3 text-light"></i>
                        <h6 class="mb-0">No Departments Found</h6>
                    </td>
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
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        })
    });
</script>

@endsection
