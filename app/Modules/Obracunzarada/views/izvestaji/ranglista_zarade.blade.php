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
                    <h4>TROSKOVNI CENTAR:32250000 MASINSKA OBRADA </h4>
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
                            <tr>
                                <td>57</td>
                                <td>0006702</td>
                                <td>DJURIC D. NIKOLA</td>
                                <td>KV</td>
                                <td>65,091.01</td>
                                <td>184</td>
                                <td>72,488.94</td>
                                <td>53,314.75</td>
                                <td>41,480.73</td>
                                <td>5,807.30</td>
                                <td>0.00</td>
                                <td>1,980.18</td>
                                <td>53,314.75</td>
                            </tr>

                            <tr>
                                <td>42</td>
                                <td>0008900</td>
                                <td>Nikola Jovanović</td>
                                <td>BGZZ</td>
                                <td>34,511.54</td>
                                <td>210</td>
                                <td>56,284.15</td>
                                <td>40,211.34</td>
                                <td>25,120.89</td>
                                <td>4,839.25</td>
                                <td>0.00</td>
                                <td>1,054.29</td>
                                <td>40,211.34</td>
                            </tr>
                            <tr>
                                <td>19</td>
                                <td>0003450</td>
                                <td>Zarko Petrović</td>
                                <td>XLVV</td>
                                <td>52,334.70</td>
                                <td>198</td>
                                <td>72,340.10</td>
                                <td>51,908.47</td>
                                <td>35,642.53</td>
                                <td>5,017.42</td>
                                <td>0.00</td>
                                <td>2,450.65</td>
                                <td>51,908.47</td>
                            </tr>
                            <tr>
                                <td>35</td>
                                <td>0005210</td>
                                <td>Marko Nikolić</td>
                                <td>CRRS</td>
                                <td>40,223.99</td>
                                <td>165</td>
                                <td>66,548.21</td>
                                <td>45,300.78</td>
                                <td>39,847.19</td>
                                <td>3,500.12</td>
                                <td>0.00</td>
                                <td>2,100.73</td>
                                <td>45,300.78</td>
                            </tr>
                            <tr>
                                <td>51</td>
                                <td>0006230</td>
                                <td>Darko Đorđević</td>
                                <td>DSXX</td>
                                <td>48,999.88</td>
                                <td>190</td>
                                <td>74,820.47</td>
                                <td>58,117.60</td>
                                <td>42,855.20</td>
                                <td>6,712.98</td>
                                <td>0.00</td>
                                <td>2,811.05</td>
                                <td>58,117.60</td>
                            </tr>
                            <tr>
                                <td>29</td>
                                <td>0007780</td>
                                <td>Aleksandar Stojanović</td>
                                <td>FGBB</td>
                                <td>37,588.42</td>
                                <td>175</td>
                                <td>63,881.34</td>
                                <td>47,955.11</td>
                                <td>33,668.54</td>
                                <td>5,342.37</td>
                                <td>0.00</td>
                                <td>1,679.11</td>
                                <td>47,955.11</td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td>0002450</td>
                                <td>Jelena Pavlović</td>
                                <td>HZZV</td>
                                <td>53,750.14</td>
                                <td>162</td>
                                <td>79,230.88</td>
                                <td>60,024.56</td>
                                <td>44,019.04</td>
                                <td>7,204.19</td>
                                <td>0.00</td>
                                <td>3,601.22</td>
                                <td>60,024.56</td>
                            </tr>
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

