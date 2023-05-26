@extends('layouts.app')

@section('title', 'Liste des Héros')

@section('content')

    <div class="card bg-secondary bg-opacity-75 border-opacity-50 text-light">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title">Liste des Héros</h2>
            @if(Auth::user()->heros()->exists())
                <a href="{{ route('heros.show', Auth::user()->heros->id) }}" class="btn btn-dark">Voir son héros</a>
            @else
                <a href="{{ route('heros.create') }}" class="btn btn-primary">Créer un héros</a>
            @endif
        </div>
        <div class="card-body">
            <div id="map" class="rounded-3" style="height: 500px;"></div>
            <hr>
            <form action="{{ route('heros.index') }}" method="GET" class="form-inline">
                <div class="row">
                    <div class="col-md-5 mb-2">
                        <select name="incident_query" class="form-control">
                            <option value="">Rechercher par incident</option>
                            @foreach ($incidents as $incident)
                                <option value="{{ $incident->id }}" {{ request('incident_query') == $incident->id ? 'selected' : '' }}>{{ $incident->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5 mb-2">
                        <input type="text" name="query" value="{{ request('query') }}" class="form-control" placeholder="Rechercher par nom de héros">
                    </div>
                    <div class="col-md-2 mb-2">
                        <button type="submit" class="btn btn-primary">Rechercher</button>
                    </div>
                </div>
            </form>
            <br/>
            @foreach ($heros as $hero)
                <div class="card mb-3 bg-dark bg-opacity-75 border-opacity-50 text-light">
                    <div class="card-header">
                        <h3 class="card-title p-2">{{ $hero->name }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 d-flex justify-content-between align-items-center">
                                <img class="card-img-top img-center rounded-circle" src="{{ asset($hero->image) }}" alt="{{ $hero->name }}">
                            </div>
                            <div class="col-md-5">
                                <h4>Information du héro :</h4>
                                <p>Téléphone: {{ $hero->phone_number }}</p>
                                <p>Ville: {{ $hero->city }}</p>
                                <p>Localisation (lat, lon): {{ $hero->latitude }}, {{ $hero->longitude }}</p>
                            </div>
                            <div class="col-md-5">
                                <h4 class="card-text">Liste des incidents:</h4>
                                <p>
                                    @foreach ($hero->incidents as $incident)
                                        <span class="badge rounded-2 text-bg-danger p-2">{{ $incident->name }}</span>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col d-flex justify-content-center">
                                <a href="{{ route('heros.show', $hero) }}" class="btn btn-primary">Visualiser</a>
                            </div>
                            @if(Auth::user()->id === $hero->user_id)
                                <div class="col d-flex justify-content-center">
                                    <a href="{{ route('heros.edit', $hero) }}" class="btn btn-secondary">Modifier</a>
                                </div>
                                <div class="col d-flex justify-content-center">
                                    <form action="{{ route('heros.destroy', $hero) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Etes-vous certain de vouloir continuer ?')">Supprimer</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        html, body {
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url({{ asset('image/fd6.jpg') }});
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            z-index: -1;
        }

        .content-container {
            padding: 150px 300px;
        }

        .content-container {
            padding: 150px 300px;
        }

        @media (max-width: 1350px) {
            .content-container {
                padding: 150px 50px;
            }
        }

        @media (max-width: 992px) {
            .content-container {
                padding: 150px 40px;
            }
        }

        @media (max-width: 850px) {
            .content-container {
                padding: 150px 30px;
            }
        }

        @media (max-width: 576px) {
            .content-container {
                padding: 150px 15px;
            }
        }
    </style>

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
        marker.bindPopup(`
            <div class="custom-popup" style="width: 300px; height: 150px;">
                 <div class="row">
                    <div class="col-md-4 d-flex justify-content-between align-items-center">
                          <img class="card-img-top img-center rounded-circle" src="{{ asset($hero->image) }}" alt="{{ $hero->name }}">
                    </div>
                    <div class="col-md-8">
                        <h4>{{ $hero->name }}</h4>
                        <p>Incidents: ${incidentsString}</p>
                        <p>Téléphone: {{ $hero->phone_number }}</p>
                    </div>
                </div>
            </div>
        `);
        markers.push(marker);
        @endforeach
    </script>

@endsection
