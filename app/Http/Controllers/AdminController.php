<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\CaseDiary;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Require the user to be authenticated for all actions in this controller.
        $this->middleware('auth');

        // This definitive check will bypass any lingering session issues.
        // It will abort the request if the user's role is not 'admin'.
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->role !== 'admin') {
                abort(403, 'This action is unauthorized.');
            }
            return $next($request);
        });
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $totalLawyers = User::where('role', 'lawyer')->count();
        $activeLawyers = User::where('role', 'lawyer')->where('approved', true)->count();
        $pendingLawyers = User::where('role', 'lawyer')->where('approved', false)->count();
        $totalStaff = User::where('role', 'staff')->count();

        return view('admin.dashboard', compact('totalLawyers', 'activeLawyers', 'pendingLawyers', 'totalStaff'));
    }

    /**
     * Show pending lawyers for approval.
     *
     * @return \Illuminate\Http\Response
     */
    public function lawyers()
    {
        $lawyers = User::where('role', 'lawyer')
            ->get();

        return view('admin.lawyers', compact('lawyers'));
    }

    
    // ajax function to update lawyer status
  public function toggleStatus(Request $request)
{
    $lawyer = User::findOrFail($request->lawyer_id);
    $lawyer->approved = $request->status;
    $lawyer->save();

    return response()->json(['message' => 'Lawyer status updated successfully!']);
}

    /**
     * View a specific lawyer's details.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function viewLawyer($id)
    {
        $lawyer = User::where('role', 'lawyer')->findOrFail($id);
        $totalStaff = User::where('role', 'staff')->where('chamber_id', $lawyer->chamber_id)->count();
        $totalCases = CaseDiary::where('chamber_id', $lawyer->chamber_id)->count();
        $plaintiffParties = CaseDiary::where('chamber_id', $lawyer->chamber_id)->where('lawyer_side', 'Plaintiff')->count();
        $defendantParties = CaseDiary::where('chamber_id', $lawyer->chamber_id)->where('lawyer_side', 'Defendant')->count();
 
        return view('admin.view_lawyer', compact('lawyer' , 'totalStaff', 'totalCases', 'plaintiffParties', 'defendantParties'));
    }

}
