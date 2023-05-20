@extends('layouts.app')

@section('title', 'Liste des Incidents')

@section('content')

    <div class="card bg-secondary bg-opacity-75 border-opacity-50 text-light">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title">Liste des Incidents</h2>
            <a href="{{ route('incidents.create') }}" class="btn btn-primary">Créer un incident</a>
        </div>

        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <table class="table bg-dark rounded-3 text-light">
                            <thead>
                            <tr class="text-center">
                                <th>Nom</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($incidents as $incident)
                                <tr class="text-center">
                                    <td>{{ $incident->name }}</td>
                                    <td>
                                        <a href="{{ route('incidents.edit', $incident) }}" class="btn btn-secondary">Modifier</a>
                                        <form action="{{ route('incidents.destroy', $incident) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Etes-vous certain de vouloir continuer ?')">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
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
            background-image: url({{ asset('image/fd30.jpeg') }});
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
@endsection
