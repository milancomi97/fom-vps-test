<?php use App\Modules\Obracunzarada\Consts\UserRoles; ?>
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
            /*margin-top: 15mm;*/
            /*table-layout: fixed;*/
        }

        th, td {
            border: 1px solid #000;
            padding: 0px 1px;
            text-align: center;
            font-size: 2.5mm;

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

        .header_left{
            text-align: left;
        }
        .header_right{
            text-align: right;
        }


        .page-break {
            page-break-before: always;
        }

        .page-number:after { content: counter(page); }

        .half_width{
            width: 50%;
        }

        .half_half_width{
            width: 25%;
        }

        .full_width{
            width: 100%;
        }
        header {
            position: fixed;
            top: 5px;
            left: 0px;
            right: 0px;
            height: 50px;


        }
        .no_borders{
            border-width: 0 !important;
        }
        .full_width {
            text-align: left; /* Or center, if you prefer */
            padding: 0;
            margin: 0;
        }



        footer {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            height: 50px;
        }

        </style>


</head>
<body>
<div class="container">
</div>
<header>
    <table class="table table-header no_borders border_bottom">
        <thead><tr><th class="no_borders header_left half_half_width"></th><th class="no_borders half_width">RANG LISTA BRUTO ZARADA po TC-ima</th><th class="no_borders header_right half_half_width"></th></tr></thead>
        <thead><tr><th class="no_borders header_left half_half_width">{{$podaciFirme['skraceni_naziv_firme']}}</th><th class="no_borders half_width"></th><th class="no_borders header_right half_half_width">Datum štampe: {{date('d')}}.{{date('m')}}.{{date('Y')}}</th></tr></thead>
        <thead><tr><th class="no_borders header_left half_half_width">ZA MESEC:  {{$podaciMesec->datum}}</th><th class="no_borders half_width"></th><th class="no_borders header_right half_half_width"><span class="page-number">Stranica </span></th></tr></thead>
    </table>
</header>
            <div class="table-container">
                <main>
                    <?php $breakCounter=0; ?>
                @foreach($groupedZara as $troskovniCentar)
                    <h4 style="text-align: center;margin-top: 15mm">TROSKOVNI CENTAR:{{$troskovniCentar[0]['org_celina_data']['id']}} {{$troskovniCentar[0]['org_celina_data']['naziv_troskovnog_mesta']}} </h4>
                        <table class="table table-striped mt-3">
                            <thead>
                            <tr>
                                <th >Rb</th>
                                <th >MB</th>
                                <th>Prezime i ime</th>
                                <th >Kval.</th>
                                <th >Osnovna</th>
                                <th >SATI</th>
                                <th >BRUTO ZARADA</th>
                                <th >NETO ZARADA</th>
                                <th >REDOVNI RAD</th>
                                <th >PREK. RAD</th>
                                <th >MINULI RAD</th>
                                <th >TOPLI OBROK</th>
                                <th >ZA ISPLATU</th>
                            </tr>
                            </thead>
                            <tbody id="table-body">
                                <?php
                                $i=1;
                                $sum_KOEF_osnovna_zarada =$sum_UKSA_ukupni_sati_za_isplatu =$sum_IZNETO_zbir_ukupni_iznos_naknade_i_naknade =$sum_NETO_neto_zarada =$sum_EFIZNO_kumulativ_iznosa_za_efektivne_sate=$sum_BMIN_prekovremeni_iznos =$sum_PREK_prekovremeni =$sum_varijab =$sum_TOPLI_obrok_iznos =$sum_ZA_ISPLATU_NETO_neto_zarada =0;
                                ?>
                            @foreach($troskovniCentar as $radnik)
                                @if($radnik->maticnadatotekaradnika->BRCL_redosled_poentazi > 100)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$radnik->maticni_broj}}</td>
                                <td class="radnik_name">{{$radnik->prezime.' '. $radnik->srednje_ime. '. '. $radnik->ime}}</td>
                                <td>{{$strucneKvalifikacijeSifarnik[$radnik->maticnadatotekaradnika->RBPS_priznata_strucna_sprema]['skraceni_naziv_kvalifikacije'] ?? ''}}</td>
{{--                                <td>{{$strucneKvalifikacijeSifarnik[$radnik->maticnadatotekaradnika->RBPS_priznata_strucna_sprema]['naziv_kvalifikacije'] ?? ''}}</td>--}}
{{--                                <td>{{$MDR->KOEF}}</td>--}}
                                 <td>{{number_format($radnik->maticnadatotekaradnika->KOEF_osnovna_zarada,2,'.',',')}}</td>
                                <td>{{$radnik->UKSA_ukupni_sati_za_isplatu}}</td>
                                <td>{{number_format($radnik->IZNETO_zbir_ukupni_iznos_naknade_i_naknade,2,'.',',')}}</td>
                                <td>{{number_format($radnik->NETO_neto_zarada,2,'.',',')}}</td>
                                <td>{{number_format($radnik->EFIZNO_kumulativ_iznosa_za_efektivne_sate/$minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto,2,'.',',')}}</td>
                                <td>{{number_format($radnik->BMIN_prekovremeni_iznos,2,'.',',')}}</td>
                                <td>{{number_format($radnik->varijab,2,'.',',')}}</td>
                                <td>{{number_format($radnik->TOPLI_obrok_iznos/$minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto,2,'.',',')}}</td>
                                <td>{{number_format($radnik->NETO_neto_zarada-$radnik->SIOB_ukupni_iznos_obustava-$radnik->ZARKR_ukupni_zbir_kredita,2,'.',',')}}</td>
                                    <?php
                                    $sum_KOEF_osnovna_zarada+=$radnik->maticnadatotekaradnika->KOEF_osnovna_zarada;
                                    $sum_UKSA_ukupni_sati_za_isplatu+=$radnik->UKSA_ukupni_sati_za_isplatu;
                                    $sum_IZNETO_zbir_ukupni_iznos_naknade_i_naknade+=$radnik->IZNETO_zbir_ukupni_iznos_naknade_i_naknade;
                                    $sum_NETO_neto_zarada+=$radnik->NETO_neto_zarada;
                                    $sum_EFIZNO_kumulativ_iznosa_za_efektivne_sate+=$radnik->EFIZNO_kumulativ_iznosa_za_efektivne_sate/$minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto;
                                    $sum_BMIN_prekovremeni_iznos+=$radnik->BMIN_prekovremeni_iznos;
                                    $sum_varijab+=$radnik->varijab;
                                    $sum_TOPLI_obrok_iznos+=$radnik->TOPLI_obrok_iznos/$minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto;
                                    $sum_ZA_ISPLATU_NETO_neto_zarada+=$radnik->NETO_neto_zarada-$radnik->SIOB_ukupni_iznos_obustava-$radnik->ZARKR_ukupni_zbir_kredita;
                                    ?>
                            </tr>
                                @endif

                                @if(auth()->user()->permission->role_id==UserRoles::SUPERVIZOR)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$radnik->maticni_broj}}</td>
                                        <td>{{$radnik->prezime.' '. $radnik->srednje_ime. ' '. $radnik->ime}}</td>
                                        <td>{{$strucneKvalifikacijeSifarnik[$radnik->maticnadatotekaradnika->RBPS_priznata_strucna_sprema]['naziv_kvalifikacije'] ?? ''}}</td>
                                        {{--                                <td>{{$MDR->KOEF}}</td>--}}
                                        <td>{{$radnik->maticnadatotekaradnika->KOEF_osnovna_zarada}}</td>
                                        <td>{{$radnik->UKSA_ukupni_sati_za_isplatu}}</td>
                                        <td>{{number_format($radnik->IZNETO_zbir_ukupni_iznos_naknade_i_naknade,2, '.', ',')}}</td>
                                        <td>{{number_format($radnik->NETO_neto_zarada,2, '.', ',')}}</td>
                                        <td>{{number_format($radnik->EFIZNO_kumulativ_iznosa_za_efektivne_sate/$minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto,2, '.', ',')}}</td>
                                        <td>{{$radnik->PREK_prekovremeni}}</td>
                                        <td>{{number_format($radnik->varijab,2, '.', ',')}}</td>
                                        <td>{{number_format($radnik->TOPLI_obrok_iznos/$minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto,2, '.', ',')}}</td>
                                        <td>{{number_format($radnik->NETO_neto_zarada-$radnik->SIOB_ukupni_iznos_obustava-$radnik->ZARKR_ukupni_zbir_kredita,2, '.', ',')}}</td>
                                            <?php
                                            $sum_KOEF_osnovna_zarada+=$radnik->maticnadatotekaradnika->KOEF_osnovna_zarada;
                                            $sum_UKSA_ukupni_sati_za_isplatu+=$radnik->UKSA_ukupni_sati_za_isplatu;
                                            $sum_IZNETO_zbir_ukupni_iznos_naknade_i_naknade+=$radnik->IZNETO_zbir_ukupni_iznos_naknade_i_naknade;
                                            $sum_NETO_neto_zarada+=$radnik->NETO_neto_zarada+=$radnik->NETO_neto_zarada;
                                            $sum_EFIZNO_kumulativ_iznosa_za_efektivne_sate+=$radnik->EFIZNO_kumulativ_iznosa_za_efektivne_sate/$minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto;
                                            $sum_BMIN_prekovremeni_iznos+=$radnik->BMIN_prekovremeni_iznos;
                                            $sum_varijab+=$radnik->varijab;
                                            $sum_TOPLI_obrok_iznos+=$radnik->TOPLI_obrok_iznos/$minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto;
                                            $sum_ZA_ISPLATU_NETO_neto_zarada+=$radnik->NETO_neto_zarada-$radnik->SIOB_ukupni_iznos_obustava-$radnik->ZARKR_ukupni_zbir_kredita;
                                            ?>
                                    </tr>
                                @endif
                                <?php $breakCounter++; ?>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr style="font-weight: 700;">
                                <td colspan="4"> UKUPNO ZA TROSKOVNI CENTAR:   </td>
                                <td>{{number_format($sum_KOEF_osnovna_zarada,2,'.',',')}}</td>
                                <td>{{number_format($sum_UKSA_ukupni_sati_za_isplatu,2,'.',',')}}</td>
                                <td>{{number_format($sum_IZNETO_zbir_ukupni_iznos_naknade_i_naknade,2,'.',',')}}</td>
                                <td>{{number_format($sum_NETO_neto_zarada,2,'.',',')}}</td>
                                <td>{{number_format($sum_EFIZNO_kumulativ_iznosa_za_efektivne_sate,2,'.',',')}}</td>
                                <td>{{number_format($sum_BMIN_prekovremeni_iznos,2,'.',',')}}</td>
                                <td>{{number_format($sum_varijab,2,'.',',')}}</td>
                                <td>{{number_format($sum_TOPLI_obrok_iznos,2,'.',',')}}</td>
                                <td>{{number_format($sum_ZA_ISPLATU_NETO_neto_zarada,2,'.',',')}}</td>
                            </tr>
                            </tfoot>
                        </table>
{{--                        <div class="page-break"></div>--}}
                            <?php if ($breakCounter > 20): ?>
                        <div class="page-break"></div>
                            <?php $breakCounter = 0; ?>
                        <?php endif; ?>

                    @endforeach
                </main>

            </div>
<footer class="text-center">
    Footer prostor
    <span class="page-number">Stranica </span>
</footer>
</body>
</html>
