@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <style>
        .vrsta_placanja_input{
          width: 50px;
          text-align: center;
        }

        .vrsta_placanja_td{
            padding:10px 15px 0 0 !important;
        }
    </style>
@endsection

@section('content')
    <div class="container mb-5">
        <div id="statusMessage"></div>
        <h1>Datoteka obracunskih koeficijenata test</h1>


{{--        <div>--}}
{{--            <table class="table table-striped">--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    @foreach($mesecnaTabelaPoentaza[0] as $key => $value)--}}
{{--                        <th>{{ $key }}</th>--}}
{{--                    @endforeach--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                @foreach($mesecnaTabelaPoentaza as $poentaza)--}}
{{--                    <tr>--}}
{{--                        @foreach($poentaza as $value)--}}
{{--                            <td>{{ $value }}</td>--}}
{{--                        @endforeach--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        </div>--}}




        <h1>mesecnaTabelaPotenrazaTable</h1>

        @foreach($mesecnaTabelaPotenrazaTable as $key => $radnikData)
            <div>
                <h3 class="text-center"> Tabela</h3>
                <h3 class="text-center"> Organizaciona celina: {{$key}}</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        @foreach($tableHeaders as $keyheader =>$header)
                            <th>{{ $header }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                         @foreach($radnikData as $value)
                             <tr>
                             <td>{{ $value['maticni_broj'] }}</td>
                             <td>{{ $value['ime'] }}</td>
                             <td>{{ $value['prezime'] }}</td>
                            @foreach( $value['vrste_placanja'] as $vrstaPlacanja)
                                     <td class="vrsta_placanja_td"><input type="text" class="vrsta_placanja_input"  data-toggle="tooltip" data-placement="top" title={{ $vrstaPlacanja['name']}} value={{ $vrstaPlacanja['value']}}></td>
                                 @endforeach
                                 @endforeach
                             </tr>
                    </tbody>
                </table>
            </div>
        @endforeach

    </div>
    </div>
@endsection



@section('custom-scripts')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection

