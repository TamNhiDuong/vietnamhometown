<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Vietnam - Hometown') }}</title>
    <!-- Styles -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://gmaps-marker-clusterer.github.io/gmaps-marker-clusterer/assets/css/docs.min.css" rel="stylesheet">
    <link href="https://gmaps-marker-clusterer.github.io/gmaps-marker-clusterer/assets/css/style.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.3.0/bootbox.min.js"></script>
    <script src="https://gmaps-marker-clusterer.github.io/gmaps-marker-clusterer/assets/js/docs.min.js"></script>
</head>
<body>
<div >
    @yield('content')
</div>
</body>
<style>
    .mapboxgl-popup {
        max-width: 400px;
        font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
    }
</style>
@yield('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.4.11/d3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/trianglify/0.1.2/trianglify.min.js"></script>
</html>
