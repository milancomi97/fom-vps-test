@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <style>
        .border-custom {
            border-style: dashed !important;
            border-width: 3px !important;
            border-color: black !important;
        }

        .border-bottom-custom{
            border-bottom-style: dashed !important;
            border-bottom-width: 3px !important;
            border-bottom-color: black !important;
        }

        .border-top-custom{
            border-top-style: dashed !important;
            border-top-width: 3px !important;
            border-top-color: black !important;
        }
        .header-custom{
            letter-spacing: 3px;
        }

        .border-left-disabled{
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

        h1{
            font-size: 1.3rem
        }
        h2{
            font-size: 1.6rem
        }
    </style>


@endsection

@section('content')
    <div class="container mb-5">
        <div class="col col-lg-12 text-right">

            <form method="POST" class="d-inline" action="{{route('datotekaobracunskihkoeficijenata.email_radnik')}}">
                @csrf
                <button type="submit" class="btn mt-5 btn-secondary btn-lg" id="print-page">Pošalji email &nbsp;&nbsp;<i class="fa fa-envelope fa-2xl " aria-hidden="true"></i></button>
            </form>
            <form method="POST" class="d-inline" action="{{route('datotekaobracunskihkoeficijenata.stampa_radnik')}}">
                @csrf
                <button type="submit" class="btn mt-5 btn-secondary btn-lg" id="print-page">Štampaj &nbsp;&nbsp;<i class="fa fa-print fa-2xl " aria-hidden="true"></i></button>
            </form>

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

            <div class="col-md-12 text-center mb-5 mt-3">
                <div class="section">
                    <span class="strong">{{$podaciFirme['skraceni_naziv_firme']}}</span><br>
                    {{$podaciFirme['adresa_za_prijem_poste']}}<br>
                    PIB: {{$podaciFirme['pib']}}<br>
                    Banke: {{$podaciFirme['racuni_u_bankama']}}<br>
                </div>

                <div class="section header">
                    OBRACUN ZARADE I NAKNADA ZARADE
                </div>

            </div>

            <div class="col-md-6 pl-3">
                <div class="section ">
                    ZA MESEC: {{$datum}}<br>
                    TROSKOVNI CENTAR: {{$mdrData['troskovno_mesto_id']}}<br>
                    {{$mdrData['MBRD_maticni_broj']}} {{$mdrData['PREZIME_prezime']}} {{$mdrData['IME_ime']}}<br>
                    {{--                ({{$mdrData['adresa_ulica_broj']}}) ({{$mdrData['adresa_grad']}})<br>--}}
                    {{$mdrPreparedData['RBIM_isplatno_mesto_id']}} tekuci racun: {{$mdrData['ZRAC_tekuci_racun']}}<br>
                    Datum dospelosti: {{$podaciMesec['period_isplate_do']}}<br>
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
                    Prosecna bruto zarada/cas: {{$mdrData['PRCAS_ukupni_sati_za_ukupan_bruto_iznost']}}<br>
                </div>
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
                        <h2 class="text-center header-custom">{{$radnik['sati']  ?? 0}}</h2>
                    </div>
                    <div class="col-lg-2 p-2 ">
                        <h2 class="text-right header-custom">{{$radnik['iznos'] ?? 0}} </h2>
                    </div>
                </div>
            @endif
        @endforeach



        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-top border-top-custom border-bottom-custom">
                <h1 class="text-left header-custom">1. BRUTO ZARADA :</h1>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-top border-top-custom border-bottom-custom">
                <h2 class="text-right header-custom">184,00</h2>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-top border-top-custom border-bottom-custom">
                <h2 class="text-right header-custom">{{$zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade}}</h2>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom"> <b>-</b> IZNOS PORESKOG OSLOBODJENJA :</h2>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom">{{$zarData->POROSL_poresko_oslobodjenje}}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom"> <b>-</b> Oporezivi iznos zarade :</h2>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom">{{$zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade-$zarData->POROSL_poresko_oslobodjenje}}</h2>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h1 class="text-left header-custom">2. NETO ZARADA (1 - 5) :</h1>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom">184,00</h2>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom">{{$zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade - $zarData->SIP_ukupni_iznos_poreza - $zarData->SID_ukupni_iznos_doprinosa}}</h2>
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
                <h2 class="text-right header-custom">{{$zarData->SIOB_ukupni_iznos_obustava}}</h2>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom">4. ZA ISPLATU (1 - 5 - 3 ) :</h2>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom">{{$zarData->UKSA_ukupni_sati_za_isplatu}}</h2>
            </div>
        </div>



        @foreach($radnikData as $radnik)


            @if($radnik['KESC_prihod_rashod_tip']=='R')
                <div class="row">
                    <div class="col-lg-8 p-2 ">
                        <h2 class="text-left header-custom">{{$radnik['sifra_vrste_placanja']}} {{$radnik['naziv_vrste_placanja']}}</h2>
                    </div>
                    <div class="col-lg-2 p-2 ">
                        <h2 class="text-right header-custom">{{$radnik['sati']  ?? 0}}</h2>
                    </div>
                    <div class="col-lg-2 p-2 ">
                        <h2 class="text-right header-custom">{{$radnik['iznos'] ?? 0}} </h2>
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
                <h2 class="text-right header-custom">{{$zarData->SID_ukupni_iznos_doprinosa}}</h2>
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
                <h2 class="text-right header-custom">{{$zarData->SIP_ukupni_iznos_poreza}}</h2>
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
                <h2 class="text-right header-custom SIP_D">{{$zarData->SIP_ukupni_iznos_poreza}} </h2>
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
                <h2 class="text-right header-custom">{{$zarData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca}}</h2>
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
                <h2 class="text-right header-custom">{{$zarData->PIOP_penzijsko_osiguranje_na_teret_poslodavca}}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-top border-top-custom border-bottom-custom">
                <h2 class="text-left header-custom"><b>-</b>Ukupni doprinosi</h2>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-top border-top-custom border-bottom-custom">
                <h2 class="text-right header-custom">{{$zarData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca +$zarData->PIOP_penzijsko_osiguranje_na_teret_poslodavca}}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom"><b>-</b>UKUPNA BRUTO ZARADA</h2>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom">
                    {{$zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade +$zarData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca +$zarData->PIOP_penzijsko_osiguranje_na_teret_poslodavca}}
                </h2>
            </div>
        </div>
    </div>

        <h1 class="text-center font-weight-bold">Kontrola tabele</h1>

        <div class="container-fluid mt-5" style="margin-left:150px">
            <h1 class="text-center font-weight-bold">DKOP</h1>
            <table class="table">
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
                            <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="container-fluid mt-5" style="margin-left:150px">
            <h1 class="text-center font-weight-bold">Krediti</h1>
            <table class="table">
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
        <div class="container-fluid mt-5" style="margin-left:150px">
            <h1 class="text-center font-weight-bold">ZARA</h1>
            <table class="table">
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

@endsection



@section('custom-scripts')

@endsection

