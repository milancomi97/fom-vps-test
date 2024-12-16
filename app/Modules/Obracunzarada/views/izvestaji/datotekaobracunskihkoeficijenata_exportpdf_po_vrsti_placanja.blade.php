<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prikaz vrste placanja</title>
    <style>
        @page {
            size: A4;
            margin: 5mm;
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


        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }



        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top:0mm;
        }

        .table th, .table td {
            border: 0.5mm solid #000;
            padding: 3mm;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .text-right {
            text-align: right;
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
            top: 0px;
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
    <table class="table table-header no_borders border_bottom">
        <thead><tr><th class="no_borders header_left half_half_width"></th><th class="no_borders half_width">Prikaz vrste placanja: {{ $dkopData[0]['sifra_vrste_placanja'] }} - {{ $dkopData[0]['naziv_vrste_placanja'] }}</th><th class="no_borders header_right half_half_width"></th></tr></thead>
        <thead><tr><th class="no_borders header_left half_half_width">{{$podaciFirme['skraceni_naziv_firme']}}</th><th class="no_borders half_width"></th><th class="no_borders header_right half_half_width">Datum štampe: {{date('d')}}.{{date('m')}}.{{date('Y')}}</th></tr></thead>
        <thead><tr><th class="no_borders header_left half_half_width">ZA MESEC:  {{$podaciMesec->datum}}</th><th class="no_borders half_width"></th><th class="no_borders header_right half_half_width"><span class="page-number">Stranica </span></th></tr></thead>
    </table>
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
                <td>{{ $vrstaPlacanja['maticni_broj'] }} {{ $vrstaPlacanja['mdrData']['PREZIME_prezime'] }}  {{ $vrstaPlacanja['mdrData']['IME_ime'] }}</td>
                <td>{{ $vrstaPlacanja['troskovno_mesto_id'] }}</td>
                <td class="text-right">{{ $vrstaPlacanja['sati'] }}</td>
                <td class="text-right">{{ number_format($vrstaPlacanja['iznos'], 2, ',', '.') }}</td>
            </tr>
            @php
                $satiBrojac += $vrstaPlacanja['sati'];
                $iznosBrojac += $vrstaPlacanja['iznos'];
            @endphp
        @endforeach
        <tr>
            <td colspan="2">Ukupno:</td>
            <td class="text-right"><b>{{ $satiBrojac }}</b></td>
            <td class="text-right"><b>{{ number_format($iznosBrojac, 2, ',', '.') }}</b></td>
            <td colspan="2">
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
