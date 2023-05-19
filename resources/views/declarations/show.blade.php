@extends('layouts.app')

@section('title', 'Détails de la Déclaration')

@section('content')

<div class="content-container">
    <div class="card bg-secondary bg-opacity-75 border-opacity-50 text-light">
        <div class="card-body">
            <h1 class="card-title">Détails de la Déclaration</h1>
            <hr>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card bg-dark mb-3 text-center">
                        <div class="card-body">
                            <h5 class="card-title">Incident</h5>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5>{{ $declaration->incident->name }}</h5>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="map" class="rounded-3" style="height: 500px;"></div>
            <hr>
            <div class="text-center">
                <h2>Héros disponibles dans un rayon de 50 km</h2>
            </div>
            <br/>
            <div class="row" id="heroes-list">
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
        background-image: url({{ asset('image/fd24.jpg') }});
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
        function initMap(latitude, longitude) {
            var map = L.map('map').setView([latitude, longitude], 9);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
                maxZoom: 18,
            }).addTo(map);

            var redIcon = L.icon({
                iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
            });

            L.marker([latitude, longitude], { icon: redIcon }).addTo(map);
            L.circle([latitude, longitude], { radius: 50000 }).addTo(map);

            function getDistance(lat1, lon1, lat2, lon2) {
                var earthRadius = 6371;

                var distanceLat = deg2rad(lat2 - lat1);
                var distanceLon = deg2rad(lon2 - lon1);

                var a = Math.sin(distanceLat / 2) * Math.sin(distanceLat / 2) + Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * Math.sin(distanceLon / 2) * Math.sin(distanceLon / 2);
                var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

                var distance = earthRadius * c;

                return distance * 1000;
            }

            function deg2rad(deg) {
                return deg * (Math.PI / 180);
            }

            var heroesWithDistance = [];

            @foreach ($heros as $hero)
            var heroLatitude = {{ $hero->latitude }};
            var heroLongitude = {{ $hero->longitude }};
            var distance = getDistance(latitude, longitude, heroLatitude, heroLongitude);
            var heroDistance = distance / 1000;
            heroDistance = Math.round(heroDistance * 100) / 100;

            if (distance <= 50000) {
                heroesWithDistance.push({
                    hero: {!! json_encode($hero) !!},
                    distance: distance,
                    distanceHero: heroDistance
                });
                var marker = L.marker([heroLatitude, heroLongitude]).addTo(map);
                var incidents = {!! json_encode($hero->incidents->pluck('name')) !!};
                var incidentsString = Array.isArray(incidents) ? incidents.join(', ') : incidents;
                marker.bindPopup("<h4>{{ $hero->name }}</h4><p>Incidents: " + incidentsString + "</p><p>Téléphone: {{ $hero->phone_number }}</p>");
            }
            @endforeach

            heroesWithDistance.sort(function(a, b) {
                return a.distance - b.distance;
            });

            if (heroesWithDistance.length === 0) {
                var noHeroesCard = document.createElement('div');
                noHeroesCard.classList.add('col-md-12');
                noHeroesCard.innerHTML = '<div class="card bg-dark mb-3"><div class="card-body"><h5 class="card-title">Aucun héros disponible dans un rayon de 50 km.</h5></div></div>';
                document.getElementById('heroes-list').appendChild(noHeroesCard);
            } else {
                heroesWithDistance.forEach(function(heroData) {
                    var hero = heroData.hero;
                    var heroLatitude = hero.latitude;
                    var heroLongitude = hero.longitude;

                    var heroCard = document.createElement('div');
                    heroCard.classList.add('col-md-6');
                    heroCard.innerHTML = '<div class="card bg-dark mb-3"><div class="card-body"><h5 class="card-title">' + hero.name + '</h5><p class="card-text">Téléphone: ' + hero.phone_number + '</p><p class="card-text">Incidents: ' + incidentsString + '</p><p class="card-text">Localisation: (' + heroLatitude + ', ' + heroLongitude + ')</p><p class="card-text">Distance: ' + heroData.distanceHero + ' km</p></div></div>';
                    document.getElementById('heroes-list').appendChild(heroCard);
                });
            }
        }

        var declarationLatitude = {{ $declaration->latitude }};
        var declarationLongitude = {{ $declaration->longitude }};

        initMap(declarationLatitude, declarationLongitude);

    </script>

@endsection
