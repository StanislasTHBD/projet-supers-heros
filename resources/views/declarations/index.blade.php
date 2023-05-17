@extends('layouts.app')

@section('title', 'Liste des Déclarations')

@section('content')
    <h1>Liste des Déclarations</h1>

    <a href="{{ route('declarations.create') }}" class="btn btn-primary mb-3">Créer une déclaration</a>

    <div id="map" style="height: 500px;"></div>

    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th>Ville</th>
            <th>Incident</th>
            <th>Localisation (lat, lon)</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($declarations as $declaration)
            <tr>
                <td>{{ $declaration->city }}</td>
                <td>{{ $declaration->incident->name }}</td>
                <td>{{ $declaration->latitude }}, {{ $declaration->longitude }}</td>
                <td>
                    <a href="{{ route('declarations.show', ['declaration' => $declaration->id]) }}" class="btn btn-primary">Visualiser</a>
                    <a href="{{ route('declarations.edit', ['declaration' => $declaration->id]) }}" class="btn btn-secondary">Modifier</a>
                    <form method="POST" action="{{ route('declarations.destroy', ['declaration' => $declaration->id]) }}" style="display: inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Etes-vous certain de vouloir continuer ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @if ($declarations->isNotEmpty())
        <script>
            var map = L.map('map').setView([{{ $declarations[0]->latitude }}, {{ $declarations[0]->longitude }}], 5);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var redIcon = L.icon({
                iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
            });

            @foreach ($declarations as $declaration)
            L.marker([{{ $declaration->latitude }}, {{ $declaration->longitude }}], { icon: redIcon })
                .addTo(map)
                .bindPopup("Ville: {{ $declaration->city }}<br>Incident: {{ $declaration->incident->name }}");
            @endforeach

        </script>
    @endif
@endsection
