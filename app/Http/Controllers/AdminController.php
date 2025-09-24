<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        return view('admin.dashboard');
    }

    /**
     * Show pending lawyers for approval.
     *
     * @return \Illuminate\Http\Response
     */
    public function pendingLawyers()
    {
        $pendingLawyers = User::where('role', 'lawyer')
            ->where('approved', false)
            ->get();

        return view('admin.pending-lawyers', compact('pendingLawyers'));
    }

    /**
     * Approve a lawyer.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveLawyer(User $user)
    {
        $user->update(['approved' => true]);
        return redirect()->route('admin.pending.lawyers')->with('success', 'Lawyer approved successfully!');
    }

    /**
     * Deny a lawyer.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function denyLawyer(User $user)
    {
        $user->delete();
        return redirect()->route('admin.pending.lawyers')->with('success', 'Lawyer denied and deleted.');
    }
}
