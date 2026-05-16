<?php

namespace App\Http\Controllers;

use App\Mail\OfferLetterMail;
use App\Models\Department;
use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\EmployeeLoginMail;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::with('department')->latest()->get();

        if ($request->ajax()) {
            return response()->json(['html' => view('employees.index', compact('employees'))->render()]);
        }
        return view('employees.index', compact('employees'));
    }

    public function create(Request $request)
    {
        $departments = Department::all();
        if ($request->ajax()) {
            return response()->json(['html' => view('employees.form', compact('departments'))->render()]);
        }
        return view('employees.form', compact('departments'));
    }

    public function show(Request $request, Employee $employee)
    {
        $employee->load('department');
        if ($request->ajax()) {
            return response()->json(['html' => view('employees.show', compact('employee'))->render()]);
        }
        return view('employees.show', compact('employee'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'nullable|string|max:255',
            'email'         => 'required|email|unique:employees,email',
            'salary'        => 'required|numeric|min:0',
            'department_id' => 'required|exists:departments,id',
            'gender'        => 'required|in:Male,Female,Other',
            'profile'       => 'nullable|mimes:jpg,png|max:2048',
            'join_date'     => 'required|date',
            'status'        => 'required|in:Active,Inactive',
            'resume'        => 'nullable|mimes:pdf,doc,docx|max:2048',
            'certificate'   => 'nullable|mimes:pdf,doc,docx,jpg,png|max:4096',
        ]);

        $lastEmployee = Employee::orderBy('id', 'desc')->first();
        $nextIdNumber = $lastEmployee ? $lastEmployee->id + 1 : 1;
        $employeeId = 'EMP-' . str_pad($nextIdNumber, 4, '0', STR_PAD_LEFT);



        $prefix = strtolower(substr($request->first_name, 0, 3));
        $randomNumber = rand(1000, 9999);
        $plainPassword = $prefix . $randomNumber;
        $hashedPassword = Hash::make($plainPassword);

        $resume = null;
        if ($request->hasFile('resume')) {
            $file = $request->file('resume');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('resumes'), $filename);
            $resume = 'resumes/' . $filename;
        }

        $certificate = null;
        if ($request->hasFile('certificate')) {
            $file = $request->file('certificate');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('certificates'), $filename);
            $certificate = 'certificates/' . $filename;
        }

        $profile = null;
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('profiles'), $filename);
            $profile = 'profiles/' . $filename;
        }

        Employee::create([
            'employee_id'   => $employeeId,
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'department_id' => $request->department_id,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'join_date'     => $request->join_date,
            'profile'       => $profile,
            'gender'        => $request->gender,
            'position'      => $request->position,
            'address'       => $request->address,
            'city'          => $request->city,
            'state'         => $request->state,
            'pincode'       => $request->pincode,
            'salary'        => $request->salary,
            'status'        => $request->status,
            'resume'        => $resume,
            'certificate'   => $certificate,
        ]);
        User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => $hashedPassword
        ]);

        
        Mail::to($employee->email)->send(
    new EmployeeLoginMail(
        $employee->first_name,
        $employee->email,
        $plainPassword
    )
      );

        return response()->json([
            'status' => 'success',
            'message' => 'Employee Added Successfully!',
            'redirect_url' => route('employees.index')
        ]);
    }

    public function edit(Request $request, Employee $employee)
    {
        $employee->load('department');
        $departments = Department::all();
        if ($request->ajax()) {
            return response()->json(['html' => view('employees.form', compact('employee', 'departments'))->render()]);
        }
        return view('employees.form', compact('employee', 'departments'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'nullable|string|max:255',
            'email'         => 'required|email|unique:employees,email,' . $employee->id,
            'salary'        => 'required|numeric|min:0',
            'department_id' => 'required|exists:departments,id',
            'profile'       => 'nullable|mimes:jpg,png|max:2048',
            'gender'        => 'required|in:Male,Female,Other',
            'status'        => 'required|in:Active,Inactive',
            'resume'        => 'nullable|mimes:pdf,doc,docx|max:2048',
            'certificate'   => 'nullable|mimes:pdf,doc,docx,jpg,png|max:4096',
        ], [
            'department_id.required' => 'Please select a department',
            'first_name.required'    => 'First name is required',
            'email.required'         => 'Email is required',
            'salary.required'        => 'Salary is required',
        ]);

        $updateData = [
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'department_id' => $request->department_id,
            'gender'        => $request->gender,
            'position'      => $request->position,
            'address'       => $request->address,
            'city'          => $request->city,
            'state'         => $request->state,
            'pincode'       => $request->pincode,
            'salary'        => $request->salary,
            'status'        => $request->status,
        ];

        if ($request->has('join_date') && $request->join_date != $employee->join_date) {
            $created_at = Carbon::parse($employee->created_at);
            $now = Carbon::now();

            if ($created_at->diffInMonths($now) >= 3) {
                return response()->json(['errors' => ['join_date' => ['Joining date cannot be changed after 3 months.']]], 422);
            }
            if ($employee->join_date_edits >= 2) {
                return response()->json(['errors' => ['join_date' => ['Joining date edit limit (2 times) exceeded.']]], 422);
            }

            $updateData['join_date'] = $request->join_date;
            $updateData['join_date_edits'] = $employee->join_date_edits + 1;
        }

        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('profiles'), $filename);
            $updateData['profile'] = 'profiles/' . $filename;
        }

        if ($request->hasFile('resume')) {
            $file = $request->file('resume');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('resumes'), $filename);
            $updateData['resume'] = 'resumes/' . $filename;
        }

        if ($request->hasFile('certificate')) {
            $file = $request->file('certificate');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('certificates'), $filename);
            $updateData['certificate'] = 'certificates/' . $filename;
        }

        $employee->update($updateData);
        $user = User::where('email', $employee->email)->first();

        if ($user) {
            $user->update([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Employee Updated Successfully',
            'redirect_url' => route('employees.index')
        ]);
    }

    public function destroy(Request $request, Employee $employee)
    {
        $user = User::where('email', $employee->email)->first();

        if ($user) {
            $user->delete();
        }

        $employee->delete();

        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'message' => 'Employee Deleted Successfully!', 'redirect_url' => route('employees.index')]);
        }
        return back()->with('success', 'Employee Deleted');
    }

    public function offerLetter(Request $request, Employee $employee)
    {
        $employee->load('department');

        $pdf = Pdf::loadView('employees.offer_letter', compact('employee'));

        $folder = 'offer_letters';
        if (!file_exists(public_path($folder))) {
            mkdir(public_path($folder), 0755, true);
        }

        $fileName = 'Offer_Letter_' . $employee->employee_id . '.pdf';
        $filePath = $folder . '/' . $fileName;

        $pdf->save(public_path($filePath));

        $employee->offer_letter = $filePath;
        $employee->save();

        Mail::to($employee->email)->send(new OfferLetterMail($employee, public_path($filePath)));

        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'message' => 'Offer Letter generated and emailed to ' . $employee->email]);
        }
        return back()->with('success', 'Offer Letter generated, saved, and emailed to ' . $employee->email);
    }
}
