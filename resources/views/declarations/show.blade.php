@extends('layouts.app')

@section('title', 'Détails de la Déclaration')

@section('content')
    <div class="container">
        <h1>Détails de la Déclaration</h1>

        <div>
            <h2>{{ $declaration->incident->name }}</h2>
        </div>

        <div id="map" style="height: 500px;"></div>

        <br/>

        <h2>Héros disponibles dans un rayon de 50 km :</h2>

        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Incident</th>
                    <th>Localisation (lat, lon)</th>
                    <th>Distance (en km)</th>
                </tr>
                </thead>
                <tbody id="heroes-list">
                </tbody>
            </table>
        </div>

    </div>

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
                var noHeroesRow = document.createElement('tr');
                var noHeroesCell = document.createElement('td');
                noHeroesCell.setAttribute('colspan', '5');

                var noHeroesHeading = document.createElement('h5');
                noHeroesHeading.textContent = 'Aucun héros disponible dans un rayon de 50 km.';
                noHeroesCell.appendChild(noHeroesHeading);

                noHeroesRow.appendChild(noHeroesCell);
                document.getElementById('heroes-list').appendChild(noHeroesRow);
            } else {
                heroesWithDistance.forEach(function (heroData) {
                    var hero = heroData.hero;
                    var heroLatitude = hero.latitude;
                    var heroLongitude = hero.longitude;

                    var row = document.createElement('tr');

                    var nameCell = document.createElement('td');
                    nameCell.textContent = hero.name;
                    row.appendChild(nameCell);

                    var phoneCell = document.createElement('td');
                    phoneCell.textContent = hero.phone_number;
                    row.appendChild(phoneCell);

                    var incidentsCell = document.createElement('td');
                    incidentsCell.textContent = incidentsString;
                    row.appendChild(incidentsCell);

                    var locationCell = document.createElement('td');
                    locationCell.textContent = '(' + heroLatitude + ', ' + heroLongitude + ')';
                    row.appendChild(locationCell);

                    var distanceCell = document.createElement('td');
                    distanceCell.textContent = heroData.distanceHero + ' km';
                    row.appendChild(distanceCell);

                    document.getElementById('heroes-list').appendChild(row);
                });
            }
        }

        var declarationLatitude = {{ $declaration->latitude }};
        var declarationLongitude = {{ $declaration->longitude }};

        initMap(declarationLatitude, declarationLongitude);

    </script>

@endsection
