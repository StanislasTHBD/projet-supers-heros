@extends('layouts.app')

@section('title', isset($incident) ? 'Modifier l\'Incident' : 'Créer un Incident')

@section('content')
    <div class="container">
        <h1>{{ isset($incident) ? 'Modifier l\'Incident' : 'Créer un Incident' }}</h1>

        <form action="{{ isset($incident) ? route('incidents.update', $incident) : route('incidents.store') }}" method="POST">
            @csrf
            @if (isset($incident))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', isset($incident) ? $incident->name : '') }}">
            </div>

            <button type="submit" class="btn btn-primary">Valider</button>
        </form>
    </div>
@endsection
