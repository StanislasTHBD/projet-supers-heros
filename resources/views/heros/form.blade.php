@extends('layouts.app')

@section('title', isset($hero) ? 'Modifier l\'Héros' : 'Créer un Héros')

@section('content')
    <div class="container">
        <h1>{{ isset($hero) ? 'Modifier l\'Héros' : 'Créer un Héros' }}</h1>

        <form action="{{ isset($hero) ? route('heros.update', $hero) : route('heros.store') }}" method="POST">
            @csrf
            @if (isset($hero))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', isset($hero) ? $hero->name : '') }}">
            </div>

            <div class="mb-3">
                <label for="incidents" class="form-label">Incidents</label>
                <select class="form-select" id="incidents" name="incidents[]" multiple>
                    @foreach ($incidents as $incident)
                        <option value="{{ $incident->name }}" {{ in_array($incident->name, $selectedIncidents) ? 'selected' : '' }}>
                            {{ $incident->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="latitude" class="form-label">Latitude</label>
                        <input type="text" class="form-control" id="latitude" name="latitude" value="{{ old('latitude', isset($hero) ? $hero->latitude : '') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="longitude" class="form-label">Longitude</label>
                        <input type="text" class="form-control" id="longitude" name="longitude" value="{{ old('longitude', isset($hero) ? $hero->longitude : '') }}">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">Téléphone</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', isset($hero) ? $hero->phone_number : '') }}">
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </form>
    </div>
@endsection
