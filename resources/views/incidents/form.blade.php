@extends('layouts.app')

@section('title', isset($incident) ? 'Modifier l\'Incident' : 'Créer un Incident')

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
            <h2>{{ isset($incident) ? 'Modifier l\'Incident' : 'Créer un Incident' }}</h2>
        </div>

        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <form action="{{ isset($incident) ? route('incidents.update', $incident) : route('incidents.store') }}" method="POST">
                            @csrf
                            @if (isset($incident))
                                @method('PUT')
                            @endif

                            <div class="mb-3">
                                <label for="name" class="form-label">Nom</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', isset($incident) ? $incident->name : '') }}">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Valider</button>
                        </form>
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
            background-image: url({{ asset('image/fd20.jpeg') }});
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
