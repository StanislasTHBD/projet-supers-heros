<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeclarationsRequest;
use App\Models\Declarations;
use App\Models\Heros;
use App\Models\Incidents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeclarationsController extends Controller
{
    public function index()
    {
        $declarations = Declarations::all();

        return view('declarations.index', ['declarations' => $declarations]);
    }

    public function create()
    {
        $incidents = Incidents::all();
        return view('declarations.form', ['incidents' => $incidents]);
    }

    public function store(DeclarationsRequest $request)
    {
        $validatedData = $request->validated();

        $declaration = Declarations::create($validatedData);

        return redirect()->route('declarations.show', ['declaration' => $declaration->id])->with('status-success', 'Déclaration créée avec succès.');
    }

    public function show(Declarations $declaration)
    {
        $heroIds = DB::table('hero_incident')->where('incident_id', $declaration->incident_id)->pluck('hero_id');

        $heros = Heros::whereIn('id', $heroIds)->get();

        return view('declarations.show', compact('declaration', 'heros'));
    }

    public function edit(Declarations $declaration)
    {
        $incidents = Incidents::all();
        return view('declarations.form', compact('declaration', 'incidents'));
    }

    public function update(DeclarationsRequest $request, Declarations $declaration)
    {
        $validatedData = $request->validated();

        $declaration->update($validatedData);

        return redirect()->route('declarations.show', ['declaration' => $declaration->id])->with('status-warning', 'Déclaration mise à jour avec succès.');
    }

    public function destroy(Declarations $declaration)
    {
        $declaration->delete();

        return redirect()->route('declarations.index')->with('status-danger', 'Déclaration supprimée avec succès.');
    }
}
