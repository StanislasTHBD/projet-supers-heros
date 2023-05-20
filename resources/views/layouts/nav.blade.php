<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('welcome') }}">Le Site du Héros</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('declarations.index') }}">Déclarations</a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('heros.index') }}">Héros</a>
                </li>
                @endauth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('incidents.index') }}">Incidents</a>
                </li>
            </ul>
            <ul class="navbar-nav me-2">
                @guest
                    <li class="nav-item">
                        <a class="nav-link btn" href="{{ route('login') }}">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn" href="{{ route('register') }}">Inscription</a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link btn">Déconnexion</button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
