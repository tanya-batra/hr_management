<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date ?? Carbon::today()->toDateString();

        $employees = Employee::where('status', 'Active')->get();

        $attendances = Attendance::where('date', $date)->get()->keyBy('employee_id');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('attendance.index', compact('employees', 'attendances', 'date'))->render()
            ]);
        }
        return view('attendance.index', compact('employees', 'attendances', 'date'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array'
        ]);

        $date = $request->date;

        foreach ($request->attendance as $emp_id => $status) {
            Attendance::updateOrCreate(
                ['employee_id' => $emp_id, 'date' => $date],
                ['status' => $status]
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Attendance saved for ' . Carbon::parse($date)->format('d M, Y'),
            'redirect_url' => route('attendance.index', ['date' => $date])
        ]);
    }
    public function report(Request $request)
    {
        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');
        $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;

        $employees = Employee::where('status', 'Active')->get();

        $attendances = Attendance::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get()
            ->groupBy('employee_id');

        $attendanceData = [];
        foreach ($attendances as $empId => $records) {
            foreach ($records as $record) {
                $day = Carbon::parse($record->date)->format('j');
                $attendanceData[$empId][$day] = $record->status;
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'html' => view('attendance.report', compact('employees', 'attendanceData', 'month', 'year', 'daysInMonth'))->render()
            ]);
        }
        return view('attendance.report', compact('employees', 'attendanceData', 'month', 'year', 'daysInMonth'));
    }
    public function leaveRequests()
    {
        $leaves = Leave::with('employee')->latest()->get();

        return view('attendance.leave_requests', compact('leaves'));
    }
    public function approve($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->status = 'Approved';
        $leave->save();

        return back()->with('success', 'Leave Approved');
    }

    public function reject(Request $request)
    {
        $request->validate([
            'leave_id' => 'required|exists:leaves,id',
            'reject_reason' => 'required|string|max:255',
        ]);

        $leave = Leave::findOrFail($request->leave_id);
        $leave->status = 'Rejected';
        $leave->reject_reason = $request->reject_reason;
        $leave->save();

        return back()->with('success', 'Leave Rejected');
    }
}
