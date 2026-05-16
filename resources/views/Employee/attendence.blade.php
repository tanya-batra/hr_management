
@extends(request()->ajax() ? 'layouts.ajax' : 'Employee.layout.app')
@section('content')

<div class="container-fluid">

<div class="card shadow-sm border-0">
<div class="card-body">

<h4 class="mb-4 fw-bold">My Attendance</h4>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Attendance Buttons -->
<div class="d-flex gap-2 mb-4">

<form action="{{ route('employee.checkin') }}" method="POST">
@csrf
<button class="btn btn-success px-4">
<i class="fa fa-sign-in-alt"></i> Check In
</button>
</form>

<form action="{{ route('employee.checkout') }}" method="POST">
@csrf
<button class="btn btn-danger px-4">
<i class="fa fa-sign-out-alt"></i> Check Out
</button>
</form>

</div>

<!-- Attendance Table -->
<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead class="table-dark">
<tr>
<th>Date</th>
<th>Check In</th>
<th>Check Out</th>
<th>Status</th>
</tr>
</thead>

<tbody>

@forelse($attendance as $row)

<tr>
<td>{{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}</td>
<td>
<span class="badge bg-success">
{{ $row->clock_in ?? '—' }}
</span>
</td>

<td>
<span class="badge bg-danger">
{{ $row->clock_out ?? '—' }}
</span>
</td>

<td>
@if($row->status == 'Present')
<span class="badge bg-primary">Present</span>
@elseif($row->status == 'Absent')
<span class="badge bg-warning text-dark">Absent</span>
@else
<span class="badge bg-secondary">{{ $row->status }}</span>
@endif
</td>

</tr>

@empty

<tr>
<td colspan="4" class="text-center text-muted">
No Attendance Record Found
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>
</div>

</div>

@endsection