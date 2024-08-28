@php use App\Modules\Obracunzarada\Consts\StatusOdgovornihLicaObracunskiKoef;use App\Modules\Obracunzarada\Consts\StatusPoenteraObracunskiKoef;use App\Modules\Obracunzarada\Consts\StatusRadnikaObracunskiKoef;use App\Modules\Obracunzarada\Consts\UserRoles; @endphp
@extends('obracunzarada::theme.layout.app_poenter')

@section('custom-styles')
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">

    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
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
            border-bottom-color: red;
            border-bottom-style: dashed;
            border-bottom-width: 2px;
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
            padding: 0.75rem !important;
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
    <div class="container-fluid mt-5">

    </div>
    <div class="container main-container mb-5">
        <h2 class="text-center ml-5">Evidencija rada i odsustvovanje radnika</h2>
        <h1 class="text-center ml-5"><b>{!! $formattedDate!!}</b></h1>
        <div class="container  ml-5">
            <ul class="list-group">
                <li class="list-group-item">Kalendarski broj dana: {{$monthData->kalendarski_broj_dana}}</li>
                <li class="list-group-item">Mesečni fond sati: {{$monthData->mesecni_fond_sati}}</li>
            </ul>
        </div>

        <div class="loader-container" style="text-align: center">
            <h3 id="statusMessage" class="text-success text-center"></h3>
        </div>
        <form>
            @csrf
        </form>
        <div class="loading" style="display: none;">
        </div>
        <?php
        $approvedStatus=0;
        $approvedOrganizacioneCeline=[];
        ?>
        @foreach($mesecnaTabelaPotenrazaTable as $key => $organizacionacelina)
            @if(isset($troskovnaMestaPermission[$key]) && $troskovnaMestaPermission[$key])
                <div class="table-div mt-5">
                    <h3 class="text-center"> Organizaciona celina: <b>{{$key}} </b> -
                        &nbsp{{$organizacionacelina[0]->organizacionecelina->naziv_troskovnog_mesta}}.</h3>
                    <button id='osvezi_stranicu' onClick="window.location.reload()" class="btn btn-secondary  calcBtn">Osveži proveru</button>

                @if(isset($mesecnaTabelaPoentazaPermissions[$key]['poenterData'][auth()->user()->id]))
                        @if($mesecnaTabelaPoentazaPermissions[$key]['poenterData'][auth()->user()->id]['status']==StatusRadnikaObracunskiKoef::UPRIPREMI)
                            {{$approvedStatus++}}
                            <button class="btn btn-primary calcBtn" onclick="submitTroskovniCentar('{{$key}}',{{auth()->user()->id}},{{$mesecnaTabelaPoentazaPermissions[$key]['permission_record_id']}})">
                                Zatvori {{$key}} celinu
                            </button>
                        @elseif($mesecnaTabelaPoentazaPermissions[$key]['poenterData'][auth()->user()->id]['status']==StatusRadnikaObracunskiKoef::POSLATNAPROVERU)
                            <?php
                                $approvedOrganizacioneCeline[]=$key;
            ?>
                            <form method="POST" action="{{route('datotekaobracunskihkoeficijenata.odobravanje_export_pdf_org_celine')}}">
                                @csrf
                                <input type="hidden" name="approved_org_celine" value="{{json_encode($key)}}">
                                <input type="hidden" name="month_id" value="{{$monthData->id}}">
                                <button id='export-pdf-celina' class="btn btn-secondary  calcBtn">Štampaj PDF</button>
                            </form>
                        @endif
                    @endif

                    <div class="divider"></div>
                    <table class="table table-striped" id="table-div{{$key}}">
                        <thead>
                        <tr>
                            @foreach($tableHeaders as $keyheader =>$header)
                                <th>{{ $header }}</th>
                            @endforeach
                                <th>Provera</th>
                                {{--                            <th>Napomena</th>--}}
                            {{--                            <th>STATUS</th>--}}

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($organizacionacelina as $radnikId => $value)
                            {{--                            $mesecnaTabelaPoentazaPermissions[$key]['odgovornaLicaData'][auth()->user()->id]--}}
                            @if($radnikId !=='columnSum')

                            <tr>
                                <td>{{ $value['maticni_broj'] }}</td>
                                <td class="ime_prezime">{{ $value['ime'] }}</td>
                                @foreach( $value['vrste_placanja'] as $vrstaPlacanja)
                                    @if(isset($mesecnaTabelaPoentazaPermissions[$key]['poenterData'][auth()->user()->id]))
                                        @if($mesecnaTabelaPoentazaPermissions[$key]['poenterData'][auth()->user()->id]['status']==StatusRadnikaObracunskiKoef::UPRIPREMI)
                                            <td class="vrsta_placanja_td"><input type="number" data-record-id="{{$value['id']}}"
                                                                                 min="0"
                                                                                 class="vrsta_placanja_input"
                                                                                 data-toggle="tooltip"
                                                                                 data-placement="top"
                                                                                 title={{ $vrstaPlacanja['name']}} data-vrsta-placanja-key={{$vrstaPlacanja['key']}} value={{($vrstaPlacanja['sati'] > 0) ? $vrstaPlacanja['sati'] : null}}>
                                            </td>
                                        @elseif($mesecnaTabelaPoentazaPermissions[$key]['poenterData'][auth()->user()->id]['status']==StatusRadnikaObracunskiKoef::POSLATNAPROVERU)
                                            <td class="vrsta_placanja_td">{{ $vrstaPlacanja['sati']}}</td>
                                    @endif
{{--                                    @elseif($userPermission->role_id !== UserRoles::POENTER)--}}
                                        @else
                                        <td class="vrsta_placanja_td">{{ $vrstaPlacanja['sati']}}</td>
                                    @endif
                                @endforeach

                                <td class="{{$value->rowSum < 168 ? 'bg-danger': ''}}">{{$value->rowSum}}</td>
                                @endif
                                @endforeach
                            </tr>
                            <tr style="background-color: #ADD8E6;">

                                <td></td>
                                <td class="rowSum ime_prezime">Ukupno:</td>
                                @foreach($organizacionacelina['columnSum'] as $sumKey =>$sumValue)
                                    <td class="vrsta_placanja_td text-center">{{$sumValue}}</td>
                                @endforeach
                                <td></td>

                            </tr>
                        </tbody>
                    </table>

                    <div class="container-fluid">
                        {!! $vrstePlacanjaDescription !!}
                    </div>
                    <div class="end_org_celina"></div>

                </div>
                    @endif
                    @endforeach
                    @if($approvedStatus==0)
                        <div class="container mt-5 mb-5 text-center">
                            <form method="POST" action="{{route('datotekaobracunskihkoeficijenata.odobravanje_export_pdf_org_celine')}}">
                                @csrf
                                <input type="hidden" name="approved_org_celine" value="{{json_encode($approvedOrganizacioneCeline)}}">
                                <input type="hidden" name="month_id" value="{{$monthData->id}}">
                                <button id='export-pdf' type="submit" class="btn btn-secondary btn-lg">Štampaj sve podatke</button>
                            </form>
                        </div>
                    @endif
                </div>
    </div>
    <!-- Modal -->
    <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Unos Napomene:</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Your form goes here -->
                    <h3 class="" id="radnik_modal"></h3>
                    <form id="myForm">
                        <div class="form-group">
                            <label for="napomena_text_old">Napomena</label>
                            <div id="napomena_text_old">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="napomena_text">Unesi napomenu</label>
                            <textarea class="form-control" id="napomena_text" rows="5"></textarea>
                        </div>

                        <input type="hidden" name="record_id_modal" id="record_id_modal">
                        <!-- Add more form elements as needed -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvori</button>
                    <button type="button" class="btn btn-primary" id="submitFormBtn">Sačuvaj</button>
                </div>
            </div>
        </div>
    </div>
    {{--    END NAPOMENA MODAL--}}

    {{--    POENTER STATUS MODAL--}}
    <div class="modal" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Izmena statusa:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Your form goes here -->
                    <h3 class="" id="radnik_status_modal"></h3>
                    <form id="statusForm">
                        <div class="form-group mt-5">
                            <label for="status_radnika">Status radnika:</label>
                            <select id="status_radnika" class="custom-select form-control" name="status_radnika">
                                @foreach($statusRadnikaOK as $value => $label)
                                    <option value="{{ $value}}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="record_id_status_modal" id="record_id_status_modal">
                        <!-- Add more form elements as needed -->
                        {{--                        statusRadnikaOK--}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvori</button>
                    <button type="button" class="btn btn-primary" id="submitFormBtnStatus">Sačuvaj</button>
                </div>
            </div>
        </div>
    </div>

    {{--    POENTER STATUS END MODAL--}}
    {{--    ADMINISTRATOR STATUS MODAL--}}
    <div class="modal" id="statusAdminModal" tabindex="-1" role="dialog" aria-labelledby="statusAdminModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Administrator izmena statusa:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Your form goes here -->
                    <form id="statusAdminForm">

                        <div class="row">
                            <div class="col-12">
                                <div class='status_admin_div'>
                                    <div class="form-group mt-5 status_admin_element">
                                        <label for="status_admin">Status:</label>
                                        <select id="status_admin" class="custom-select form-control"
                                                name="status_admin">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="record_id_status_admin_modal" id="record_id_status_admin_modal">
                        <input type="hidden" name="user_id_status_admin_modal" id="user_id_status_admin_modal">
                        <input type="hidden" name="status_type_admin_modal" id="status_type_admin_modal">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvori</button>
                    <button type="button" class="btn btn-primary" id="submitFormBtnStatusAdmin">Izmeni</button>
                </div>
            </div>
        </div>
    </div>

    {{--    ADMINISTRATOR STATUS END MODAL--}}
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
            // setTimeout(function () {
            //     $('input').prop('disabled', false);
            // }, 3000);

            $('[data-toggle="tooltip"]').tooltip({'trigger': 'focus'})

        });
    </script>
    <script
        src="{{ asset('modules/obracunzarada/datotekaobracunskihkoef_odobravanje_poenter/ajax_logic.js') }}"></script>
    <script
        src="{{ asset('modules/obracunzarada/datotekaobracunskihkoef_odobravanje_poenter/modal_logic.js') }}"></script>
    <script
        src="{{ asset('modules/obracunzarada/datotekaobracunskihkoef_odobravanje_poenter/recalculate_logic.js') }}"></script>

    <script src="{{asset('admin_assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>

@endsection
