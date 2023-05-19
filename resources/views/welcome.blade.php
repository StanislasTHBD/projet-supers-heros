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

                        <div class="col-md-6">
                            <div class="card bg-dark bg-opacity-75 border-opacity-50 text-light clickable-div" onclick="window.location.href = '{{ route('heros.create') }}'">
                                <div class="card-body text-center">
                                    <h1 class="card-title text-light">Prêt à devenir un héros ?</h1>
                                    <p class="card-text text-light">Inscrivez-vous dès maintenant et rejoignez notre équipe !</p>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
    }

    .full-page-image {
        background-image: url({{ asset('image/fd5.jpg') }});
        background-size: cover;
        background-position: center;
        width: 100%;
        height: 100%;
    }
</style>
