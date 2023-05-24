<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncidentsRequest;
use App\Models\Incidents;
use Exception;
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

        return redirect()->route('incidents.index')->with('status-success', 'Incident créé avec succès.');
    }

    public function edit(Incidents $incident)
    {
        return view('incidents.form', compact('incident'));
    }

    public function update(IncidentsRequest $request, Incidents $incident)
    {
        $incident->update($request->validated());

        return redirect()->route('incidents.index')->with('status-warning', 'Incident mis à jour avec succès.');
    }

    public function destroy(Incidents $incident)
    {
        try {
            $incident->delete();
            return redirect()->route('incidents.index')->with('status-danger', 'Incident supprimé avec succès.');
        } catch (Exception $e) {
            $errorMessage = 'Une erreur s\'est produite lors de la suppression de l\'incident.';
            return redirect()->route('incidents.index')->with('status-danger', $errorMessage);
        }
    }
}
