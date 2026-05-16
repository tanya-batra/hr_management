@extends(request()->ajax() ? 'layouts.ajax' : 'layouts.app')

@section('content')
<div class="dashboard-card mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <h5 class="dashboard-card-title mb-0">
            <i class="fa fa-calendar-check text-primary me-2"></i> Mark Attendance
        </h5>

        <form action="{{ route('attendance.index') }}" method="GET" class="d-flex align-items-center mt-3 mt-md-0" id="date-form">
            <label class="fw-bold me-2 mb-0">Select Date:</label>
            <input type="date" name="date" class="form-control form-control-sm" value="{{ $date }}" id="attendance-date" max="{{ date('Y-m-d') }}">
        </form>
    </div>

    <form action="{{ route('attendance.store') }}" method="POST" class="ajax-form">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-uppercase" style="font-size: 0.85rem;">
                    <tr>
                        <th>Employee</th>
                        <th>Department</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $emp)
                        @php
                            $currentStatus = isset($attendances[$emp->id]) ? $attendances[$emp->id]->status : 'Present';
                        @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($emp->profile)
                                        <img src="{{ asset($emp->profile) }}" class="rounded-circle shadow-sm me-3" width="40" height="40" style="object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-primary fw-bold me-3" style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($emp->first_name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold text-dark">{{ $emp->first_name }} {{ $emp->last_name }}</div>
                                        <div class="text-muted" style="font-size: 12px;">{{ $emp->employee_id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-info text-dark">{{ $emp->department->name ?? 'N/A' }}</span></td>

                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" name="attendance[{{ $emp->id }}]" id="present_{{ $emp->id }}" value="Present" {{ $currentStatus == 'Present' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-success btn-sm px-3" for="present_{{ $emp->id }}">Present</label>

                                    <input type="radio" class="btn-check" name="attendance[{{ $emp->id }}]" id="absent_{{ $emp->id }}" value="Absent" {{ $currentStatus == 'Absent' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-danger btn-sm px-3" for="absent_{{ $emp->id }}">Absent</label>

                                    <input type="radio" class="btn-check" name="attendance[{{ $emp->id }}]" id="half_{{ $emp->id }}" value="Half Day" {{ $currentStatus == 'Half Day' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-warning btn-sm px-3" for="half_{{ $emp->id }}">Half Day</label>

                                    <input type="radio" class="btn-check" name="attendance[{{ $emp->id }}]" id="leave_{{ $emp->id }}" value="On Leave" {{ $currentStatus == 'On Leave' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-secondary btn-sm px-3" for="leave_{{ $emp->id }}">Leave</label>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center py-5 text-muted"><i class="fa fa-users fs-1 d-block mb-2"></i>No Active Employees Found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($employees->count() > 0)
        <div class="text-end pt-4 mt-3 border-top">
            <button type="submit" class="btn btn-primary px-4 py-2">
                <i class="fa fa-save me-1"></i> Save Attendance
            </button>
        </div>
        @endif
    </form>
</div>

<script>
    $('#attendance-date').change(function() {
        let url = $('#date-form').attr('action') + '?date=' + $(this).val();

        $('.sidebar-menu a').removeClass('active');
        $('a[href*="attendance"]').addClass('active');

        if(typeof loadPage === "function") {
            loadPage(url);
        } else {
            window.location.href = url;
        }
    });
</script>
@endsection
