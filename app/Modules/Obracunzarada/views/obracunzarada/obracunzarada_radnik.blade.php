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

    </style>


@endsection

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row mb-5 border">


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
    </div>

        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-top border-top-custom border-bottom-custom">
                <h2 class="text-left header-custom">1. BRUTO ZARADA :</h2>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-top border-top-custom border-bottom-custom">
                <h3 class="text-right header-custom">184,00</h3>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-top border-top-custom border-bottom-custom">
                <h3 class="text-right header-custom">143.164,01</h3>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h3 class="text-left header-custom"> <b>-</b> IZNOS PORESKOG OSLOBODJENJA :</h3>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-custom">
                <h3 class="text-right header-custom">25.000,00</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h3 class="text-left header-custom"> <b>-</b> Oporezivi iznos zarade :</h3>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-custom">
                <h3 class="text-right header-custom">118.164,01</h3>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom">2. NETO ZARADA (1 - 5) :</h2>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">
                <h3 class="text-right header-custom">184,00</h3>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">
                <h3 class="text-right header-custom">102.857,97</h3>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom">061 PRIMLJENA KONTACIJA</h2>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">
                <h3 class="text-right header-custom">0,00</h3>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">
                <h3 class="text-right header-custom">0,00</h3>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h3 class="text-left header-custom">3. UK. OBUSTAVE :</h3>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-custom">
                <h3 class="text-right header-custom">0,00</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h3 class="text-left header-custom">4. ZA ISPLATU (1 - 5 - 3 ) :</h3>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-custom">
                <h3 class="text-right header-custom">102.857,97</h3>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-8 p-2 ">
                <h3 class="text-left header-custom">053 PENZIJSKO OS. 14,0%</h3>
            </div>
            <div class="col-lg-2 p-2 ">
                <h3 class="text-right header-custom">0,0</h3>
            </div>
            <div class="col-lg-2 p-2 ">
                <h3 class="text-right header-custom">20.052,96</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-2 ">
                <h3 class="text-left header-custom">054 ZDRAVSTVENO O. 5,15%</h3>
            </div>
            <div class="col-lg-2 p-2 ">
                <h3 class="text-right header-custom">0,0</h3>
            </div>
            <div class="col-lg-2 p-2 ">
                <h3 class="text-right header-custom">7.372,95</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-2 ">
                <h3 class="text-left header-custom">055 NEZAPOSLENOST 0,75%</h3>
            </div>
            <div class="col-lg-2 p-2 ">
                <h3 class="text-right header-custom">0,0</h3>
            </div>
            <div class="col-lg-2 p-2 ">
                <h3 class="text-right header-custom">1.073,73</h3>
            </div>
        </div>



        <div class="row">
            <div class="col-lg-8 p-3  border-bottom border-top border-top-custom border-bottom-custom">
                <h2 class="text-left header-custom">UKUPNI DOPRINOSI</h2>
            </div>
            <div class="col-lg-2 p-3  border-bottom border-top border-top-custom border-bottom-custom">
                <h3 class="text-right header-custom">0,00</h3>
            </div>
            <div class="col-lg-2 p-3  border-bottom border-top border-top-custom border-bottom-custom">
                <h3 class="text-right header-custom">28.489,64</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom">050 POREZ ( 10 % )</h2>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">
                <h3 class="text-right header-custom">0,00</h3>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">
                <h3 class="text-right header-custom">11.816,40</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom">5. UKUPNI POREZI I DOPRINOSI (a + b) :</h2>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">
                <h3 class="text-right header-custom">0,00</h3>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">
                <h3 class="text-right header-custom">40.306,04</h3>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom"> Dodati tabele bruto neto po koef</h2>
            </div>
{{--            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">--}}
{{--                <h3 class="text-right header-custom">0,00</h3>--}}
{{--            </div>--}}
{{--            <div class="col-lg-2 p-3 border-bottom border-bottom-custom">--}}
{{--                <h3 class="text-right header-custom">40.306,04</h3>--}}
{{--            </div>--}}
        </div>

        <div class="row">
            <div class="col-lg-12 p-3 border-bottom border-bottom-custom">
                <h3 class="text-left header-custom">6. OBAVEZE NA TERET POSLODAVCA :</h3>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-8 p-2 ">
                <h3 class="text-left header-custom">Zdravstveno osiguranje (p)</h3>
            </div>
            <div class="col-lg-2 p-2 ">
                <h3 class="text-right header-custom">5.15%</h3>
            </div>
            <div class="col-lg-2 p-2 ">
                <h3 class="text-right header-custom">7373</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-2 ">
                <h3 class="text-left header-custom">Penzijsko-invalidsko osig.(p)</h3>
            </div>
            <div class="col-lg-2 p-2 ">
                <h3 class="text-right header-custom">10.00%</h3>
            </div>
            <div class="col-lg-2 p-2 ">
                <h3 class="text-right header-custom">14316</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-top border-top-custom border-bottom-custom">
                <h3 class="text-left header-custom"><b>-</b>Ukupni doprinosi</h3>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-top border-top-custom border-bottom-custom">
                <h3 class="text-right header-custom">21689</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h3 class="text-left header-custom"><b>-</b>UKUPNA BRUTO ZARADA</h3>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-custom">
                <h3 class="text-right header-custom">164853,35</h3>
            </div>
        </div>


    </div>
    </div>
@endsection



@section('custom-scripts')

@endsection

