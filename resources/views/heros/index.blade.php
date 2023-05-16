@extends('layouts.app')

@section('title', 'Liste des Héros')

@section('content')
    <div class="container">
        <h1>Liste des Héros</h1>

        <div class="mb-3">
            <a href="{{ route('heros.create') }}" class="btn btn-primary">Créer un héros</a>
        </div>

        <div id="map" style="height: 500px;"></div>

        <hr>

        <form action="{{ route('heros.index') }}" method="GET" class="form-inline">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <select name="incident_query" class="form-control">
                        <option value="">Rechercher par incident</option>
                        @foreach ($incidents as $incident)
                            <option value="{{ $incident->id }}" {{ request('incident_query') == $incident->id ? 'selected' : '' }}>{{ $incident->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <input type="text" name="query" value="{{ request('query') }}" class="form-control" placeholder="Rechercher par nom de héros">
                </div>
                <div class="col-md-4 mb-2">
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                </div>
            </div>
        </form>


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
                    <td>
                        <ul>
                            @foreach ($hero->incidents as $incident)
                                <li>{{ $incident->name }}</li>
                            @endforeach
                        </ul>
                    </td>
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

    <script>
        var map = L.map('map', {
            minZoom: 3,
            maxZoom: 18,
            maxBounds: L.latLngBounds(L.latLng(-90, -180), L.latLng(90, 180))
        }).setView([49.435984899682005, 1.1260986328125002], 3); // ROUEN

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
            // noWrap: true
        }).addTo(map);

        var markers = [];

        @foreach ($heros as $hero)
        var marker = L.marker([{{ $hero->latitude }}, {{ $hero->longitude }}]).addTo(map);
        var incidents = {!! json_encode($hero->incidents->pluck('name')) !!};
        var incidentsString = Array.isArray(incidents) ? incidents.join(', ') : incidents;
        marker.bindPopup("<h4>{{ $hero->name }}</h4><p>Incidents: " + incidentsString + "</p><p>Téléphone: {{ $hero->phone_number }}</p>");
        markers.push(marker);
        @endforeach
    </script>

@endsection
