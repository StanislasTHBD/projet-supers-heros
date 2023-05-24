@extends('layouts.app')

@section('title', 'Liste des Déclarations')

@section('content')

    <div class="card bg-secondary bg-opacity-75 border-opacity-50 text-light">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title">Liste des Déclarations</h2>
            <a href="{{ route('declarations.create') }}" class="btn btn-primary">Créer une déclaration</a>
        </div>
        <div class="card-body">

            @if (count($declarations) === 0)
                <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                    <h4>Aucune déclaration disponible.</h4>
                </div>
            @else

                <div id="map" class="rounded-3" style="height: 500px;"></div>

                <hr>

                @foreach ($declarations as $declaration)
                    <div class="card mb-3 bg-dark bg-opacity-75 border-opacity-50 text-light">
                        <div class="card-header">
                            <h3 class="card-title">{{ $declaration->city }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h4>Information de l'incident :</h4>
                                    <p>Incident: {{ $declaration->incident->name }}</p>
                                    <p>Localisation (lat, lon): {{ $declaration->latitude }}, {{ $declaration->longitude }}</p>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col d-flex justify-content-center">
                                    <a href="{{ route('declarations.show', ['declaration' => $declaration->id]) }}" class="btn btn-primary">Visualiser</a>
                                </div>
                                <div class="col d-flex justify-content-center">
                                    <a href="{{ route('declarations.edit', ['declaration' => $declaration->id]) }}" class="btn btn-secondary">Modifier</a>
                                </div>
                                <div class="col d-flex justify-content-center">
                                    <form method="POST" action="{{ route('declarations.destroy', ['declaration' => $declaration->id]) }}" style="display: inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Etes-vous certain de vouloir continuer ?')">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <style>
        html, body {
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url({{ asset('image/fd22.jpg') }});
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


    @if ($declarations->isNotEmpty())
        <script>
            var map = L.map('map',{
                minZoom: 3,
                maxZoom: 18,
                maxBounds: L.latLngBounds(L.latLng(-90, -180), L.latLng(90, 180))
            }).setView([{{ $declarations[0]->latitude }}, {{ $declarations[0]->longitude }}], 5);

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
