<?php use App\Modules\Obracunzarada\Consts\UserRoles; ?>
    <!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style>
        @page {
            size: A4 portrait;
            margin: 5mm;
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
        .text-left{
            text-align: left;
            padding-left: 2mm;
        }
        .text-right{
            text-align: right;
            padding-right: 2mm;
        }

        .page-number:after { content: counter(page); }
        .page-break {
            page-break-before: always;
        }

        .borderless{
            border-width: 0 !important;
            background-color: white;
            height: 20mm!important;
        }
    </style>

</head>
<body>
<div class="table-container">
    <h4>ZA MESEC: 0324</h4>
{{--    {{$pageNumber}}--}}
{{--    {{$PAGE_NUM}}--}}


@foreach($bankeDataZara as $key=>  $troskovnoMesto)
{{--        <h4 style="text-align: center;margin-top: 20px">{{$key}} - {{$isplatnaMestaSifarnika[$key]['naim_naziv_isplatnog_mesta']}} </h4>--}}
{{--        <script type="text/php">$PAGE_NUM</script>--}}
            <span class="page-number">Stranica </span>
        <table class="table table-striped mt-3">
            <thead>
            <tr >
                <th class="borderless" colspan="2">Podaci o firmi da se ponavlja test</th>
                <th class="borderless" colspan="2">Podaci o firmi da se ponavlja test</th>
            </tr>
            <tr >
                <th class="borderless" colspan="4"></th>
            </tr>
            <tr>
                <th colspan="4">{{$key}} - {{$isplatnaMestaSifarnika[$key]['naim_naziv_isplatnog_mesta']}} </th>
            </tr>
            <tr>
                <th>Maticni broj</th>
                <th>Prezime i ime</th>
                <th>Za isplatu</th>
                <th>Broj računa</th>
            </tr>
            </thead>
            <tbody id="table-body">
                <?php
                $i=1;
                ?>
                @foreach($troskovnoMesto as $radnik)
                    <tr>
                        <td class="text-left">{{ $radnik['maticni_broj']  }}</td>
                        <td class="text-left">{{ $radnik['prezime']  }} . {{ $radnik['ime']  }}</td>
                        <td class="text-right">{{ number_format($radnik['UKIS_ukupan_iznos_za_izplatu'], 2, '.', ',')  }}</td>
                        <td  class="text-right">{{ $radnik['maticnadatotekaradnika']['ZRAC_tekuci_racun']  }}</td>
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
