<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncidentsRequest;
use App\Models\Incidents;
use Illuminate\Http\Request;

class IncidentsController extends Controller
{
    public function index()
    {
        $incidents = Incidents::all();

        return view('incidents.index', compact('incidents'));
    }

    public function create()
    {
        return view('incidents.form');
    }

    public function store(IncidentsRequest $request)
    {
        Incidents::create($request->validated());

        return redirect()->route('incidents.index')->with('success', 'Incident created successfully.');
    }

    public function edit(Incidents $incident)
    {
        return view('incidents.form', compact('incident'));
    }

    public function update(IncidentsRequest $request, Incidents $incident)
    {
        $incident->update($request->validated());

        return redirect()->route('incidents.index')->with('success', 'Incident updated successfully.');
    }

    public function destroy(Incidents $incident)
    {
        $incident->delete();

        return redirect()->route('incidents.index')->with('success', 'Incident deleted successfully.');
    }
}
