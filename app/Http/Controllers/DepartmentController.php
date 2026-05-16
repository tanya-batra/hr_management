<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller {

    public function index(Request $request) {
        $departments = Department::orderBy('created_at', 'desc')->get();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('departments.index', compact('departments'))->render()
            ]);
        }
        return view('departments.index', compact('departments'));
    }

    public function create(Request $request) {
        if ($request->ajax()) {
            return response()->json([
                'html' => view('departments.form')->render()
            ]);
        }
        return view('departments.form');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|unique:departments,name|max:255',
            'description' => 'nullable|max:1000',
        ]);

        Department::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Department created successfully!',
            'redirect_url' => route('department.index')
        ]);
    }

    public function edit(Request $request, Department $department) {
        if ($request->ajax()) {
            return response()->json([
                'html' => view('departments.form', compact('department'))->render()
            ]);
        }
        return view('departments.form', compact('department'));
    }

    public function update(Request $request, Department $department) {
        $request->validate([
            'name' => 'required|unique:departments,name,'.$department->id.'|max:255',
            'description' => 'nullable|max:1000',
        ]);

        $department->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Department updated successfully!',
            'redirect_url' => route('department.index')
        ]);
    }

    public function destroy(Request $request, Department $department) {
        $department->delete();

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Department deleted successfully!',
                'redirect_url' => route('department.index')
            ]);
        }
        return redirect()->route('department.index');
    }
}
