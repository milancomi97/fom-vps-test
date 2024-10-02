<!-- resources/views/stanje-zaliha/index.blade.php -->

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"/>
    <style>
        div.dataTables_length select{
            width: 40% !important;
            text-align: center !important;
        }

        .container-fluid{
            width: 80%!important;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="text-center">Pregled podataka</h1>

        <!-- Tabovi za različite entitete -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('materijali') ? 'active' : '' }}" href="{{ route('materijalno.materijali.index') }}">Materijali</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('stanje-materijala') ? 'active' : '' }}" href="{{ route('materijalno.stanje-materijala.index') }}">Stanje Materijala</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('kartice') ? 'active' : '' }}" href="{{ route('materijalno.kartice.index') }}">Kartice</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('porudzbine') ? 'active' : '' }}" href="{{ route('materijalno.porudzbine.index') }}">Porudžbine</a>
            </li>
        </ul>

    </div>
@endsection

@section('custom-scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    <script>
    </script>
@endsection
