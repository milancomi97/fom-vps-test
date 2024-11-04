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
        <thead><tr><th class="no_borders header_left half_width"></th><th class="text-center no_borders half_width">Izveštaj kredita po bankama</th><th class="no_borders header_right half_half_width"></th></tr></thead>
        <thead><tr><th class="no_borders header_left half_half_width">{{$podaciFirme['skraceni_naziv_firme']}}</th><th class="no_borders half_width"></th><th class="no_borders header_right half_half_width">Datum štampe: {{date('d')}}.{{date('m')}}.{{date('Y')}}</th></tr></thead>
        <thead><tr><th class="no_borders header_left half_half_width">ZA MESEC:  {{$podaciMesec->datum}}</th><th class="no_borders half_width"></th><th class="no_borders header_right half_half_width"><span class="page-number">Stranica </span></th></tr></thead>
    </table>
    @foreach ($dkopData as $nazivKreditora =>$krediti)
        <h3 class="text-center text-secondary mt-5 custom_border">{{$nazivKreditora}}</h3>
        <table class="table table-bordered mt-2">
            <thead>
            <tr>
                <th>Radnik</th>
                <th>Glavnica</th>
                <th>Saldo</th>
                <th>Rata</th>
                <th>Iznos</th>
            </tr>
            </thead>
            <tbody>
                <?php
                $satiBrojac=0;
                $iznosBrojac=0;
                ?>


            @foreach($krediti as $vrstaPlacanja)
                <tr>
                    <td>{{  $vrstaPlacanja['maticni_broj'] }} {{  $vrstaPlacanja['mdrData']['PREZIME_prezime'] }}  {{  $vrstaPlacanja['mdrData']['srednje_ime'] }}. {{  $vrstaPlacanja['mdrData']['IME_ime'] }}</td>
                    <td class="text-right">{{number_format($vrstaPlacanja['kreditData']['GLAVN_glavnica'],2,'.',',') }}</td>
                    <td class="text-right">{{number_format($vrstaPlacanja['kreditData']['SALD_saldo'],2,'.',',') }}</td>
                    <td class="text-right">{{number_format($vrstaPlacanja['kreditData']['RATA_rata'],2,'.',',') }}</td>
                    <td class="text-right">{{number_format($vrstaPlacanja['iznos'],2,'.',',') }}</td>

                </tr>
                    <?php
                    $satiBrojac+= $vrstaPlacanja['sati'];
                    $iznosBrojac+=$vrstaPlacanja['iznos'];
                    ?>
            @endforeach

            <tr class="bolder">
                <td colspan="4">
                    Ukupno:
                </td>
                <td class="text-right text-danger">{{number_format($iznosBrojac,2,'.',',')}}</td>
            </tr>
            </tbody>
        </table>
    @endforeach

</div>
</body>
</html>
