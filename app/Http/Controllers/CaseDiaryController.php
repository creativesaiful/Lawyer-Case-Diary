<?php

namespace App\Http\Controllers;

use App\Models\CaseDiary;
use App\Models\CourtList;
use App\Models\CaseComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Models\Date;

class CaseDiaryController extends Controller
{
    public function __construct()
    {
        if (Auth::check() && !in_array(Auth::user()->role, ['lawyer', 'staff'])) {
            abort(403, 'This action is unauthorized.');
        }
    }
    
    public function index(Request $request)
    {
        $cases = CaseDiary::query();

        if (Auth::user()->isAdmin()) {
            // Admin sees all cases
            $cases = $cases->with('chamber');
        } else {
            // Lawyer/Staff sees only their chamber's cases
            $cases = $cases->where('chamber_id', Auth::user()->chamber_id);
        }

        $cases = $cases->latest()->get();
        $courts = CourtList::all();

        return view('cases.index', compact('cases', 'courts'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $date = $request->input('date');

        $cases = CaseDiary::query();

        if (Auth::user()->isAdmin()) {
            $cases->with('chamber');
        } else {
            $cases->where('chamber_id', Auth::user()->chamber_id);
        }

        if ($query) {
            $cases->where(function ($q) use ($query) {
                $q->where('case_number', 'like', "%{$query}%")
                    ->orWhere('court_name', 'like', "%{$query}%")
                    ->orWhere('plaintiff_name', 'like', "%{$query}%")
                    ->orWhere('defendant_name', 'like', "%{$query}%")
                    ->orWhere('lawyer_side', 'like', "%{$query}%")
                    ->orWhere('client_mobile', 'like', "%{$query}%")
                    ->orWhere('short_order', 'like', "%{$query}%")
                    ->orWhere('details', 'like', "%{$query}%");
            });
        }
        
        if ($date) {
            $cases->whereDate('next_date', $date);
        }

        $cases = $cases->latest()->get();

        return response()->json([
            'html' => view('cases.partials.case-list-table', compact('cases'))->render()
        ]);
    }

    public function create()
    {
        $this->authorize('create', CaseDiary::class);
        $courts = CourtList::all();
        return view('cases.create', compact('courts'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', CaseDiary::class);

        // Validate the request
        
        $validated = $request->validate([
            'case_number' => 'required|string',
            'court_id' => 'required|exists:court_lists,id',
            'plaintiff_name' => 'required|string',
            'defendant_name' => 'required|string',
            'client_mobile' => 'required|numeric|digits:11',//max 11 digits
            'lawyer_side' => 'required|string',
            
            'details' => 'nullable|string',
        ]);

        $validated['chamber_id'] = Auth::user()->chamber_id;
        $validated['created_by'] = Auth::id();
        
        
        CaseDiary::create($validated);

        return redirect()->route('cases.index')->with('success', 'Case created successfully.');
    }

    public function show(CaseDiary $caseDiary)
    {
         
        $this->authorize('view', $caseDiary);
        
        $dates = $caseDiary->dates()->orderBy('next_date', 'desc')->get();

       
        
        return view('cases.show', compact('caseDiary', 'dates'));
    }

    public function dateUpdate(CaseDiary $caseDiary)
    {
        $this->authorize('update', $caseDiary);
        return view('cases.date-update', compact('caseDiary'));
    }

    public function updateDate(Request $request, CaseDiary $caseDiary)
    {
        $this->authorize('update', $caseDiary);

        $validated = $request->validate([
            'next_date' => 'required|date|after_or_equal:today',
            'short_order' => 'required|string',
            'comments' => 'nullable|string',
        ]);

      //create a new date entry
        $dateEntry = new Date();
        $dateEntry->case_id = $caseDiary->id;
        $dateEntry->next_date = $validated['next_date'];
        $dateEntry->short_order = $validated['short_order'];
        $dateEntry->comments = $validated['comments'] ?? '';
        $dateEntry->updated_by = Auth::id();
        $dateEntry->chamber_id = Auth::user()->chamber_id;
        $dateEntry->save();



        return redirect()->route('dashboard')->with('success', 'Next date updated successfully.');
    }

public function editDate(\App\Models\Date $date)
{
    // Authorize using the parent case
    $this->authorize('update', $date->caseDiary);

    return view('cases.date-edit', compact('date'));
}


    public function edit(CaseDiary $caseDiary)
    {
        $this->authorize('update', $caseDiary);
        $courts = CourtList::all();
        return view('cases.edit', compact('caseDiary', 'courts'));
    }

    public function update(Request $request, CaseDiary $caseDiary)
    {
        
        $this->authorize('update', $caseDiary);
 
        $validated = $request->validate([
            'case_number' => 'required|string',
            'court_id' => 'required|exists:court_lists,id',
            'plaintiff_name' => 'required|string',
            'defendant_name' => 'required|string',
            'client_mobile' => 'required|numeric|digits:11',//max 11 digits
            'lawyer_side' => 'required|string',
            'details' => 'nullable|string', 
        ]);
 
        
        $caseDiary->update($validated);

        return redirect()->route('cases.index')->with('success', 'Case updated successfully.');
    }

    public function destroy(CaseDiary $caseDiary)
    {
        $this->authorize('delete', $caseDiary);
        $caseDiary->delete();
        return redirect()->route('cases.index')->with('success', 'Case deleted successfully.');
    }

    public function exportPdf(Request $request)
    {
        $cases = CaseDiary::query();

        if (!Auth::user()->isAdmin()) {
            $cases->where('chamber_id', Auth::user()->chamber_id);
        }

        $query = $request->input('query');
        $date = $request->input('date');

        if ($query) {
            $cases->where(function ($q) use ($query) {
                // Same search logic as search method
            });
        }
        
        if ($date) {
            $cases->whereDate('next_date', $date);
        }

        $filteredCases = $cases->get();

        $pdf = Pdf::loadView('cases.pdf-export', compact('filteredCases'));
        return $pdf->download('case_diary.pdf');
    }

    public function generateDocx(Request $request, CaseDiary $caseDiary)
    {
        $this->authorize('view', $caseDiary);

        $templateProcessor = new TemplateProcessor(storage_path('app/templates/application_template.docx'));
        
        // Dynamic data
        $templateProcessor->setValue('case_number', $caseDiary->case_number);
        $templateProcessor->setValue('court_name', $caseDiary->court_name);
        $templateProcessor->setValue('plaintiff_name', $caseDiary->plaintiff_name);
        $templateProcessor->setValue('defendant_name', $caseDiary->defendant_name);
        $templateProcessor->setValue('lawyer_side', $caseDiary->lawyer_side);
        $templateProcessor->setValue('next_date', $caseDiary->next_date ? $caseDiary->next_date->format('Y-m-d') : 'N/A');
        $templateProcessor->setValue('short_order', $caseDiary->short_order);
        
        $filename = 'Application_' . $caseDiary->case_number . '.docx';
        $templateProcessor->saveAs(public_path('downloads/' . $filename));

        return response()->download(public_path('downloads/' . $filename))->deleteFileAfterSend(true);
    }
    
    public function addComment(Request $request, CaseDiary $case)
    {
        $this->authorize('view', $case);
        
        $request->validate([
            'comment_text' => 'required|string',
        ]);
        
        $case->comments()->create([
            'user_id' => Auth::id(),
            'comment_text' => $request->comment_text
        ]);
        
        return back()->with('success', 'Comment added successfully.');
    }
}
