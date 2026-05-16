<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmpController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'showLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/dashboard', [AuthController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::prefix('departments')->group(function () {
    Route::get('/', [DepartmentController::class, 'index'])->name('department.index');
    Route::get('/create', [DepartmentController::class, 'create'])->name('department.create');
    Route::post('/store', [DepartmentController::class, 'store'])->name('department.store');
    Route::get('/edit/{department}', [DepartmentController::class, 'edit'])->name('department.edit');
    Route::put('/update/{department}', [DepartmentController::class, 'update'])->name('department.update');
    Route::delete('/delete/{department}', [DepartmentController::class, 'destroy'])->name('department.destroy');
});
Route::prefix('employees')->group(function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/store', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::get('/edit/{employee}', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/update/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/delete/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
});
Route::get('employees/{employee}/offer-letter', [EmployeeController::class, 'offerLetter'])->name('employees.offerLetter');
Route::get('/admin/leave-requests', [AttendanceController::class, 'leaveRequests'])->name('leave.request');
Route::get('/leave/approve/{id}', [AttendanceController::class, 'approve'])->name('leave.approve');
Route::post('/leave/reject', [AttendanceController::class, 'reject'])->name('leave.reject');
// Attendance Routes
Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::post('/attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');
Route::get('/attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');

Route::middleware(['auth'])->group(function () {
    Route::get('/employee/dashboard', function () {
        return view('Employee.dashboard');
    })->name('employee.dashboard');
    Route::get('/employee/attendance', [EmpController::class, 'attendance'])
        ->name('employee.attendance');
    Route::post('/employee/attendance/checkin', [EmpController::class, 'checkIn'])->name('employee.checkin');
    Route::post('/employee/attendance/checkout', [EmpController::class, 'checkOut'])->name('employee.checkout');
    Route::get('/employee/leave', [EmpController::class, 'leave'])->name('employee.leave');

    Route::post('/employee/leave/store', [EmpController::class, 'leaveStore'])->name('employee.leave.store');
    Route::get('/employee/profile', [EmpController::class, 'profile'])->name('employee.profile');
   Route::put('/employee/profile/update', [EmpController::class, 'updateProfile'])->name('employee.profile.update');
});
