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
        .bolder{
            font-weight: 700;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">

                <div class="container mt-4">
                    <h2 class="text-center">Rekapitulacija Ostvarene Zarade</h2>
                    <h2 class="text-center">{{$datum}}</h2>

                    <div class="row mb-3">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-2 text-right">

                            <form method="POST" class="d-inline" action="{{route('datotekaobracunskihkoeficijenata.stampa_ostvarene_zarade')}}">
                                @csrf
                                <input type="hidden" name="month_id" value="{{$month_id}}">

                                <button type="submit" class="btn mt-5 btn-secondary btn-lg" id="print-page">Excel &nbsp;&nbsp;<i class="fa fa-print fa-2xl " aria-hidden="true"></i></button>
                            </form>
                        </div>
                        <div class="col-sm-2 text-right">

                        <form method="POST" class="d-inline" action="{{route('datotekaobracunskihkoeficijenata.stampa_ostvarene_zarade')}}">
                        @csrf
                            <input type="hidden" name="month_id" value="{{$month_id}}">

                            <button type="submit" class="btn mt-5 btn-secondary btn-lg" id="print-page">PDF &nbsp;&nbsp;<i class="fa fa-print fa-2xl " aria-hidden="true"></i></button>
                    </form>
                        </div>
                        <div class="col-sm-1"></div>

                        <div class="col col-sm-3 text-right">
                            <form method="POST" class="" action="{{route('datotekaobracunskihkoeficijenata.email_ostvarene_zarade')}}">
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
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th onclick="sortTable(0)">VP</th>
                            <th onclick="sortTable(1)">Naziv vrste placanja</th>
                            <th class="text-right" onclick="sortTable(2)">Sati</th>
                            <th class="text-right" onclick="sortTable(3)">Iznos</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $ukupanPrihod=0;
                        ?>
                        @foreach($dkopData as $vrstaPlacanja)

                            @if($vrstePlacanjaSifarnik[$vrstaPlacanja->sifra_vrste_placanja]['KESC_prihod_rashod_tip']=='P')
                        <tr>
                            <td>{{$vrstaPlacanja->sifra_vrste_placanja}}</td>
                            <td>{{$vrstaPlacanja->naziv_vrste_placanja}}</td>
                            <td class="text-right">{{number_format($vrstaPlacanja->sati)}}</td>
                            <td class="text-right">{{number_format($vrstaPlacanja->iznos, 2, '.', ',')}}</td>
                        </tr>
                                <?php
                            $ukupanPrihod+=$vrstaPlacanja->iznos;
                                    ?>
                            @endif


                        @endforeach
                        <tr style="border-top:2px solid black">
                            <td></td>
                            <td></td>
                            <td>Bruto zarada:</td>
                            <td class="text-right"><b>{{number_format($ukupanPrihod, 2, '.', ',')}}</b></td>
                        </tr>

                        <?php
                        $ukupniPorezi=0;
                        ?>
                        @foreach($dkopData as $vrstaPlacanja)

                            @if($vrstePlacanjaSifarnik[$vrstaPlacanja->sifra_vrste_placanja]['KESC_prihod_rashod_tip']=='R' &&$vrstePlacanjaSifarnik[$vrstaPlacanja->sifra_vrste_placanja]['SLOV_grupe_vrsta_placanja']=='P')
                                <tr>
                                    <td>{{$vrstaPlacanja->sifra_vrste_placanja}}</td>
                                    <td>{{$vrstaPlacanja->naziv_vrste_placanja}}</td>
                                    <td class="text-right">{{number_format($vrstaPlacanja->sati)}}</td>
                                    <td class="text-right">{{number_format($vrstaPlacanja->iznos, 2, '.', ',')}}</td>
                                    <?php
                                    $ukupniPorezi+=$vrstaPlacanja->iznos;
                                    ?>
                            @endif


                        @endforeach
                        <tr style="border-top:2px solid black">
                            <td></td>
                            <td></td>
                            <td><b>Ukupni doprinosi na teret radnika:</b></td>
                            <td class="text-right"><b>{{number_format($ukupniPorezi, 2, '.', ',')}}</b></td>
                        </tr>

                        <?php
                        $ukupniPoreziLicnaPrimanja=0;
                        ?>

                        @foreach($dkopData as $vrstaPlacanja)

                            @if($vrstePlacanjaSifarnik[$vrstaPlacanja->sifra_vrste_placanja]['KESC_prihod_rashod_tip']=='R'  &&$vrstePlacanjaSifarnik[$vrstaPlacanja->sifra_vrste_placanja]['SLOV_grupe_vrsta_placanja']==='U')
                                <tr>
                                    <td>{{$vrstaPlacanja->sifra_vrste_placanja}}</td>
                                    <td>{{$vrstaPlacanja->naziv_vrste_placanja}}</td>
                                    <td class="text-right">{{number_format($vrstaPlacanja->sati)}}</td>
                                    <td class="text-right">{{number_format($vrstaPlacanja->iznos, 2, '.', ',')}}</td>
                                    <?php
                                   $ukupniPoreziLicnaPrimanja+=$vrstaPlacanja->iznos;
                                    ?>
                            @endif

                        @endforeach


                        <tr style="border-top:2px solid black">
                            <td></td>
                            <td></td>
                            <td><b>Ukupan porez na lična primanja:</b></td>
                            <td class="text-right"><b>{{number_format($ukupniPoreziLicnaPrimanja, 2, '.', ',')}}</b></td>
                        </tr>

                        <?php
                        $ukupniRashod=0;
                        ?>

                            @foreach($dkopData as $vrstaPlacanja)

                                @if($vrstePlacanjaSifarnik[$vrstaPlacanja->sifra_vrste_placanja]['KESC_prihod_rashod_tip']=='R' && $vrstePlacanjaSifarnik[$vrstaPlacanja->sifra_vrste_placanja]['SLOV_grupe_vrsta_placanja']!=='P' && $vrstePlacanjaSifarnik[$vrstaPlacanja->sifra_vrste_placanja]['SLOV_grupe_vrsta_placanja']!=='U')
                            <tr>
                                <td>{{$vrstaPlacanja->sifra_vrste_placanja}}</td>
                                <td>{{$vrstaPlacanja->naziv_vrste_placanja}}</td>
                                <td class="text-right">{{number_format($vrstaPlacanja->sati)}}</td>
                                <td class="text-right">{{number_format($vrstaPlacanja->iznos, 2, '.', ',')}}</td>
                                <?php
                                 $ukupniRashod+=$vrstaPlacanja->iznos;
                                ?>
                                @endif

                            @endforeach
                            <tr style="border-top:2px solid black">
                                <td></td>
                                <td></td>
                                <td><b>Ukupne obustave:</b></td>
                                <td class="text-right"><b>{{number_format($ukupniRashod, 2, '.', ',')}}</b></td>
                            </tr>


                        </tbody>
                    </table>
                </div>


                <div class="container mt-5">
                    <table class="table table-bordered">
                        <tbody>
                        <tr class="bolder">
                            <td >1. BRUTO ZARADA</td>
                            <td></td>
                            <td class="text-right">{{number_format($zaraData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td >- IZNOS PORESKOG OSLOBODJENJA</td>
                            <td></td>r
                            <td class="text-right">{{number_format($zaraData->POROSL_poresko_oslobodjenje, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td >- OPOREZIVI IZNOS ZARADE</td>
                            <td></td>
                            <td class="text-right">{{number_format($zaraData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade -$zaraData->POROSL_poresko_oslobodjenje, 2, '.', ',')}}</td>
                        </tr>
                        <tr class="bolder">
                            <td >2. NETO ZARADA (1-5)</td>
                            <td></td>
                            <td class="text-right">{{number_format($zaraData->NETO_neto_zarada , 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td >3. UK. OBUSTAVE</td>
                            <td></td>
                            <td class="text-right">{{number_format($zaraData->SIOB_ukupni_iznos_obustava +  $zaraData->ZARKR_ukupni_zbir_kredita, 2, '.', ',')}}</td>
                        </tr>
                        <tr class="bolder">
                            <td >4. ZA ISPLATU</td>
                            <td></td>
                            <td class="text-right">{{number_format($zaraData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade -  $zaraData->SIP_ukupni_iznos_poreza - $zaraData->SID_ukupni_iznos_doprinosa - $zaraData->SIOB_ukupni_iznos_obustava - $zaraData->ZARKR_ukupni_zbir_kredita, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td >UKUPNI DOPRINOSI</td>
                            <td></td>
                            <td class="text-right">{{number_format($zaraData->SID_ukupni_iznos_doprinosa, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td >050 POREZ (10%)</td>
                            <td></td>
                            <td class="text-right">{{number_format($zaraData->SIP_ukupni_iznos_poreza, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td >5. Ukupni porezi i doprinosi na teret radnika</td>
                            <td></td>
                            <td class="text-right">{{number_format($zaraData->SIP_ukupni_iznos_poreza + $zaraData->SID_ukupni_iznos_doprinosa, 2, '.', ',')}}</td>
                        </tr>

                        <tr>
                            <td >6. Ukupni doprinosi na teret poslodavca: </td>
                            <td></td>
                            <td></td>

                        </tr>
                        <tr>
                            <td >Zdravstveno osiguranje (p)</td>
                            <td></td>
                            <td class="text-right">{{number_format($zaraData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td >Penzijsko-invalidsko osig. (p)</td>
                            <td></td>
                            <td class="text-right">{{number_format($zaraData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td >Ukupni doprinosi</td>
                            <td></td>
                            <td class="text-right">{{number_format($zaraData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca + $zaraData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</td>
                        </tr>
                        <tr class="bolder">
                            <td >7. Potrebna sredstva (BRUTO II):</td>
                            <td></td>
                            <td class="text-right">{{number_format($zaraData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade +$zaraData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca + $zaraData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</td>

                        </tr>
                        <tr>
                            <td >12. BROJ AKTIVNIH RADNIKA:</td>
                            <td></td>
                            <td class="text-right">{{$aktivnihRadnika}}</td>
                        </tr>
                        <tr>
                            <td >13. BROJ RADNIKA SA ZARADOM:</td>
                            <td></td>
                            <td class="text-right">{{$radnikaSaZaradom}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
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
            dir = "asc"; // Set the sorting direction to ascending initially
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
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

