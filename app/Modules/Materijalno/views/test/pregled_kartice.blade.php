<!-- resources/views/stanje-zaliha/index.blade.php -->

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <style>

    </style>
@endsection

@section('content')
    <div class="container">
        @include('materijalno::vertical_nav_magacin')

        <h2>Pregled Kartice - Dokument: {{ $idbr }}</h2>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Šifra Dokumenta</th>
                <th>ID Broj</th>
                <th>Materijal</th>
                <th>Količina</th>
                <th>Vrednost</th>
                <th>Magacin</th>
                <th>Datum Knjiženja</th>
            </tr>
            </thead>
            <tbody>
            @foreach($kartice as $kartica)
                <tr>
                    <td>{{ $kartica->sd }}</td>
                    <td>{{ $kartica->idbr }}</td>
                    <td>{{ $kartica->materijal->naziv_materijala ?? 'N/A' }}</td>
                    <td>{{ $kartica->kolicina }}</td>
                    <td>{{ $kartica->vrednost }}</td>
                    <td>{{ $kartica->magacin->naziv ?? 'N/A' }}</td>
                    <td>{{ $kartica->datum_k }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('custom-scripts')

@endsection
