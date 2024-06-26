<?php use App\Modules\Obracunzarada\Consts\UserRoles; ?>

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tempus Dominus CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tempusdominus-bootstrap-4@5.39.0/build/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

    <style>
        .form-container {
            /*max-width: 600px;*/
            /*margin: 200px auto;*/
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            margin-bottom: 30px;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="content" >
            <h1 class="text-center mt-5">Ukupna rekapitulacija za:<b>{{$archiveDate}}</b></h1>
        </div>
        <div class="container-lg">
            <div class="row mb-5 ">

            </div>
        </div>
        <!-- /.content-wrapper -->
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">

                <div class="container mt-4">
                    <div class="row mb-3 form-container">
                        <div class="col-sm-4 mb-5 mt-5">
                            <div class="">
                                <form method="GET" action="{{route('arhiva.mesec')}}">
                                    @csrf
                                    <div class="form-group" class="text-center" style="margin-bottom: 10px">
                                        <div class="input-group date datetimepicker-icon" id="datetimepicker" data-target-input="nearest">
                                            <input type="text" id="arhiva_datum_mesec" placeholder="Datum pregleda" name="arhiva_datum_mesec" class="form-control datetimepicker-input" data-target="#datetimepicker" />
                                            <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-secondary btn-lg btn-block ukupna_rekapitulacija">Nov pregled</button>
                                </form>
                            </div>

                        </div>
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2 text-right">

                            <form method="POST" class="d-inline" action="{{route('datotekaobracunskihkoeficijenata.stampa_ostvarene_zarade')}}">
                                @csrf
{{--                                <input type="hidden" name="month_id" value="--}}{{--{{$month_id}}--}}{{--">--}}
                                <button type="submit" class="btn mt-5 btn-secondary btn-lg" style="width: 200px; visibility: hidden" id="print-page">PDF &nbsp;&nbsp;<i class="fa fa-print " aria-hidden="true"></i></button>

                                <button type="submit" class="btn btn-secondary btn-lg" style="width: 200px" id="print-page">PDF &nbsp;&nbsp;<i class="fa fa-print " aria-hidden="true"></i></button>
                            </form>
                        </div>
                        <div class="col-sm-2"></div>

                        <div class="col col-sm-3 mt-5 text-right">
                            <form method="POST" class="" action="{{route('datotekaobracunskihkoeficijenata.email_ostvarene_zarade')}}">
                                @csrf
                                <div class="input-group">
                                    <label>
                                        <input type="email" class="form-control mt-2" style="width: 200px" name="email_to" placeholder="Email primaoca">
                                    </label>
                                    <button type="submit" class="btn btn-secondary btn-lg" style="width: 200px" id="print-page">Pošalji email &nbsp;&nbsp;<i class="fa fa-envelope " aria-hidden="true"></i></button>
{{--                                    <input type="hidden" name="month_id" value="{{/*$month_id*/}}">--}}

                                </div>

                            </form>
                        </div>

                    </div>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th onclick="sortTable(0)">VP</th>
                            <th onclick="sortTable(1)">Naziv vrste placanja</th>
                            <th onclick="sortTable(2)">Sati</th>
                            <th onclick="sortTable(3)">Iznos</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $ukupanPrihod=0;
                        ?>
{{--                        @foreach($dkopData as $vrstaPlacanja)--}}

{{--                            @if($vrstePlacanjaSifarnik[$vrstaPlacanja->sifra_vrste_placanja]['KESC_prihod_rashod_tip']=='P')--}}
{{--                                <tr>--}}
{{--                                    <td>{{$vrstaPlacanja->sifra_vrste_placanja}}</td>--}}
{{--                                    <td>{{$vrstaPlacanja->naziv_vrste_placanja}}</td>--}}
{{--                                    <td>{{number_format($vrstaPlacanja->sati)}}</td>--}}
{{--                                    <td>{{number_format($vrstaPlacanja->iznos, 2, '.', ',')}}</td>--}}
{{--                                </tr>--}}
{{--                                    <?php--}}
{{--                                    $ukupanPrihod+=$vrstaPlacanja->iznos;--}}
{{--                                    ?>--}}
{{--                            @endif--}}


{{--                        @endforeach--}}
                        <tr style="border-top:2px solid black">
                            <td></td>
                            <td></td>
                            <td><b>Bruto zarada:</b></td>
{{--                            <td><b>{{number_format($ukupanPrihod, 2, '.', ',')}}</b></td>--}}
                        </tr>

                        <?php
                        $ukupniPorezi=0;
                        ?>
{{--                        @foreach($dkopData as $vrstaPlacanja)--}}

{{--                            @if($vrstePlacanjaSifarnik[$vrstaPlacanja->sifra_vrste_placanja]['KESC_prihod_rashod_tip']=='R' &&$vrstePlacanjaSifarnik[$vrstaPlacanja->sifra_vrste_placanja]['SLOV_grupe_vrsta_placanja']=='P')--}}
{{--                                <tr>--}}
{{--                                    <td>{{$vrstaPlacanja->sifra_vrste_placanja}}</td>--}}
{{--                                    <td>{{$vrstaPlacanja->naziv_vrste_placanja}}</td>--}}
{{--                                    <td>{{number_format($vrstaPlacanja->sati)}}</td>--}}
{{--                                    <td>{{number_format($vrstaPlacanja->iznos, 2, '.', ',')}}</td>--}}
{{--                                    <?php--}}
{{--                                    $ukupniPorezi+=$vrstaPlacanja->iznos;--}}
{{--                                    ?>--}}
{{--                            @endif--}}


{{--                        @endforeach--}}
                        <tr style="border-top:2px solid black">
                            <td></td>
                            <td></td>
                            <td><b>Ukupni porezi:</b></td>
{{--                            <td><b>{{number_format($ukupniPorezi, 2, '.', ',')}}</b></td>--}}
                        </tr>

                        <?php
                        $ukupniRashod=0;
                        ?>

{{--                        @foreach($dkopData as $vrstaPlacanja)--}}

{{--                            @if($vrstePlacanjaSifarnik[$vrstaPlacanja->sifra_vrste_placanja]['KESC_prihod_rashod_tip']=='R'  &&$vrstePlacanjaSifarnik[$vrstaPlacanja->sifra_vrste_placanja]['SLOV_grupe_vrsta_placanja']!=='P')--}}
{{--                                <tr>--}}
{{--                                    <td>{{$vrstaPlacanja->sifra_vrste_placanja}}</td>--}}
{{--                                    <td>{{$vrstaPlacanja->naziv_vrste_placanja}}</td>--}}
{{--                                    <td>{{number_format($vrstaPlacanja->sati)}}</td>--}}
{{--                                    <td>{{number_format($vrstaPlacanja->iznos, 2, '.', ',')}}</td>--}}
{{--                                    <?php--}}
{{--                                    $ukupniRashod+=$vrstaPlacanja->iznos;--}}
{{--                                    ?>--}}
{{--                            @endif--}}

{{--                        @endforeach--}}
                        <tr style="border-top:2px solid black">
                            <td></td>
                            <td></td>
                            <td><b>Ukupne obustave:</b></td>
                            <td><b>{{number_format($ukupniRashod, 2, '.', ',')}}</b></td>
                        </tr>

                        {{--                        @foreach($dkopData as $vrstaPlacanja)--}}

                        {{--                            <tr>--}}
                        {{--                                <td>{{$vrstaPlacanja->sifra_vrste_placanja}}</td>--}}
                        {{--                                <td>{{$vrstaPlacanja->naziv_vrste_placanja}}</td>--}}
                        {{--                                <td>{{number_format($vrstaPlacanja->sati)}}</td>--}}
                        {{--                                <td>{{number_format($vrstaPlacanja->iznos, 2, '.', ',')}}</td>--}}


                        {{--                            </tr>--}}

                        {{--                        @endforeach--}}
                        </tbody>
                    </table>
                </div>


                <div class="container mt-5">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td >1. BRUTO ZARADA</td>
                            <td></td>
{{--                            <td>{{number_format($zaraData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade, 2, '.', ',')}}</td>--}}
                        </tr>
                        <tr>
                            <td >- IZNOS PORESKOG OSLOBODJENJA</td>
                            <td></td>
{{--                            <td>{{number_format($zaraData->POROSL_poresko_oslobodjenje, 2, '.', ',')}}</td>--}}
                        </tr>
                        <tr>
                            <td >- OPOREZIVI IZNOS ZARADE</td>
                            <td></td>
{{--                            <td>{{number_format($zaraData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade -$zaraData->POROSL_poresko_oslobodjenje, 2, '.', ',')}}</td>--}}
                        </tr>
                        <tr>
                            <td >2. NETO ZARADA (1-5)</td>
                            <td></td>
{{--                            <td>{{number_format($zaraData->NETO_neto_zarada , 2, '.', ',')}}</td>--}}
                        </tr>
                        <tr>
                            <td >3. UK. OBUSTAVE</td>
                            <td></td>
{{--                            <td>{{number_format($zaraData->SIOB_ukupni_iznos_obustava +  $zaraData->ZARKR_ukupni_zbir_kredita, 2, '.', ',')}}</td>--}}
                        </tr>
                        <tr>
                            <td >4. ZA ISPLATU (1-5-3)</td>
                            <td></td>
{{--                            <td>{{number_format($zaraData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade -  $zaraData->SIP_ukupni_iznos_poreza - $zaraData->SID_ukupni_iznos_doprinosa - $zaraData->SIOB_ukupni_iznos_obustava - $zaraData->ZARKR_ukupni_zbir_kredita, 2, '.', ',')}}</td>--}}
                        </tr>
                        <tr>
                            <td >UKUPNI DOPRINOSI</td>
                            <td></td>
{{--                            <td>{{number_format($zaraData->SID_ukupni_iznos_doprinosa, 2, '.', ',')}}</td>--}}
                        </tr>
                        <tr>
                            <td>050 POREZ (10%)</td>
                            <td></td>
{{--                            <td>{{number_format($zaraData->SIP_ukupni_iznos_poreza, 2, '.', ',')}}</td>--}}
                        </tr>
                        <tr>
                            <td >5. UKUPNI POREZI I DOPRINOSI (a+b)</td>
                            <td></td>
{{--                            <td>{{number_format($zaraData->SIP_ukupni_iznos_poreza + $zaraData->SID_ukupni_iznos_doprinosa, 2, '.', ',')}}</td>--}}
                        </tr>

                        <tr>
                            <td >6. OBAVEZE NA TERET POSLODAVCA: </td>
                            <td></td>
                            <td></td>

                        </tr>
                        <tr>
                            <td >Zdravstveno osiguranje (p)</td>
                            <td></td>
{{--                            <td>{{number_format($zaraData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</td>--}}
                        </tr>
                        <tr>
                            <td >Penzijsko-invalidsko osig. (p)</td>
                            <td></td>
{{--                            <td>{{number_format($zaraData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</td>--}}
                        </tr>
                        <tr>
                            <td >Ukupni doprinosi</td>
                            <td></td>
{{--                            <td>{{number_format($zaraData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca + $zaraData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</td>--}}
                        </tr>
                        <tr>
                            <td >7. UKUPNA BRUTO ZARADA:</td>
                            <td></td>
{{--                            <td>{{number_format($zaraData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade +$zaraData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca + $zaraData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</td>--}}

                        </tr>
                        <tr>
                            <td >12. BROJ AKTIVNIH RADNIKA:</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td >13. BROJ RADNIKA SA ZARADOM:</td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- /.content-wrapper -->
    </div>
    <?php
    $userData=Auth::user()->load(['permission']);
    $permissions = $userData->permission;
    ?>
    @if($permissions['role_id']==UserRoles::PROGRAMER)
        <h1 class="text-center">Progamerski deo:</h1>
        <h2 class="text-center">Prikaz tabele SUME</h2>
        <div class="table-container mb-5">
            <table class="table table-striped">
                <thead>
                <tr>
                    @if($zaraData->isNotEmpty())
                        @foreach(array_keys($zaraData->first()->getAttributes()) as $column)
                            <th>{{ $column }}</th>
                        @endforeach
                    @else
                        <h1 class="text-center mt-5">Podaci za unete parametre ne postoje</h1>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($zaraData as $zar)
                    <tr>
                        @foreach($zar->getAttributes() as $value)
                            <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection



@section('custom-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- Tempus Dominus JS -->
    <script src="https://cdn.jsdelivr.net/npm/tempusdominus-bootstrap-4@5.39.0/build/js/tempusdominus-bootstrap-4.min.js"></script>
     <script>






         $(function () {
             $('.datetimepicker-icon').datetimepicker({
                 format: 'MM.YYYY'
             });
         });

         $(document).ready(function () {
             $('#datetimepicker1').datetimepicker({
                 format: 'MM.YYYY'
             });

             $('#datetimepicker2').datetimepicker({
                 format: 'MM.YYYY'
             });


         });
             $(document).on('click', 'body .ukupna_rekapitulacija', function (e) {
            var maticniBroj = $('#maticni_broj_mesec').val();
            var datum = $('#arhiva_datum_mesec').val();

            if(datum !=='') {
                // Construct the URL with query parameters
                window.location.href ='{{ route('arhiva.ukupnaRekapitulacija') }}' +
                    '?datum=' + encodeURIComponent(datum);

                // Redirect to the constructed URL
            }
        });

    </script>
@endsection

