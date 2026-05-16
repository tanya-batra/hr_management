@extends('layouts.app')

@section('content')
    <div class="container py-4">

        <!-- Profile Card -->
        <div class="card shadow-lg rounded-4 border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-person-circle me-2"></i> Employee Profile</h4>
                <a href="{{ route('employees.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left-circle"></i> Back
                </a>
            </div>

            <div class="card-body p-4">
                <div class="row g-3 mb-4 text-center">
                    <!-- Profile Image -->
                    <div class="col-12">
                        @if ($employee->profile)
                            <img src="{{ asset($employee->profile) }}" alt="Profile Image" class="rounded-circle shadow-sm"
                                style="width:150px;height:150px;object-fit:cover;">
                        @else
                            <img src="{{ asset('default-profile.png') }}" alt="Profile Image"
                                class="rounded-circle shadow-sm" style="width:150px;height:150px;object-fit:cover;">
                        @endif
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted">Employee ID</h6>
                        <p class="fw-bold">{{ $employee->employee_id }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Full Name</h6>
                        <p class="fw-bold">{{ $employee->first_name }} {{ $employee->last_name }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Email</h6>
                        <p><a href="mailto:{{ $employee->email }}" class="text-decoration-none">{{ $employee->email }}</a>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Phone</h6>
                        <p>{{ $employee->phone ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Gender</h6>
                        <p>{{ $employee->gender }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Department</h6>
                        <p>{{ $employee->department->name ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Position</h6>
                        <p>{{ $employee->position ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Salary</h6>
                        <p>${{ number_format($employee->salary, 2) }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Status</h6>
                        <span
                            class="badge bg-{{ $employee->status == 'Active' ? 'success' : 'secondary' }} text-uppercase py-2 px-3">
                            {{ $employee->status }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Join Date</h6>
                        <p>{{ $employee->join_date ? \Carbon\Carbon::parse($employee->join_date)->format('d M, Y') : '-' }}
                        </p>
                    </div>
                    <div class="col-12">
                        <h6 class="text-muted">Profile Description</h6>
                        <p>{{ $employee->profile_text ?? '-' }}</p>
                    </div>
                    <div class="col-12">
                        <h6 class="text-muted">Address</h6>
                        <p>{{ $employee->address }}, {{ $employee->city }}, {{ $employee->state }},
                            {{ $employee->pincode }}</p>
                    </div>
                </div>

                <!-- Files -->
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <h6 class="text-muted">Resume</h6>
                        @if ($employee->resume)
                            <a href="{{ asset($employee->resume) }}" target="_blank"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-file-earmark-text me-1"></i> View Resume
                            </a>
                        @else
                            <span class="text-muted">No Resume</span>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted">Certificate</h6>
                        @if ($employee->certificate)
                            <a href="{{ asset($employee->certificate) }}" target="_blank"
                                class="btn btn-outline-success btn-sm">
                                <i class="bi bi-file-earmark-check me-1"></i> View Certificate
                            </a>
                        @else
                            <span class="text-muted">No Certificate</span>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted">Offer Letter</h6>
                        @if ($employee->offer_letter)
                            <a href="{{ asset($employee->offer_letter) }}" target="_blank"
                                class="btn btn-outline-info btn-sm">
                                <i class="bi bi-file-earmark-pdf me-1"></i> View Offer Letter
                            </a>
                        @else
                            <span class="text-muted">No Offer Letter</span>
                        @endif

                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square me-1"></i> Edit
                    </a>



                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            <i class="bi bi-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card-header {
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }

        .card-body h6 {
            font-weight: 500;
            font-size: 0.85rem;
            color: #6c757d;
        }

        .card-body p {
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .btn-sm i {
            vertical-align: -2px;
        }
    </style>
@endsection
