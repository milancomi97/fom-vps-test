<?php use App\Modules\Obracunzarada\Consts\UserRoles; ?>
    <!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        @page {
            size: A4 portrait;
            margin: 5mm;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
        }
        .disable_top_border td{
            border-top: 0 !important;
            padding: 5px 0px 0px 0px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /*table-layout: fixed;*/
        }

        th, td {
            border: 1px solid #000;
            padding: 2px 1px;
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
    @foreach($bankeDataZara as $key=>  $troskovnoMesto)
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
            <tr >
                <th class="borderless" colspan="4"></th>
            </tr>
            <tr>
                <th colspan="4" class="text-left">Isplatno mesto: {{$key}} - {{$isplatnaMestaSifarnika[$key]['naim_naziv_isplatnog_mesta']}} </th>
            </tr>
            <tr>
            <tr>
                <th>Matični broj
                </th>
                <th>
                    Prezime i ime
                </th>
                <th>
                    Za Isplatu
                </th>
                <th>
                    Tekući račun
                </th>
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
                        <td class="text-left">{{ $radnik['prezime']  }} {{ $radnik['srednje_ime']  }} . {{ $radnik['ime']  }}</td>
                        <td class="text-right">{{ number_format($radnik['UKIS_ukupan_iznos_za_izplatu'], 2, '.', ',')  }}</td>
                        <td  class="text-right">{{ $radnik['maticnadatotekaradnika']['ZRAC_tekuci_racun']  }}</td>
                            <?php $iznosPoBanciCounter+=$radnik['UKIS_ukupan_iznos_za_izplatu']; ?>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2"> UKUPNO ZA ISPLATNO MESTO:   </td>
                <td  class="text-right"><b>{{ number_format($iznosPoBanciCounter, 2, '.', ',') }}</b></td>
                <td></td>
            </tr>
            </tfoot>
        </table>

        <div class="page-break"></div>

    @endforeach
</div>
</body>
</html>
