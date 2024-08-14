@php use App\Modules\Obracunzarada\Consts\StatusOdgovornihLicaObracunskiKoef;use App\Modules\Obracunzarada\Consts\StatusPoenteraObracunskiKoef;use App\Modules\Obracunzarada\Consts\StatusRadnikaObracunskiKoef;use App\Modules\Obracunzarada\Consts\UserRoles; @endphp
@extends('obracunzarada::theme.layout.app')

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
        .rowSum{
            text-align: right;
            font-weight: 800;
        }
        .calcBtn{
            float:right;
            margin:1em;
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
            padding: 10px 15px 0 0 !important;
        }

        .divider {
            width: 100%;
            height: 1px; /* Set the height of the divider line */
            background-color: #000; /* Set the color of the divider line */
            margin: 10px 0; /* Add margin for spacing if needed */
        }

        .loading2 {
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


        div.loadingInit{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(16, 16, 16, 0);
        }
        div.loading{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(16, 16, 16, 0);
        }

        @-webkit-keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @-webkit-keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @-moz-keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @-ms-keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @-moz-keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @-webkit-keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @-o-keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        .uil-ring-css {
            margin: auto;
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 200px;
            height: 800px;
        }
        .uil-ring-css > div {
            position: absolute;
            display: block;
            width: 200px;
            height: 200px;
            top: 20px;
            left: 20px;
            border-radius: 100px;
            box-shadow: 0 8px 0 0 #BDC7FF;
            -ms-animation: uil-ring-anim 1.4s linear infinite;
            -moz-animation: uil-ring-anim 1.4s linear infinite;
            -webkit-animation: uil-ring-anim 1.4s linear infinite;
            -o-animation: uil-ring-anim 1.4s linear infinite;
            animation: uil-ring-anim 1.4s linear infinite;
        }

        *.hidden {
            display: none !important;
        }

        .invisible{
           visibility: hidden !important;
        }

    </style>
@endsection

@section('content')

    <div class="container-fluid mt-5">
        <div class="loadingInit">
            <div class='uil-ring-css' style='transform:scale(0.79);'>
                <div></div>
            </div>
            <h1 class="obrada-title text-center text-primary mt-5">Učitavanje podataka</h1>

        </div>

        <div class="loading hidden">
            <div class='uil-ring-css' style='transform:scale(0.79);'>
                <div></div>
            </div>
            <h1 class="obrada-title text-center text-primary mt-5">Generisanje PDF-a u toku</h1>

        </div>

        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="col-md-1">
                <a  href="{{route('datotekaobracunskihkoeficijenata.odobravanje_check_sati',['month_id'=>$monthData->id])}}" class="btn btn-secondary btn-lg">Kontrola sati</a>
            </div>
            <div class="col-md-1">
                <a  href="{{route('datotekaobracunskihkoeficijenata.odobravanje_check_poenteri',['month_id'=>$monthData->id])}}" class="btn btn-secondary btn-lg">Kontrola statusa</a>
            </div>
            <div class="col-md-1">
                <a  href="{{route('datotekaobracunskihkoeficijenata.create')}}" class="btn btn-secondary btn-lg">Poentaža</a>

            </div>
        </div>
    </div>
    <div class="container invisible maincontainer main-container mb-5">



        <h2 class="text-center">Evidencija rada i odsustvovanje radnika</h2>
        <h1 class="text-center"><b>{!! $formattedDate!!}</b></h1>
        <div class="container ">
            <ul class="list-group">
                <li class="list-group-item">Kalendarski broj dana: {{$monthData->kalendarski_broj_dana}}</li>
{{--                <li class="list-group-item">Prosečni godišnji fond--}}
{{--                    sati: {{$monthData->prosecni_godisnji_fond_sati}}</li>--}}
                <li class="list-group-item">Mesečni fond sati: {{$monthData->mesecni_fond_sati}}</li>
{{--                <li class="list-group-item">Cena rada tekući: {{$monthData->cena_rada_tekuci}}</li>--}}
{{--                <li class="list-group-item">Cena rada prethodni:{{$monthData->cena_rada_prethodni}}</li>--}}
            </ul>
        </div>


        <form>
            @csrf
        </form>
        <div class="loading2" style="display: none;">
        </div>
        <?php
        $approvedStatus=0;
        $approvedOrganizacioneCeline=[];
        ?>
        @foreach($mesecnaTabelaPotenrazaTable as $key => $organizacionacelina)
            @if(isset($troskovnaMestaPermission[$key]) && $troskovnaMestaPermission[$key])
                <div class="table-div mt-5">
                        <?php
                        $approvedOrganizacioneCeline[]=$key;
                        ?>
                    <h3 class="text-center"> Organizaciona celina: <b>{{$key}} </b> -
                        &nbsp{{$organizacionacelina[0]->organizacionecelina->naziv_troskovnog_mesta}}.</h3>
                    <button id='osvezi_stranicu' onClick="window.location.reload()" class="btn btn-secondary  calcBtn">Osveži proveru</button>
                    <form target="hiddenIframe2" class="loaderEvent" method="POST" action="{{route('datotekaobracunskihkoeficijenata.odobravanje_export_pdf_org_celine')}}">
                        @csrf
                        <input type="hidden" name="approved_org_celine" value="{{json_encode($key)}}">
                        <input type="hidden" name="month_id" value="{{$monthData->id}}">
                        <button id='export-pdf-celina' class="btn btn-secondary  calcBtn">Štampaj PDF</button>
                    </form>
                    <iframe id="hiddenIframe2" name="hiddenIframe2" style="display:none;"></iframe>

                    <div class="divider"></div>

                    <table class="table table-striped" id="table-div{{$key}}">
                        <thead>
                        <tr>
                            @foreach($tableHeaders as $keyheader =>$header)
                                <th>{{ $header }}</th>
                            @endforeach
                            <th>Napomena</th>
                            <th>Status</th>
                            <th>Provera</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($organizacionacelina as $radnikId =>$value)

                            @if($radnikId !=='columnSum')
                            <tr>
                                <td>{{ $value['maticni_broj'] }}</td>
                                <td class="ime_prezime">{{ $value['ime'] }}</td>
                                @foreach( $value['vrste_placanja'] as $vrstaPlacanja)

                                    <td class="vrsta_placanja_td"><input type="number" data-record-id="{{$value['id']}}"
                                                                         min="0"
                                                                         disabled="disabled"
                                                                         class="vrsta_placanja_input"
                                                                         data-toggle="tooltip"
                                                                         data-placement="top"
                                                                         title={{ $vrstaPlacanja['name']}} data-vrsta-placanja-key={{$vrstaPlacanja['key']}} value={{($vrstaPlacanja['sati'] > 0) ? $vrstaPlacanja['sati'] : null}}>
                                    </td>
                                @endforeach
                                <td class="napomena_td" data-napomena-value="{{$value['napomena']}}"
                                    data-radnik-name="{{$value['ime']}}" data-record-id="{{$value['id']}}">
                                    @if($value['napomena'])
                                        <span class="napomena text-danger">   <i class="fas fa-sticky-note"></i></span>
                                    @else
                                        <span class="napomena text-primary">  <i class="fas fa-plus"
                                                                                 aria-hidden="true"></i></span>
                                    @endif
                                </td>
                                <td class="status_td" data-status-value="{{$value['status_poentaze']}}"
                                    data-radnik-name="{{$value['ime']}}" data-record-id="{{$value['id']}}">
                                    @if($value['status_poentaze']==StatusRadnikaObracunskiKoef::POSLATNAPROVERU)
                                        <span class="status_icon text-success">   <i class="fas fa-check"></i></span>
                                    @elseif($value['status_poentaze']==StatusRadnikaObracunskiKoef::POSLATNAPROVERU)
                                        <span class="status_icon text-warning">   <i class="far fa-bell"></i></span>
                                    @elseif($value['status_poentaze']==StatusRadnikaObracunskiKoef::ODOBREN)
                                        <span class="status_icon text-danger">   <i
                                                class=" far fa-times-circle"></i></span>
                                    @endif
                                </td>
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
                                <td></td>
                                <td></td>

                            </tr>
                        </tbody>
                    </table>
                    <div class="container-fluid">
                        {!! $vrstePlacanjaDescription !!}
                    </div>
                    @if(isset($mesecnaTabelaPoentazaPermissions[$key]))
                        <div class="row mt-5 mb-5 border">
                            <div class="col-3">
                            </div>
                            <div class="col-3">
                                <h2>Poenteri:</h2>
                                <div class="d-flex flex-column align-items-start">
                                    @foreach($mesecnaTabelaPoentazaPermissions[$key]['poenterData'] as $poenterId => $poenterStatusData)
                                        @if($userPermission->role_id == UserRoles::ADMINISTRATOR || $userPermission->role_id == UserRoles::SUPERVIZOR || $userPermission->role_id == UserRoles::PROGRAMER)
                                            <button class="administrator-config btn btn-link"
                                                    data-permission-record-id='{{$mesecnaTabelaPoentazaPermissions[$key]['permission_record_id']}}'
                                                    data-user-id='{{$poenterId}}'
                                                    data-status-type='poenteri_status'
                                            >
                                                {{$poenterStatusData['name'] }} -
                                                <b> {{StatusPoenteraObracunskiKoef::all()[$poenterStatusData['status']]}}</b>
                                            </button>
                                        @else
                                            <p>{{$poenterStatusData['name'] }} -
                                                <b> {{StatusPoenteraObracunskiKoef::all()[$poenterStatusData['status']]}}</b>
                                            </p>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-3">
                                <h2>Odgovorna lica:</h2>
                                <div class="d-flex flex-column align-items-start">
                                    @foreach($mesecnaTabelaPoentazaPermissions[$key]['odgovornaLicaData'] as $odgovornoLiceId => $odgovornaLicaDataStatusData)
                                        @if($userPermission->role_id == UserRoles::ADMINISTRATOR || $userPermission->role_id == UserRoles::SUPERVIZOR || $userPermission->role_id == UserRoles::PROGRAMER)
                                            <button class="administrator-config btn btn-link"
                                                    data-permission-record-id='{{$mesecnaTabelaPoentazaPermissions[$key]['permission_record_id']}}'
                                                    data-user-id='{{$odgovornoLiceId}}'
                                                    data-status-type='odgovorna_lica_status'
                                            >
                                                {{$odgovornaLicaDataStatusData['name'] }} -
                                                <b> {{StatusOdgovornihLicaObracunskiKoef::all()[$odgovornaLicaDataStatusData['status']]}}</b>
                                            </button>
                                        @else
                                            <p>{{$odgovornaLicaDataStatusData['name'] }} -
                                                <b> {{StatusOdgovornihLicaObracunskiKoef::all()[$odgovornaLicaDataStatusData['status']]}}</b>
                                            </p>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-3 text-right">
                            </div>
                        </div>
                    @endif
                    <div class="end_org_celina"></div>
                </div>
                    @endif
                    @endforeach

                        <div class="container mt-5 mb-5 text-center">
                            <div class="row">
                                <div class="col-3">
                                </div>
                                <div class="col-3">
                                    <form class="loaderEvent" method="POST" action="{{route('datotekaobracunskihkoeficijenata.odobravanje_export_pdf_org_celine')}}">
                                        @csrf
                                        <input type="hidden" name="approved_org_celine" value="{{json_encode($approvedOrganizacioneCeline)}}">
                                        <input type="hidden" name="month_id" value="{{$monthData->id}}">
                                        <button type="submit" id='export-pdf' class="btn btn-secondary btn-lg">PDF</button>
                                    </form>
                                </div>
                                <div class="col-3">
                                    <form class="loaderEvent" method="POST" action="{{route('datotekaobracunskihkoeficijenata.odobravanje_export_excel_org_celine')}}">
                                        @csrf
                                        <input type="hidden" name="approved_org_celine" value="{{json_encode($approvedOrganizacioneCeline)}}">
                                        <input type="hidden" name="month_id" value="{{$monthData->id}}">
                                        <button type="submit" id='export-pdf' class="btn btn-secondary btn-lg">Excel</button>
                                    </form>
                                </div>
                            </div>

                            <iframe id="hiddenIframe" name="hiddenIframe" style="display:none;"></iframe>

                        </div>
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
            setTimeout(function () {
                $('input').prop('disabled', false);
            }, 3000);

            $('[data-toggle="tooltip"]').tooltip({'trigger': 'focus'})

        });
    </script>
    <script src="{{ asset('modules/obracunzarada/datotekaobracunskihkoef_odobravanje/ajax_logic.js') }}"></script>
    <script src="{{ asset('modules/obracunzarada/datotekaobracunskihkoef_odobravanje/modal_logic.js') }}"></script>
    <script src="{{ asset('modules/obracunzarada/datotekaobracunskihkoef_odobravanje/recalculate_logic.js') }}"></script>


    {{--    dodaj nov fajl koji ce da sredjuje kalkulaciju --}}
    <script src="{{asset('admin_assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>

@endsection
