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
                        <div class="info-group">
                            <h5>Incidents</h5>
                            <p>{{ $hero->incidents }}</p>
                        </div>
                        <div class="info-group">
                            <h5>Téléphone</h5>
                            <p>{{ $hero->phone_number }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-group">
                            <h5>Localisation (lat, lon)</h5>
                            <p>{{ $hero->latitude }}, {{ $hero->longitude }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
