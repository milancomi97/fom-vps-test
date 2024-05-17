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
        <div class="content" >
            <!-- Content Header (Page header) -->
            <h2 class="text-center">RANG LISTA BRUTO ZARADA po TC-ima</h2>
            <div class="container mt-4 mb-5">
                <h4>ZA MESEC: 0324</h4>

                @foreach($groupedZara as $troskovniCentar)
                    <h4>TROSKOVNI CENTAR:{{$troskovniCentar[0]['org_celina_data']['id']}} {{$troskovniCentar[0]['org_celina_data']['naziv_troskovnog_mesta']}} </h4>
                        <table class="table table-striped mt-3">
                            <thead>
                            <tr>
                                <th onclick="sortTable(0)">Rb</th>
                                <th onclick="sortTable(1)">MB</th>
                                <th onclick="sortTable(2)">Prezime i ime</th>
                                <th onclick="sortTable(3)">Kval.</th>
                                <th onclick="sortTable(4)">Osnovna</th>
                                <th onclick="sortTable(5)">SATI</th>
                                <th onclick="sortTable(6)">BRUTO ZARADA</th>
                                <th onclick="sortTable(7)">NETO ZARADA</th>
                                <th onclick="sortTable(8)">REDOVNI RAD</th>
                                <th onclick="sortTable(9)">PREKOVREMENI RAD</th>
                                <th onclick="sortTable(10)">MINULI RAD</th>
                                <th onclick="sortTable(11)">TOPLI OBROK</th>
                                <th onclick="sortTable(12)">ZA ISPLATU</th>
                            </tr>
                            </thead>
                            <tbody id="table-body">
                            @foreach($troskovniCentar as $radnik)
                            <tr>
                                <td>0</td>
                                <td>{{$radnik->maticni_broj}}</td>
                                <td>{{$radnik->prezime.' '. $radnik->srednje_ime. ' '. $radnik->ime}}</td>
                                <td>KV</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
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
        </div>

        <!-- /.content-wrapper -->
    </div>
@endsection



@section('custom-scripts')
<script>
    function sumColumn(index) {
        let total = 0;
        const rows = document.querySelectorAll("#table-body tr");
        rows.forEach(row => {
            const value = row.cells[index].innerText.replace(',', '').trim();
            total += parseFloat(value);
        });
        return total.toLocaleString();
    }

    window.onload = function() {
        document.getElementById('total-bruto').innerText = sumColumn(6);
        document.getElementById('total-neto').innerText = sumColumn(7);
        document.getElementById('total-redovni').innerText = sumColumn(8);
        document.getElementById('total-prekovremeni').innerText = sumColumn(9);
        document.getElementById('total-minuli').innerText = sumColumn(10);
        document.getElementById('total-topli').innerText = sumColumn(11);
        document.getElementById('total-isplatu').innerText = sumColumn(12);
    };
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

