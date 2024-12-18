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
    <div class="container mt-5 mb-5">
        <h1 class="text-center text-primary">Provera PPP</h1>
        <div class="row mt-5 shadow mb-5">
            <!-- Left column for additional data -->
            <div class="col-lg-3 custom_border">
                <h3>Dodatni podaci</h3>
                <p></p>
                <!-- Additional data fields can be added here as needed -->
            </div>

            <!-- Right column for XML preview and download -->
            <div class="col-lg-9 mx-auto ">
                <div class="text-center">
                    <form action="{{ route('arhiva.pppPrijavaDownload') }}" method="POST" class="d-flex justify-content-center">
                      @csrf
                        <input type="hidden" name="datum_nastanka" value="{{$fileInputs['datum_nastanka']}}">
                        <input type="hidden" name="datum_placanja" value="{{$fileInputs['datum_placanja']}}">
                        <input type="hidden" name="preduzece_budzet" value="{{$fileInputs['preduzece_budzet']}}">
                        <input type="hidden" name="obracunski_period_month" value="{{$fileInputs['obracunski_period_month']}}">
                        <input type="hidden" name="obracunski_period_year" value="{{$fileInputs['obracunski_period_year']}}">
                        <input type="hidden" name="konacno" value="{{$fileInputs['konacno']}}">
                        <input type="hidden" name="maticniBroj" value="{{$fileInputs['maticniBroj']}}">
                        <button type="submit" class="btn btn-success mt-3">Preuzmi fajl</button>
                    </form>
                </div>

                <h3 class="mt-3">XML Preview</h3>
                <pre class="text-start">{{ $xmlContent }}</pre>
            </div>
        </div>
    </div>
@endsection

@section('custom-scripts')
@endsection
