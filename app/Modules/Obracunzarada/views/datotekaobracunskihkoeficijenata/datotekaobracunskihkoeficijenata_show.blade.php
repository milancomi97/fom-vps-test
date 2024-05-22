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


    <div class="container-fluid">
        <div class="col-md-12 text-center mt-5"  id="form-column">
            <h1>Unos poentaže: {{$mesecnaTabelaPoentaza->maticni_broj}}
                {{$mesecnaTabelaPoentaza->prezime}}
                {{$mesecnaTabelaPoentaza->ime}}
            </h1>
        </div>
        <div class="row">
            <div class="col-sm-1">
            </div>
            <div class="col-sm-6 mt-5">
                <div class="form-row border-bottom">
                    <div class="form-group col-md-2 "> <!-- Change col-md-6 to your desired width -->
                        <label for="PREB_prebacaj">Prebačaj</label>
                        <input type="number" value="{{$mdrData['PREB_prebacaj']}}" name="PREB_prebacaj" min="0"  class="form-control" data-mdr-id="{{$mdrData['id']}}"  id="PREB_prebacaj">
                    </div>
                    <div class="form-group col-md-2"> <!-- Change col-md-6 to your desired width -->
                        <label for="DANI_kalendarski_dani">Kalendarski dani</label>

                        <input type="number" value="{{$mdrData['DANI_kalendarski_dani']}}" name="DANI_kalendarski_dani"  min="0"  class="form-control" data-mdr-id="{{$mdrData['id']}}" id="DANI_kalendarski_dani">
                    </div>

                </div>
                {{--                <h1 class="text-center mt-5"> Unos poentaže:</h1>--}}

                <div class="mt-5">
                    <!-- Left Column - Form -->

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
            <div class="col-sm-1">
            </div>
            <div class="col-sm-3 mt-5 text-center">

                <h2 class="text-center">Podaci poentera:</h2>
                 <table class="table table-bordered" id="secondEditableTable">
                    <thead>
                    <tr>
                        <th>Sifra</th>
                        <th>Naziv</th>
                        <th>Sati</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($poenterVrstePlacanja as $vrstaPlacanja)
                       @if($vrstaPlacanja['sati']!=0)
                        <tr>
                            <td>{{$vrstaPlacanja['key']}}</td>
                            <td>{{$vrstaPlacanja['name']}}</td>
                            <td>{{$vrstaPlacanja['sati']}}</td>
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                <a class="btn btn-success mt-3 btn-lg" href="{!! url('obracunzarada/datotekaobracunskihkoeficijenata/odobravanje?month_id=')!!}{{$mesecnaTabelaPoentaza->obracunski_koef_id}}">Forma Poentera</a>


            </div>
        </div>


    </div>


@endsection

@section('custom-scripts')
    <script>
        var vrstePlacanja = {!! $vrstePlacanja !!};
        var vrstePlacanjaData = {!! $vrstePlacanjaData !!};
        var storeAllRoute = '{!! route('datotekaobracunskihkoeficijenata.updateVariabilna') !!}';
        var deleteVrstaPlacanjaData = '{!! route('datotekaobracunskihkoeficijenata.deleteVariabilna') !!}';

    </script>

    <script src="{{ asset('modules/obracunzarada/datotekaobracunskihkoef_show/ajax_logic.js') }}"></script>
@endsection
