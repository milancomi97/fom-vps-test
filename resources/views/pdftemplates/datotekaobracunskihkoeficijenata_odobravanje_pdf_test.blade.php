<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
            font-size: 2mm
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

        .celina-data{
            display:inline-block;
            font-size: 10px;
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
        <span class="strong">{{$podaciFirme['skraceni_naziv_firme']}}</span><br>
        <h5 class="celina-details">Mesec: {{date('m')}}</h5>
        <h5 class="celina-details">Datum štampe: {{date('m')}}</h5>
        <span class="page-number">Stranica </span>
        <h5 class="celina-details"> <span class="page-number">Stranica </span></h5>
    </div>
        <div class="celina-data">
        <h1 style="text-align: left">Organizaciona celina: {{$key}}</h1>
        </div>
        <div class="celina-details-div" style="width: 10%;">
            <span class="strong">{{$podaciFirme['skraceni_naziv_firme']}}</span><br>
            <h5 class="celina-details">Mesec: {{date('m')}}</h5>
            <h5 class="celina-details">Datum štampe: {{date('m')}}</h5>
            <span class="page-number">Stranica </span>
            <h5 class="celina-details"> <span class="page-number">Stranica </span></h5>
        </div>
    </div>
        <table style="margin-top:50px;">
        <thead style="display: table-header-group;">
        <tr>
            @foreach($tableHeaders as $header)
                <th>{{$header}}</th>
            @endforeach
            <th>Provera</th>
        </tr>
        </thead>
        <tbody>
        @foreach($radnici as $subKey => $radnik)
            @if($subKey !=='columnSum')
                <tr>
                        <?php $rowCounter++; ?>
                    <td>{{$radnik['maticni_broj']}}</td>
                    <td style="text-align: left;">{{ $radnik['ime'] }}</td>
                    @foreach($radnik['vrste_placanja'] as $vrstaPlacanja)
                        <td>{{$vrstaPlacanja['sati']}}</td>
                    @endforeach
                    <td>{{ $radnik['rowSum'] }}
                </tr>
            @endif
            @if($rowCounter ==15)
                    <?php $pageCounter++ ?>
        </tbody>
    </table>
    <div class="container-fluid">
        {!! $vrstePlacanjaDescription !!}
    </div>
    <div class="container-fluid mt-5">
        <div style="font-size: 10px;"><p>Poenter________________</p>
            @foreach($potpisi as $potpis)
                <div style="font-size: 10px;"><p> {{$potpis}}</p>
                    @endforeach
                </div>
                <div class="page-break"></div>

                <div class="document-header">
                    <div class="celina-details-div" style="width: 30%;">
                        <span class="strong">{{$podaciFirme['skraceni_naziv_firme']}}</span><br>
                        <h5 class="celina-details">Mesec: {{date('m')}}</h5>
                        <h5 class="celina-details">Datum štampe: {{date('m')}}</h5>
                        <span class="page-number">Stranica </span>
                        <h5 class="celina-details"> <span class="page-number">Stranica </span></h5>
                    </div>
                    <div class="celina-data">
                        <h1 style="text-align: left">Organizaciona celina: {{$key}}</h1>
                    </div>
                    <div class="celina-details-div" style="width: 10%;">
                        <span class="strong">{{$podaciFirme['skraceni_naziv_firme']}}</span><br>
                        <h5 class="celina-details">Mesec: {{date('m')}}</h5>
                        <h5 class="celina-details">Datum štampe: {{date('m')}}</h5>
                        <span class="page-number">Stranica </span>
                        <h5 class="celina-details"> <span class="page-number">Stranica </span></h5>
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
                <div class="container-fluid mt-5">
                    <div ><p>Poenter________________</p>
                        @foreach($potpisi as $potpis)
                            <div ><p> {{$potpis}}</p>
                                @endforeach
                            </div>
                            @if(!$loop->last)
                                <div class="page-break"></div>
        @endif
@endforeach
</body>
</html>
