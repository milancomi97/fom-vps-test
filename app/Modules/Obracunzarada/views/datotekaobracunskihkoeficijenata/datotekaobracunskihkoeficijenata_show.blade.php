@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <style>
        .ime_prezime{
            display: block;
            width: 250px;
        }

        .main-container{
            margin-left:100px !important;
        }
           .vrsta_placanja_input{
          width: 50px;
          text-align: center;
        }

        .vrsta_placanja_td{
            padding:10px 15px 0 0 !important;
        }
        .divider {
            width: 100%;
            height: 1px; /* Set the height of the divider line */
            background-color: #000; /* Set the color of the divider line */
            margin: 10px 0; /* Add margin for spacing if needed */
        }

        .lds-dual-ring {
            display: inline-block;
            width: 80px;
            height: 80px;
        }
        .lds-dual-ring:after {
            content: " ";
            display: block;
            width: 64px;
            height: 64px;
            margin: 8px;
            border-radius: 50%;
            border: 6px solid red;
            border-color: red transparent red transparent;
            animation: lds-dual-ring 1.5s linear infinite;
        }
        @keyframes lds-dual-ring {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('content')
    <div class="container main-container mb-5">
        <p id="statusMessage" class="text-success"></p>
        <div id="status"></div>
        <div class="loader-container" style="text-align: center">
            <div id="loader" class="lds-dual-ring" style="display: none;"></div>

        </div>
        <form>
            @csrf
        </form>
        <h1>Evidencija rada i odsustvovanje radnika datum: {!! $monthData['datum'] !!}</h1>


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




        @foreach($mesecnaTabelaPotenrazaTable as $key => $radnikData)
            <div>
                <h3 class="text-center"> Organizaciona celina: {{$key}}</h3>
                <div class="divider"></div>
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
                            <td class="ime_prezime">{{ $value['ime'] }}</td>
                            @foreach( $value['vrste_placanja'] as $vrstaPlacanja)
                                <td class="vrsta_placanja_td"><input type="text" data-record-id="{{$value['id']}}"
                                                                     class="vrsta_placanja_input" data-toggle="tooltip"
                                                                     data-placement="top"
                                                                     title={{ $vrstaPlacanja['name']}} data-vrsta-placanja-key={{$vrstaPlacanja['key']}} value={{ $vrstaPlacanja['value']}}>
                                </td>
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
        let storeRoute ='{!! route('datotekaobracunskihkoeficijenata.update') !!}'
</script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()

            $(".vrsta_placanja_td").on('focusout', function (event) {
                if (event.target.value !== '') {

                    event.stopImmediatePropagation();
                    $("#loader").show();
                    debugger;

                    var input_value = event.target.value;
                    var input_key = event.target.dataset.vrstaPlacanjaKey
                    var record_id = event.target.dataset.recordId
                    var _token = $('input[name="_token"]').val();


                    $.ajax({
                        url: storeRoute,
                        type: 'POST',
                        data: {
                            _token: _token,
                            input_value: input_value,
                            input_key: input_key,
                            record_id: record_id
                        },
                        success: function (response) {
                            $("#statusMessage").text(response.message).addClass("text-success");
                            $("#loader").hide();

                        },
                        error: function (response) {
                            $("#statusMessage").text("Greska: " + response.message).addClass("text-danger");
                            $("#loader").hide();

                        }
                    });


                }
            });
        });
    </script>
@endsection

