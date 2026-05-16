@extends(request()->ajax() ? 'layouts.ajax' : 'layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="dashboard-card">

            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <h5 class="dashboard-card-title mb-0">
                    <i class="fa {{ isset($department) ? 'fa-edit' : 'fa-plus' }} text-primary me-2"></i>
                    {{ isset($department) ? 'Edit Department' : 'Add New Department' }}
                </h5>
                <a href="{{ route('department.index') }}" class="btn btn-outline-secondary btn-sm ajax-link">
                    <i class="fa fa-arrow-left me-1"></i> Back to List
                </a>
            </div>

            <form action="{{ isset($department) ? route('department.update', $department->id) : route('department.store') }}"
                  method="POST" class="ajax-form">
                @csrf
                @if(isset($department))
                    @method('PUT')
                @endif

                <div class="mb-4">
                    <label class="form-label fw-bold text-dark">Department Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control form-control-lg fs-6" placeholder="e.g. IT & Development"
                           value="{{ $department->name ?? '' }}">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-dark">Description</label>
                    <textarea name="description" class="form-control" rows="4"
                              placeholder="Write a brief description about this department roles...">{{ $department->description ?? '' }}</textarea>
                </div>

                <div class="text-end border-top pt-4 mt-2">
                    <button type="submit" class="btn btn-primary px-4 py-2">
                        <i class="fa fa-check-circle me-1"></i> {{ isset($department) ? 'Update Department' : 'Save Department' }}
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
