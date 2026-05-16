@extends(request()->ajax() ? 'layouts.ajax' : 'Employee.layout.app')

@section('content')

<div class="container-fluid py-2">

<div class="row mb-4">
<div class="col-12">
<h4 class="fw-bold text-dark mb-1">Employee Dashboard</h4>
<p class="text-muted">Welcome {{ auth()->user()->name }}</p>
</div>
</div>

<div class="row g-4 mb-4">

<div class="col-md-3">
<div class="dashboard-card border-bottom border-primary border-4 text-center">
<i class="fa fa-calendar-check fs-1 text-primary opacity-50 mb-3"></i>
<h6 class="text-muted fw-bold">My Attendance</h6>
<h2 class="fw-bold">0</h2>
</div>
</div>

<div class="col-md-3">
<div class="dashboard-card border-bottom border-success border-4 text-center">
<i class="fa fa-plane fs-1 text-success opacity-50 mb-3"></i>
<h6 class="text-muted fw-bold">My Leaves</h6>
<h2 class="fw-bold">0</h2>
</div>
</div>

<div class="col-md-3">
<div class="dashboard-card border-bottom border-warning border-4 text-center">
<i class="fa fa-building fs-1 text-warning opacity-50 mb-3"></i>
<h6 class="text-muted fw-bold">Department</h6>
<h5 class="fw-bold">0</h5>
</div>
</div>

<div class="col-md-3">
<div class="dashboard-card border-bottom border-danger border-4 text-center">
<i class="fa fa-money-bill fs-1 text-danger opacity-50 mb-3"></i>
<h6 class="text-muted fw-bold">Monthly Salary</h6>
<h5 class="fw-bold">0</h5>
</div>
</div>

</div>


<div class="row g-4">

<div class="col-md-8">
<div class="dashboard-card">
<h5 class="dashboard-card-title">My Attendance Overview</h5>
<canvas id="attendanceChart" height="100"></canvas>
</div>
</div>

<div class="col-md-4">
<div class="dashboard-card">
<h5 class="dashboard-card-title">Leave Status</h5>
<canvas id="leaveChart" height="200"></canvas>
</div>
</div>

</div>

</div>


<script>

if(document.getElementById('attendanceChart')){

var ctx = document.getElementById('attendanceChart').getContext('2d');

new Chart(ctx,{
type:'bar',
data:{
labels:['Mon','Tue','Wed','Thu','Fri','Sat'],
datasets:[{
label:'Hours Worked',
data:[8,8,7,8,6,0],
backgroundColor:'rgba(54,162,235,0.7)'
}]
},
options:{responsive:true}
});

}

if(document.getElementById('leaveChart')){

var ctx2=document.getElementById('leaveChart').getContext('2d');

new Chart(ctx2,{
type:'doughnut',
data:{
labels:['Approved','Pending','Rejected'],
datasets:[{
data:[3,1,0],
backgroundColor:['#28a745','#ffc107','#dc3545']
}]
}
});

}

</script>

@endsection