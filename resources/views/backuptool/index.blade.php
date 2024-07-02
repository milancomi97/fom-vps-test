<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gosa FOM</title>

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
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4 mt-5">Proces povratka starih podataka</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">

    <form action="{{ route('backup.import') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="file">Izaberite backup:</label>
            <select name="file" id="file" class="form-control">
                @foreach ($files as $file)
                    <option value="{{ $file }}">{{ $file }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Vrati podatke</button>
    </form>
    </div>
    </div>
</div>
</body>
</html>
