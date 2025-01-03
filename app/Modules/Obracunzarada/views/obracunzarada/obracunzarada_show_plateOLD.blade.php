@php use App\Modules\Obracunzarada\Consts\UserRoles; @endphp
@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <style>
        .border-custom {
            border-style: dashed !important;
            border-width: 0px !important;
            border-color: black !important;
        }

        .border-bottom-custom {
            border-bottom-style: dashed !important;
            border-bottom-width: 0px !important;
            border-bottom-color: black !important;
        }

        .border-top-custom {
            border-top-style: dashed !important;
            border-top-width: 0px !important;
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
    <div class="container mb-5">
        <div class="row">
            <div class="col col-lg-4 text-left">
                <a href="{{route('datotekaobracunskihkoeficijenata.show_all_plate',['month_id'=>$zarData->obracunski_koef_id])}}"
                   class="btn btn-primary btn-lg mt-5 text-left">Lista &nbsp;&nbsp;<i class="fa fa-list fa-2xl "
                                                                                      aria-hidden="true"></i></a>
            </div>

            <div class="col col-lg-2 text-right">
                <form method="POST" class="" action="{{route('datotekaobracunskihkoeficijenata.stampa_radnik_lista')}}">
                    @csrf
                    <input type="hidden" name="radnik_maticni" value="{{$radnik_maticni}}">
                    <input type="hidden" name="month_id" value="{{$month_id}}">
                    <button type="submit" class="btn mt-5 btn-secondary btn-lg" id="print-page">PDF &nbsp;&nbsp;<i
                            class="fa fa-print fa-2xl " aria-hidden="true"></i></button>
                </form>
            </div>
            <div class="col col-lg-3 text-right">
            </div>
            <div class="col col-lg-3 text-right">
                <form method="POST" class="" action="{{route('datotekaobracunskihkoeficijenata.email_radnik_lista')}}">
                    @csrf
                    <div class="input-group">
                        <button type="submit" class="btn mt-5 btn-secondary btn-lg" style="width: 200px"
                                id="print-page">Pošalji email &nbsp;&nbsp;<i class="fa fa-envelope fa-2xl "
                                                                             aria-hidden="true"></i></button>
                        <input type="hidden" name="radnik_maticni" value="{{$radnik_maticni}}">
                        <input type="hidden" name="month_id" value="{{$month_id}}">
                        <label>
                            <input type="email" class="form-control mt-2" style="width: 200px" name="email_to"
                                   placeholder="Email primaoca">
                        </label>
                    </div>

                </form>
            </div>
        </div>
        <div class="row mb-5 mt-5 border">


            {{--                <p>{{$podaciFirme['skraceni_naziv_firme']}}</p>--}}
            {{--                <p>{{$podaciFirme['adresa_za_prijem_poste']}}</p>--}}
            {{--                <p>PIB:{{$podaciFirme['pib']}}</p>--}}
            {{--                <p>Banke:{{$podaciFirme['racuni_u_bankama']}}</p>--}}

            {{--                <p>OBRACUN ZARADE I NAKNADA ZARADE</p>--}}
            {{--                <p>ZA MESEC: {{$datum}}</p>--}}

            {{--                <p>TROSKOVNI CENTAR : {{$mdrData['troskovno_mesto_id']}}</p>--}}
            {{--                <p>{{$mdrData['MBRD_maticni_broj']}} {{$mdrData['PREZIME_prezime']}} {{$mdrData['IME_ime']}} </p>--}}
            {{--                <p>(($Ulica broj)) $((Grad)) </p>--}}
            {{--                <p>{{$mdrPreparedData['RBIM_isplatno_mesto_id']}} {{$mdrData['ZRAC_tekuci_racun']}}}</p>--}}
            {{--                <p>Datum dospelosti: {{$podaciMesec['period_isplate_do']}}</p>--}}

            {{--                <p>Strucna sprema: {{$mdrPreparedData['RBPS_priznata_strucna_sprema']}}</p>--}}
            {{--                <p>Radno mesto {{$mdrPreparedData['RBRM_radno_mesto']}}</p>--}}


            {{--                <p>Staz kod poslodavca: {{$mdrData['GGST_godine_staza']}} god {{$mdrData['MMST_meseci_staza']}} mes</p>--}}
            {{--                <p>Osnovna bruto zarada: {{$mdrData['KOEF_osnovna_zarada']}}</p>--}}
            {{--                <p>Prosecna bruto zarada/cas: {{$mdrData['PRCAS_ukupni_sati_za_ukupan_bruto_iznost']}}</p>--}}
            {{--                <p>(($prosecni ucinak, pitaj snezu:))</p>--}}



            {{--            </div>--}}
            <div class="col-md-12 text-right">
                <p>Datum štampe:{{$datumStampe}}</p>
            </div>

            <div class="col-md-12 text-left mb-5">

                <div class="section">

                    <span class="strong">{{$podaciFirme['skraceni_naziv_firme']}}</span><br>
                    {{$podaciFirme['adresa_za_prijem_poste']}}<br>
                    PIB: {{$podaciFirme['pib']}}<br>
                    Banke: {{$podaciFirme['racuni_u_bankama']}}<br>
                    Maticni broj: {{$podaciFirme['maticni_broj']}}

                </div>

                <div class="section header">
                </div>

            </div>

            <div class="col-md-6 pl-3">
                <b>OBRACUN ZARADE I NAKNADA ZARADE</b>
                |  ZA MESEC: {{$datum}}
                <div class="section ">
                    TROSKOVNI
                    CENTAR: {{$troskovnoMesto['sifra_troskovnog_mesta']}} {{ $troskovnoMesto['naziv_troskovnog_mesta']}}
                   <br>

                    <br>
                    <b> {{$mdrData['MBRD_maticni_broj']}}</b> - {{$userData['prezime']}}  {{$userData['srednje_ime']}}
                    . {{$userData['ime']}}<br>
                    {{$mdrData['adresa_ulica_broj']}}  {{$mdrData['adresa_mesto']}} <br>
                    <b> {{$mdrData['RBIM_isplatno_mesto_id']}} </b> |  {{$mdrPreparedData['RBIM_isplatno_mesto_id']}} tekuci racun: {{$mdrData['ZRAC_tekuci_racun']}}<br>
                    Datum dospelosti: <b> {{\Carbon\Carbon::createFromFormat('Y-m-d', $podaciMesec['period_isplate_do'])->format('d.m.Y')}}</b>
                    <br>
                </div>
            </div>

            <div class="col-md-6">

                <div class="section">

                    JMBG: {{$mdrPreparedData['LBG_jmbg']}}<br>

                </div>

                <div class="section">

                    Osnovna bruto zarada: {{$mdrData['KOEF_osnovna_zarada']}}<br>
                    Prosecna bruto
                    zarada/cas: {{  number_format($mdrData['PRIZ_ukupan_bruto_iznos']/$mdrData['PRCAS_ukupni_sati_za_ukupan_bruto_iznost'], 2, ',', '.')}}
                    <br>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 p-3 border border-custom">
                <h1 class="text-left header-custom">   Strucna sprema: {{$mdrPreparedData['RBPS_priznata_strucna_sprema']}}


                </h1>
            </div>
            <div class="col-lg-4 p-3 border-left-disabled border border-custom">
                <h1 class="text-center header-custom">Staz kod poslodavca:</h1>
            </div>
            <div class="col-lg-2 p-3 border-left-disabled border border-custom">
                <h1 class="text-center header-custom"> <b>{{$mdrData['GGST_godine_staza']}} god {{$mdrData['MMST_meseci_staza']}} m</b></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-3 border border-custom">
                <h1 class="text-left header-custom">  Radno mesto:<b>{{$mdrPreparedData['RBRM_radno_mesto']}}</b>
                </h1>
            </div>
            <div class="col-lg-2 p-3 border-left-disabled border border-custom">
                <h1 class="text-center header-custom"> </h1>
            </div>
            <div class="col-lg-2 p-3 border-left-disabled border border-custom">
                <h1 class="text-center header-custom"></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 p-3 border border-custom">
                <h1 class="text-left header-custom"> Osnovna bruto zarada
                </h1>
            </div>
            <div class="col-lg-2 p-3 border-left-disabled border border-custom">
                <h1 class="text-center header-custom"> </h1>
            </div>
            <div class="col-lg-2 p-3 border-left-disabled border border-custom">
                <h1 class="text-center header-custom"></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 p-3 border border-custom">
                <h1 class="text-left header-custom"> Prosecna bruto zarada
                </h1>
            </div>
            <div class="col-lg-2 p-3 border-left-disabled border border-custom">
                <h1 class="text-center header-custom">Učinak </h1>
            </div>
            <div class="col-lg-2 p-3 border-left-disabled border border-custom">
                <h1 class="text-center header-custom"></h1>
            </div>
        </div>
        @foreach($radnikData as $radnik)

            @if($radnik['KESC_prihod_rashod_tip']=='P')
                <div class="row">
                    <div class="col-lg-8 p-2 ">
                        <h2 class="text-left header-custom">{{$radnik['sifra_vrste_placanja']}} {{$radnik['naziv_vrste_placanja']}}</h2>
                    </div>
                    <div class="col-lg-2 p-2 ">
                        <h2 class="text-center header-custom">{{($radnik['sati'] !== null  && $radnik['procenat'] == null) ?  $radnik['sati'] : null}} {{$radnik['procenat'] !== null ?  $radnik['procenat'] .'%' : null}}</h2>
                    </div>
                    <div class="col-lg-2 p-2 ">
                        <h2 class="text-right header-custom">{{ $radnik['iznos'] !== null  ? number_format($radnik['iznos'], 2, ',', '.') : 0}} </h2>
                    </div>
                </div>
            @endif
        @endforeach


        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-top border-top-custom border-bottom-custom">
                <h1 class="text-left header-custom">1. BRUTO ZARADA :</h1>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-top border-top-custom border-bottom-custom">
                <h2 class="text-center header-custom">{{$zarData->UKSA_ukupni_sati_za_isplatu}}</h2>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-top border-top-custom border-bottom-custom">
                <h2 class="text-right header-custom">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade, 2, ',', '.')}}</h2>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom"><b>-</b> IZNOS PORESKOG OSLOBODJENJA :</h2>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom">{{ number_format($zarData->POROSL_poresko_oslobodjenje, 2, ',', '.')}}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom"><b>-</b> Oporezivi iznos zarade :</h2>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade-$zarData->POROSL_poresko_oslobodjenje, 2, ',', '.')}}</h2>
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
                <h2 class="text-right header-custom">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade - $zarData->SIP_ukupni_iznos_poreza - $zarData->SID_ukupni_iznos_doprinosa, 2, ',', '.')}}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom">3. UK. OBUSTAVE :</h2>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom">{{ number_format($zarData->SIOB_ukupni_iznos_obustava +$zarData->ZARKR_ukupni_zbir_kredita, 2, ',', '.')}}</h2>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom">4. ZA ISPLATU (1 - 5 - 3 ) :</h2>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom">{{ number_format($zarData->NETO_neto_zarada -$zarData->SIOB_ukupni_iznos_obustava - $zarData->ZARKR_ukupni_zbir_kredita, 2, ',', '.')}}</h2>
            </div>
        </div>


        @foreach($radnikData as $radnik)

            @if($radnik['KESC_prihod_rashod_tip']=='R')
                @if($radnik['sifra_vrste_placanja']=='093')
                    <div class="row">
{{--                        kreditAdditionalData--}}
{{--                        kreditorAdditionalData--}}





                        <div class="col-lg-2 p-2 ">
                            <h2 class="text-left header-custom">{{$radnik['sifra_vrste_placanja']}} {{$radnik['naziv_vrste_placanja']}}</h2>
                        </div>
                        <div class="col-lg-2 p-2 ">
                            <p class="text-left header-custom">{{$radnik['kreditorAdditionalData']['imek_naziv_kreditora']}}</p>
                        </div>
                        <div class="col-lg-2 p-2 ">
                            <p class="text-left header-custom">saldo:{{$radnik['kreditAdditionalData']['SALD_saldo']}}</p>
                        </div>
{{--                        <div class="col-lg-2 p-2 ">--}}
{{--                            <h2 class="text-right header-custom">{{$radnik['sati']  !== null  ? $radnik['sati'] : 0}}</h2>--}}
{{--                        </div>--}}


                        <div class="col-lg-3 p-2 ">
                            <p class="text-right header-custom">{{$radnik['kreditAdditionalData']['PART_partija_poziv_na_broj']}}</p>
                        </div>
                        <div class="col-lg-3 p-2 ">
                            <p class="text-right header-custom">{{ $radnik['iznos'] !== null  ? number_format($radnik['iznos'], 2, ',', '.') : 0}} {{--    RATA: {{$radnik['kreditAdditionalData']['RATA_rata']}}--}} </p>
                        </div>
                    </div>
                    @else
                <div class="row">
                    <div class="col-lg-8 p-2 ">
                        <h2 class="text-left header-custom">{{$radnik['sifra_vrste_placanja']}} {{$radnik['naziv_vrste_placanja']}}</h2>
                    </div>
                    <div class="col-lg-2 p-2 ">
                        <h2 class="text-right header-custom">{{$radnik['sati']  !== null  ? $radnik['sati'] : 0}}</h2>
                    </div>
                    <div class="col-lg-2 p-2 ">
                        <h2 class="text-right header-custom">{{ $radnik['iznos'] !== null  ? number_format($radnik['iznos'], 2, ',', '.') : 0}}  </h2>
                    </div>
                </div>
                    @endif
            @endif
        @endforeach

        <div class="row">
            <div class="col-lg-8 p-3  border-bottom border-top border-top-custom border-bottom-custom">
                <h1 class="text-left header-custom">UKUPNI DOPRINOSI</h1>
            </div>
            <div class="col-lg-2 p-3  border-bottom border-top border-top-custom border-bottom-custom">
                <h2 class="text-right header-custom"></h2>
            </div>
            <div class="col-lg-2 p-3  border-bottom border-top border-top-custom border-bottom-custom">
                <h2 class="text-right header-custom">{{ number_format($zarData->SID_ukupni_iznos_doprinosa, 2, ',', '.')}}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h1 class="text-left header-custom">050 POREZ ( 10 % )</h1>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom"></h2>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom">{{ number_format($zarData->SIP_ukupni_iznos_poreza, 2, ',', '.')}}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h1 class="text-left header-custom">5. UKUPNI POREZI I DOPRINOSI:</h1>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom"></h2>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom SIP_D">{{ number_format($zarData->SIP_ukupni_iznos_poreza + $zarData->SID_ukupni_iznos_doprinosa, 2, ',', '.')}} </h2>
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
                <h2 class="text-right header-custom">{{ number_format($zarData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca, 2, ',', '.')}}</h2>
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
                <h2 class="text-right header-custom">{{ number_format($zarData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, ',', '.')}}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-top border-top-custom border-bottom-custom">
                <h2 class="text-left header-custom"><b>-</b>Ukupni doprinosi</h2>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-top border-top-custom border-bottom-custom">
                <h2 class="text-right header-custom">{{ number_format($zarData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca +$zarData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, ',', '.')}}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom"><b>-</b>UKUPNA BRUTO ZARADA</h2>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom">
                    {{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade +$zarData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca +$zarData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, ',', '.')}}
                </h2>
            </div>
        </div>
    </div>

    @if(\App\Models\User::with('permission')->find(Auth::id())->permission->role_id ==UserRoles::PROGRAMER)
        <h1 class="text-center font-weight-bold">Kontrola tabele</h1>
        <div class="container-fluid mt-5" style="margin-left:150px">
            <h1 class="text-center font-weight-bold">ZARA</h1>

            <div style="width: 90% !important;">
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        @foreach ($zarData->toArray() as $key => $value)
                            <th>{{ ucfirst($key) }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @foreach ($zarData->toArray() as $value)
                            <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="container-fluid mt-5" style="margin-left:150px">
            <h1 class="text-center font-weight-bold">DKOP</h1>
            <div style="width: 90% !important;">

                <table class="table-striped table-bordered table-responsive">
                    <thead>
                    <tr>
                        @foreach ($dkopData->first()->toArray() as $key => $value)
                            <th>{{ ucfirst($key) }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($dkopData as $dkop)
                        <tr>
                            @foreach ($dkop->toArray() as $value)
                                <td class="text-center">{{ $value }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if(count($kreditiData))
            <div class="container-fluid mt-5" style="margin-left:150px">
                <h1 class="text-center font-weight-bold">Krediti</h1>
                <div style="width: 90% !important;">
                    <table class="table  table-responsive">
                        <thead>
                        <tr>
                            @foreach ($kreditiData->first()->toArray() as $key => $value)
                                <th>{{ ucfirst($key) }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($kreditiData as $dkop)
                            <tr>
                                @foreach ($dkop->toArray() as $value)
                                    <td>{{ $value }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

            <?php
            $userData = Auth::user()->load(['permission']);
            $permissions = $userData->permission;
            ?>
        @if($permissions['role_id']==UserRoles::PROGRAMER)

            <div class="container-fluid mt-5" style="margin-left:150px">
                <h1 class="text-center font-weight-bold">SVE FORMULE</h1>
                <div style="width: 90% !important;">

                    <table class="table-dark table-bordered  table-responsive">
                        <thead>
                        <tr>
                            @foreach (array_values($vrstePlacanjaData)[0] as $key => $value)
                                <th>{{ ucfirst($key) }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($vrstePlacanjaData as $vrstaPlacanja)
                            <tr>
                                @foreach ($vrstaPlacanja as $value)
                                    <td class="text-center" style="white-space: nowrap;">{{ $value }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    @endif
@endsection



@section('custom-scripts')

@endsection

