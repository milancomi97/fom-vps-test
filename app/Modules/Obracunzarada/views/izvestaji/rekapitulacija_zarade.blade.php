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
                        <tr>
                            <td>001</td>
                            <td>TEKUCI RAD-osn.zarad</td>
                            <td>97.282,00</td>
                            <td>53.866.429,31</td>
                        </tr>
                        <tr>
                            <td>002</td>
                            <td>PREKOVREMENI RAD</td>
                            <td>16.526,00</td>
                            <td>12.145.614,72</td>
                        </tr>
                        <tr>
                            <td>004</td>
                            <td>NOCNI RAD-26%</td>
                            <td>0,00</td>
                            <td>146.885,33</td>
                        </tr>
                        <tr>
                            <td>005</td>
                            <td>MINULI RAD</td>
                            <td>0,00</td>
                            <td>4.901.105,79</td>
                        </tr>
                        <tr>
                            <td>007</td>
                            <td>VISINSKI (3-10M)</td>
                            <td>0,00</td>
                            <td>273.840,00</td>
                        </tr>
                        <tr>
                            <td>008</td>
                            <td>VISINSKI (11-20M)</td>
                            <td>0,00</td>
                            <td>144.000,00</td>
                        </tr>
                        <tr>
                            <td>009</td>
                            <td>GODISNJI ODMOR</td>
                            <td>4.688,00</td>
                            <td>2.386.361,96</td>
                        </tr>
                        <tr>
                            <td>010</td>
                            <td>PLACENO ODSUSTVO100%</td>
                            <td>576,00</td>
                            <td>296.891,55</td>
                        </tr>
                        <tr>
                            <td>012</td>
                            <td>BOLOVANJE 65%</td>
                            <td>3.464,00</td>
                            <td>974.545,35</td>
                        </tr>
                        <tr>
                            <td>013</td>
                            <td>BOLOVANJE 100%</td>
                            <td>432,00</td>
                            <td>224.089,14</td>
                        </tr>
                        <tr>
                            <td>014</td>
                            <td>BOLOV. PREKO 30 DANA</td>
                            <td>0,00</td>
                            <td>0,00</td>
                        </tr>
                        <tr>
                            <td>015</td>
                            <td>BOLOV. BEZ DOZNAKE</td>
                            <td>0,00</td>
                            <td>0,00</td>
                        </tr>
                        <tr>
                            <td>017</td>
                            <td>OPRAVDANI IZOSTANCI</td>
                            <td>0,00</td>
                            <td>0,00</td>
                        </tr>
                        <tr>
                            <td>018</td>
                            <td>NEOPRAVDANI IZOSTAN.</td>
                            <td>0,00</td>
                            <td>0,00</td>
                        </tr>
                        <tr>
                            <td>019</td>
                            <td>TOPLI OBROK - NOVAC</td>
                            <td>0,00</td>
                            <td>1.812.478,35</td>
                        </tr>
                        <tr>
                            <td>070</td>
                            <td>RAZLIKA PLATE</td>
                            <td>0,00</td>
                            <td>132.505,72</td>
                        </tr>
                        <tr>
                            <td>087</td>
                            <td>PORODILJSKO ODSUSTVO</td>
                            <td>0,00</td>
                            <td>0,00</td>
                        </tr>
                        <tr>
                            <td>410</td>
                            <td>DOTACIJA DO MBZ</td>
                            <td>0,00</td>
                            <td>237.802,53</td>
                        </tr>
                        <tr>
                            <td>458</td>
                            <td>RENTA</td>
                            <td>0,00</td>
                            <td>37.942,10</td>
                        </tr>
                        <!-- Add more rows here -->
                        </tbody>
                    </table>
                </div>


                <div class="container mt-5">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td >1. BRUTO ZARADA</td>
                            <td>122.968,00</td>
                            <td>77.580.491,83</td>
                        </tr>
                        <tr>
                            <td >- IZNOS PORESKOG OSLOBODJENJA</td>
                            <td>15.876.041,66</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td >- OPOREZIVI IZNOS ZARADE</td>
                            <td>61.704.450,17</td>
                            <td>15.876.041,66</td>

                        </tr>
                        <tr>
                            <td >2. NETO ZARADA (1-5)</td>
                            <td>122.968,00</td>
                            <td>55.971.528,87</td>
                        </tr>
                        <tr>
                            <td >3. UK. OBUSTAVE</td>
                            <td>3.785.996,21</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td >4. ZA ISPLATU (1-5-3)</td>
                            <td>52.185.532,66</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td >UKUPNI DOPRINOSI</td>
                            <td>0,0</td>
                            <td>15.438.517,92</td>
                        </tr>
                        <tr>
                            <td>050 POREZ (10%)</td>
                            <td>0,0</td>
                            <td>6.170.445,04</td>
                        </tr>
                        <tr>
                            <td >5. UKUPNI POREZI I DOPRINOSI (a+b)</td>
                            <td>21.608.962,96</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>UKUPNO:</td>
                            <td>30</td>
                            <td>612</td>
                        </tr>
                        <tr>
                            <td >6. OBAVEZE NA TERET POSLODAVCA: Zdravstveno osiguranje (p)</td>
                            <td>5.15%</td>
                            <td>3995395</td>
                        </tr>
                        <tr>
                            <td >Penzijsko-invalidsko osig. (p)</td>
                            <td>10.00%</td>
                            <td>7758049</td>
                        </tr>
                        <tr>
                            <td >Ukupni doprinosi</td>
                            <td>11753445</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td >7. UKUPNA BRUTO ZARADA:</td>
                            <td>89333936,38</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td >12. BROJ AKTIVNIH RADNIKA:</td>
                            <td>668</td>
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

