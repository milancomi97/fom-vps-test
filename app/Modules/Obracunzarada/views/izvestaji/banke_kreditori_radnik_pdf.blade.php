<?php use App\Modules\Obracunzarada\Consts\UserRoles; ?>
    <!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        @page {
            size: A4 portrait;
            margin-top: 2mm;
            margin-right: 5mm;
            margin-bottom: 10mm;
            margin-left: 5mm;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /*table-layout: fixed;*/
        }

        th, td {
            border: 1px solid #000;
            padding: 2px 1px;
            text-align: center
        }

        th {
            background-color: #f2f2f2;
        }

        .table-container {
            width: 100%;
            max-width: 200mm; /* A4 width in mm minus margins */
        }

        .radnik_name{
            min-width: 100px;
            text-align: left;
            padding: 5px 5px 5px 5px;
        }
        .page-number:after { content: counter(page); }
        .page-break {
            page-break-before: always;
        }

        .text-left{
            text-align: left;
            padding-left: 2mm;
        }
        .text-right{
            text-align: right;
            padding-right: 2mm;
        }
        .text-bottom{
            vertical-align: bottom;
        }
        .text-top{
            vertical-align: top;
        }
        .borderless{
            border-width: 2px !important;
            background-color: hotpink;
            height: 20mm!important;
        }

        .disable_top_border td{
            border: 0 !important;
            padding: 5px 5px 0px 0px;
        }

        .disable_top_border tr,th{
            border: 0 !important;
        }
    </style>

</head>
<body>
<div class="table-container">
    @foreach($kreditiDataZara as $key=> $troskovnoMesto)
        {{--        <h4 style="text-align: center;margin-top: 20px">{{$key}} - {{$isplatnaMestaSifarnika[$key]['naim_naziv_isplatnog_mesta']}} </h4>--}}
        {{--        <script type="text/php">$PAGE_NUM</script>--}}
        <table class="table disable_top_border ">
            <tbody>
            <tr>
                <td colspan="2">
                    <img src="{{asset('images/company/logo2.jpg')}}" width="50mm" style="margin-left: 5mm" height="auto">
                </td>
            </tr>
            <tr>
                <td  class="pl-4"  ><strong>{{ $podaciFirme['skraceni_naziv_firme'] }} </strong>  </td>

                <td class="text-right">Datum: {{ $datumStampe }}</td>
            </tr>
            <tr>
                <td colspan="2" class="text-right"><span class="page-number">Strana: </span>
                </td>
            </tr>
            </tbody>
        </table>

        <table class="table table-striped mt-3">
            <thead>
            <tr>
                <th colspan="4">{{$key}} - {{$kreditoriSifarnik[$key]['imek_naziv_kreditora']}} </th>
            </tr>
            <tr>
                <th>Matični broj</th>
                <th>Prezime i ime</th>
                <th>Partija</th>
                <th>Odbijeno</th>
                <th>Ostatak</th>
            </tr>
            </thead>
            <tbody id="table-body">
                <?php
                $i=1;
                $iznosPoBanciCounter=0;
                ?>
            @foreach($troskovnoMesto as $radnik)
                <tr>
                    <td class="text-left">{{ $radnik['maticni_broj']  }}</td>
                    <td class="text-left">{{ $mdrSifarnik[$radnik['maticni_broj']]['PREZIME_prezime']  }} {{$mdrSifarnik[$radnik['maticni_broj']]['srednje_ime']}}. {{ $mdrSifarnik[$radnik['maticni_broj']]['IME_ime']  }}</td>
                    <td class="text-right">{{$radnik['PART_partija_kredita']  }}</td>
                    <td class="text-right">{{ number_format($radnik['iznos'], 2, ',', '.')  }}</td>
                    <td class="text-right">{{ number_format($radnik['SALD_saldo'], 2, ',', '.')  }}</td>
                                                <?php $iznosPoBanciCounter+=$radnik['iznos']; ?>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2"></td>
                <td colspan="2" class="text-right"> UKUPNO: <b>{!! number_format($iznosPoBanciCounter,2, ',', '.') !!} </b> </td>
                <td></td>
            </tr>
            </tfoot>
        </table>

        <div class="page-break"></div>

    @endforeach
</div>
</body>
</html>
