@extends(request()->ajax() ? 'layouts.ajax' : 'layouts.app')

@section('content')
<div class="dashboard-card mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <h5 class="dashboard-card-title mb-0">
            <i class="fa fa-chart-bar text-primary me-2"></i> Monthly Attendance Report
        </h5>

        <form action="{{ route('attendance.report') }}" method="GET" class="d-flex align-items-center mt-3 mt-md-0" id="report-form">
            <select name="month" class="form-select form-select-sm me-2 report-filter">
                @for($m=1; $m<=12; ++$m)
                    <option value="{{ sprintf("%02d", $m) }}" {{ $month == sprintf("%02d", $m) ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                    </option>
                @endfor
            </select>
            <select name="year" class="form-select form-select-sm report-filter">
                @for($y = date('Y'); $y >= date('Y')-2; $y--)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm text-center align-middle" style="font-size: 13px;">
            <thead class="table-light">
                <tr>
                    <th class="text-start text-uppercase" style="min-width: 150px;">Employee</th>
                    @for($i = 1; $i <= $daysInMonth; $i++)
                        <th>{{ $i }}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $emp)
                    <tr>
                        <td class="text-start fw-bold text-dark">{{ $emp->first_name }} {{ $emp->last_name }}</td>

                        @for($i = 1; $i <= $daysInMonth; $i++)
                            @php
                                $status = $attendanceData[$emp->id][$i] ?? '-';
                                $badgeClass = 'text-muted'; 
                                $letter = '-';

                                if($status == 'Present') { $badgeClass = 'text-success fw-bold'; $letter = 'P'; }
                                elseif($status == 'Absent') { $badgeClass = 'text-danger fw-bold'; $letter = 'A'; }
                                elseif($status == 'Half Day') { $badgeClass = 'text-warning fw-bold'; $letter = 'H'; }
                                elseif($status == 'On Leave') { $badgeClass = 'text-primary fw-bold'; $letter = 'L'; }
                            @endphp
                            <td class="{{ $badgeClass }}" title="{{ $status }}">{{ $letter }}</td>
                        @endfor
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $daysInMonth + 1 }}" class="text-center py-4">No employees found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex mt-3 gap-3 small fw-bold">
            <span class="text-success"><i class="fa fa-circle"></i> P = Present</span>
            <span class="text-danger"><i class="fa fa-circle"></i> A = Absent</span>
            <span class="text-warning"><i class="fa fa-circle"></i> H = Half Day</span>
            <span class="text-primary"><i class="fa fa-circle"></i> L = Leave</span>
        </div>
    </div>
</div>

<script>
    $('.report-filter').change(function() {
        let url = $('#report-form').attr('action') + '?' + $('#report-form').serialize();
        if(typeof loadPage === "function") {
            loadPage(url);
        } else {
            window.location.href = url;
        }
    });
</script>
@endsection
