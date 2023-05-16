@extends('layouts.app')

@section('title', 'Visualiser l\'héros')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">{{ $hero->name }}</h1>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Incidents</h5>
                                <ul class="list-group">
                                    @foreach ($hero->incidents as $incident)
                                        <li class="list-group-item">{{ $incident->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Téléphone</h5>
                                <p class="card-text">{{ $hero->phone_number }}</p>
                                <hr>
                                <h5 class="card-title">Adresse</h5>
                                <p class="card-text">{{ $hero->street }}</p>
                                <p class="card-text">{{ $hero->postal_code }} - {{ $hero->city }}</p>
                                <hr>
                                <h5 class="card-title">Localisation (lat, lon)</h5>
                                <p class="card-text">{{ $hero->latitude }}, {{ $hero->longitude }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="map" style="height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var heroLatitude = {{ $hero->latitude }};
        var heroLongitude = {{ $hero->longitude }};

        var map = L.map('map', {
            minZoom: 3,
            maxZoom: 9,
            maxBounds: L.latLngBounds(L.latLng(-90, -180), L.latLng(90, 180))
        }).setView([heroLatitude, heroLongitude], 7);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        }).addTo(map);

        var marker = L.marker([heroLatitude, heroLongitude]).addTo(map);

        var circle = L.circle([heroLatitude, heroLongitude], {
            color: 'blue',
            fillColor: '#blue',
            fillOpacity: 0.2,
            radius: 50000
        }).addTo(map);
    </script>
@endsection
