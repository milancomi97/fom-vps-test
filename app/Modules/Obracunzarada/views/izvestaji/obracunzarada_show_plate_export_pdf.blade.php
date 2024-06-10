<!DOCTYPE html>
<html>
<head>
    <style>
    </style>

</head>
<body>
    <div class="container mb-5">
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
                <h3>{{$datumStampe}}</h3>
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
                    OBRACUN ZARADE I NAKNADA ZARADE
                </div>

            </div>

            <div class="col-md-6 pl-3">
                <div class="section ">
                    ZA MESEC: {{$datum}}<br>
                    TROSKOVNI CENTAR: {{$troskovnoMesto['sifra_troskovnog_mesta']}} {{ $troskovnoMesto['naziv_troskovnog_mesta']}}<br>
                   <b> {{$mdrData['MBRD_maticni_broj']}}</b> - {{$userData['prezime']}}  {{$userData['srednje_ime']}}. {{$userData['ime']}}<br>
                    {{$mdrData['adresa_mesto']}} <br>
                    {{$mdrData['adresa_ulica_broj']}} <br>
                    {{$mdrPreparedData['RBIM_isplatno_mesto_id']}} tekuci racun: {{$mdrData['ZRAC_tekuci_racun']}}<br>
                    Datum dospelosti: {{\Carbon\Carbon::createFromFormat('Y-m-d', $podaciMesec['period_isplate_do'])->format('d.m.Y')}}<br>
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
                    Prosecna bruto zarada/cas: {{  number_format($mdrData['PRIZ_ukupan_bruto_iznos']/$mdrData['PRCAS_ukupni_sati_za_ukupan_bruto_iznost'], 2, '.', ',')}}<br>
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
                        <h2 class="text-center header-custom">{{($radnik['sati'] !== null  && $radnik['procenat'] == null) ?  $radnik['sati'] : null}} {{$radnik['procenat'] !== null ?  $radnik['procenat'] .'%' : null}}</h2>
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
                <h2 class="text-center header-custom">{{$zarData->UKSA_ukupni_sati_za_isplatu}}</h2>
            </div>
            <div class="col-lg-2 p-3 border-bottom border-top border-top-custom border-bottom-custom">
                <h2 class="text-right header-custom">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade, 2, '.', ',')}}</h2>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom"> <b>-</b> IZNOS PORESKOG OSLOBODJENJA :</h2>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom">{{ number_format($zarData->POROSL_poresko_oslobodjenje, 2, '.', ',')}}</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom"> <b>-</b> Oporezivi iznos zarade :</h2>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade-$zarData->POROSL_poresko_oslobodjenje, 2, '.', ',')}}</h2>
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
                <h2 class="text-right header-custom">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade - $zarData->SIP_ukupni_iznos_poreza - $zarData->SID_ukupni_iznos_doprinosa, 2, '.', ',')}}</h2>
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
                <h2 class="text-right header-custom">{{ number_format($zarData->SIOB_ukupni_iznos_obustava +$zarData->ZARKR_ukupni_zbir_kredita, 2, '.', ',')}}</h2>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-8 p-3 border-bottom border-bottom-custom">
                <h2 class="text-left header-custom">4. ZA ISPLATU (1 - 5 - 3 ) :</h2>
            </div>

            <div class="col-lg-4 p-3 border-bottom border-bottom-custom">
                <h2 class="text-right header-custom">{{ number_format($zarData->NETO_neto_zarada -$zarData->SIOB_ukupni_iznos_obustava - $zarData->ZARKR_ukupni_zbir_kredita, 2, '.', ',')}}</h2>
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
</body>
</html>

