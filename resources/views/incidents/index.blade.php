@extends('layouts.app')

@section('title', 'Liste des Incidents')

@section('content')
    <div class="container">
        <h1>Liste des Incidents</h1>

        <div class="mb-3">
            <a href="{{ route('incidents.create') }}" class="btn btn-primary">Créer un incident</a>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($incidents as $incident)
                <tr>
                    <td>{{ $incident->name }}</td>
                    <td>
                        <a href="{{ route('incidents.edit', $incident) }}" class="btn btn-secondary">Modifier</a>
                        <form action="{{ route('incidents.destroy', $incident) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Etes-vous certain de vouloir continuer ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
