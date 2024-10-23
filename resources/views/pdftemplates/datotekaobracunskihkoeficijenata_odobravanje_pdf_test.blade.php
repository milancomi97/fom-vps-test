<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5mm;
            margin-top: 5mm;
        }

        .zero_color{
            color: lightgrey;
        }

        .footer-potpis-table{
            margin-bottom: 0;
            margin-top:5mm;
        }

        .document-header{
            border-bottom: solid 1px aquamarine;

        }
        .container-fluid{
            border-top: solid 1px aquamarine;

            margin-bottom: 5mm;

        }
        th, td {
            border: 1px solid black;
            padding: 1px 0px;
            text-align: center;
            font-size: 3mm
        }

        th {
            background-color: #f2f2f2;
        }

        .page-break {
            page-break-before: always;
        }
        .page-number:after { content: counter(page); }

        .no-border {
            border: 0px solid black;
            text-align: left;
        }

        .celina-details {
            text-align: left;
            margin-top: 1px;
            margin-bottom: 1px;

        }

        .document-header{
            width: 700px;

        }
        .celina-details-div {
            /*float: right;*/
            margin-right: 10px;
            display:inline-block;
            font-size: 10px;
        }
        .footer-opis-code{
            font-size: 2mm;
        }
.naziv_firme{
    font-size:4mm;
}
        .celina-data{
            display:inline-block;
            font-size: 2mm;
            width: 50%;
        }
    </style>
</head>
<body>
@foreach($data as $key => $radnici)
        <?php
        $rowCounter = 0;
        $pageCounter = 1;
        $potpisi = json_decode($organizacioneCelineSifarnik[$key]->odgovorni_direktori_pravila, true);
        ?>
    <div class="document-header">
        <div class="celina-details-div" style="width: 30%;">
            <span class="strong naziv_firme">{{$podaciFirme['skraceni_naziv_firme']}}</span><br>
            <h5 class="celina-details">Mesec obrade: {{$podaciMesec->datum}}</h5>
        </div>
        <div class="celina-data">
            <h1 style="text-align: left">{{$key}}</h1>
            <h1 style="text-align: left">{{$organizacioneCelineSifarnik[$key]->naziv_troskovnog_mesta}}</h1>
        </div>
        <div class="celina-details-div" style="width: 10%;">

            <h5 class="celina-details">Datum štampe: {{date('d')}}.{{date('m')}}.{{date('Y')}}</h5>
            <span class="page-number">Stranica </span>
        </div>
    </div>
    <table>
        <thead style="display: table-header-group;">
        <tr>
            @foreach($tableHeaders as $header)
                <th>{{$header}}</th>
            @endforeach
            <th>Ukupno</th>
        </tr>
        </thead>
        <tbody>
        @foreach($radnici as $subKey => $radnik)
            @if($subKey !=='columnSum')
                <tr>
                        <?php $rowCounter++; ?>
                    <td style="font-weight: 600">{{$radnik['maticni_broj']}}</td>
                    <td style="text-align: left;padding-left: 3px;font-weight: 600">{{ $radnik['ime'] }}</td>
                    @foreach($radnik['vrste_placanja'] as $vrstaPlacanja)
                        <td class="{{$vrstaPlacanja['sati']==0 ?'zero_color':''}}">{{$vrstaPlacanja['sati']}}</td>


                    @endforeach
                    <td style="font-weight: 600;">{{ $radnik['rowSum'] }}
                </tr>
            @endif

            @if($loop->last)
                <tr style="background-color: #ADD8E6;">

                    <td></td>
                    <td class="rowSum ime_prezime">Ukupno:</td>
                    @foreach($radnici['columnSum'] as $sumKey =>$sumValue)
                        <td class="vrsta_placanja_td text-center">{{$sumValue}}</td>
                    @endforeach
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
            @endif
            @if($rowCounter==20)
                    <?php $pageCounter++ ?>

        </tbody>
    </table>
    <div class="container-fluid">
        {!! $vrstePlacanjaDescription !!}
    </div>
    <div class="container-fluid">
        <div style="font-size: 2.5mm"><p>Poenter________________</p>
            @foreach($potpisi as $potpis)
                <div style="font-size: 2.5mm;"><p> {{$potpis}}</p>
                    @endforeach
                </div>
                <div style="margin-top: 15mm">
                    <h3 style="text-align: left">Napomena:</h3>
                    <div style="border-bottom: 1px solid black; height: 15px; margin-bottom: 5mm;"></div>
                    <div style="border-bottom: 1px solid black; height: 15px; margin-bottom: 5mm;"></div>
                    <div style="border-bottom: 1px solid black; height: 15px;"></div>
                </div>

                <div class="page-break"></div>

                <div class="document-header">
                    <div class="celina-details-div" style="width: 30%;">
                        <span class="strong naziv_firme">{{$podaciFirme['skraceni_naziv_firme']}}</span><br>
                        <h5 class="celina-details">Mesec obrade: {{$podaciMesec->datum}}</h5>
                    </div>
                    <div class="celina-data">
                        <h1 style="text-align: left">{{$key}}</h1>
                        <h1 style="text-align: left">{{$organizacioneCelineSifarnik[$key]->naziv_troskovnog_mesta}}</h1>
                    </div>
                    <div class="celina-details-div" style="width: 10%;">

                        <h5 class="celina-details">Datum štampe: {{date('d')}}.{{date('m')}}.{{date('Y')}}</h5>
                        <span class="page-number">Stranica </span>
                                         </div>
                </div>
                <table class="custom-table">
                    <thead style="display: table-header-group;">
                    <tr>
                        @foreach($tableHeaders as $header)
                            <th>{{$header}}</th>
                        @endforeach
                        <th>Provera</th>
                    </tr>
                        <?php
                        $rowCounter = 0;
                        $pageCounter++;
                        ?>

                    @endif
                    @endforeach
                    </thead>
                </table>
                <div class="container-fluid">
                    {!! $vrstePlacanjaDescription !!}
                </div>
                <div class="container-fluid ">
                    <div style="font-size: 2.5mm"><p>Poenter________________</p>
                        @foreach($potpisi as $potpis)
                            <div style="font-size: 2.5mm;"><p> {{$potpis}}</p>
                                @endforeach
                            </div>
                            @if(!$loop->last)
                                <div class="page-break"></div>
    @endif
                            <div style="margin-top: 20mm;">
                                <h3 style="text-align: left">Napomena:</h3>
                                <div style="border-bottom: 1px solid black; height: 15px; margin-bottom: 5mm;"></div>
                                <div style="border-bottom: 1px solid black; height: 15px; margin-bottom: 5mm;"></div>
                                <div style="border-bottom: 1px solid black; height: 15px;"></div>
                            </div>
@endforeach
</body>
</html>
