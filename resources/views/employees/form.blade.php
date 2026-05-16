@extends(request()->ajax() ? 'layouts.ajax' : 'layouts.app')

@section('content')
<div class="dashboard-card">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <h5 class="dashboard-card-title mb-0">
            <i class="fa {{ isset($employee) ? 'fa-user-edit' : 'fa-user-plus' }} text-primary me-2"></i>
            {{ isset($employee) ? 'Edit Employee' : 'Add New Employee' }}
        </h5>
        <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary btn-sm ajax-link">
            <i class="fa fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <form action="{{ isset($employee) ? route('employees.update', $employee->id) : route('employees.store') }}"
          method="POST" enctype="multipart/form-data" class="ajax-form">
        @csrf
        @if(isset($employee)) @method('PUT') @endif

        <div class="row g-4">
            <h6 class="text-primary fw-bold mb-0 border-bottom pb-2">Personal Information</h6>

            <div class="col-md-4">
                <label class="form-label fw-bold">First Name <span class="text-danger">*</span></label>
                <input type="text" name="first_name" class="form-control" value="{{ $employee->first_name ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Last Name</label>
                <input type="text" name="last_name" class="form-control" value="{{ $employee->last_name ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Gender <span class="text-danger">*</span></label>
                <select name="gender" class="form-select">
                    <option value="Male" {{ (isset($employee) && $employee->gender == 'Male') ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ (isset($employee) && $employee->gender == 'Female') ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ (isset($employee) && $employee->gender == 'Other') ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ $employee->email ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ $employee->phone ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Profile Picture</label>
                <input type="file" name="profile" class="form-control" accept="image/*">
            </div>

            <h6 class="text-primary fw-bold mb-0 mt-5 border-bottom pb-2">Job Details</h6>

            <div class="col-md-4">
                <label class="form-label fw-bold">Department <span class="text-danger">*</span></label>
                <select name="department_id" class="form-select">
                    <option value="">Select Department</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ (isset($employee) && $employee->department_id == $dept->id) ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Position</label>
                <input type="text" name="position" class="form-control" value="{{ $employee->position ?? '' }}" placeholder="e.g. Senior Developer">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Salary <span class="text-danger">*</span></label>
                <input type="number" name="salary" class="form-control" value="{{ $employee->salary ?? '' }}">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-bold">Joining Date <span class="text-danger">*</span></label>
                <input type="date" name="join_date" class="form-control" value="{{ isset($employee) && $employee->join_date ? \Carbon\Carbon::parse($employee->join_date)->format('Y-m-d') : '' }}">
                @if(isset($employee))
                    <small class="text-muted d-block mt-1"><i class="fa fa-info-circle"></i> Edits used: {{ $employee->join_date_edits ?? 0 }} / 2</small>
                @endif
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-select">
                    <option value="Active" {{ (isset($employee) && $employee->status == 'Active') ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ (isset($employee) && $employee->status == 'Inactive') ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <h6 class="text-primary fw-bold mb-0 mt-5 border-bottom pb-2">Address & Documents</h6>

            <div class="col-md-12">
                <label class="form-label fw-bold">Address</label>
                <input type="text" name="address" class="form-control" value="{{ $employee->address ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">City</label>
                <input type="text" name="city" class="form-control" value="{{ $employee->city ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">State</label>
                <input type="text" name="state" class="form-control" value="{{ $employee->state ?? '' }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Pincode</label>
                <input type="text" name="pincode" class="form-control" value="{{ $employee->pincode ?? '' }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Resume (PDF/DOC)</label>
                <input type="file" name="resume" class="form-control" accept=".pdf,.doc,.docx">
                @if(isset($employee) && $employee->resume)
                    <a href="{{ asset($employee->resume) }}" target="_blank" class="small text-primary mt-1 d-block"><i class="fa fa-download"></i> View Current Resume</a>
                @endif
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Certificate</label>
                <input type="file" name="certificate" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
                @if(isset($employee) && $employee->certificate)
                    <a href="{{ asset($employee->certificate) }}" target="_blank" class="small text-success mt-1 d-block"><i class="fa fa-download"></i> View Current Certificate</a>
                @endif
            </div>
        </div>

        <div class="text-end pt-4 mt-4 border-top">
            <button type="submit" class="btn btn-primary px-4 py-2">
                <i class="fa fa-save me-1"></i> {{ isset($employee) ? 'Update Employee' : 'Save Employee' }}
            </button>
        </div>
    </form>
</div>
@endsection
