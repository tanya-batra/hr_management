@extends(request()->ajax() ? 'layouts.ajax' : 'layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Employee Leave Requests</h4>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Employee</th>
                        <th>Employee Id</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaves as $leave)
                        <tr>
                            <td>{{ $leave->employee->first_name }} {{ $leave->employee->last_name }}</td>
                            <td>{{ $leave->employee->employee_id }}</td>
                            <td>{{ $leave->from_date }}</td>
                            <td>{{ $leave->to_date }}</td>
                            <td>{{ $leave->reason }}</td>
                            <td>
                                @if ($leave->status == 'Pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($leave->status == 'Approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                    <br>
                                    <small>Reason: {{ $leave->reject_reason }}</small>
                                @endif
                            </td>
                            <td>
                                @if ($leave->status == 'Pending')
                                    <a href="{{ route('leave.approve', $leave->id) }}"
                                        class="btn btn-success btn-sm">Approve</a>
                                    <button class="btn btn-danger btn-sm"
                                        onclick="openRejectModal({{ $leave->id }})">Reject</button>
                                @else
                                    <span class="text-success fw-bold">Done</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('leave.reject') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Reject Leave</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="leave_id" id="leave_id">
                        <label>Reason</label>
                        <input type="text" name="reject_reason" id="reject_reason" class="form-control" required
                            placeholder="enter reason">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Reject Leave</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal(id) {
            document.getElementById('leave_id').value = id;
            var modal = new bootstrap.Modal(document.getElementById('rejectModal'));
            modal.show();
        }
    </script>
@endsection
