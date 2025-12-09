<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = Staff::orderBy('staff_id', 'asc')->get();

        return view('staffs.index', compact('staffs'));
    }

    public function create()
    {
        return view('staffs.create');
    }

    public function show($staff_id)
    {
        $staff = Staff::find($staff_id);
        return response()->json($staff);
    }

    public function store(Request $request)
    {
        $staff = new Staff();
        $staff->first_name = $request->input('first_name');
        $staff->last_name = $request->input('last_name');
        $staff->staff_id = $request->input('staff_id');
        $staff->email = $request->input('email');
        $staff->role = $request->input('role');
        $staff->department = $request->input('department');
        $staff->contact_no = $request->input('contact_no');
        $staff->address = $request->input('address');
        $staff->emergency_contact = $request->input('emergency_contact');
        $staff->status = $request->input('status', 'active');
        $staff->save();

        return redirect()->route('staff.index');
    }

    public function edit($staff_id)
    {
        $staff = Staff::find($staff_id);
        return view('staffs.edit', compact('staff'));
    }

    public function update(Request $request, $staff_id)
    {
        $staff = Staff::find($staff_id);
        
        // Check if request is JSON (AJAX)
        if ($request->wantsJson() || $request->expectsJson()) {
            $staff->first_name = $request->input('first_name');
            $staff->last_name = $request->input('last_name');
            $staff->staff_id = $request->input('staff_id');
            $staff->email = $request->input('email');
            $staff->role = $request->input('role');
            $staff->department = $request->input('department');
            $staff->contact_no = $request->input('contact_no');
            $staff->emergency_contact = $request->input('emergency_contact');
            $staff->address = $request->input('address');
            $staff->status = $request->input('status');
            $staff->save();
            
            return response()->json(['success' => true, 'message' => 'Staff updated successfully']);
        }
        
        // Regular form submission
        $staff->first_name = $request->input('first_name');
        $staff->last_name = $request->input('last_name');
        $staff->staff_id = $request->input('staff_id');
        $staff->email = $request->input('email');
        $staff->role = $request->input('role');
        $staff->department = $request->input('department');
        $staff->contact_no = $request->input('contact_no');
        $staff->emergency_contact = $request->input('emergency_contact');
        $staff->address = $request->input('address');
        $staff->status = $request->input('status');
        $staff->save();

        return redirect()->route('staff.index');
    }

    public function delete($staff_id)
    {
        $staff = Staff::find($staff_id);
        $staff->delete();

        return redirect()->route('staff.index');
    }
}
