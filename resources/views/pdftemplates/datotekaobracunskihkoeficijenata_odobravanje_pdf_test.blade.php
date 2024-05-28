<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 5px; text-align: center; font-size: 2mm }
        th { background-color: #f2f2f2; }
        .page-break { page-break-before: always; }
        thead { display: table-header-group; }
        tfoot { display: table-footer-group; }
    </style>
</head>
<body>
@php
    $rowsPerPage = 35; // Adjust this value based on your layout
    $rowCount = count($rows);
    $pages = ceil($rowCount / $rowsPerPage);
@endphp

@for($page = 0; $page < $pages; $page++)
    <h1 style="text-align: center">Dynamic Table Header <b>PAGE:{{$page+1}}</b></h1>
    <table>
        <thead>
        <tr>
            <th style="min-width: 10mm;text-align:center;">Maticni</th>
            <th style="min-width: 25mm;text-align:left;">Prezime Srednje ime</th>
            <th>SVP</th>
            <th>SVP</th>
            <th>SVP</th>
            <th>SVP</th>
            <th>SVP</th>
            <th>SVP</th>
            <th>SVP</th>
            <th>SVP</th>
            <th>SVP</th>
            <th>SVP</th>
            <th>SVP</th>
            <th>SVP</th>
            <th>SVP</th>
            <th>SVP</th>
            <th>SVP</th>
            <th>SVP</th>
            <th>SVP</th>
            <th>SVP</th>
            <th>SVP</th>
            <th>SVP</th>

        </tr>
        </thead>
        <tbody>
        @for($i = $page * $rowsPerPage; $i < ($page + 1) * $rowsPerPage && $i < $rowCount; $i++)
            <tr>
                <td>{{ $rows[$i]['column1'] }}</td>
                <td style="text-align:left;"><b>{{ $rows[$i]['column2'] }}</b></td>
                <td>{{ $rows[$i]['column3'] }}</td>
                <td>{{ $rows[$i]['column4'] }}</td>
                <td>{{ $rows[$i]['column5'] }}</td>
                <td>{{ $rows[$i]['column6'] }}</td>
                <td>{{ $rows[$i]['column7'] }}</td>
                <td>{{ $rows[$i]['column8'] }}</td>
                <td>{{ $rows[$i]['column9'] }}</td>
                <td>{{ $rows[$i]['column10'] }}</td>
                <td>{{ $rows[$i]['column11'] }}</td>
                <td>{{ $rows[$i]['column12'] }}</td>
                <td>{{ $rows[$i]['column13'] }}</td>
                <td>{{ $rows[$i]['column14'] }}</td>
                <td>{{ $rows[$i]['column15'] }}</td>
                <td>{{ $rows[$i]['column16'] }}</td>
                <td>{{ $rows[$i]['column17'] }}</td>
                <td>{{ $rows[$i]['column18'] }}</td>
                <td>{{ $rows[$i]['column19'] }}</td>
                <td>{{ $rows[$i]['column20'] }}</td>
                <td>{{ $rows[$i]['column21'] }}</td>
                <td>{{ $rows[$i]['column22'] }}</td>
            </tr>
        @endfor
        </tbody>
    </table>
    <h1 style="text-align: center">Dynamic Table Footer</h1>
    @if($page < $pages - 1)
        <div class="page-break"></div>
    @endif
@endfor

</body>
</html>
