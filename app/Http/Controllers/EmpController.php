<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class EmpController extends Controller
{

    public function attendance(Request $request)
    {
        $user = Auth::user();

        $employee = \App\Models\Employee::where('email', $user->email)->first();

        if (!$employee) {
            return back()->with('error', 'Employee record not found');
        }

        $attendance = \App\Models\Attendance::where('employee_id', $employee->id)
            ->get();

        return view('Employee.attendence', compact('attendance'));
    }


    public function checkIn()
    {
        $user = Auth::user();

        $employee = Employee::where('email', $user->email)->first();

        $today = Carbon::today();

        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today)
            ->first();

        if (!$attendance) {

            Attendance::create([
                'employee_id' => $employee->id,
                'date' => $today,
                'clock_in' => Carbon::now(),
                'status' => 'Present'
            ]);
        }

        return back()->with('success', 'Check In Successful');
    }

    public function checkOut()
    {
        $user = Auth::user();

        $employee = Employee::where('email', $user->email)->first();

        $today = Carbon::today();

        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('date', $today)
            ->first();

        if ($attendance) {
            $attendance->update([
                'clock_out' => Carbon::now()
            ]);
        }

        return back()->with('success', 'Check Out Successful');
    }
    public function leave()
    {
        $employee = Employee::where('email', Auth::user()->email)->first();

        $leaves = Leave::where('employee_id', $employee->id)->latest()->get();

        return view('Employee.leave', compact('leaves'));
    }


    public function leaveStore(Request $request)
    {
        $employee = Employee::where('email', Auth::user()->email)->first();

        Leave::create([
            'employee_id' => $employee->id,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'reason' => $request->reason,
            'status' => 'Pending'
        ]);

        return back()->with('success', 'Leave Applied Successfully');
    }
    public function profile()
    {
        $employee = Employee::where('email', Auth::user()->email)->first();
        $departments = Department::all();

        return view('Employee.profile', compact('employee', 'departments'));
    }

 public function updateProfile(Request $request)
{

    $request->validate([
        'first_name' => 'required',
        'email' => 'required|email',
        'profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'resume' => 'nullable|mimes:pdf,doc,docx|max:2048',
        'certificate' => 'nullable|mimes:pdf,jpg,png|max:2048'
    ]);

    $employee = Employee::where('email', Auth::user()->email)->first();
    $user = Auth::user();


    // Profile Image Upload
    if ($request->hasFile('profile')) {

        $image = $request->file('profile');
        $imageName = time().'_profile_'.$image->getClientOriginalName();

        $image->move(public_path('profiles'), $imageName);

        $employee->profile = 'profiles/'.$imageName;
    }


    // Resume Upload
    if ($request->hasFile('resume')) {

        $resume = $request->file('resume');
        $resumeName = time().'_resume_'.$resume->getClientOriginalName();

        $resume->move(public_path('resumes'), $resumeName);

        $employee->resume = 'resumes/'.$resumeName;
    }


    // Certificate Upload
    if ($request->hasFile('certificate')) {

        $certificate = $request->file('certificate');
        $certificateName = time().'_certificate_'.$certificate->getClientOriginalName();

        $certificate->move(public_path('certificates'), $certificateName);

        $employee->certificate = 'certificates/'.$certificateName;
    }


    // Employee Table Update
    $employee->first_name = $request->first_name;
    $employee->last_name = $request->last_name;
    $employee->email = $request->email;
    $employee->phone = $request->phone;
    $employee->address = $request->address;
    $employee->city = $request->city;
    $employee->state = $request->state;
    $employee->pincode = $request->pincode;

    $employee->save();


    // User Table Update
    $user->name = $request->first_name.' '.$request->last_name;
    $user->email = $request->email;


    // Password Change
    if ($request->password) {

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error','Current password is incorrect');
        }

        $user->password = Hash::make($request->password);
    }

    $user->save();


    return back()->with('success','Profile Updated Successfully');

}
}
