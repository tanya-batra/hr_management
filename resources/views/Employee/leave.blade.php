@extends(request()->ajax() ? 'layouts.ajax' : 'Employee.layout.app')
@section('content')
    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-4">My Leave</h4>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Apply Leave Button Right Side -->
            <div class="d-flex justify-content-end mb-4 me-3">
                <button class="btn btn-warning" onclick="toggleLeaveForm()">
                    <i class="fa fa-plus"></i> Apply Leave
                </button>
            </div>

            <!-- Leave Form -->
            <div id="leaveForm" style="display:none;">
                <form action="{{ route('employee.leave.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>From Date</label>
                            <input type="date" name="from_date" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>To Date</label>
                            <input type="date" name="to_date" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Reason</label>
                            <input type="text" name="reason" class="form-control" required>
                        </div>
                    </div>
                    <button class="btn btn-success">Submit Leave</button>
                </form>
                <hr>
            </div>

            <h5 class="mt-4">My Leave Requests</h5>

            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>From</th>
                        <th>To</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Reject Reason</th> <!-- New Column -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaves as $leave)
                        <tr>
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
                                @endif
                            </td>
                            <td>
                                @if ($leave->status == 'Rejected' && $leave->reject_reason)
                                    {{ $leave->reject_reason }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    <script>
        function toggleLeaveForm() {
            var form = document.getElementById("leaveForm");
            form.style.display = form.style.display === "none" ? "block" : "none";
        }
    </script>
@endsection
