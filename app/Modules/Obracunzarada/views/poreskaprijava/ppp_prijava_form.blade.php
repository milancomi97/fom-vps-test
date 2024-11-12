<?php use App\Modules\Obracunzarada\Consts\UserRoles; ?>

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <style>
        .custom_border{
            border-right: silver solid 5px;
        }
    </style>

@endsection

@section('content')
    <div class="container mt-5 mb-5 ">
        <div class="row">
            <div class="col-md-8 border p-5">
        <h2 class="mt-5 mb-5 text-center">Poreska prijava</h2>
        <form method="POST" action="{{ route('arhiva.pppPrijava') }}">
            @csrf
            <div class="form-group">
                <label for="datum_nastanka">Datum Nastanka</label>
                <input type="date" class="form-control" id="datum_nastanka" name="datum_nastanka">
            </div>
            <div class="form-group">
                <label for="datum_placanja">Datum Placanja</label>
                <input type="date" class="form-control" id="datum_placanja" name="datum_placanja">
            </div>
            <div class="form-group">
                <label for="preduzece_budzet">Tip</label>
                <select class="form-select form-control" id="preduzece_budzet" name="preduzece_budzet" aria-label="Select example">
                    <option value="1">Preduzeće</option>
                    <option value="2">Budžet</option>
                </select>
            </div>


            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="obracunski_period_month">Obracunski Period (Mesec)</label>
                    <input type="number" class="form-control" id="obracunski_period_month" name="obracunski_period_month" >
                </div>
                <div class="form-group  offset-md-2 col-md-5">
                    <label for="obracunski_period_year">Obracunski Period (Godina)</label>
                    <input type="number" class="form-control" id="obracunski_period_year" name="obracunski_period_year" >
                </div>
            </div>
            <div class="form-check mb-3">
                <div class="col-md-5">
                    <input class="form-check-input form-control" checked type="checkbox" value="K" name="konacno" id="konacno">
                    <label for="konacno" class="mt-2">
                        Konacno:
                    </label>
                </div>
            </div>
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-primary poreska-prijava">Prikaz</button>
            </div>

        </form>
            </div>
        </div>
    </div>
@endsection

@section('custom-scripts')
    <script>


    </script>
@endsection
