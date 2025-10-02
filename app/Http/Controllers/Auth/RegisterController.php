<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Chamber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Flasher\Laravel\Facade\Flasher;


class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $chambers = Chamber::all();
        return view('auth.register', compact('chambers'));
    }

   
public function register(Request $request)
{
    // 1️⃣ Validation
    $request->validate([
        'chamber_no' => 'required|numeric|unique:chambers,chamber_no',
        'address' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'mobile' => 'required|string|unique:users,mobile',
        'bar_number' => 'required|numeric|unique:users,bar_number',
        'password' => 'required|string|min:8|confirmed', // requires password_confirmation field
    ]);

    dd($request->all());

    // 2️⃣ Create Chamber
    $chamber = Chamber::create([
        'chamber_no' => $request->chamber_no,
        'address' => $request->address,
    ]);

    // 3️⃣ Create User
    $user = User::create([
        'name' => $request->name,
        'mobile' => $request->mobile,
        'password' => Hash::make($request->password),
        'role' => 'lawyer',
        'chamber_id' => $chamber->id,
        'bar_number' => $request->bar_number,
        'approved' => false, // pending approval
    ]);


    Flasher::addSuccess('User registered successfully!');


    return redirect()->route('login')
                     ->with('success', 'Registration successful! Your account is pending approval.');
}

}