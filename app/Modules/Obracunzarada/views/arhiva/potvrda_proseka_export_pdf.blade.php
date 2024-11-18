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
        .disable_top_border td{
            border-top: 0 !important;
            padding: 5px 0px 0px 0px;
        }

        table{
            width: 100%;

        }

        .cust_border{
            border-top: 2px solid lightslategray !important;
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
        <td  class="pl-4"  ><strong>{{ $podaciFirme['skraceni_naziv_firme'] }} </strong>  </td>

        <td class="text-right">Datum: {{ $datumStampe }}</td>
    </tr>
    <tr>
        <td colspan="2">
            <img src="{{asset('images/company/logo2.jpg')}}" width="50mm" style="margin-left: 10mm" height="auto">
        </td>
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
    Kojom se potvrdjuje da je <b>
        {!! $radnikData->prezime !!}   {!! $radnikData->srednje_ime !!}. {!! $radnikData->imme !!} ({!! $radnikData->maticni_broj !!})</b>
</td>
    </tr>
    <tr>

        <td colspan="2">
            ostvario-la bruto zaradu za period od {!! $datumOd !!} do {!! $datumDo !!}  godine u iznosu od
            {!! number_format($resultData['izneto'],2,'.',',') !!} dinara, sto prosecno iznosi {!! number_format($resultData['izneto'] /$resultData['brojMeseci'],2,'.',',') !!}dinara;
        </td>
    </tr>
    <tr>

        <td colspan="2">
            ostvario-la neto zaradu za period od {!! $datumOd !!} do {!! $datumDo !!} godine u iznosu od
            {!!  number_format($resultData['neto'],2,'.',',') !!} dinara, sto prosecno iznosi  {!! number_format($resultData['neto'] /$resultData['brojMeseci'],2,'.',',') !!} dinara.
        </td>
    </tr>
    <tr>
        <td  colspan="2">Potvrda se izdaje na licni zahtev, radi regulisanja prava radnika
            "{!! $opis !!}" i u druge svrhe se ne moze upotrebiti.</td>
    </tr>

    </tbody>
</table>
<table class="table cust_border">
    <tbody>
    <tr>
        <td>Referent</td>
        <td class="text-right">Odgovorno lice</td>
    </tr>
    </tbody>
</table>




{{--<div class="container">--}}
{{--    <div class="content">--}}
{{--        <h1 class="text-center mt-5">Potvrda proseka</h1>--}}
{{--        <h2 class="text-center mt-5">{{ $radnikData->maticni_broj }} {{ $radnikData->prezime }} {{ $radnikData->ime }}</h2>--}}
{{--        <h2 class="text-center mt-5"><b>{{ $datumOd }} - {{ $datumDo }}</b></h2>--}}

{{--        <table class="table text-center table-striped table-bordered mt-5 mb-5 mt-3">--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                <th>#</th>--}}
{{--                @php--}}
{{--                    $counter = 1;--}}
{{--                @endphp--}}
{{--                @foreach($resultData as $key => $data)--}}
{{--                    @if(is_array($data))--}}
{{--                        <th class="text-center">{{ $counter++ }}</th>--}}
{{--                    @endif--}}
{{--                @endforeach--}}
{{--            </tr>--}}

{{--            <tr>--}}
{{--                <th>Datum:</th>--}}
{{--                @foreach($resultData as $data)--}}
{{--                    @if(is_array($data))--}}
{{--                        <th>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $data['datum'])->startOfMonth()->format('m.Y') }}</th>--}}
{{--                    @endif--}}
{{--                @endforeach--}}
{{--                <th>Ukupno:</th>--}}
{{--                <th>Prosek:</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            <tr>--}}
{{--                <td><b>Izneto:</b></td>--}}
{{--                @foreach($resultData as $data)--}}
{{--                    @if(is_array($data))--}}
{{--                        <td>{{ number_format($data['IZNETO'], 2, '.', ',') }}</td>--}}
{{--                    @endif--}}
{{--                @endforeach--}}
{{--                <td>{{ number_format($resultData['izneto'], 2, '.', ',') }}</td>--}}
{{--                <td><b>{{ number_format($resultData['izneto'] / ($counter - 1), 2, '.', ',') }}</b></td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td><b>Neto:</b></td>--}}
{{--                @foreach($resultData as $data)--}}
{{--                    @if(is_array($data))--}}
{{--                        <td>{{ number_format($data['NETO'], 2, '.', ',') }}</td>--}}
{{--                    @endif--}}
{{--                @endforeach--}}
{{--                <td>{{ number_format($resultData['neto'], 2, '.', ',') }}</td>--}}
{{--                <td><b>{{ number_format($resultData['neto'] / ($counter - 1), 2, '.', ',') }}</b></td>--}}
{{--            </tr>--}}
{{--            </tbody>--}}
{{--        </table>--}}
{{--    </div>--}}
{{--</div>--}}
</body>
</html>
