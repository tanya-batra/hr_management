@extends('layouts.app')
@section('content')
    <div class="container py-4">
        <div class="card shadow-sm rounded-3 p-4">
            <h4 class="mb-4">{{ isset($employee) ? 'Edit Employee' : 'Add Employee' }}</h4>

            <form action="{{ isset($employee) ? route('employees.update', $employee->id) : route('employees.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($employee))
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Profile Image</label>
                        <input type="file" name="profile" class="form-control">
                        @if (isset($employee) && $employee->profile)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $employee->profile) }}" alt="Profile Image"
                                    class="img-thumbnail" width="100">
                            </div>
                        @endif
                        @error('profile_image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label>First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" value="{{ old('first_name', $employee->first_name ?? '') }}"
                            class="form-control">
                        @error('first_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label>Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $employee->last_name ?? '') }}"
                            class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $employee->email ?? '') }}"
                            class="form-control">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label>Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $employee->phone ?? '') }}"
                            class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Gender</label>
                        <select name="gender" class="form-control">
                            <option value="Male"
                                {{ old('gender', $employee->gender ?? '') == 'Male' ? 'selected' : '' }}>Male
                            </option>
                            <option value="Female"
                                {{ old('gender', $employee->gender ?? '') == 'Female' ? 'selected' : '' }}>
                                Female</option>
                            <option value="Other"
                                {{ old('gender', $employee->gender ?? '') == 'Other' ? 'selected' : '' }}>
                                Other</option>
                        </select>
                    </div>

                    <!-- Job Info -->
                    <div class="col-md-6">
                        <label>Position</label>
                        <input type="text" name="position" value="{{ old('position', $employee->position ?? '') }}"
                            class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Department</label>
                        <select name="department_id" class="form-control">
                            <option value="">-- Select Department --</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}"
                                    {{ old('department_id', $employee->department_id ?? '') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Salary</label>
                        <input type="text" name="salary" value="{{ old('salary', $employee->salary ?? '') }}"
                            class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Join Date</label>
                        <input type="date" name="join_date" value="{{ old('join_date', $employee->join_date ?? '') }}"
                            class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="Active"
                                {{ old('status', $employee->status ?? '') == 'Active' ? 'selected' : '' }}>
                                Active</option>
                            <option value="Inactive"
                                {{ old('status', $employee->status ?? '') == 'Inactive' ? 'selected' : '' }}>Inactive
                            </option>
                            <option value="Terminated"
                                {{ old('status', $employee->status ?? '') == 'Terminated' ? 'selected' : '' }}>Terminated
                            </option>
                        </select>
                    </div>

                    <!-- Address Info -->
                    <div class="col-md-6">
                        <label>Address</label>
                        <input type="text" name="address" value="{{ old('address', $employee->address ?? '') }}"
                            class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>City</label>
                        <input type="text" name="city" value="{{ old('city', $employee->city ?? '') }}"
                            class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>State</label>
                        <input type="text" name="state" value="{{ old('state', $employee->state ?? '') }}"
                            class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Pincode</label>
                        <input type="text" name="pincode" value="{{ old('pincode', $employee->pincode ?? '') }}"
                            class="form-control">
                    </div>

                    <!-- File Uploads -->
                    <div class="col-md-6">
                        <label>Resume</label>
                        <input type="file" name="resume" class="form-control">
                        @if (isset($employee) && $employee->resume)
                            <a href="{{ asset('storage/' . $employee->resume) }}" target="_blank"
                                class="btn btn-sm btn-outline-primary mt-1">View Resume</a>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label>Certificate</label>
                        <input type="file" name="certificate" class="form-control">
                        @if (isset($employee) && $employee->certificate)
                            <a href="{{ asset('storage/' . $employee->certificate) }}" target="_blank"
                                class="btn btn-sm btn-outline-success mt-1">View Certificate</a>
                        @endif
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($employee) ? 'Update Employee' : 'Save Employee' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .card label {
            font-weight: 500;
        }
    </style>
@endsection
