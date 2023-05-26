<?php

namespace App\Http\Controllers;

use App\Http\Requests\HerosRequest;
use App\Models\Heros;
use App\Models\Incidents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class HerosController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $incidentQuery = $request->input('incident_query');

        $heros = Heros::query();

        if ($query) {
            $heros->where('heros.name', 'like', "%{$query}%");
        }

        if ($incidentQuery) {
            $heros->whereHas('incidents', function ($q) use ($incidentQuery) {
                $q->where('incidents.id', $incidentQuery);
            });
        }

        $heros = $heros->get();
        $incidents = Incidents::all();

        return view('heros.index', compact('heros', 'incidents'));
    }

    public function create()
    {
        $incidents = Incidents::all();

        $user = Auth::user();
        $hasHero = $user->heros()->exists();

        if ($hasHero) {
            return redirect()->route('heros.index')->with('status-danger', 'Vous ne pouvez créer qu\'un seul héros.');
        }

        return view('heros.form', compact('incidents'));
    }

    public function store(HerosRequest $request)
    {
        $herosData = $request->validated();

        $heros = Heros::create($herosData);

        if ($request->hasFile('image')) {
            $request->file('image')->store('public/heros');

            $heros->image = 'storage/heros/'.$request->file('image')->hashName();
            $heros->save();
        }

        $selectedIncidents = $request->input('incidents', []);
        $heros->incidents()->attach($selectedIncidents);

        return redirect()->route('heros.show', $heros)->with('status-success', 'Héros créé avec succès');
    }

    public function show(Heros $hero)
    {
        return view('heros.show', compact('hero'));
    }

    public function edit(Heros $hero)
    {
        if ($hero->user_id !== Auth::id()) {
            return redirect()->route('heros.index')->with('status-danger', 'Vous n\'êtes pas autorisé à modifier ce héros.');
        }

        $incidents = Incidents::all();

        return view('heros.form', compact('hero', 'incidents'));
    }

    public function update(HerosRequest $request, Heros $hero)
    {
        if ($hero->user_id !== Auth::id()) {
            return redirect()->route('heros.index')->with('status-danger', 'Vous n\'êtes pas autorisé à mettre à jour ce héros.');
        }

        $herosData = $request->validated();

        if ($request->hasFile('image')) {

            if ($hero->image && $hero->image !== 'storage/hero/default.jpg') {
                $oldImagePath = public_path($hero->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            $newImagePath = $request->file('image')->store('public/heros');
            $herosData['image'] = 'storage/heros/' . basename($newImagePath);
        }

        $hero->update($herosData);

        $selectedIncidents = $request->input('incidents', []);
        $hero->incidents()->sync($selectedIncidents);

        return redirect()->route('heros.show', $hero)->with('status-warning', 'Héros mis à jour avec succès');
    }

    public function destroy(Heros $hero)
    {
        if ($hero->user_id !== Auth::id()) {
            return redirect()->route('heros.index')->with('status-danger', 'Vous n\'êtes pas autorisé à supprimer ce héros.');
        }

        if ($hero->image && $hero->image !== 'storage/hero/default.jpg') {
            $oldImagePath = public_path($hero->image);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
        }

        $hero->incidents()->detach();
        $hero->delete();

        return redirect()->route('heros.index')->with('status-danger', 'Héros supprimé avec succès');
    }

}
