@php use App\Modules\Obracunzarada\Consts\StatusRadnikaObracunskiKoef; @endphp
@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"/>

    <style>
        .new-vrste-placanja{
            width: 250px;
        }

        .nov-naziv{
            width: 250px;
        }
    </style>
@endsection

@section('content')


    <div class="container">
        <div class="container mt-5">
            <!-- Left Column - Form -->
            <div class="col-md-12" id="form-column">
                <h1>Milan Dimitrijevic (dodaj podatke o radniku)</h1>
            </div>
            <table class="table table-bordered" id="editableTable">
                <thead>
                <tr>
                    <th>Sifra vrste placanja</th>
                    <th>Naziv vrste placanja</th>
                    <th>Sati</th>
                    <th>Unos</th>
                    <th>Procenat</th>
                    <th>RJ</th>
                    <th>Brigada</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>


@endsection

@section('custom-scripts')
    <script>
        var vrstePlacanjaData = {!! $vrstePlacanja !!}
    </script>

    <script src="{{ asset('modules/obracunzarada/datotekaobracunskihkoef_show/ajax_logic.js') }}"></script>
@endsection
