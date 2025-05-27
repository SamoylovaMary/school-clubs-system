<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = Report::with('user')->get();
        return view('reports.admin_index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'students_count' => 'required|integer|min:1',
            'sports' => 'required|array',
            'sports.*.name' => 'required|string',
            'sports.*.count' => 'required|integer|min:1',
            'events' => 'required|array',
            'events.*.name' => 'required|string',
            'events.*.date' => 'required|date',
            'events.*.document' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        $eventsData = [];
        
        foreach ($request->events as $index => $event) {
            $eventData = [
                'name' => $event['name'],
                'date' => $event['date']
            ];
            
            if ($request->hasFile("events.$index.document")) {
                $path = $request->file("events.$index.document")->store('events');
                $eventData['document_path'] = $path;
            }
            
            $eventsData[] = $eventData;
        }

        $report = Report::create([
            'user_id' => auth()->id(),
            'students_count' => $validated['students_count'],
            'sports' => $validated['sports'],
            'events' => $eventsData,
            'status' => 'draft'
        ]);

        return redirect()->route('reports.index')->with('success', 'Отчёт успешно создан!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        abort_if($report->user_id !== auth()->id(), 403);
        return view('reports.show', compact('report'));
    }

    public function adminIndex()
    {
        $reports = Report::with('user')->paginate(10);
        return view('admin.reports.index', compact('reports'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
