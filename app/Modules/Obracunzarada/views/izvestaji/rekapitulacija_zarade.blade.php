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
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">

                <div class="container mt-4">
                    <h2 class="text-center">Rekapitulacija Ostvarene Zarade</h2>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th onclick="sortTable(0)">VP</th>
                            <th onclick="sortTable(1)">Naziv vrste placanja</th>
                            <th onclick="sortTable(2)">Sati</th>
                            <th onclick="sortTable(3)">Iznos</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($dkopData as $vrstaPlacanja)
                        <tr>
                            <td>{{$vrstaPlacanja->sifra_vrste_placanja}}</td>
                            <td>{{$vrstaPlacanja->naziv_vrste_placanja}}</td>
                            <td>{{number_format($vrstaPlacanja->sati)}}</td>
                            <td>{{number_format($vrstaPlacanja->iznos, 2, '.', ',')}}</td>


                        </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="container mt-5">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td >1. BRUTO ZARADA</td>
                            <td></td>
                            <td>{{number_format($zaraData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td >- IZNOS PORESKOG OSLOBODJENJA</td>
                            <td></td>r
                            <td>{{number_format($zaraData->POROSL_poresko_oslobodjenje, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td >- OPOREZIVI IZNOS ZARADE</td>
                            <td></td>
                            <td>{{number_format($zaraData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade -$zaraData->POROSL_poresko_oslobodjenje, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td >2. NETO ZARADA (1-5)</td>
                            <td></td>
                            <td>{{number_format($zaraData->NETO_neto_zarada , 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td >3. UK. OBUSTAVE</td>
                            <td></td>
                            <td>{{number_format($zaraData->SIOB_ukupni_iznos_obustava +  $zaraData->ZARKR_ukupni_zbir_kredita, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td >4. ZA ISPLATU (1-5-3)</td>
                            <td></td>
                            <td>{{number_format($zaraData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade -  $zaraData->SIP_ukupni_iznos_poreza - $zaraData->SID_ukupni_iznos_doprinosa - $zaraData->SIOB_ukupni_iznos_obustava - $zaraData->ZARKR_ukupni_zbir_kredita, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td >UKUPNI DOPRINOSI</td>
                            <td></td>
                            <td>{{number_format($zaraData->SID_ukupni_iznos_doprinosa, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td>050 POREZ (10%)</td>
                            <td></td>
                            <td>{{number_format($zaraData->SIP_ukupni_iznos_poreza, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td >5. UKUPNI POREZI I DOPRINOSI (a+b)</td>
                            <td></td>
                            <td>{{number_format($zaraData->SIP_ukupni_iznos_poreza + $zaraData->SID_ukupni_iznos_doprinosa, 2, '.', ',')}}</td>
                        </tr>

                        <tr>
                            <td >6. OBAVEZE NA TERET POSLODAVCA: </td>
                            <td></td>
                            <td></td>

                        </tr>
                        <tr>
                            <td >Zdravstveno osiguranje (p)</td>
                            <td></td>
                            <td>{{number_format($zaraData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td >Penzijsko-invalidsko osig. (p)</td>
                            <td></td>
                            <td>{{number_format($zaraData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td >Ukupni doprinosi</td>
                            <td></td>
                            <td>{{number_format($zaraData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca + $zaraData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td >7. UKUPNA BRUTO ZARADA:</td>
                            <td></td>
                            <td>{{number_format($zaraData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade +$zaraData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca + $zaraData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</td>

                        </tr>
                        <tr>
                            <td >12. BROJ AKTIVNIH RADNIKA:</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td >13. BROJ RADNIKA SA ZARADOM:</td>
                            <td></td>
                            <td></td>
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

