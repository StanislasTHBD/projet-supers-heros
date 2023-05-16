@extends('layouts.app')

@section('title', isset($hero) ? 'Modifier l\'Héros' : 'Créer un Héros')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        <h1>{{ isset($hero) ? 'Modifier l\'Héros' : 'Créer un Héros' }}</h1>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="search-city"><h5>Recherche</h5></label>
                    <div class="input-group">
                        <input type="text" id="search-city" class="form-control" placeholder="lat, long / ville / code postal">
                        <div class="input-group-append">
                            <button type="button" id="btn-search" class="btn btn-primary">Rechercher</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="map" style="height: 500px;"></div>

<br/>

        <form action="{{ isset($hero) ? route('heros.update', $hero) : route('heros.store') }}" method="POST">
            @csrf
            @if (isset($hero))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label"><h5>Nom</h5></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', isset($hero) ? $hero->name : '') }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="phone_number" class="form-label"><h5>Téléphone</h5></label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', isset($hero) ? $hero->phone_number : '') }}">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="incidents" class="form-label"><h5>Incidents</h5></label>
                <select class="form-select" name="incidents[]" multiple>
                    @foreach ($incidents as $incident)
                        <option value="{{ $incident->id }}" {{ isset($hero) && in_array($incident->id, $hero->incidents->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $incident->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="latitude" class="form-label"><h5>Latitude</h5></label>
                        <input type="text" class="form-control text-bg-secondary" id="latitude" name="latitude" value="{{ old('latitude', isset($hero) ? $hero->latitude : '') }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="longitude" class="form-label"><h5>Longitude</h5></label>
                        <input type="text" class="form-control text-bg-secondary" id="longitude" name="longitude" value="{{ old('longitude', isset($hero) ? $hero->longitude : '') }}" readonly>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="street" class="form-label"><h5>Rue</h5></label>
                <input type="text" class="form-control text-bg-secondary" id="street" name="street" value="{{ old('street', isset($hero) ? $hero->street : '') }}" readonly>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="postal_code" class="form-label"><h5>Code postale</h5></label>
                        <input type="text" class="form-control text-bg-secondary" id="postal_code" name="postal_code" value="{{ old('postal_code', isset($hero) ? $hero->postal_code : '') }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="city" class="form-label"><h5>Ville</h5></label>
                        <input type="text" class="form-control text-bg-secondary" id="city" name="city" value="{{ old('city', isset($hero) ? $hero->city : '') }}" readonly>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
    </div>

    <script>
        var heroLatitude = {{ $hero->latitude ?? 'null' }};
        var heroLongitude = {{ $hero->longitude ?? 'null' }};

        // var map = L.map('map').setView([49.38237627928732, 1.0743266344070437], 13); //CESI
        var map = L.map('map', {
            minZoom: 3,
            maxZoom: 18,
            maxBounds: L.latLngBounds(L.latLng(-90, -180), L.latLng(90, 180))
        }).setView([49.435984899682005, 1.1260986328125002], 3); // ROUEN

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        }).addTo(map);

        var marker;
        var circle;

        if (heroLatitude && heroLongitude) {
            marker = L.marker([heroLatitude, heroLongitude]).addTo(map);
            map.setView([heroLatitude, heroLongitude], 7);

            circle = L.circle([heroLatitude, heroLongitude], {
                color: 'blue',
                fillColor: '#blue',
                fillOpacity: 0.2,
                radius: 50000
            }).addTo(map);
        }

        map.on('click', function(e) {
            if (circle) {
                map.removeLayer(circle);
            }

            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker(e.latlng).addTo(map);

            // Récupérer les coordonnées lat/lon
            var lat = e.latlng.lat;
            var lon = e.latlng.lng;

            // Mettre à jour les champs du formulaire
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lon;

            circle = L.circle([lat, lon], {
                color: 'blue',
                fillColor: '#blue',
                fillOpacity: 0.2,
                radius: 50000
            }).addTo(map);

            // Récupérer le nom de la ville
            fetch('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + lat + '&lon=' + lon)
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {

                    if (data.address.road) {
                        document.getElementById('street').value = data.address.road;
                    } else if (data.address.hamlet) {
                        document.getElementById('street').value = data.address.hamlet;
                    } else {
                        document.getElementById('street').value = 'Non disponible';
                    }

                    if (data.address.city) {
                        document.getElementById('city').value = data.address.city;
                    } else if (data.address.village) {
                        document.getElementById('city').value = data.address.village;
                    } else if (data.address.state) {
                        document.getElementById('city').value = data.address.state;
                    } else if (data.address.municipality) {
                        document.getElementById('city').value = data.address.municipality; }
                    else if (data.address.country) {
                        document.getElementById('city').value = data.address.country;
                    } else {
                        document.getElementById('city').value = 'Non disponible';
                    }

                    if (data.address.postcode) {
                    document.getElementById('postal_code').value = data.address.postcode;
                    } else if (data.address.country_code) {
                        document.getElementById('postal_code').value = data.address.country_code;
                    } else {
                        document.getElementById('postal_code').value = 'Non disponible';
                    }

                })
                .catch(function(error) {
                    console.log(error);
                });
        });

        // Recherche de ville
        var searchButton = document.getElementById('btn-search');
        var searchCityInput = document.getElementById('search-city');

        function searchCity(query) {
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}&addressdetails=1&limit=1`)
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    if (data.length > 0) {
                        const result = data[0];
                        const lat = parseFloat(result.lat);
                        const lon = parseFloat(result.lon);
                        const street = result.address.road || result.address.hamlet || 'Non disponible';
                        const city = result.address.city || result.address.village || result.address.town || result.address.municipality || 'Non disponible';
                        const postalCode = result.address.postcode || 'Non disponible';

                        map.setView([lat, lon], 9);

                        if (marker) {
                            map.removeLayer(marker);
                        }

                        marker = L.marker([lat, lon]).addTo(map);

                        // Mettre à jour les champs du formulaire
                        document.getElementById('latitude').value = lat;
                        document.getElementById('longitude').value = lon;
                        document.getElementById('street').value = street;
                        document.getElementById('city').value = city;
                        document.getElementById('postal_code').value = postalCode;


                        // Supprimer le cercle existant s'il y en a un
                        if (circle) {
                            map.removeLayer(circle);
                        }

                        // Afficher le périmètre
                        circle = L.circle([lat, lon], {
                            color: 'blue',
                            fillColor: '#blue',
                            fillOpacity: 0.3,
                            radius: 50000
                        }).addTo(map);
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        }

        searchButton.addEventListener('click', function() {
            var searchQuery = searchCityInput.value;
            if (searchQuery) {
                searchCity(searchQuery);
            }
        });
    </script>
@endsection
