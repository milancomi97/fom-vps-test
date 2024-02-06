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

    <div class="container mb-5">
        <h1  class="text-center mt-5" >{{$mesecnaTabelaPoentaza->maticni_broj .' ' .$mesecnaTabelaPoentaza->prezime  . ' ' . $mesecnaTabelaPoentaza->ime }}</h1>
        <form method="post" action="{{ route('datotekaobracunskihkoeficijenata.update_akontacije') }}">
            @csrf

            <div class="form-group mt-5 mb-5">
                <label for="vrednost_akontacije">Vrednost akontacije:</label>
                <input type="number" name="vrednost_akontacije" class="form-control" id="vrednost_akontacije" value="{{$vrednostAkontacije['iznos']}}">
                <input type="hidden" name="mesecna_tabela_poentaza_id" value="{{$mesecna_tabela_poentaza_id}}">
            </div>
            <div class="text-center">

            <button type="submit" class="btn btn-primary btn-lg mb-5">Izmeni</button>

            </div>
        </form>
    </div>


@endsection

@section('custom-scripts')
    <script>
    </script>
@endsection
