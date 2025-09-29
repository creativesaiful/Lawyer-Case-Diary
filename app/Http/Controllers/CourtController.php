<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CourtList;

class CourtController extends Controller
{
    public function __construct()
    {
        if (Auth::check() && Auth::user()->role !== 'lawyer' && Auth::user()->role !== 'staff') {
            abort(403, 'This action is unauthorized.');
        }
    }

    public function index()
    {
        $courts = CourtList::all();
        return view('courts.index', compact('courts'));
    }

    public function create()
    {
        return view('courts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'court_name' => 'required|string|max:255',
            'judge_name' => 'nullable|string|max:255',
        ]);

        $chamberId = Auth::user()->chamber_id;
        if (!$chamberId) {
            return redirect()->back()->withErrors(['error' => 'You are not associated with any chamber.']);
        } 
        $request->merge(['chamber_id' => $chamberId]);

        CourtList::create($request->all());

        return redirect()->route('courts.index')->with('success', 'Court added successfully.');
    }

    public function edit(CourtList $court)
    {
        return view('courts.edit', compact('court'));
    }

    public function update(Request $request, CourtList $court)
    {
        $request->validate([
            'court_name' => 'required|string|max:255',
            'judge_name' => 'nullable|string|max:255',
        ]);

        $court->update($request->all());

        return redirect()->route('courts.index')->with('success', 'Court updated successfully.');
    }

    public function destroy(CourtList $court)
    {
        $court->delete();
        return redirect()->route('courts.index')->with('success', 'Court deleted successfully.');
    }
}
