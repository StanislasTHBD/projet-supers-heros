@extends('layouts.app')

@section('title', 'Liste des Héros')

@section('content')
    <div class="container">
        <h1>Liste des Héros</h1>

        <div class="mb-3">
            <a href="{{ route('heros.create') }}" class="btn btn-primary">Créer un héros</a>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Incidents</th>
                <th>Localisation (lat, lon)</th>
                <th>Téléphone</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($heros as $hero)
                <tr>
                    <td>{{ $hero->name }}</td>
{{--                    <td>{{ implode(', ', $hero->incidents) }}</td>--}}
                    <td>{{ is_array($hero->incidents) ? implode(', ', $hero->incidents) : $hero->incidents }}</td>

                    <td>{{ $hero->latitude }}, {{ $hero->longitude }}</td>
                    <td>{{ $hero->phone_number }}</td>
                    <td>
                        <a href="{{ route('heros.show', $hero) }}" class="btn btn-primary">Visualiser</a>
                        <a href="{{ route('heros.edit', $hero) }}" class="btn btn-secondary">Modifier</a>
                        <form action="{{ route('heros.destroy', $hero) }}" method="POST" class="d-inline">
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
