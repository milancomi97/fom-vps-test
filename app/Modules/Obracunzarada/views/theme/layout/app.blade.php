<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Fom cloud app</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->

    <link rel="stylesheet" href="{{asset('admin_assets/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('admin_assets/dist/css/adminlte.min.css')}}">
    @yield('custom-styles')
</head>
<style>
    html {
        zoom: 83% !important;
    }
</style>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
    @include('obracunzarada::theme.layout.header')
    @include('firstmodule::adminlte.layout.sidebar')
    @yield('content')
    @include('obracunzarada::theme.layout.footer')


</div>
<script>

</script>
</body>
</html>
