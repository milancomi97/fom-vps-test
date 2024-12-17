<?php use App\Modules\Obracunzarada\Consts\UserRoles; ?>

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <style>
        .error {
            border: 1px solid red;
        }

        .infoAcc {
            margin-bottom: 0;
        }

        #errorContainer {
            color: red;
            text-align: center;
            font-size: 2em;
            margin-bottom: 2em;
        }
        th{
            min-width: 100px;

        }
        td{
            min-width: 100px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="content" >
            <!-- Content Header (Page header) -->
            <h2 class="text-center">RANG LISTA BRUTO ZARADA po TC-ima</h2>
            <div class="row mb-3">
                <div class="col-sm-4"></div>
                <div class="col-sm-2 text-right">

                    <form method="POST" class="d-inline" action="{{route('datotekaobracunskihkoeficijenata.stampa_rang_liste_excel')}}">
                        @csrf
                        <input type="hidden" name="month_id" value="{{$month_id}}">
                        <button type="submit" class="btn mt-5 btn-secondary btn-lg" id="print-page">Excel &nbsp;&nbsp;<i class="fa fa-print fa-2xl " aria-hidden="true"></i></button>
                    </form>
                </div>
                <div class="col-sm-2 text-right">

                    <form method="POST" class="d-inline" action="{{route('datotekaobracunskihkoeficijenata.stampa_rang_liste')}}">
                        @csrf
                        <input type="hidden" name="month_id" value="{{$month_id}}">
                        <button type="submit" class="btn mt-5 btn-secondary btn-lg" id="print-page">PDF &nbsp;&nbsp;<i class="fa fa-print fa-2xl " aria-hidden="true"></i></button>
                    </form>
                </div>
                <div class="col-sm-1 text-right">
                </div>
                <div class="col col-sm-3 text-right">
                    <form method="POST" class="" action="{{route('datotekaobracunskihkoeficijenata.email_rang_liste')}}">
                        @csrf
                        <div class="input-group">
                            <button type="submit" class="btn mt-5 btn-secondary btn-lg" style="width: 200px" id="print-page">Pošalji email &nbsp;&nbsp;<i class="fa fa-envelope fa-2xl " aria-hidden="true"></i></button>
                            <input type="hidden" name="month_id" value="{{$month_id}}">
                            <label>
                                <input type="email" class="form-control mt-2" style="width: 200px" name="email_to" placeholder="Email primaoca">
                            </label>
                        </div>

                    </form>
                </div>
            </div>
            <div class="container mt-4 mb-5">
                <h4>ZA MESEC: {{$datum->format('m.Y.')}}</h4>

                @foreach($groupedZara as $troskovniCentar)
                    <h4 class="mt-5 text-center">TROSKOVNI CENTAR:{{$troskovniCentar[0]['org_celina_data']['id']}} {{$troskovniCentar[0]['org_celina_data']['naziv_troskovnog_mesta']}} </h4>
                        <table class="table table-striped mt-3">
                            <thead>
                            <tr>
{{--                                <th onclick="sortTable(0)">Rb</th>--}}
{{--                                <th onclick="sortTable(1)">MB</th>--}}
{{--                                <th onclick="sortTable(2)">Prezime i ime</th>--}}
{{--                                <th onclick="sortTable(3)">Kval.</th>--}}
{{--                                <th onclick="sortTable(4)">Osnovna</th>--}}
{{--                                <th onclick="sortTable(5)">SATI</th>--}}
{{--                                <th onclick="sortTable(6)">BRUTO ZARADA</th>--}}
{{--                                <th onclick="sortTable(7)">NETO ZARADA</th>--}}
{{--                                <th onclick="sortTable(8)">REDOVNI RAD</th>--}}
{{--                                <th onclick="sortTable(9)">PREKOVREMENI RAD</th>--}}
{{--                                <th onclick="sortTable(10)">MINULI RAD</th>--}}
{{--                                <th onclick="sortTable(11)">TOPLI OBROK</th>--}}
{{--                                <th onclick="sortTable(12)">ZA ISPLATU</th>--}}
                                <th >Rb</th>
                                <th >MB</th>
                                <th >Prezime i ime</th>
                                <th >Kval.</th>
                                <th >Osnovna</th>
                                <th >SATI</th>
                                <th >BRUTO ZARADA</th>
                                <th >NETO ZARADA</th>
                                <th >REDOVNI RAD</th>
                                <th >PREKOVREMENI RAD</th>
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
                                <td>{{$radnik->prezime. ' '. $radnik->ime}}</td>
                                <td>{{$strucneKvalifikacijeSifarnik[$radnik->maticnadatotekaradnika->RBPS_priznata_strucna_sprema]['skraceni_naziv_kvalifikacije'] ?? ''}}</td>
{{--                                <td>{{$MDR->KOEF}}</td>--}}
                                 <td>{{number_format($radnik->maticnadatotekaradnika->KOEF_osnovna_zarada,2,',','.')}}</td>
                                <td>{{$radnik->UKSA_ukupni_sati_za_isplatu}}</td>
                                <td>{{number_format($radnik->IZNETO_zbir_ukupni_iznos_naknade_i_naknade,2,',','.')}}</td>
                                <td>{{number_format($radnik->NETO_neto_zarada,2,',','.')}}</td>
                                <td>{{number_format($radnik->EFIZNO_kumulativ_iznosa_za_efektivne_sate/$minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto,2,',','.')}}</td>
                                <td>{{number_format($radnik->BMIN_prekovremeni_iznos,2,',','.')}}</td>
                                <td>{{number_format($radnik->varijab/$minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto,2,',','.')}}</td>
                                <td>{{number_format($radnik->TOPLI_obrok_iznos/$minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto,2,',','.')}}</td>
                                <?php
                                   $zaIsplatu= $radnik->NETO_neto_zarada-$radnik->SIOB_ukupni_iznos_obustava-$radnik->ZARKR_ukupni_zbir_kredita
                                    ?>
                                <td>{{number_format($zaIsplatu,2,',','.')}}</td>
                               <?php
                                $sum_KOEF_osnovna_zarada+=$radnik->maticnadatotekaradnika->KOEF_osnovna_zarada;
                                $sum_UKSA_ukupni_sati_za_isplatu+=$radnik->UKSA_ukupni_sati_za_isplatu;
                                $sum_IZNETO_zbir_ukupni_iznos_naknade_i_naknade+=$radnik->IZNETO_zbir_ukupni_iznos_naknade_i_naknade;
                                $sum_NETO_neto_zarada+=$radnik->NETO_neto_zarada;
                                $sum_EFIZNO_kumulativ_iznosa_za_efektivne_sate+=$radnik->EFIZNO_kumulativ_iznosa_za_efektivne_sate/$minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto;
                                $sum_BMIN_prekovremeni_iznos+=$radnik->BMIN_prekovremeni_iznos;
                                $sum_varijab+=$radnik->varijab/$minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto;
                                $sum_TOPLI_obrok_iznos+=$radnik->TOPLI_obrok_iznos/$minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto;
                                $sum_ZA_ISPLATU_NETO_neto_zarada+=$radnik->NETO_neto_zarada-$radnik->SIOB_ukupni_iznos_obustava-$radnik->ZARKR_ukupni_zbir_kredita;
                                ?>
                            </tr>
                                @endif

                                @if(auth()->user()->permission->role_id==UserRoles::SUPERVIZOR)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$radnik->maticni_broj}}</td>
                                        <td>{{$radnik->prezime.' '. $radnik->ime}}</td>
                                        <td>{{$strucneKvalifikacijeSifarnik[$radnik->maticnadatotekaradnika->RBPS_priznata_strucna_sprema]['skraceni_naziv_kvalifikacije'] ?? ''}}</td>
                                        {{--                                <td>{{$MDR->KOEF}}</td>--}}
                                        <td>{{$radnik->maticnadatotekaradnika->KOEF_osnovna_zarada}}</td>
                                        <td>{{$radnik->UKSA_ukupni_sati_za_isplatu}}</td>
                                        <td>{{number_format($radnik->IZNETO_zbir_ukupni_iznos_naknade_i_naknade,2,',','.')}}</td>
                                        <td>{{number_format($radnik->NETO_neto_zarada,2,',','.')}}</td>
                                        <td>{{number_format($radnik->EFIZNO_kumulativ_iznosa_za_efektivne_sate/$minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto,2,',','.')}}</td>
                                        <td>{{number_format($radnik->BMIN_prekovremeni_iznos,2,',','.')}}</td>
                                        <td>{{number_format($radnik->varijab/$minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto,2,',','.')}}</td>
                                        <td>{{number_format($radnik->TOPLI_obrok_iznos/$minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto,2,',','.')}}</td>
                                        <td>{{number_format($radnik->NETO_neto_zarada-$radnik->SIOB_ukupni_iznos_obustava-$radnik->ZARKR_ukupni_zbir_kredita,2,',','.')}}</td>
                                            <?php
                                            $sum_KOEF_osnovna_zarada+=$radnik->maticnadatotekaradnika->KOEF_osnovna_zarada;
                                            $sum_UKSA_ukupni_sati_za_isplatu+=$radnik->UKSA_ukupni_sati_za_isplatu;
                                            $sum_IZNETO_zbir_ukupni_iznos_naknade_i_naknade+=$radnik->IZNETO_zbir_ukupni_iznos_naknade_i_naknade;
                                            $sum_NETO_neto_zarada+=$radnik->NETO_neto_zarada+=$radnik->NETO_neto_zarada;
                                            $sum_EFIZNO_kumulativ_iznosa_za_efektivne_sate+=$radnik->EFIZNO_kumulativ_iznosa_za_efektivne_sate/$minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto;
                                            $sum_BMIN_prekovremeni_iznos+=$radnik->BMIN_prekovremeni_iznos;
                                            $sum_varijab+=$radnik->varijab/$minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto;
                                            $sum_TOPLI_obrok_iznos+=$radnik->TOPLI_obrok_iznos/$minimalneBrutoOsnoviceSifarnik->STOPA1_koeficijent_za_obracun_neto_na_bruto;
                                            $sum_ZA_ISPLATU_NETO_neto_zarada+=$radnik->NETO_neto_zarada-$radnik->SIOB_ukupni_iznos_obustava-$radnik->ZARKR_ukupni_zbir_kredita;
                                            ?>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr style="font-weight: 700;">
                                <td colspan="4"> UKUPNO ZA TROSKOVNI CENTAR:   </td>
                                <td>{{number_format($sum_KOEF_osnovna_zarada,2,',','.')}}</td>
                                <td>{{number_format($sum_UKSA_ukupni_sati_za_isplatu,2,',','.')}}</td>
                                <td>{{number_format($sum_IZNETO_zbir_ukupni_iznos_naknade_i_naknade,2,',','.')}}</td>
                                <td>{{number_format($sum_NETO_neto_zarada,2,',','.')}}</td>
                                <td>{{number_format($sum_EFIZNO_kumulativ_iznosa_za_efektivne_sate,2,',','.')}}</td>
                                <td>{{number_format($sum_BMIN_prekovremeni_iznos,2,',','.')}}</td>
                                <td>{{number_format($sum_varijab,2,',','.')}}</td>
                                <td>{{number_format($sum_TOPLI_obrok_iznos,2,',','.')}}</td>
                                <td>{{number_format($sum_ZA_ISPLATU_NETO_neto_zarada,2,',','.')}}</td>
                            </tr>
                            </tfoot>
                        </table>

                @endforeach
            </div>
        </div>

        <!-- /.content-wrapper -->
    </div>
@endsection



@section('custom-scripts')
<script>

    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.querySelector(".table");
        switching = true;
        dir = "asc";
        while (switching) {
            switching = false;
            rows = table.querySelectorAll("tbody tr"); // Only select rows within the tbody
            for (i = 0; i < (rows.length - 1); i++) {  // Adjust loop to account for tbody specific indexing
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }

</script>
@endsection

