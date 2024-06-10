<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            size: A4 portrait;
            margin: 5mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 2px 1px;
            text-align: center
        }

        th {
            background-color: #f2f2f2;
        }

        .table-container {
            width: 100%;
            max-width: 200mm; /* A4 width in mm minus margins */
            margin: 0 auto;
        }

        .radnik_name{
            min-width: 100px;
            text-align: left;
            padding: 5px 5px 5px 5px;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .header-custom {
            font-weight: bold;
            font-size: 12px;
        }

        .border-bottom {
            border-bottom: 1px solid #000;
        }

        .border-top {
            border-top: 1px solid #000;
        }

        .border-bottom-custom {
            border-bottom: 1px solid #000;
        }

        .border-top-custom {
            border-top: 1px solid #000;
        }

        .p-2 {
            padding: 2px;
        }

        .p-3 {
            padding: 3px;
        }

        .mb-5 {
            margin-bottom: 5mm;
        }

        .mt-5 {
            margin-top: 5mm;
        }

        .strong {
            font-weight: bold;
        }

        .section {
            margin-bottom: 5mm;
        }

        .header {
            margin-top: 5mm;
            margin-bottom: 5mm;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="container mb-5">
    <div class="row mb-5 mt-5 border">
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

        <table>
            <tr>
                <td class="section">
                    ZA MESEC: {{$datum}}<br>
                    TROSKOVNI CENTAR: {{$troskovnoMesto['sifra_troskovnog_mesta']}} {{ $troskovnoMesto['naziv_troskovnog_mesta']}}<br>
                    <b>{{$mdrData['MBRD_maticni_broj']}}</b> - {{$userData['prezime']}} {{$userData['srednje_ime']}}. {{$userData['ime']}}<br>
                    {{$mdrData['adresa_mesto']}}<br>
                    {{$mdrData['adresa_ulica_broj']}}<br>
                    {{$mdrPreparedData['RBIM_isplatno_mesto_id']}} tekuci racun: {{$mdrData['ZRAC_tekuci_racun']}}<br>
                    Datum dospelosti: {{\Carbon\Carbon::createFromFormat('Y-m-d', $podaciMesec['period_isplate_do'])->format('d.m.Y')}}<br>
                </td>
                <td class="section">
                    Strucna sprema: {{$mdrPreparedData['RBPS_priznata_strucna_sprema']}}<br>
                    Radno mesto: {{$mdrPreparedData['RBRM_radno_mesto']}}<br>
                    Staz kod poslodavca: {{$mdrData['GGST_godine_staza']}} god {{$mdrData['MMST_meseci_staza']}} m<br>
                    Osnovna bruto zarada: {{$mdrData['KOEF_osnovna_zarada']}}<br>
                    Prosecna bruto zarada/cas: {{ number_format($mdrData['PRIZ_ukupan_bruto_iznos']/$mdrData['PRCAS_ukupni_sati_za_ukupan_bruto_iznost'], 2, '.', ',')}}<br>
                </td>
            </tr>
        </table>
    </div>

    <table>
        <tr>
            <th class="text-left header-custom">VP: Naziv vrste placanja</th>
            <th class="text-center header-custom">Sati</th>
            <th class="text-center header-custom">Iznos</th>
        </tr>
        @foreach($radnikData as $radnik)
            @if($radnik['KESC_prihod_rashod_tip']=='P')
                <tr>
                    <td class="text-left header-custom">{{$radnik['sifra_vrste_placanja']}} {{$radnik['naziv_vrste_placanja']}}</td>
                    <td class="text-center header-custom">{{($radnik['sati'] !== null  && $radnik['procenat'] == null) ?  $radnik['sati'] : null}} {{$radnik['procenat'] !== null ?  $radnik['procenat'] .'%' : null}}</td>
                    <td class="text-right header-custom">{{ $radnik['iznos'] !== null  ? number_format($radnik['iznos'], 2, '.', ',') : 0}}</td>
                </tr>
            @endif
        @endforeach
        <tr>
            <td class="text-left header-custom">1. BRUTO ZARADA :</td>
            <td class="text-center header-custom">{{$zarData->UKSA_ukupni_sati_za_isplatu}}</td>
            <td class="text-right header-custom">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade, 2, '.', ',')}}</td>
        </tr>
        <tr>
            <td class="text-left header-custom"><b>-</b> IZNOS PORESKOG OSLOBODJENJA :</td>
            <td colspan="2" class="text-right header-custom">{{ number_format($zarData->POROSL_poresko_oslobodjenje, 2, '.', ',')}}</td>
        </tr>
        <tr>
            <td class="text-left header-custom"><b>-</b> Oporezivi iznos zarade :</td>
            <td colspan="2" class="text-right header-custom">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade-$zarData->POROSL_poresko_oslobodjenje, 2, '.', ',')}}</td>
        </tr>
        <tr>
            <td class="text-left header-custom">2. NETO ZARADA (1 - 5) :</td>
            <td></td>
            <td class="text-right header-custom">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade - $zarData->SIP_ukupni_iznos_poreza - $zarData->SID_ukupni_iznos_doprinosa, 2, '.', ',')}}</td>
        </tr>
        <tr>
            <td class="text-left header-custom">061 PRIMLJENA AKONTACIJA</td>
            <td class="text-right header-custom">0,00</td>
            <td class="text-right header-custom">0,00</td>
        </tr>
        <tr>
            <td class="text-left header-custom">3. UK. OBUSTAVE :</td>
            <td colspan="2" class="text-right header-custom">{{ number_format($zarData->SIOB_ukupni_iznos_obustava +$zarData->ZARKR_ukupni_zbir_kredita, 2, '.', ',')}}</td>
        </tr>
        <tr>
            <td class="text-left header-custom">4. ZA ISPLATU (1 - 5 - 3 ) :</td>
            <td colspan="2" class="text-right header-custom">{{ number_format($zarData->NETO_neto_zarada -$zarData->SIOB_ukupni_iznos_obustava - $zarData->ZARKR_ukupni_zbir_kredita, 2, '.', ',')}}</td>
        </tr>
        @foreach($radnikData as $radnik)
            @if($radnik['KESC_prihod_rashod_tip']=='R')
                <tr>
                    <td class="text-left header-custom">{{$radnik['sifra_vrste_placanja']}} {{$radnik['naziv_vrste_placanja']}}</td>
                    <td class="text-right header-custom">{{$radnik['sati']  !== null  ? $radnik['sati'] : 0}}</td>
                    <td class="text-right header-custom">{{ $radnik['iznos'] !== null  ? number_format($radnik['iznos'], 2, '.', ',') : 0}}</td>
                </tr>
            @endif
        @endforeach
        <tr>
            <td class="text-left header-custom">UKUPNI DOPRINOSI</td>
            <td class="text-right header-custom">0,00</td>
            <td class="text-right header-custom">{{ number_format($zarData->SID_ukupni_iznos_doprinosa, 2, '.', ',')}}</td>
        </tr>
        <tr>
            <td class="text-left header-custom">050 POREZ ( 10 % )</td>
            <td class="text-right header-custom">0,00</td>
            <td class="text-right header-custom">{{ number_format($zarData->SIP_ukupni_iznos_poreza, 2, '.', ',')}}</td>
        </tr>
        <tr>
            <td class="text-left header-custom">5. UKUPNI POREZI I DOPRINOSI (a + b) :</td>
            <td class="text-right header-custom">0,00</td>
            <td class="text-right header-custom SIP_D">{{ number_format($zarData->SIP_ukupni_iznos_poreza + $zarData->SID_ukupni_iznos_doprinosa, 2, '.', ',')}}</td>
        </tr>
        <tr>
            <td class="text-left header-custom">6. OBAVEZE NA TERET POSLODAVCA :</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-left header-custom">Zdravstveno osiguranje (p)</td>
            <td class="text-right header-custom">5.15%</td>
            <td class="text-right header-custom">{{ number_format($zarData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</td>
        </tr>
        <tr>
            <td class="text-left header-custom">Penzijsko-invalidsko osig.(p)</td>
            <td class="text-right header-custom">10.00%</td>
            <td class="text-right header-custom">{{ number_format($zarData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</td>
        </tr>
        <tr>
            <td class="text-left header-custom"><b>-</b>Ukupni doprinosi</td>
            <td colspan="2" class="text-right header-custom">{{ number_format($zarData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca +$zarData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</td>
        </tr>
        <tr>
            <td class="text-left header-custom"><b>-</b>UKUPNA BRUTO ZARADA</td>
            <td colspan="2" class="text-right header-custom">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade +$zarData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca +$zarData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</td>
        </tr>
    </table>
</div>
</body>
</html>
