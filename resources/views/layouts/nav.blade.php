<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('welcome') }}">Le Site du Héros</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('declarations.index') }}">Déclarations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('heros.index') }}">Héros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('incidents.index') }}">Incidents</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
