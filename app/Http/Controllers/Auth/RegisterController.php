<?php
namespace app\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Chamber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $chambers = Chamber::all();
        return view('auth.register', compact('chambers'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|unique:users',
            'chamber_id' => 'required|exists:chambers,id',
            'bar_number' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'role' => 'lawyer',
            'chamber_id' => $request->chamber_id,
            'bar_number' => $request->bar_number,
            'approved' => false,
        ]);

        // Implement logic to handle payment initiation here
        // For now, redirect to a pending page.
        return redirect()->route('login')->with('success', 'Registration successful! Your account is pending approval.');
    }
}