<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prikaz vrste placanja</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            margin: 0;
            padding: 0;
        }

        h1, h2, h3, h4, h5, h6 {
            margin-top: 5mm;
            margin-bottom: 5mm;
            text-align: center;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .btn {
            display: inline-block;
            padding: 4mm 8mm;
            margin: 4mm 0;
            font-size: 10pt;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 2mm;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10mm;
        }

        .table th, .table td {
            border: 1mm solid #000;
            padding: 3mm;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
<h3 class="text-center mt-1">Prikaz vrste placanja:</h3>
<h1 class="text-center mt-1">{{ $dkopData[0]['sifra_vrste_placanja'] }} - {{ $dkopData[0]['naziv_vrste_placanja'] }}</h1>

<h3 class="text-center mt-1">{{ $datum }}</h3>
<div class="container">
    <table class="table table-bordered mt-5">
        <thead>
        <tr>
            <th>Radnik</th>
            <th>Organizaciona celina</th>
            <th>Sati</th>
            <th>Iznos</th>
        </tr>
        </thead>
        <tbody>
        @php
            $satiBrojac = 0;
            $iznosBrojac = 0;
        @endphp
        @foreach($dkopData as $vrstaPlacanja)
            <tr>
                <td>{{ $vrstaPlacanja['maticni_broj'] }} {{ $vrstaPlacanja['mdrData']['PREZIME_prezime'] }} {{ $vrstaPlacanja['mdrData']['srednje_ime'] }}. {{ $vrstaPlacanja['mdrData']['IME_ime'] }}</td>
                <td>{{ $vrstaPlacanja['troskovno_mesto_id'] }}</td>
                <td class="text-right">{{ $vrstaPlacanja['sati'] }}</td>
                <td class="text-right">{{ number_format($vrstaPlacanja['iznos'], 2, '.', ',') }}</td>
            </tr>
            @php
                $satiBrojac += $vrstaPlacanja['sati'];
                $iznosBrojac += $vrstaPlacanja['iznos'];
            @endphp
        @endforeach
        <tr>
            <td colspan="2">Ukupno:</td>
            <td class="text-right">{{ $satiBrojac }}</td>
            <td class="text-right">{{ number_format($iznosBrojac, 2, '.', ',') }}</td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
