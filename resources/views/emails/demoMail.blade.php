<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Fom app') }} </title>
</head>
<body>
<h1>Goša Fom ad</h1>
<img src="{{url(asset('images/company/100_godina_postojanja.jpg'))}}" alt="Descriptive text" width="auto" height="auto">
</body>
</html>
