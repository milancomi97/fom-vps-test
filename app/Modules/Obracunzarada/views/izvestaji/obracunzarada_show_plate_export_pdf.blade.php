<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @page {
            size: A4;
            margin: 5mm 10mm;
            font-size: 3mm;
        }
        .footer {
            width: 100%;
            text-align: center;
            position: fixed;
            bottom: 0px;
        }
        @if(count($radnikData) > 15)
        .small_font{
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            font-size: 2.5mm;
            margin-top:0 !important;
            margin-bottom: 0!important;

        }
        @endif
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }
        .disable_top_border td{
            border-top: 0 !important;
            padding: 5px 0px 0px 0px;
        }

        table{
            width: 100%;
            border-bottom: 3px solid lightblue !important;

        }
        .custom_shadow{
            box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;
        }
        .table-bordered td{
            border-left: 0 !important;
            border-right: 0 !important;

        }
        .text-right{
            text-align: right;
        }

        .text-center{
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container mb-5">
    <!-- Company Info Section -->
    <h1 class="text-center">TEST PDF</h1>

    <table class="table disable_top_border">

        <tr>
            <td colspan="2">
                <img src="{{asset('images/company/logo2.jpg')}}" width="50mm"  height="auto">
            </td>
        </tr>
        <tr>


            <td  class="pl-4"  ><strong>{{ $podaciFirme['skraceni_naziv_firme'] }} </strong>  </td>

            <td class="text-right">Datum: {{ $datumStampe }}</td>
        </tr>
        <tr>

            <td>{{ $podaciFirme['adresa_za_prijem_poste'] }}</td>
            <td></td>
        </tr>
        <tr>

            <td>PIB: {{ $podaciFirme['pib'] }}</td>
            <td></td>
        </tr>
        <tr>
            <td>
                Matični broj: {{$podaciFirme['maticni_broj']}}
            </td>
        </tr>
        <tr>

            <td>Banka: {{ $podaciFirme['racuni_u_bankama'] }}</td>
            <td></td>
        </tr>

    </table>

    <!-- Payroll Summary -->
    <table class="table mt-2 disable_top_border">
        <tr>
            <td class="pl-4" ><strong>OBRAČUN ZARADE I NAKNADA ZARADE</strong></td>
            <td></td>
        </tr>
        <tr>
            <td class="pl-4" ><b>ZA MESEC: {{ $datum }}</b></td>
        </tr>
        <tr>
            <td>Troškovi Centar: {{ $troskovnoMesto['sifra_troskovnog_mesta'] }} {{ $troskovnoMesto['naziv_troskovnog_mesta'] }}</td>
        </tr>


        <tr>
            <td>
                {{$mdrData['MBRD_maticni_broj']}} -<b> {{$userData['prezime']}}
                     {{$userData['ime']}}</b>
            </td>
            <td class="text-right">
                JMBG: {{$mdrPreparedData['LBG_jmbg']}}<br>
            </td>
        </tr>



        <tr>
            <td><b>{{$mdrData['RBIM_isplatno_mesto_id']}} </b>  {{$mdrPreparedData['RBIM_isplatno_mesto_id']}} </td>
            <td class="text-right"> tekuci racun: {{$mdrData['ZRAC_tekuci_racun']}} </td>
        </tr>
        <tr>
            <td>
                Datum dospelosti: <b> {{\Carbon\Carbon::createFromFormat('Y-m-d', $podaciMesec['period_isplate_do'])->format('d.m.Y')}}</b>
            </td>
            <td class="text-right">
                E-pošta: {{$mdrData['email_za_plate']}}
            </td>
        </tr>
    </table>

    <table class="table disable_top_border">
        <tr>
            <td>
                Stručna sprema: {{$mdrPreparedData['RBPS_priznata_strucna_sprema']}}
            </td>
            <td class="text-right">
                Staž kod poslodavca {{$mdrData['GGST_godine_staza']}} god {{$mdrData['MMST_meseci_staza']}} m
            </td>
        </tr>
        <tr>
            <td>Radno mesto: {{$mdrPreparedData['RBRM_radno_mesto']}}
            </td>
        </tr>
        <tr>
            <td>Osnovna bruto zarada:  {{number_format($mdrPreparedData['KOEF_osnovna_zarada'], 2, ',', '.')}}</td>
        </tr>
        <tr>
            <td>
                Prosečna bruto zarada/čas: {{  number_format($mdrData['PRIZ_ukupan_bruto_iznos']/$mdrData['PRCAS_ukupni_sati_za_ukupan_bruto_iznost'], 2, ',', '.')}}
            </td>
            <td class="text-right">
                Učinak: {{  number_format($mdrData['PREB_prebacaj'], 2, ',', '.')}}
            </td>
        </tr>
    </table>

    <!-- Income and Deductions Table with Foreach Loop for Radnik Data -->
    <table class="table table-bordered ">
        <thead>
        <tr>
            {{--                <th>Vrsta Plaćanja</th>--}}
            {{--                <th>Procenat</th>--}}
            {{--                <th>Sati</th>--}}
            {{--                <th>Iznos</th>--}}
        </tr>
        </thead>
        <tbody>
        @foreach($radnikData as $radnik)
            @if($radnik['KESC_prihod_rashod_tip'] == 'P')
                <tr >
                    <td class="small_font">{{ $radnik['sifra_vrste_placanja'] }} {{ $radnik['naziv_vrste_placanja'] }}</td>
                    <td class="small_font text-center">
                        {{ $radnik['procenat'] !== null ? $radnik['procenat'] . '%' : '' }}
                    </td>
                    <td class="small_font">{{ $radnik['sati'] !== null && $radnik['procenat'] == null ? $radnik['sati'] : '' }}</td>
                    <td class="small_font text-right">{{ $radnik['iznos'] !== null ? number_format($radnik['iznos'], 2, ',', '.') : '0.00' }}</td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>

    <!-- Deductions Table for 'R' Type Entries -->
    <table class="table table-bordered">
        <thead>
        <tr>
            {{--                <th>Vrsta Plaćanja</th>--}}
            {{--                <th>Kreditor</th>--}}
            {{--                <th>Saldo</th>--}}
            {{--                <th>Partija / Poziv</th>--}}
            {{--                <th>Iznos</th>--}}
        </tr>
        </thead>
        <tbody>
        @foreach($radnikData as $radnik)
            @if($radnik['KESC_prihod_rashod_tip'] == 'R')
                @if($radnik['sifra_vrste_placanja'] == '093')
                    <tr>
                        <td class="small_font">{{ $radnik['sifra_vrste_placanja'] }} {{ $radnik['naziv_vrste_placanja'] }}</td>
                        <td class="small_font">{{ $radnik['kreditorAdditionalData']['imek_naziv_kreditora'] ?? '' }}</td>
                        <td class="small_font">{{ $radnik['kreditAdditionalData']['SALD_saldo'] - $radnik['kreditAdditionalData']['RATA_rata']}}</td>
                        <td class="small_font ">part={{ $radnik['kreditAdditionalData']['PART_partija_poziv_na_broj'] ?? '' }}</td>
                        <td class="small_font text-right">{{ $radnik['iznos'] !== null ? number_format($radnik['iznos'], 2, ',', '.') : '0.00' }}</td>
                    </tr>
                @else
                    <tr>
                        <td  class="small_font">{{ $radnik['sifra_vrste_placanja'] }} {{ $radnik['naziv_vrste_placanja'] }}</td>
                        <td  class="small_font"></td>
                        <td  class="small_font"></td>
                        <td class="">{{ $radnik['procenat'] !== null ? $radnik['procenat'].'%' : '' }}</td>
                        <td  class="small_font text-right">{{ $radnik['iznos'] !== null ? number_format($radnik['iznos'], 2, ',', '.') : '0.00' }}</td>
                    </tr>
                @endif
            @endif
        @endforeach
        </tbody>
    </table>

    <!-- Bruto and Neto Summary -->
    <table class="table table-bordered ">
        <tr>
            <td><strong>Bruto zarada:</strong></td>
            <td class="text-right">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Poresko oslobođenje:</strong></td>
            <td class="text-right">{{ number_format($zarData->POROSL_poresko_oslobodjenje, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Oporezivi iznos zarade:</strong></td>
            <td class="text-right">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade - $zarData->POROSL_poresko_oslobodjenje, 2, ',', '.') }}</td>
        </tr>
    </table>

    <!-- Net Salary and Deductions -->
    <table class="table table-bordered ">
        <tr>
            <td><strong>Neto zarada:</strong></td>
            <td class="text-right">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade - $zarData->SIP_ukupni_iznos_poreza - $zarData->SID_ukupni_iznos_doprinosa, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Uk. obustave:</strong></td>
            <td class="text-right">{{ number_format($zarData->SIOB_ukupni_iznos_obustava + $zarData->ZARKR_ukupni_zbir_kredita, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Za isplatu:</strong></td>
            <td class="text-right">{{ number_format($zarData->NETO_neto_zarada - $zarData->SIOB_ukupni_iznos_obustava - $zarData->ZARKR_ukupni_zbir_kredita, 2, ',', '.') }}</td>
        </tr>
    </table>

    <!-- Contributions Summary -->
{{--    <table class="table table-bordered">--}}
{{--        <tr>--}}
{{--            --}}{{--                <td><strong>Ukupni Doprinosi</strong></td>--}}
{{--            --}}{{--                <td class="text-right">{{ number_format($zarData->SID_ukupni_iznos_doprinosa, 2, ',', '.') }}</td>--}}
{{--        </tr>--}}
{{--        --}}{{--            <tr>--}}
{{--        --}}{{--                <td><strong>Porez (10%)</strong></td>--}}
{{--        --}}{{--                <td class="text-right">{{ number_format($zarData->SIP_ukupni_iznos_poreza, 2, ',', '.') }}</td>--}}
{{--        --}}{{--            </tr>--}}
{{--        <tr>--}}
{{--            <td><strong>Ukupni porezi i doprinosi na teret radnika</strong></td>--}}
{{--            <td class="text-right">{{ number_format($zarData->SIP_ukupni_iznos_poreza + $zarData->SID_ukupni_iznos_doprinosa, 2, ',', '.') }}</td>--}}
{{--        </tr>--}}
{{--    </table>--}}

    <!-- Employer’s Obligations Section -->
{{--    <table class="table table-bordered">--}}
{{--        <tr>--}}
{{--            <td>Zdravstveno osiguranje (p):</td>--}}
{{--            <td class="text-right">5.15%</td>--}}
{{--            <td class="text-right">{{ number_format($zarData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca, 2, ',', '.') }}</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td>Penzijsko-invalidsko osiguranje (p):</td>--}}
{{--            <td class="text-right">10.00%</td>--}}
{{--            <td class="text-right">{{ number_format($zarData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, ',', '.') }}</td>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <td><strong>Ukupno potrebna sredstva:</strong></td>--}}
{{--            <td></td>--}}
{{--            <td class="text-right">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade + $zarData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca + $zarData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, ',', '.') }}</td>--}}
{{--        </tr>--}}
{{--    </table>--}}

    <p class="text-left"><i>Ovaj dokument je punovažan bez pečata i potpisa.</i></p>
</div>
<footer class="text-center footer">
   <p class="text-left" style="border-top:solid 2px black">AnalizaPlus</p>
</footer>
</body>
</html>
