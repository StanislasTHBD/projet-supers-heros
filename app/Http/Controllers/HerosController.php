<?php

namespace App\Http\Controllers;

use App\Http\Requests\HerosRequest;
use App\Models\Heros;
use App\Models\Incidents;
use Illuminate\Http\Request;

class HerosController extends Controller
{
    public function index()
    {
        $heros = Heros::all();
        $incidents = Incidents::all();

        return view('heros.index', compact('heros', 'incidents'));
    }

    public function create()
    {
        $incidents = Incidents::all();
        $selectedIncidents = [];
        return view('heros.form', compact('incidents', 'selectedIncidents'));
    }

    public function store(HerosRequest $request)
    {
        $data = $request->validated();

        $incidents = isset($data['incidents']) ? implode(',', (array) $data['incidents']) : '';

        $heros = Heros::create(array_merge($data, ['incidents' => $incidents]));

        return redirect()->route('heros.index')->with('success', 'Heros created successfully.');
    }

    public function show(Heros $hero)
    {
        return view('heros.show', compact('hero'));
    }

    public function edit(Heros $hero)
    {
        $incidents = Incidents::all();
        $selectedIncidents = old('incidents', isset($hero) ? explode(',', $hero->incidents) : []);
        return view('heros.form', compact('hero', 'incidents', 'selectedIncidents'));
    }

    public function update(HerosRequest $request, Heros $hero)
    {
        $data = $request->validated();

        $incidents = isset($data['incidents']) ? implode(',', (array) $data['incidents']) : '';

        $hero->update(array_merge($data, ['incidents' => $incidents]));

        return redirect()->route('heros.index')->with('success', 'Heros updated successfully.');
    }

    public function destroy(Heros $hero)
    {
        $hero->delete();
        return redirect()->route('heros.index')->with('success', 'Heros deleted successfully.');
    }
}
