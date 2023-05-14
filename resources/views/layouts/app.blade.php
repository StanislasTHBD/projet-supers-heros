<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">

    <title>@yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body>
@include('layouts.nav')
@include('layouts.notify')

<div class="container" style="margin-top: 80px;">
    @yield('content')
</div>


</body>
</html>
