<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Potvrda proseka</title>
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 180mm;
            margin: 0 auto;
        }

        .content {
            margin: 0;
        }

        h1, h2 {
            margin-top: 5mm;
            margin-bottom: 5mm;
            text-align: center;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10mm;
            margin-bottom: 10mm;
        }

        .table th, .table td {
            border: 0.5mm solid #000;
            padding: 3mm;
            text-align: center;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <h1 class="text-center mt-5">Potvrda proseka</h1>
        <h2 class="text-center mt-5">{{ $radnikData->maticni_broj }} {{ $radnikData->prezime }} {{ $radnikData->ime }}</h2>
        <h2 class="text-center mt-5"><b>{{ $datumOd }} - {{ $datumDo }}</b></h2>

        <table class="table text-center table-striped table-bordered mt-5 mb-5 mt-3">
            <thead>
            <tr>
                <th>#</th>
                @php
                    $counter = 1;
                @endphp
                @foreach($resultData as $key => $data)
                    @if(is_array($data))
                        <th class="text-center">{{ $counter++ }}</th>
                    @endif
                @endforeach
            </tr>

            <tr>
                <th>Datum:</th>
                @foreach($resultData as $data)
                    @if(is_array($data))
                        <th>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $data['datum'])->startOfMonth()->format('m.Y') }}</th>
                    @endif
                @endforeach
                <th>Ukupno:</th>
                <th>Prosek:</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><b>Izneto:</b></td>
                @foreach($resultData as $data)
                    @if(is_array($data))
                        <td>{{ number_format($data['IZNETO'], 2, '.', ',') }}</td>
                    @endif
                @endforeach
                <td>{{ number_format($resultData['izneto'], 2, '.', ',') }}</td>
                <td><b>{{ number_format($resultData['izneto'] / ($counter - 1), 2, '.', ',') }}</b></td>
            </tr>
            <tr>
                <td><b>Neto:</b></td>
                @foreach($resultData as $data)
                    @if(is_array($data))
                        <td>{{ number_format($data['NETO'], 2, '.', ',') }}</td>
                    @endif
                @endforeach
                <td>{{ number_format($resultData['neto'], 2, '.', ',') }}</td>
                <td><b>{{ number_format($resultData['neto'] / ($counter - 1), 2, '.', ',') }}</b></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
