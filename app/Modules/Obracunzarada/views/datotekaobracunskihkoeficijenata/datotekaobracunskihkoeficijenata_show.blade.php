@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <style>
        .ime_prezime{
            display: block;
            width: 250px;
        }

        .tooltip {
            font-weight:800;
            font-size: large;
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

        .loading {
            height: 0;
            width: 0;
            padding: 15px;
            border: 6px solid #ccc;
            border-right-color: #5091fee8;
            border-radius: 22px;
            -webkit-animation: rotate 1s infinite linear;
            /* left, top and position just for the demo! */
            position: absolute;
            left: 50%
        }

        @-webkit-keyframes rotate {
            /* 100% keyframe for  clockwise.
               use 0% instead for anticlockwise */
            100% {
                -webkit-transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('content')
    <div class="container main-container mb-5">
        <div class="loader-container" style="text-align: center">
            <h2>Evidencija rada i odsustvovanje radnika datum: <b>{!! $monthData!!}</b></h2>
            <h3 id="statusMessage" class="text-success text-center"></h3>
        </div>
        <form>
            @csrf
        </form>
            <div class="loading" style="display: none;">
            </div>
        @foreach($mesecnaTabelaPotenrazaTable as $key => $organizacionacelina)
            <div class="mt-5">
                <h3 class="text-center"> Organizaciona celina: <b>{{$key}} </b> - &nbsp{{$organizacionacelina[0]->organizacionecelina->naziv_troskovnog_mesta}}.</h3>
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
                    @foreach($organizacionacelina as $value)
                        <tr>
                            <td>{{ $value['maticni_broj'] }}</td>
                            <td class="ime_prezime">{{ $value['ime'] }}</td>
                            @foreach( $value['vrste_placanja'] as $vrstaPlacanja)
                                <td class="vrsta_placanja_td"><input type="number" data-record-id="{{$value['id']}}"
                                                                     min="0"
                                                                     disabled="disabled"
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
            setTimeout(function(){
                $('input').prop('disabled', false);
            }, 3000);

            $('[data-toggle="tooltip"]').tooltip()

            // $('input').keydown(function(e) {
            //     // Check if the pressed key is an arrow key
            //     if (e.which === 37 || e.which === 39) {
            //         e.preventDefault(); // Prevent the default behavior of arrow keys
            //
            //         // Get the current tabindex
            //         var currentTabIndex = parseInt($(this).attr('tabindex'));
            //
            //         // Check which arrow key is pressed and focus on the next/previous input field
            //         switch (e.which) {
            //             case 37: // Left arrow
            //                 focusInput(currentTabIndex - 1);
            //                 break;
            //             case 39: // Right arrow
            //                 focusInput(currentTabIndex + 1);
            //                 break;
            //         }
            //     }
            // });
            // function focusInput(tabindex) {
            //     debugger;
            //     if (tabindex > 0 && tabindex <= $('input').length) {
            //         $('input[tabindex="' + tabindex + '"]').focus();
            //     }
            // }
        });
    </script>
    <script src="{{ asset('modules/obracunzarada/datotekaobracunskihkoef_show/ajax_logic.js') }}"></script>
@endsection

