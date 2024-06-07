<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

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

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }

        .no-border {
            border: 0px solid black;
            text-align: left;
        }

        .footer-potpis-table {
            margin-top: 20px;
        }

        .celina-details {
            text-align: left;
            margin-top: 1px;
            margin-bottom: 1px;

        }

        .celina-details-div {
            float: right;
            margin-right: 10px;
            display:inline-block;
            font-size: 10px;

        }
        .celina-data{
            margin-left: auto;
            margin-right: auto;
            max-width: 500px;
            font-size: 10px;
        }

        .text-left-ime {
            text-align: left;
        }
        .custom-table{
            margin-top:50px;
        }
        .footer-potpis-code{
            font-size: 10px;
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
    <div class="celina-details-div">

        <h5 class="celina-details">Mesec: {{date('m')}}</h5>
        <h5 class="celina-details">Datum štampe: {{date('m')}}</h5>
        <h5 class="celina-details">Strana: {{$pageCounter}}</h5>
    </div>
        <div class="celina-data">
        <h1 style="text-align: center">Organizaciona celina: {{$key}}</h1>
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
        @foreach($radnici as $subKey => $radnik)
            @if($subKey !=='columnSum')
                <tr>
                        <?php $rowCounter++; ?>
                    <td>{{$radnik['maticni_broj']}}</td>
                    <td class="text-left-ime">{{ $radnik['ime'] }}</td>
                    @foreach($radnik['vrste_placanja'] as $vrstaPlacanja)
                        <td>{{$vrstaPlacanja['sati']}}</td>
                    @endforeach
                    <td>{{ $radnik['rowSum'] }}
                </tr>
            @endif
            @if($rowCounter ==20)
                    <?php $pageCounter++ ?>
        </tbody>
    </table>
    <div class="container-fluid">
        {!! $vrstePlacanjaDescription !!}
    </div>
    <div class="container-fluid mt-5">
        <div class="footer-potpis-code"><p>Poenter________________</p>
            @foreach($potpisi as $potpis)
                <div class="footer-potpis-code"><p> {{$potpis}}</p>
                    @endforeach
                </div>
                <div class="page-break"></div>

                <div class="celina-details-div">

                    <h5 class="celina-details">Mesec: {{date('m')}}</h5>
                    <h5 class="celina-details">Datum štampe: {{date('m')}}</h5>
                    <h5 class="celina-details">Strana: {{$pageCounter}}</h5>
                </div>
                <div class="celina-data">
                    <h1 style="text-align: center">Organizaciona celina: {{$key}}</h1>
                </div>
                <table class="custom-table">
                    <thead>
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
                    </tbody>
                </table>
                <div class="container-fluid">
                    {!! $vrstePlacanjaDescription !!}
                </div>
                <div class="container-fluid mt-5">
                    <div class="footer-potpis-code"><p>Poenter________________</p>
                        @foreach($potpisi as $potpis)
                            <div class="footer-potpis-code"><p> {{$potpis}}</p>
                                @endforeach
                            </div>
                            <div class="page-break"></div>
@endforeach

</body>
</html>
