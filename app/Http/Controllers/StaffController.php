<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staffs;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = Staffs::select(
            'id',
            'first_name',
            'last_name',
            'role',
            'department'
        )
        ->orderBy('first_name')
        ->get();

        return view ('staffs.index', compact('staffs'));
    }

    public function create()
    {
        return view('staffs.create');
    }

    public function store(Request $request)
    {
        $staff = new Staffs();
        $staff->first_name = $request->input('first_name');
        $staff->last_name = $request->input('last_name');
        $staff->email = $request->input('email');
        $staff->role = $request->input('role');
        $staff->department = $request->input('department');
        $staff->contact_no = $request->input('contact_no');
        $staff->address = $request->input('address');
        $staff->emergency_contact = $request->input('emergency_contact');
        $staff->save();

        return redirect()->route('staff.index');
    }

    public function edit($id)
    {
        $staff = Staffs::findOrFail($id);
        return view('staffs.edit', compact('staff'));
    }
}
