@extends(request()->ajax() ? 'layouts.ajax' : 'layouts.app')

@section('content')

<div class="container-fluid py-2">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold text-dark mb-1">Dashboard Overview</h4>
            <p class="text-muted">Here's what's happening in your HR system today.</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="dashboard-card border-bottom border-primary border-4 text-center">
                <i class="fa fa-users fs-1 text-primary opacity-50 mb-3"></i>
                <h6 class="text-muted fw-bold" style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Total Employees</h6>
                <h2 class="mb-0 fw-bold text-dark">{{ $employeeCount ?? 0 }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card border-bottom border-success border-4 text-center">
                <i class="fa fa-building fs-1 text-success opacity-50 mb-3"></i>
                <h6 class="text-muted fw-bold" style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Departments</h6>
                <h2 class="mb-0 fw-bold text-dark">{{ $departmentCount ?? 0 }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card border-bottom border-warning border-4 text-center">
                <i class="fa fa-calendar-check fs-1 text-warning opacity-50 mb-3"></i>
                <h6 class="text-muted fw-bold" style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Upcoming Events</h6>
                <h2 class="mb-0 fw-bold text-dark">0</h2> </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card border-bottom border-danger border-4 text-center">
                <i class="fa fa-money-bill-wave fs-1 text-danger opacity-50 mb-3"></i>
                <h6 class="text-muted fw-bold" style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Monthly Payroll</h6>
                <h2 class="mb-0 fw-bold text-dark">$0</h2> </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="dashboard-card h-100">
                <h5 class="dashboard-card-title mb-4">Salary Statistics (Current Year)</h5>
                <canvas id="salaryChart" height="100"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card h-100">
                <h5 class="dashboard-card-title mb-4">Employee Status</h5>
                <canvas id="employeeStatusChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        if(document.getElementById('salaryChart')) {
            var salaryCtx = document.getElementById('salaryChart').getContext('2d');
            new Chart(salaryCtx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Total Salary Paid ($)',
                        data: [12000, 19000, 30000, 25000, 22000, 28000],
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: '#3b82f6',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: { responsive: true, scales: { y: { beginAtZero: true } } }
            });
        }

        if(document.getElementById('employeeStatusChart')) {
            var statusCtx = document.getElementById('employeeStatusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Active', 'On Leave', 'Inactive'],
                    datasets: [{
                        data: [85, 10, 5],
                        backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                        borderWidth: 0
                    }]
                },
                options: { responsive: true, cutout: '70%', plugins: { legend: { position: 'bottom' } } }
            });
        }
    });
</script>

@endsection
