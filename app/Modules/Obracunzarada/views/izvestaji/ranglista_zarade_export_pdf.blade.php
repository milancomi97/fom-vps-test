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
            /*table-layout: fixed;*/
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
        </style>

</head>
<body>
            <div class="table-container">
                <h4>ZA MESEC: 0324</h4>
                @foreach($groupedZara as $troskovniCentar)
                    <h4 style="text-align: center;margin-top: 20px">TROSKOVNI CENTAR:{{$troskovniCentar[0]['org_celina_data']['id']}} {{$troskovniCentar[0]['org_celina_data']['naziv_troskovnog_mesta']}} </h4>
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
                                ?>
                            @foreach($troskovniCentar as $radnik)
                                @if($radnik->maticnadatotekaradnika->BRCL_redosled_poentazi > 100)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$radnik->maticni_broj}}</td>
                                <td class="radnik_name">{{$radnik->prezime.' '. $radnik->srednje_ime. ' '. $radnik->ime}}</td>
                                <td>skrati</td>
{{--                                <td>{{$strucneKvalifikacijeSifarnik[$radnik->maticnadatotekaradnika->RBPS_priznata_strucna_sprema]['naziv_kvalifikacije'] ?? ''}}</td>--}}
{{--                                <td>{{$MDR->KOEF}}</td>--}}
                                 <td>{{number_format($radnik->maticnadatotekaradnika->KOEF_osnovna_zarada,2,'.',',')}}</td>
                                <td>{{$radnik->UKSA_ukupni_sati_za_isplatu}}</td>
                                <td>{{number_format($radnik->IZNETO_zbir_ukupni_iznos_naknade_i_naknade,2,'.',',')}}</td>
                                <td>{{number_format($radnik->NETO_neto_zarada,2,'.',',')}}</td>
                                <td>{{number_format($radnik->EFIZNO_kumulativ_iznosa_za_efektivne_sate/$minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto,2,'.',',')}}</td>
                                <td>{{$radnik->PREK_prekovremeni}}</td>
                                <td>{{number_format($radnik->varijab,2,'.',',')}}</td>
                                <td>{{number_format($radnik->TOPLI_obrok_iznos/$minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto,2,'.',',')}}</td>
                                <td>{{number_format($radnik->NETO_neto_zarada-$radnik->SIOB_ukupni_iznos_obustava-$radnik->ZARKR_ukupni_zbir_kredita,2,'.',',')}}</td>
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
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="6"> UKUPNO ZA TROSKOVNI CENTAR:   </td>
                                <td id="total-bruto"></td>
                                <td id="total-neto"></td>
                                <td id="total-redovni"></td>
                                <td id="total-prekovremeni"></td>
                                <td id="total-minuli"></td>
                                <td id="total-topli"></td>
                                <td id="total-isplatu"></td>
                            </tr>
                            </tfoot>
                        </table>
                @endforeach
            </div>
</body>
</html>
