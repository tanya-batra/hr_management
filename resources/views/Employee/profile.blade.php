@extends(request()->ajax() ? 'layouts.ajax' : 'Employee.layout.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-orange: #ff9800;
            --dark-orange: #e68900;
            --soft-bg: #fdfaf7;
        }

        body {
            background-color: #f4f7f6;
            font-family: 'Inter', sans-serif;
        }

        /* Premium Card Design */
        .card-modern {
            border: none;
            border-radius: 20px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        /* Profile Header Gradient */
        .profile-header-bg {
            background: linear-gradient(135deg, var(--primary-orange), #ffb74d);
            height: 120px;
            border-radius: 20px 20px 0 0;
        }

        /* Floating Image Effect */
        .profile-img-wrapper {
            margin-top: -60px;
            position: relative;
        }

        .profile-img-wrapper img {
            border: 5px solid #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .profile-img-wrapper:hover img {
            transform: scale(1.02);
        }

        /* Modern Tabs */
        .nav-pills-custom .nav-link {
            color: #666;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 12px;
            margin-right: 10px;
            transition: 0.3s;
        }

        .nav-pills-custom .nav-link.active {
            background-color: var(--primary-orange) !important;
            color: white !important;
            box-shadow: 0 8px 20px rgba(255, 152, 0, 0.3);
        }

        /* Form Styling */
        .form-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: #999;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #eee;
            padding: 12px 15px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 4px rgba(255, 152, 0, 0.1);
        }

        /* Stats Labels */
        .stat-box {
            background: var(--soft-bg);
            border-radius: 15px;
            padding: 15px;
            height: 100%;
        }

        .btn-update-profile {
            background-color: var(--primary-orange);
            color: white;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 12px;
            border: none;
            transition: 0.3s;
        }

        .btn-update-profile:hover {
            background-color: var(--dark-orange);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(230, 137, 0, 0.3);
        }
    </style>

    <div class="container py-5">
        <div class="row g-4">

            <div class="col-lg-4">
                <div class="card card-modern overflow-hidden h-100">
                    <div class="profile-header-bg"></div>
                    <div class="card-body pt-0 text-center">
                        <div class="profile-img-wrapper mb-3">
                            <img src="{{ $employee->profile ? asset($employee->profile) : 'https://ui-avatars.com/api/?name=' . urlencode($employee->first_name) . '&background=FF9800&color=fff' }}"
                                class="rounded-circle" width="120" height="120" style="object-fit: cover;">
                        </div>

                        <h3 class="fw-bold text-dark mb-1">{{ $employee->first_name }} {{ $employee->last_name }}</h3>
                        <p class="text-muted mb-3">{{ $employee->position }}</p>

                        <div class="d-flex justify-content-center gap-2 mb-4">
                            <span
                                class="badge bg-soft-warning text-dark border border-warning-subtle px-3 py-2 rounded-pill">
                                <i class="bi bi-briefcase me-1"></i> {{ $employee->department->name ?? 'Staff' }}
                            </span>
                            <span
                                class="badge {{ $employee->status == 'Active' ? 'bg-success' : 'bg-secondary' }} px-3 py-2 rounded-pill">
                                {{ $employee->status }}
                            </span>
                        </div>

                        <div class="row g-3 text-start mt-2">
                            <div class="col-6">
                                <div class="stat-box">
                                    <small class="form-label mb-1">Employee ID</small>
                                    <div class="fw-bold">#{{ $employee->employee_id }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-box">
                                    <small class="form-label mb-1">Salary</small>
                                    <div class="fw-bold text-success">₹{{ number_format($employee->salary) }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="stat-box">
                                    <small class="form-label mb-1">Joined Since</small>
                                    <div class="fw-bold"><i class="bi bi-calendar3 me-2 text-warning"></i>
                                        {{ \Carbon\Carbon::parse($employee->join_date)->format('d M, Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card card-modern h-100">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <ul class="nav nav-pills nav-pills-custom" id="profileTab" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="pill"
                                    data-bs-target="#personal-tab">Personal</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="pill"
                                    data-bs-target="#address-tab">Address</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#docs-tab">Docs</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="pill"
                                    data-bs-target="#security-tab">Security</button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('employee.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="tab-content mt-2">
                                <div class="tab-pane fade show active" id="personal-tab">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label text-uppercase">First Name</label>
                                            <input type="text" name="first_name" value="{{ $employee->first_name }}"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-uppercase">Last Name</label>
                                            <input type="text" name="last_name" value="{{ $employee->last_name }}"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-uppercase">Email Address</label>
                                            <input type="email" name="email" value="{{ $employee->email }}"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-uppercase">Phone</label>
                                            <input type="text" name="phone" value="{{ $employee->phone }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="address-tab">
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <label class="form-label">STREET ADDRESS</label>
                                            <input type="text" name="address" value="{{ $employee->address }}"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">CITY</label>
                                            <input type="text" name="city" value="{{ $employee->city }}"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">STATE</label>
                                            <input type="text" name="state" value="{{ $employee->state }}"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">PINCODE</label>
                                            <input type="text" name="pincode" value="{{ $employee->pincode }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="docs-tab">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="border rounded-4 p-4 text-center">
                                                <div class="mb-3"><i class="bi bi-file-earmark-pdf text-orange h1"></i>
                                                </div>
                                                <label class="form-label mb-3">Professional Resume</label>
                                                <input type="file" name="resume" class="form-control mb-3">
                                                @if ($employee->resume)
                                                    <a href="{{ asset($employee->resume) }}"
                                                        class="btn btn-sm btn-outline-warning w-100 rounded-pill">Download
                                                        Current</a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="border rounded-4 p-4 text-center">
                                                <div class="mb-3"><i class="bi bi-patch-check text-success h1"></i>
                                                </div>
                                                <label class="form-label mb-3">Joining Certificate</label>
                                                <input type="file" name="certificate" class="form-control mb-3">
                                                @if ($employee->certificate)
                                                    <a href="{{ asset($employee->certificate) }}"
                                                        class="btn btn-sm btn-outline-success w-100 rounded-pill">Download
                                                        Current</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="border rounded-4 p-4 text-center">
                                            <div class="mb-3">
                                                <i class="bi bi-file-earmark-text text-primary h1"></i>
                                            </div>

                                            <label class="form-label mb-3">Offer Letter</label>
                                            <!-- Download Button (Only if exists) -->
                                            @if (!empty($employee->offer_letter))
                                                <a href="{{ asset($employee->offer_letter) }}"
                                                    class="btn btn-sm btn-outline-primary w-100 rounded-pill">
                                                    Download Offer Letter
                                                </a>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="security-tab">
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <div class="alert alert-warning border-0 rounded-4">
                                                <small><i class="bi bi-info-circle me-2"></i> Leave password fields empty
                                                    if you don't want to change it.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">CURRENT PASSWORD</label>
                                            <input type="password" name="current_password" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">NEW PASSWORD</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">CONFIRM PASSWORD</label>
                                            <input type="password" name="password_confirmation" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 pt-3 border-top text-end">
                                <button type="submit" class="btn btn-update-profile shadow-sm px-5">
                                    <i class="bi bi-check-circle me-2"></i> Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
