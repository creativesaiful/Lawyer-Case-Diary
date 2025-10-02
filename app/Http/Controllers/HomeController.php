<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaseDiary;
use App\Models\Date;
use Toastr;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
{
    $user = auth()->user();

    // 🔹 Redirect admin role to admin dashboard
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    // 🔹 Lawyers and staff will stay on normal dashboard
    $selectedDate = $request->input('selected_date', now()->toDateString());

    $chamber = $user->chamber;

    $todayCases = Date::where('chamber_id', $chamber->id)
                        ->whereDate('next_date', $selectedDate)
                        ->get();

    return view('home', compact('todayCases', 'selectedDate'));
}


    public function searchByDate($date)
    {
        $user = auth()->user();
        $chamber = $user->chamber;
        dd( $chamber);
        $selectedDate = \Carbon\Carbon::parse($date)->toDateString();

        $todayCases = Date::where('chamber_id', $chamber->id)
                    ->whereDate('next_date', $selectedDate)
                    ->get();
        

        return view('home', compact('todayCases', 'selectedDate'));
    }
}
