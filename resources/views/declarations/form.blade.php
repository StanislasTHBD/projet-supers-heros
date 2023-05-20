@extends('layouts.app')

@section('title', isset($declaration) ? 'Modifier la Déclaration' : 'Créer une Déclaration')

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
    <div class="card bg-secondary bg-opacity-75 border-opacity-50 text-light">
        <div class="card-header">
            <h1>{{ isset($declaration) ? 'Modifier la Déclaration' : 'Créer une Déclaration' }}</h1>
        </div>
        <div class="card-body">
            <div id="map" class="rounded-3" style="height: 500px;"></div>

            <br/>

            <form action="{{ isset($declaration) ? route('declarations.update', $declaration) : route('declarations.store') }}" method="POST">
                @csrf
                @if (isset($declaration))
                    @method('PUT')
                @endif

                <div class="card mb-3 bg-dark bg-opacity-75 border-opacity-50 text-light">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="incident_id" class="form-label">Incident</label>
                                    <select class="form-control @error('incident_id') is-invalid @enderror" id="incident_id" name="incident_id">
                                        <option value="">Choisissez un incident</option>
                                        @foreach ($incidents as $incident)
                                            <option value="{{ $incident->id }}" {{ old('incident_id', isset($declaration) && $declaration->incident_id == $incident->id ? 'selected' : '') }}>
                                                {{ $incident->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('incident_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="city" class="form-label">Ville</label>
                                    <input type="text" class="form-control text-bg-secondary @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city', isset($declaration) ? $declaration->city : '') }}" readonly>
                                    @error('city')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="text" class="form-control text-bg-secondary @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude', isset($declaration) ? $declaration->latitude : '') }}" readonly>
                                    @error('latitude')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="text" class="form-control text-bg-secondary @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude', isset($declaration) ? $declaration->longitude : '') }}" readonly>
                                    @error('longitude')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        html, body {
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url({{ asset('image/fd23.jpg') }});
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
        var redIcon = L.icon({
            iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
        });

        function getLocation() {
            console.log('getLocation');
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                console.log("La géolocalisation n'est pas prise en charge par ce navigateur.");
            }
        }

        function initMap(latitude, longitude) {
            console.log('initMap');
            var map = L.map('map').setView([latitude, longitude], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
                maxZoom: 18,
            }).addTo(map);

            var marker = L.marker([latitude, longitude], { icon: redIcon }).addTo(map);

            map.on('click', function(e) {
                var clickedLatLng = e.latlng;

                document.getElementById("latitude").value = clickedLatLng.lat;
                document.getElementById("longitude").value = clickedLatLng.lng;

                marker.setLatLng(clickedLatLng);

                fetch('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + clickedLatLng.lat + '&lon=' + clickedLatLng.lng)
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        var city = '';

                        if (data.address.city) {
                            city = data.address.city;
                        } else if (data.address.town) {
                            city = data.address.town;
                        } else if (data.address.village) {
                            city = data.address.village;
                        } else if (data.address.state) {
                            city = data.address.state;
                        } else if (data.address.municipality) {
                            city = data.address.municipality;
                        } else if (data.address.country) {
                            city = data.address.country;
                        } else {
                            city = 'Non disponible';
                        }

                        document.getElementById('city').value = city;
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            });
        }

        function showPosition(position) {
            console.log('showPosition');
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            console.log("Latitude : " + latitude);
            console.log("Longitude : " + longitude);

            document.getElementById("latitude").value = latitude;
            document.getElementById("longitude").value = longitude;

            initMap(latitude, longitude);

            fetch('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + latitude + '&lon=' + longitude)
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {

                    if (data.address.city) {
                        document.getElementById('city').value = data.address.city;
                    } else if (data.address.town) {
                        document.getElementById('city').value = data.address.town;
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

                })
                .catch(function(error) {
                    console.log(error);
                });
        }

        function showError(error) {
            console.log('showError');
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    console.log("L'utilisateur a refusé la demande de géolocalisation.");
                    setDefaultLocation();
                    break;
                case error.POSITION_UNAVAILABLE:
                    console.log("Les informations de géolocalisation ne sont pas disponibles.");
                    setDefaultLocation();
                    break;
                case error.TIMEOUT:
                    console.log("La demande de géolocalisation a expiré.");
                    setDefaultLocation();
                    break;
                case error.UNKNOWN_ERROR:
                    console.log("Une erreur inconnue s'est produite lors de la géolocalisation.");
                    setDefaultLocation();
                    break;
            }
        }

        function setDefaultLocation() {
            console.log('setDefaultLocation');
            var latitude = 48.002782;
            var longitude = 0.19835;

            document.getElementById("latitude").value = latitude;
            document.getElementById("longitude").value = longitude;

            initMap(latitude, longitude);

            fetch('https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + latitude + '&lon=' + longitude)
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {

                    if (data.address.city) {
                        document.getElementById('city').value = data.address.city;
                    } else if (data.address.town) {
                        document.getElementById('city').value = data.address.town;
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

                })
                .catch(function(error) {
                    console.log(error);
                });
        }

        getLocation();

    </script>
@endsection
