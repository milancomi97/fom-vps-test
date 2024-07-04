@php use App\Modules\Obracunzarada\Consts\StatusOdgovornihLicaObracunskiKoef;use App\Modules\Obracunzarada\Consts\StatusPoenteraObracunskiKoef;use App\Modules\Obracunzarada\Consts\StatusRadnikaObracunskiKoef;use App\Modules\Obracunzarada\Consts\UserRoles; @endphp
@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">

    <style>

        .rowSum {
            text-align: right;
            font-weight: 800;
        }

        .calcBtn {
            float: right;
            margin: 1em;
        }

        .ime_prezime {
            display: block;
            width: 250px;
        }

        .end_org_celina {
            height: 100px;

        }

        .tooltip {
            font-weight: 800;
            font-size: large;
        }

        .vrste_placanja_description {
            margin-bottom: 0;
        }

        .main-container {
            margin-left: 100px !important;
        }

        .vrsta_placanja_input {
            width: 60px;
            text-align: center;
        }

        .vrsta_placanja_td {
            padding: 10px 15px 0 0 !important;
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

        .napomena_td {
            text-align: center
        }

        .status_td {
            text-align: center
        }

        .napomena {
            font-size: 20px;
        }

        .status_icon {
            font-size: 20px;
        }

        .table-div {
            display: table;
            margin-top: 3rem;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper mt-5 pl-5">
        <h1 class="ml-5 mb-5">Poentaža - status troškovnih mesta po poenterima</h1>

        <div class="container ml-5 mt-5">
            <div class="table-responsive" style="width: 1800px">
                <table class="table">
                    <thead>
                    {{--            <tr>--}}
                    {{--                <th>Key</th>--}}
                    {{--                @if(!empty($poenteriData))--}}
                    {{--                    @foreach(array_keys(reset($poenteriData)) as $header)--}}
                    {{--                        <th>{{ $header }}</th>--}}
                    {{--                    @endforeach--}}
                    {{--                @endif--}}
                    {{--            </tr>--}}
                    </thead>
                    <tbody>
                    @foreach($poenteriData as $key => $subList)
                        <tr>
                            <td class="border-0" colspan="3"></td>
                            <td class="border-0" colspan="3"><b>{{ $subList['poenterDetails'] }}</b></td>
                            <td class="border-0" colspan="40"></td>

                        </tr>
                        <tr>

                            @foreach($subList as $subKey => $value)

                                    <?php
                                    if($value=='0'){
                                        $color="bg-danger";
                                    }elseif($value=='1'){
                                        $color="bg-warning";
                                    }elseif($value='2'){
                                        $color = "bg-success";
                                    }
                                    ?>
                                @if($subKey !=='poenterDetails')
                                    <td style="min-width: 200px; text-align: center"

                                        class="{{$color}}">{{$subKey}}
                                        <br/> {{StatusRadnikaObracunskiKoef::all()[$value]}}</td>
                                @endif

                            @endforeach
                        </tr>

                        <tr>
                            <td class="border-0" colspan="50"></td>
                        </tr>
                        <tr>
                            <td class="border-0" colspan="50"></td>
                        </tr>
                        <tr>
                            <td class="border-0" colspan="50"></td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('custom-scripts')
    <script>
        let storeRoute = '{!! route('datotekaobracunskihkoeficijenata.update') !!}'
        let statusUpdateRoute = '{!! route('datotekaobracunskihkoeficijenata.updatePermissionStatus') !!}'
        let updateStatusAdministratorRoute = '{!! route('datotekaobracunskihkoeficijenata.updatePermissionStatusAdministrator') !!}'
        let getPermissionStatusAdministratorRoute = '{!! route('datotekaobracunskihkoeficijenata.getPermissionStatusAdministrator') !!}'
    </script>
    <script>
        $(function () {

            // change-status
            setTimeout(function () {
                $('input').prop('disabled', false);
            }, 3000);

            $('[data-toggle="tooltip"]').tooltip({'trigger': 'focus'})

        });
    </script>
    <script src="{{ asset('modules/obracunzarada/datotekaobracunskihkoef_odobravanje/ajax_logic.js') }}"></script>
    <script src="{{ asset('modules/obracunzarada/datotekaobracunskihkoef_odobravanje/modal_logic.js') }}"></script>
    <script
        src="{{ asset('modules/obracunzarada/datotekaobracunskihkoef_odobravanje/recalculate_logic.js') }}"></script>


    {{--    dodaj nov fajl koji ce da sredjuje kalkulaciju --}}
    <script src="{{asset('admin_assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>

@endsection
