@extends('layouts.app')

@section('title', 'Le Site du Héros - Bienvenue')

@section('content')
    <div class="full-page-image">
        <div class="container d-flex align-items-center justify-content-center h-100">
            <div class="card bg-secondary bg-opacity-75 border-opacity-50 text-light">
                <div class="card-body text-center">
                    <h1 class="card-title text-light">Bienvenue sur le Site du Héros !</h1>
                    <h5 class="card-text text-light">
                        Bienvenue dans un monde où les Super Héros et les citoyens unissent leurs forces pour assurer
                        la sécurité de nos communautés ! Plongez dans l'aventure en tant que Super Héros enregistré,
                        prêt à intervenir en cas d'incident. Les citoyens peuvent facilement déclarer des incidents
                        et accéder à une liste de Super Héros qualifiés, basée sur la géolocalisation,
                        pour une assistance rapide et efficace. Ensemble, construisons un avenir plus sûr en
                        protégeant nos villes avec bravoure et dévouement.
                    </h5>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-dark bg-opacity-75 border-opacity-50 text-light clickable-div" onclick="window.location.href = '{{ route('declarations.create') }}'">
                                <div class="card-body text-center">
                                    <h1 class="card-title text-light">Besoin d'un héros ?</h1>
                                    <p class="card-text text-light">Signalez votre incident et nous passerons à l'action !</p>
                                </div>
                            </div>
                        </div>

                        @auth
                            @if(Auth::user()->heros()->exists())
                                <div class="col-md-6">
                                    <div class="card bg-dark bg-opacity-75 border-opacity-50 text-light clickable-div" onclick="window.location.href = '{{ route('heros.show', Auth::user()->heros->id) }}'">
                                        <div class="card-body text-center">
                                            <h1 class="card-title text-light">Voir son héros !</h1>
                                            <p class="card-text text-light">Le profil héros, une histoire de courage et de triomphes.</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <div class="card bg-dark bg-opacity-75 border-opacity-50 text-light clickable-div" onclick="window.location.href = '{{ route('heros.create') }}'">
                                        <div class="card-body text-center">
                                            <h1 class="card-title text-light">Créez votre héros !</h1>
                                            <p class="card-text text-light">Rejoignez notre équipe d'aventuriers audacieux.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endauth
                        @guest
                            <div class="col-md-6">
                                <div class="card bg-dark bg-opacity-75 border-opacity-50 text-light clickable-div" onclick="window.location.href = '{{ route('register') }}'">
                                    <div class="card-body text-center">
                                        <h1 class="card-title text-light">Prêt à devenir un héros ?</h1>
                                        <p class="card-text text-light">Inscrivez-vous dès maintenant et rejoignez notre équipe !</p>
                                    </div>
                                </div>
                            </div>
                        @endguest
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
            background-image: url({{ asset('image/fd5.jpg') }});
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

