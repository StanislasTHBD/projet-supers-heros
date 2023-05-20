@extends('layouts.app')

@section('title', 'Visualiser l\'héros')

@section('content')

    <div class="card bg-secondary bg-opacity-75 border-opacity-50 text-light">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="card-title">{{ $hero->name }}</h1>
            @if(Auth::user()->id === $hero->user_id)
                <div class="col-auto">
                    <div class="btn-group" role="group" aria-label="Actions">
                        <a href="{{ route('heros.edit', $hero) }}" class="btn btn-secondary">Modifier</a>
                        <form action="{{ route('heros.destroy', $hero) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Etes-vous certain de vouloir continuer ?')">Supprimer</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-dark mb-3">
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
                    <div class="card bg-dark mb-3">
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
                    <div id="map" class="rounded-3" style="height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>

    <style>
        html, body {
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url({{ asset('image/fd7.jpg') }});
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
