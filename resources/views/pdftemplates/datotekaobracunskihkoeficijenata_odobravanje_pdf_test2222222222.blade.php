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
            font-size: 2mm;
        }

        th {
            background-color: #f2f2f2;
        }

        .page-break {
            page-break-before: always;
        }

        .page-number:after {
            content: counter(page);
        }

        .no-border {
            border: 0px solid black;
            text-align: left;
        }

        .celina-details {
            text-align: left;
            font-size: 10px;
        }

        .celina-details-left,
        .celina-details-right {
            width: 50%;
        }

        .celina-data {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }

        .document-header {
            width: 100%;
            display: table;
        }

        .document-header .cell {
            display: table-cell;
            vertical-align: middle;
            width: 33%;
            padding: 5px;
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
        <!-- Left part of the header -->
        <div class="cell celina-details">
            <span class="strong">{{$podaciFirme['skraceni_naziv_firme']}}</span><br>
            <h5>Mesec: {{date('m')}}</h5>
            <h5>Datum štampe: {{date('m')}}</h5>
            <span>Stranica <span class="page-number"></span></span>
        </div>
        <!-- Center part of the header -->
        <div class="cell celina-data">
            Organizaciona celina: {{$key}}
        </div>
        <!-- Right part of the header -->
        <div class="cell celina-details-right">
            <span class="strong">{{$podaciFirme['skraceni_naziv_firme']}}</span><br>
            <h5>Mesec: {{date('m')}}</h5>
            <h5>Datum štampe: {{date('m')}}</h5>
            <span>Stranica <span class="page-number"></span></span>
        </div>
    </div>

    <!-- Your table and the rest of the document -->
    <table style="margin-top: 50px;">
        <thead>
        <tr>
            @foreach($tableHeaders as $header)
                <th>{{$header}}</th>
            @endforeach
            <th>Provera</th>
        </tr>
        </thead>
        <tbody>
        @foreach($radnici as $subKey => $radnik)
            @if($subKey !== 'columnSum')
                <tr>
                        <?php $rowCounter++; ?>
                    <td>{{$radnik['maticni_broj']}}</td>
                    <td style="text-align: left;">{{ $radnik['ime'] }}</td>
                    @foreach($radnik['vrste_placanja'] as $vrstaPlacanja)
                        <td>{{$vrstaPlacanja['sati']}}</td>
                    @endforeach
                    <td>{{ $radnik['rowSum'] }}</td>
                </tr>
            @endif
            @if($rowCounter == 15)
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
                    <div class="cell celina-details-left">
                        <h5>Mesec: {{date('m')}}</h5>
                        <h5>Datum štampe: {{date('m')}}</h5>
                        <h5>Strana: {{$pageCounter}}</h5>
                    </div>
                    <div class="cell celina-data">
                        Organizaciona celina: {{$key}}
                    </div>
                </div>

                <table class="custom-table">
                    <thead>
                    <tr>
                        @foreach($tableHeaders as $header)
                            <th>{{$header}}</th>
                        @endforeach
                        <th>Provera</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $rowCounter = 0;
                        $pageCounter++;
                        ?>
                    @endif
                    @endforeach
                    </tbody>
                </table>

                <div class="container-fluid">
                    {!! $vrstePlacanjaDescription !!}
                </div>

                <div class="container-fluid mt-5">
                    <div><p>Poenter________________</p>
                        @foreach($potpisi as $potpis)
                            <div><p>{{$potpis}}</p></div>
                        @endforeach
                    </div>
                </div>
@endforeach
</body>
</html>
