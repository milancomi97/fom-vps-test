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
        .col-width{
            width: 100px;
        }

    </style>
@endsection

@section('content')

    <h1 class="text-center mt-5">Izmena Fiksnih plaćanja:</h1>

    <div class="container">

        <div class="container mt-5">
{{--            <div class="container text-center">--}}
{{--                <button data-record-id="{{$mesecnaTabelaPoentaza->id}}"  class="btn btn-primary btn-lg text-center submitBtn">Sačuvaj izmene</button>--}}
{{--            </div>--}}
            <!-- Left Column - Form -->
            <div class="col-md-12 text-center mt-5 mb-5"  id="form-column">
                <h1> {{$mesecnaTabelaPoentaza->maticni_broj}}
                    {{$mesecnaTabelaPoentaza->prezime}}
                    {{$mesecnaTabelaPoentaza->ime}}
                </h1>
            </div>
            <table class="table table-bordered" id="editableTable">
                <thead>
                <tr>
                    <th>Šifra vrste plaćanja</th>
                    <th>Naziv vrste plaćanja</th>
                    <th>Sati</th>
                    <th>Iznos</th>
                    <th>Procenat</th>
                    <th>RJ</th>
                    <th>Brigada</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div>

            </div>
        </div>
        <div class="container mb-5 mt-5 text-center">
            <button data-record-id="{{$mesecnaTabelaPoentaza->id}}"  class="btn btn-primary btn-lg text-center submitBtn" >Sačuvaj izmene</button>
        </div>
    </div>



@endsection

@section('custom-scripts')
    <script>
        var vrstePlacanja = {!! $vrstePlacanja !!};
        var vrstePlacanjaData = {!! $vrstePlacanjaData !!};
        var storeAllRoute = '{!! route('datotekaobracunskihkoeficijenata.update_fiksnap') !!}';
        var deleteVrstaPlacanjaData = '{!! route('datotekaobracunskihkoeficijenata.delete_fiksnap') !!}';

    </script>

    <script src="{{ asset('modules/obracunzarada/datotekaobracunskihkoef_show_fiksnap/ajax_logic.js') }}"></script>
@endsection
