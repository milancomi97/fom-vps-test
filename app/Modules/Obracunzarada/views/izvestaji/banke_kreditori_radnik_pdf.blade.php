<?php use App\Modules\Obracunzarada\Consts\UserRoles; ?>
    <!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style>
        @page {
            size: A4 portrait;
            margin-top: 2mm;
            margin-right: 5mm;
            margin-bottom: 10mm;
            margin-left: 5mm;
        }

        body {
            font-family: Arial, sans-serif;
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
            margin: 0 auto;
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
    </style>

</head>
<body>
<span class="page-number">Strana </span>

<div class="table-container">
    @foreach($kreditiDataZara as $key=> $troskovnoMesto)
        {{--        <h4 style="text-align: center;margin-top: 20px">{{$key}} - {{$isplatnaMestaSifarnika[$key]['naim_naziv_isplatnog_mesta']}} </h4>--}}
        {{--        <script type="text/php">$PAGE_NUM</script>--}}
        <table class="table table-striped mt-3">
            <thead>
            <tr >
                <th class="borderless" colspan="4"><span class="page-number">Stranica </span></th>
            </tr>
            <tr >
                <th class="borderless text-left" colspan="2">Podaci o firmi da se ponavlja test</th>
                <th class="borderless text-right" colspan="2">Podaci o firmi da se ponavlja test</th>
            </tr>
            <tr >
                <th class="borderless text-top" colspan=""><span>layout sa 3 kolone</span></th>
                <th class="borderless" colspan=""><span>layout sa 3 kolone</span></th>
                <th class="borderless text-bottom" colspan="2"><span>layout sa 3 kolone</span></th>
            </tr>
            <tr>
                <th colspan="4">{{$key}} - {{$kreditoriSifarnik[$key]['imek_naziv_kreditora']}} </th>
            </tr>
            <tr>
                <th>Matični broj</th>
                <th>Prezime i ime</th>
                <th>Iznos rate</th>
                <th>Saldo duga</th>
            </tr>
            </thead>
            <tbody id="table-body">
                <?php
                $i=1;
                ?>
            @foreach($troskovnoMesto as $radnik)
                <tr>
                    <td class="text-left">{{ $radnik['maticni_broj']  }}</td>
                    <td class="text-left">{{ $mdrSifarnik[$radnik['maticni_broj']]['PREZIME_prezime']  }} {{$mdrSifarnik[$radnik['maticni_broj']]['srednje_ime']}}. {{ $mdrSifarnik[$radnik['maticni_broj']]['IME_ime']  }}</td>
                    <td class="text-right">{{ number_format($radnik['iznos'], 2, '.', ',')  }}</td>
                    <td class="text-right">{{ number_format($radnik['SALD_saldo'], 2, '.', ',')  }}</td>
                    {{--                            <?php $iznosPoBanciCounter+=$radnik['UKIS_ukupan_iznos_za_izplatu']; ?>--}}
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td> UKUPNO ZA TROSKOVNI CENTAR:   </td>
                <td> UKUPNO ZA TROSKOVNI CENTAR:   </td>

            </tr>
            </tfoot>
        </table>

        <div class="page-break"></div>

    @endforeach
</div>
</body>
</html>
