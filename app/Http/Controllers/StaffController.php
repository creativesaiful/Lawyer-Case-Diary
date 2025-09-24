<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class StaffController extends Controller
{
    public function __construct()
    {
        if (Auth::check() && Auth::user()->role !== 'lawyer') {
            abort(403, 'This action is unauthorized.');
        }
    }

    public function index()
    {
        $chamberId = Auth::user()->chamber_id;
        $staffMembers = User::where('chamber_id', $chamberId)
                            ->where('role', 'staff')
                            ->get();

        return view('staff.index', compact('staffMembers'));
    }

    public function create()
    {
        // Your logic to show the staff creation form
        return view('staff.create');
    }

    public function store(Request $request)
    {
     
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|unique:users,mobile',
            'password' => 'required|min:8',
        ]);

        $stuff = new User();

        $stuff->name = $request->name;
        $stuff->mobile = $request->mobile;
        $stuff->password =  bcrypt($request->password);
        $stuff->role = 'staff';
        $stuff->chamber_id = Auth::user()->chamber_id;
        $stuff->approved = true;

        $stuff->save();


        if($stuff){
            return redirect()->route('staff.index')->with('status', 'Staff member created successfully.');
        }else{
            return redirect()->route('staff.create')->with('status', 'Something went wrong.');
        }

         
    }
}
