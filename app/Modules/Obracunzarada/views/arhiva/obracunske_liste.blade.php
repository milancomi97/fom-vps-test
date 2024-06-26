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
        .select2-selection__rendered {
            line-height:14px !important;
        }
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
        .table-container {
            width: 130%; /* Set your desired width */
            overflow-x: auto; /* Enable horizontal scrollbar */
        }
        .border-custom {
            border-style: dashed !important;
            border-width: 3px !important;
            border-color: black !important;
        }

        .border-bottom-custom {
            border-bottom-style: dashed !important;
            border-bottom-width: 3px !important;
            border-bottom-color: black !important;
        }

        .border-top-custom {
            border-top-style: dashed !important;
            border-top-width: 3px !important;
            border-top-color: black !important;
        }

        .header-custom {
            letter-spacing: 3px;
        }

        .border-left-disabled {
            border-left-width: 0 !important;
        }

        /*body {*/
        /*    font-family: 'Arial', sans-serif;*/
        /*    font-size: 12px;*/
        /*    line-height: 1.5;*/
        /*}*/
        .section {
            margin-bottom: 10px;
        }

        .strong {
            font-weight: bold;
        }

        .header {
            font-weight: bold;
            text-decoration: underline;
        }

        h1 {
            font-size: 1.3rem
        }

        h2 {
            font-size: 1.6rem
        }
    </style>
@endsection

@section('content')
    <div class="container-lg">
        <div class="content" >
            <h1 class="text-center mt-5">Obracunska lista za:<b>{{$datum}} </b></h1>
        </div>
    </div>
    <div class="container mb-5 mt-5">
        <div class="row form-container">

            <div class="col-sm-4 mt-5">
                <div class="">
                    <form method="GET" action="{{route('arhiva.mesec')}}">
                        @csrf
                        <div class="form-group">
                            <div class="input-group" data-target-input="nearest">
                                <select class="form-control custom-select maticni_broj_mesec" id="maticni_broj_mesec" name="maticni_broj_mesec"
                                        aria-describedby="maticni_broj_mesec">
                                </select>
                            </div>
                        </div>
                        <div class="form-group" >
                            <div class="input-group date datetimepicker-icon" id="datetimepicker" data-target-input="nearest">
                                <input type="text" id="arhiva_datum_mesec" name="arhiva_datum_mesec" class="form-control datetimepicker-input" data-target="#datetimepicker" />
                                <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary btn-block obracunske_liste">Nov pregled</button>
                    </form>
                </div>

            </div>

            <div class="col col-lg-1 text-right">
            </div>
            <div class="col col-lg-2 text-right">
                <form method="POST" class="" action="{{route('datotekaobracunskihkoeficijenata.stampa_radnik_lista')}}">
                    @csrf
{{--                    <input type="hidden" name="radnik_maticni" value="{{$radnik_maticni}}">--}}
{{--                    <input type="hidden" name="month_id" value="{{$month_id}}">--}}
                    <button type="submit" class="btn mt-5 btn-secondary btn-lg" id="print-page">PDF &nbsp;&nbsp;<i
                            class="fa fa-print fa-2xl " aria-hidden="true"></i></button>
                </form>
            </div>
            <div class="col col-lg-2 text-right">
            </div>
            <div class="col col-lg-3 text-right">
                <form method="POST" class="" action="{{route('datotekaobracunskihkoeficijenata.email_radnik_lista')}}">
                    @csrf
                    <div class="input-group">
                        <button type="submit" class="btn mt-5 btn-secondary btn-lg" style="width: 200px"
                                id="print-page">Pošalji email &nbsp;&nbsp;<i class="fa fa-envelope fa-2xl "
                                                                             aria-hidden="true"></i></button>
{{--                        <input type="hidden" name="radnik_maticni" value="{{$radnik_maticni}}">--}}
{{--                        <input type="hidden" name="month_id" value="{{$month_id}}">--}}
                        <label>
                            <input type="email" class="form-control mt-2" style="width: 200px" name="email_to"
                                   placeholder="Email primaoca">
                        </label>
                    </div>

                </form>
            </div>
        </div>
        <div class="row mb-5 mt-5 border">

                        </div>
            <div class="col-md-12 text-right">
                <h3>{{$datumStampe}}</h3>
            </div>

            <div class="col-md-12 text-left mb-5">

                <div class="section">

{{--                    <span class="strong">{{$podaciFirme['skraceni_naziv_firme']}}</span><br>--}}
{{--                    {{$podaciFirme['adresa_za_prijem_poste']}}<br>--}}
{{--                    PIB: {{$podaciFirme['pib']}}<br>--}}
{{--                    Banke: {{$podaciFirme['racuni_u_bankama']}}<br>--}}
{{--                    Maticni broj: {{$podaciFirme['maticni_broj']}}--}}

                </div>

                <div class="section header">
                    OBRACUN ZARADE I NAKNADA ZARADE
                </div>

            </div>

            <div class="col-md-6 pl-3">
                <div class="section ">
                    ZA MESEC: {{$datum}}<br>
                    TROSKOVNI
                    CENTAR: {{$troskovnoMesto['sifra_troskovnog_mesta']}} {{ $troskovnoMesto['naziv_troskovnog_mesta']}}
                    <br>
                    <b> {{$mdrData['MBRD_maticni_broj']}}</b> - {{$userData['prezime']}}  {{$userData['srednje_ime']}}
                    . {{$userData['ime']}}<br>
                    {{$mdrData['adresa_mesto']}} <br>
                    {{$mdrData['adresa_ulica_broj']}} <br>
                    {{$mdrPreparedData['RBIM_isplatno_mesto_id']}} tekuci racun: {{$mdrData['ZRAC_tekuci_racun']}}<br>
                    Datum
                    dospelosti: {{\Carbon\Carbon::createFromFormat('Y-m-d', $podaciMesec['period_isplate_do'])->format('d.m.Y')}}
                    <br>
                </div>
            </div>
            <div class="col-md-6">

                <div class="section">
                    Strucna sprema: {{$mdrPreparedData['RBPS_priznata_strucna_sprema']}}<br>
                    Radno mesto: {{$mdrPreparedData['RBRM_radno_mesto']}}<br>
                </div>

                <div class="section">
                    Staz kod poslodavca: {{$mdrData['GGST_godine_staza']}} god {{$mdrData['MMST_meseci_staza']}} m<br>
                    Osnovna bruto zarada: {{$mdrData['KOEF_osnovna_zarada']}}<br>
                    Prosecna bruto
                    zarada/cas: {{  number_format($mdrData['PRIZ_ukupan_bruto_iznos']/$mdrData['PRCAS_ukupni_sati_za_ukupan_bruto_iznost'], 2, '.', ',')}}
                    <br>
                </div>
            </div>
        <div class="row">
            <div class="col-lg-8 p-3 border border-custom">
                <h1 class="text-left header-custom">VP: Naziv vrste placanja</h1>
            </div>
            <div class="col-lg-2 p-3 border-left-disabled border border-custom">
                <h1 class="text-center header-custom">Sati</h1>
            </div>
            <div class="col-lg-2 p-3 border-left-disabled border border-custom">
                <h1 class="text-center header-custom">Iznos</h1>
            </div>
        </div>
        @foreach($radnikData as $radnik)

            @if($radnik['KESC_prihod_rashod_tip']=='P')
                <div class="row">
                    <div class="col-lg-8 p-2 ">
                        <h2 class="text-left header-custom">{{$radnik['sifra_vrste_placanja']}} {{$radnik['naziv_vrste_placanja']}}</h2>
                    </div>
                    <div class="col-lg-2 p-2 ">
                        <h2 class="text-center header-custom">{{($radnik['sati'] !== null  && $radnik['procenat'] == null) ?  $radnik['sati'] : null}} {{($radnik['procenat'] !== null && $radnik['procenat'] >0 ) ?  $radnik['procenat'] .'%' : null}}</h2>
                    </div>
                    <div class="col-lg-2 p-2 ">
                        <h2 class="text-right header-custom">{{ $radnik['iznos'] !== null  ? number_format($radnik['iznos'], 2, '.', ',') : 0}} </h2>
                    </div>
                </div>
            @endif
        @endforeach


        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-top border-top-custom border-bottom-custom">
                <h1 class="text-left header-custom">1. BRUTO ZARADA :</h1>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-top border-top-custom border-bottom-custom">
{{--                <h2 class="text-center header-custom">{{$zarData->UKSA_ukupni_sati_za_isplatu}}</h2>--}}
            </div>
            <div class="col-lg-2 p-3 border-bottom border-top border-top-custom border-bottom-custom">
{{--                <h2 class="text-right header-custom">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade, 2, '.', ',')}}</h2>--}}
            </div>
        </div>


        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom"><b>-</b> IZNOS PORESKOG OSLOBODJENJA :</h2>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-custom">
{{--                <h2 class="text-right header-custom">{{ number_format($zarData->POROSL_poresko_oslobodjenje, 2, '.', ',')}}</h2>--}}
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom"><b>-</b> Oporezivi iznos zarade :</h2>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-custom">
{{--                <h2 class="text-right header-custom">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade-$zarData->POROSL_poresko_oslobodjenje, 2, '.', ',')}}</h2>--}}
            </div>
        </div>


        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h1 class="text-left header-custom">2. NETO ZARADA (1 - 5) :</h1>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom"></h2>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">
{{--                <h2 class="text-right header-custom">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade - $zarData->SIP_ukupni_iznos_poreza - $zarData->SID_ukupni_iznos_doprinosa, 2, '.', ',')}}</h2>--}}
            </div>
        </div>


        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h1 class="text-left header-custom">061 PRIMLJENA AKONTACIJA</h1>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom">0,00</h2>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom">0,00</h2>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom">3. UK. OBUSTAVE :</h2>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-custom">
{{--                <h2 class="text-right header-custom">{{ number_format($zarData->SIOB_ukupni_iznos_obustava +$zarData->ZARKR_ukupni_zbir_kredita, 2, '.', ',')}}</h2>--}}
            </div>
        </div>


        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom">4. ZA ISPLATU (1 - 5 - 3 ) :</h2>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-custom">
{{--                <h2 class="text-right header-custom">{{ number_format($zarData->NETO_neto_zarada -$zarData->SIOB_ukupni_iznos_obustava - $zarData->ZARKR_ukupni_zbir_kredita, 2, '.', ',')}}</h2>--}}
            </div>
        </div>


        @foreach($radnikData as $radnik)

            @if($radnik['KESC_prihod_rashod_tip']=='R')
                <div class="row">
                    <div class="col-lg-8 p-2 ">
                        <h2 class="text-left header-custom">{{$radnik['sifra_vrste_placanja']}} {{$radnik['naziv_vrste_placanja']}}</h2>
                    </div>
                    <div class="col-lg-2 p-2 ">
                        <h2 class="text-right header-custom">{{$radnik['sati']  !== null  ? $radnik['sati'] : 0}}</h2>
                    </div>
                    <div class="col-lg-2 p-2 ">
                        <h2 class="text-right header-custom">{{ $radnik['iznos'] !== null  ? number_format($radnik['iznos'], 2, '.', ',') : 0}}  </h2>
                    </div>
                </div>
            @endif
        @endforeach

        <div class="row">
            <div class="col-lg-8 p-3  border-bottom border-top border-top-custom border-bottom-custom">
                <h1 class="text-left header-custom">UKUPNI DOPRINOSI</h1>
            </div>
            <div class="col-lg-2 p-3  border-bottom border-top border-top-custom border-bottom-custom">
                <h2 class="text-right header-custom">0,00</h2>
            </div>
            <div class="col-lg-2 p-3  border-bottom border-top border-top-custom border-bottom-custom">
                <h2 class="text-right header-custom">{{ number_format($zarData->SID_ukupni_iznos_doprinosa, 2, '.', ',')}}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h1 class="text-left header-custom">050 POREZ ( 10 % )</h1>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom">0,00</h2>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom">{{ number_format($zarData->SIP_ukupni_iznos_poreza, 2, '.', ',')}}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h1 class="text-left header-custom">5. UKUPNI POREZI I DOPRINOSI (a + b) :</h1>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom">0,00</h2>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom SIP_D">{{ number_format($zarData->SIP_ukupni_iznos_poreza + $zarData->SID_ukupni_iznos_doprinosa, 2, '.', ',')}} </h2>
            </div>
        </div>


        {{--        <div class="row">--}}
        {{--            <div class="col-lg-12 p-3 border-bottom border-bottom-custom">--}}
        {{--                <h1 class="text-left header-custom"> Dodati tabele bruto neto po koef</h1>--}}
        {{--            </div>--}}
        {{--            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">--}}
        {{--                <h2 class="text-right header-custom">0,00</h2>--}}
        {{--            </div>--}}
        {{--            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">--}}
        {{--                <h2 class="text-right header-custom">40.306,04</h2>--}}
        {{--            </div>--}}
        {{--        </div>--}}

        <div class="row">
            <div class="col-lg-12 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom">6. OBAVEZE NA TERET POSLODAVCA :</h2>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-8 p-2 ">
                <h2 class="text-left header-custom">Zdravstveno osiguranje (p)</h2>
            </div>
            <div class="col-lg-2 p-2 ">
                <h2 class="text-right header-custom">5.15%</h2>
            </div>
            <div class="col-lg-2 p-2 ">
                <h2 class="text-right header-custom">{{ number_format($zarData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-2 ">
                <h2 class="text-left header-custom">Penzijsko-invalidsko osig.(p)</h2>
            </div>
            <div class="col-lg-2 p-2 ">
                <h2 class="text-right header-custom">10.00%</h2>
            </div>
            <div class="col-lg-2 p-2 ">
                <h2 class="text-right header-custom">{{ number_format($zarData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-top border-top-custom border-bottom-custom">
                <h2 class="text-left header-custom"><b>-</b>Ukupni doprinosi</h2>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-top border-top-custom border-bottom-custom">
                <h2 class="text-right header-custom">{{ number_format($zarData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca +$zarData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom"><b>-</b>UKUPNA BRUTO ZARADA</h2>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom">
                    {{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade +$zarData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca +$zarData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, '.', ',')}}
                </h2>
            </div>
        </div>
    </div>

    @if(\App\Models\User::with('permission')->find(Auth::id())->permission->role_id ==UserRoles::PROGRAMER)
        <div class="container-lg">
            <h1 class="text-center">Progamerski deo:</h1>
            <h2 class="text-center">Prikaz tabele SUME</h2>
            <div class="table-container mb-5">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        @isset($zarData)
                            @foreach($zarData->toArray() as $column =>$values)
                                <th>{{ $column }}</th>
                            @endforeach

{{--                            <h1 class="text-center mt-5">Podaci za unete parametre ne postoje</h1>--}}
                        @endisset
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($zarData->toArray() as $zar =>$keys)

                                <td>{{ $keys }}</td>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <h2 class="text-center">Prikaz tabele DARH</h2>

            <div class="table-container mb-5">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        @if($dkopData->isNotEmpty())
                            @foreach(array_keys($dkopData->first()->getAttributes()) as $column)
                                <th>{{ $column }}</th>
                            @endforeach
                        @else
                            <h1 class="text-center mt-5">Podaci za unete parametre ne postoje</h1>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($dkopData as $dkop)
                        <tr>
                            @foreach($dkop->getAttributes() as $value)
                                <td>{{ $value }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- /.content-wrapper -->

        </div>
    @endif
@endsection



@section('custom-scripts')
    <script src="{{asset('admin_assets/plugins/select2/js/select2.full.min.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<!-- Tempus Dominus JS -->
<script src="https://cdn.jsdelivr.net/npm/tempusdominus-bootstrap-4@5.39.0/build/js/tempusdominus-bootstrap-4.min.js"></script>
<script>



    $(document).on('click', 'body .obracunske_liste', function (e) {
            // var id = $(this).data('month_id');
            // window.location.href = showRoute + id;
            var maticniBroj = $('#maticni_broj_mesec').val();
            var datum = $('#arhiva_datum_mesec').val();

            if(maticniBroj !=='' && datum !=='') {

                window.location.href = '{{ route('arhiva.obracunskeListe') }}' +
                    '?maticniBroj=' + encodeURIComponent(maticniBroj) +
                    '&datum=' + encodeURIComponent(datum);

                // Redirect to the constructed URL

            }
        });
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






        var data ={!! json_encode($radniciSelectData) !!};

        $(".maticni_broj_mesec").select2({
            data: data,
            // width: 'resolve'
        })

    });
    </script>
@endsection

