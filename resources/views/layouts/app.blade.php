<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="utf-8">

    <title>@yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>


<body>
@include('layouts.nav')
@include('layouts.notify')

<div class="container" style="margin-top: 80px;">
    @yield('content')
</div>


</body>
</html>
