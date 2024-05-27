<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header, .footer, .footer-potpis {
            background-color: #f1f1f1;
        }
        .header {
            height: 26.4mm;
            line-height: 26.4mm;
            font-size: 6.35mm;
            text-align: center;
            border-width: 0.52mm;
            border-color: #8a8af5;
            border-style: dashed;
            border-bottom-width: 0px;
        }
        .footer {
            height: auto;
            text-align: left;
            line-height: 2.6mm;
            font-size: 2.6mm;
            font-weight: 600;
            border-width: 0.5mm;
            border-color: #8a8af5;
            border-style: dashed;
            border-top-width: 0px;
            border-bottom-width: 0px;
            padding: 2.6mm 0 2.6mm 10mm;
        }
        .content {
            margin: 5.2mm;
            max-width: 261mm;
        }
        .ime_prezime{
            min-width: 61mm;
            text-align:left;
        }
        table {
            border-collapse: collapse;
            page-break-inside: avoid;
            margin-left: 2px;
        }
        th {
            border: 0.26mm solid #000;
            padding: 1mm;
            text-align: center;
            background-color: #f2f2f2;
        }
        td {
            border: 0.26mm solid #000;
            padding: 1mm;
            text-align: center;
        }
        .fieldValues {
            width: 7.8mm;
            text-align: center;
        }
        .footer-opis-code{
            text-align: left;
            border: none !important;
        }
        .footer-potpis-code{
            text-align: left;
            border: none !important;
        }
        .footer-codes-potpis{
            margin-top: 10mm;
        }
        .footer-potpis-code{
            font-size: 4mm;
            font-weight: 700;
            line-height: 10mm;
        }
    </style>
</head>
<body>
@foreach ($mesecnaTabelaPotenrazaTable as $key => $organizacionacelina)
    @if (isset($troskovnaMestaPermission[$key]) && $troskovnaMestaPermission[$key])
        <div class="content">
            <div class="header">
                Organizaciona celina: <b>{{ $key }}</b> - {{ $organizacionacelina[0]->organizacionecelina->naziv_troskovnog_mesta }}
            </div>
            <table class="table table-striped">
                <thead>
                <tr>
                    @foreach ($tableHeaders as $index => $header)
                        <th class="{{ $index == 2 ? 'ime_prezime' : '' }}">{{ $header }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach ($organizacionacelina as $value)
                    <tr>
                        <td>{{ $value['maticni_broj'] }}</td>
                        <td class="ime_prezime">{{ $value['ime'] }}</td>
                        @foreach ($value['vrste_placanja'] as $vrstaPlacanja)
                            <td class="vrsta_placanja_td">
                                        <span class="fieldValues" data-record-id="{{ $value['id'] }}" min="0" disabled="disabled" class="vrsta_placanja_input" data-toggle="tooltip" data-placement="top" title="{{ $vrstaPlacanja['name'] }}" data-vrsta-placanja-key="{{ $vrstaPlacanja['key'] }}">
                                            {{ $vrstaPlacanja['sati'] }}
                                        </span>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="footer">
                <div class="footer-codes">
                    {!! $vrstePlacanjaDescription !!}
                </div>
{{--                <div class="footer-codes-potpis">--}}
                <div class="footer-potpis-code"> Poenter________________<br><br>
                @foreach(json_decode($organizacionacelina[0]->organizacionecelina->odgovorni_direktori_pravila,true) as $data)
                        <br>{{$data}}
                @endforeach
                </div>

{{--                    {!! $this->resolvePotpisPoentaze(json_decode($organizacionacelina[0]->organizacionecelina->odgovorni_direktori_pravila, true)) !!}--}}
{{--                </div>--}}
</div>
</div>
@endif
@endforeach
</body>
</html>
