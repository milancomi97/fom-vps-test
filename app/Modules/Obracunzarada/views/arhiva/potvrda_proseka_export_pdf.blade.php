<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Potvrda proseka</title>
    <style>
        @page {
            size: A4;
            margin: 10mm 10mm;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 3mm;
        }
        .cust_bigger_font_size{
            font-size: 5mm !important;
        }
        .cust_top_margin{
            margin-top:10mm !important;
        }
        .disable_top_border td{
            border-top: 0 !important;
            padding: 5px 5px 0px 0px;
        }

        table{
            width: 100%;

        }


        .cust_border{
            border-top: 2px solid lightslategray !important;
            border-bottom: 2px solid lightslategray !important;
            margin-bottom: 5mm;
            margin-top: 5mm;
        }
        .custom_shadow{
            box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;
        }
        .table-bordered td{
            border-left: 0 !important;
            border-right: 0 !important;
        }
        .text-center{
            text-align: center;
        }

        .text-right{
            text-align: right;
        }
        td{
            margin-top: 5mm;
        }

    </style>
</head>
<body>
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
        <td colspan="2" class="text-center"><b>POTVRDA</b></td>
    </tr>
</tbody>
</table>


<table class="table disable_top_border cust_border">
    <tbody>
    <tr>
<td colspan="2">
    Kojom se potvrđuje da je <b>
        {!! $radnikData->prezime !!} {!! $radnikData->srednje_ime !!} . {!! $radnikData->ime !!} ({!! $radnikData->maticni_broj !!})</b>
</td>
    </tr>
    <tr>

        <td colspan="2">
            {!! $mdrData->POL_pol=='Z' ? 'Ostvarila':'Ostvario' !!}  bruto zaradu za period od {!! $datumOd !!} do {!! $datumDo !!}  godine u iznosu od
            {!! number_format($resultData['izneto'],2,',','.') !!} dinara, što prosečno iznosi {!! number_format($resultData['izneto'] /$resultData['brojMeseci'],2,',','.') !!} dinara;
        </td>
    </tr>
    <tr>

        <td colspan="2">
            {!! $mdrData->POL_pol=='Z' ? 'Ostvarila':'Ostvario' !!} neto zaradu za period od {!! $datumOd !!} do {!! $datumDo !!} godine u iznosu od
            {!!  number_format($resultData['neto'],2,',','.') !!} dinara, što prosečno iznosi  {!! number_format($resultData['neto'] /$resultData['brojMeseci'],2,',','.') !!} dinara.
        </td>
    </tr>
    <tr>
        <td  colspan="2">Potvrda se izdaje na lični zahtev, radi regulisanja prava radnika
           <i>{!! $opis !!}</i> i u druge svrhe se ne može upotrebiti.</td>
    </tr>

    </tbody>
</table>
<table class="table cust_top_margin">
    <tbody>
    <tr>
        <td>Referent</td>
        <td class="text-right">Odgovorno lice</td>
    </tr>
    </tbody>
</table>


</body>
</html>
