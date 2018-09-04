<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>桂林旅游行业</title>

    <script>
        window.laravel = {!! json_encode($laravel) !!};
    </script>
    <!-- Styles -->
    <link href="{{ mix('cly_admin/css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app"></div>

<!-- Scripts -->
<script src="{{ mix("cly_admin/js/index/app.js") }}"></script>
</body>
</html>