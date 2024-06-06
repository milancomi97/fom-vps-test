<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 5px; text-align: center; font-size: 2mm }
        th { background-color: #f2f2f2; }
        .page-break { page-break-before: always; }
        thead { display: table-header-group; }
        tfoot { display: table-footer-group; }
    </style>
</head>
<body>
@foreach($data as $key => $radnici)
        <?php $rowCounter=0; ?>
    <h1 style="text-align: center">Org celina {{$key}} pocetak</h1>
    <table>
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
                <td>{{ $radnik['ime'] }}</td>
                @foreach($radnik['vrste_placanja'] as $vrstaPlacanja)
                    <td>{{$vrstaPlacanja['sati']}}</td>
                @endforeach
                <td>{{ $radnik['rowSum'] }}
            </tr>
            @endif
                @if($rowCounter ==5)
        </tbody>
    </table>
    <h1 style="text-align: center">Org celina {{$key}} kraj</h1>

    <div class="page-break"></div>
    <h1 style="text-align: center">Org celina {{$key}} pocetak</h1>
                <table>
                    <thead>
                    <tr>
                        @foreach($tableHeaders as $header)
                            <th>{{$header}}</th>
                        @endforeach
                            <th>Provera</th>
                    </tr>
                @endif
        @endforeach
        </tbody>
    </table>
        <h1 style="text-align: center">Org celina {{$key}} kraj</h1>
        <div class="page-break"></div>
@endforeach

</body>
</html>
