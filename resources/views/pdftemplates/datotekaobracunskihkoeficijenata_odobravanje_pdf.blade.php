@php use App\Modules\Obracunzarada\Consts\StatusOdgovornihLicaObracunskiKoef;use App\Modules\Obracunzarada\Consts\StatusPoenteraObracunskiKoef;use App\Modules\Obracunzarada\Consts\StatusRadnikaObracunskiKoef;use App\Modules\Obracunzarada\Consts\UserRoles; @endphp
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Fom cloud app</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('admin_assets/dist/css/adminlte.min.css')}}">
    @yield('custom-styles')
</head>
<style>
    html {
        zoom: 83% !important;
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

<body class="hold-transition sidebar-mini  sidebar-collapse">
<div class="wrapper">

@foreach($mesecnaTabelaPotenrazaTable as $key => $organizacionacelina)
    @if(isset($troskovnaMestaPermission[$key]) && $troskovnaMestaPermission[$key])
        <div class="table-div mt-5">
            <h3 class="text-center"> Organizaciona celina: <b>{{$key}} </b> -
                &nbsp{{$organizacionacelina[0]->organizacionecelina->naziv_troskovnog_mesta}}.</h3>
            <div class="divider"></div>
            <table class="table table-striped" id="table-div{{$key}}">
                <thead>
                <tr>
                    @foreach($tableHeaders as $keyheader =>$header)
                        <th>{{ $header }}</th>
                    @endforeach
{{--                    <th>Napomena</th>--}}
{{--                    <th>STATUS</th>--}}

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
                                                                 class="vrsta_placanja_input"
                                                                 data-toggle="tooltip"
                                                                 data-placement="top"
                                                                 title={{ $vrstaPlacanja['name']}} data-vrsta-placanja-key={{$vrstaPlacanja['key']}} value={{ $vrstaPlacanja['sati']}}>
                            </td>
                        @endforeach
{{--                        <td class="napomena_td" data-napomena-value="{{$value['napomena']}}"--}}
{{--                            data-radnik-name="{{$value['ime']}}" data-record-id="{{$value['id']}}">--}}
{{--                            @if($value['napomena'])--}}
{{--                                <span class="napomena text-danger">   <i class="fas fa-sticky-note"></i></span>--}}
{{--                            @else--}}
{{--                                <span class="napomena text-primary">  <i class="fas fa-plus"--}}
{{--                                                                         aria-hidden="true"></i></span>--}}
{{--                            @endif--}}
{{--                        </td>--}}
{{--                        <td class="status_td" data-status-value="{{$value['status_poentaze']}}"--}}
{{--                            data-radnik-name="{{$value['ime']}}" data-record-id="{{$value['id']}}">--}}
{{--                            @if($value['status_poentaze']==StatusRadnikaObracunskiKoef::POSLATNAPROVERU)--}}
{{--                                <span class="status_icon text-success">   <i class="fas fa-check"></i></span>--}}
{{--                            @elseif($value['status_poentaze']==StatusRadnikaObracunskiKoef::POSLATNAPROVERU)--}}
{{--                                <span class="status_icon text-warning">   <i class="far fa-bell"></i></span>--}}
{{--                            @elseif($value['status_poentaze']==StatusRadnikaObracunskiKoef::ODBIJEN)--}}
{{--                                <span class="status_icon text-danger">   <i--}}
{{--                                        class=" far fa-times-circle"></i></span>--}}
{{--                            @endif--}}
{{--                        </td>--}}
                        @endforeach
                    </tr>
                </tbody>
            </table>
            <div class="container-fluid">
                {!! $vrstePlacanjaDescription !!}
            </div>
{{--            @if(isset($mesecnaTabelaPoentazaPermissions[$key]))--}}
{{--                <div class="row mt-5 mb-5 border">--}}
{{--                    <div class="col-3">--}}
{{--                    </div>--}}
{{--                    <div class="col-3">--}}
{{--                        <h2>Poenteri:</h2>--}}
{{--                        <div class="d-flex flex-column align-items-start">--}}
{{--                            @foreach($mesecnaTabelaPoentazaPermissions[$key]['poenterData'] as $poenterId => $poenterStatusData)--}}
{{--                                @if($userPermission->role_id == UserRoles::ADMINISTRATOR)--}}
{{--                                    <button class="administrator-config btn btn-link"--}}
{{--                                            data-permission-record-id='{{$mesecnaTabelaPoentazaPermissions[$key]['permission_record_id']}}'--}}
{{--                                            data-user-id='{{$poenterId}}'--}}
{{--                                            data-status-type='poenteri_status'--}}
{{--                                    >--}}
{{--                                        {{$poenterStatusData['name'] }} ---}}
{{--                                        <b> {{StatusPoenteraObracunskiKoef::all()[$poenterStatusData['status']]}}</b>--}}
{{--                                    </button>--}}
{{--                                @else--}}
{{--                                    <p>{{$poenterStatusData['name'] }} ---}}
{{--                                        <b> {{StatusPoenteraObracunskiKoef::all()[$poenterStatusData['status']]}}</b>--}}
{{--                                    </p>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-3">--}}
{{--                        <h2>Odgovorna lica:</h2>--}}
{{--                        <div class="d-flex flex-column align-items-start">--}}
{{--                            @foreach($mesecnaTabelaPoentazaPermissions[$key]['odgovornaLicaData'] as $odgovornoLiceId => $odgovornaLicaDataStatusData)--}}
{{--                                @if($userPermission->role_id == UserRoles::ADMINISTRATOR)--}}
{{--                                    <button class="administrator-config btn btn-link"--}}
{{--                                            data-permission-record-id='{{$mesecnaTabelaPoentazaPermissions[$key]['permission_record_id']}}'--}}
{{--                                            data-user-id='{{$odgovornoLiceId}}'--}}
{{--                                            data-status-type='odgovorna_lica_status'--}}
{{--                                    >--}}
{{--                                        {{$odgovornaLicaDataStatusData['name'] }} ---}}
{{--                                        <b> {{StatusPoenteraObracunskiKoef::all()[$odgovornaLicaDataStatusData['status']]}}</b>--}}
{{--                                    </button>--}}
{{--                                @else--}}
{{--                                    <p>{{$odgovornaLicaDataStatusData['name'] }} ---}}
{{--                                        <b> {{StatusOdgovornihLicaObracunskiKoef::all()[$odgovornaLicaDataStatusData['status']]}}</b>--}}
{{--                                    </p>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-3 text-right">--}}
{{--                        @if(isset($mesecnaTabelaPoentazaPermissions[$key]['odgovornaLicaData'][auth()->user()->id]))--}}
{{--                            <button class="change-status btn btn-primary"--}}
{{--                                    style="display: none"--}}
{{--                                    data-status-type="odgovorna_lica_status"--}}
{{--                                    data-permission-record-id={{$mesecnaTabelaPoentazaPermissions[$key]['permission_record_id']}}--}}
{{--                                        data-status="1"--}}
{{--                                    data-user-id="{{auth()->user()->id}}"--}}
{{--                            >Odobri--}}
{{--                            </button>--}}
{{--                            <button class="change-status btn btn-dark"--}}
{{--                                    data-status-type="odgovorna_lica_status"--}}
{{--                                    data-permission-record-id={{$mesecnaTabelaPoentazaPermissions[$key]['permission_record_id']}}--}}
{{--                                        data-status="2" data-user-id="{{auth()->user()->id}}"--}}
{{--                            >Odbij--}}
{{--                            </button>--}}
{{--                        @endif--}}



{{--                        @if(isset($mesecnaTabelaPoentazaPermissions[$key]['poenterData'][auth()->user()->id]))--}}
{{--                            <button class="change-status btn btn-success" data-status-type="poenteri_status"--}}
{{--                                    data-permission-record-id={{$mesecnaTabelaPoentazaPermissions[$key]['permission_record_id']}}--}}
{{--                                        data-status="1"--}}
{{--                                    data-user-id="{{auth()->user()->id}}"--}}
{{--                            >Zatvori/zakljuci podatke--}}
{{--                            </button>--}}
{{--                            <button class="change-status btn btn-danger"--}}
{{--                                    data-status-type="poenteri_status"--}}
{{--                                    data-permission-record-id={{$mesecnaTabelaPoentazaPermissions[$key]['permission_record_id']}}--}}
{{--                                        data-status="2" data-user-id="{{auth()->user()->id}}"--}}
{{--                            >Ponovo menjaj--}}
{{--                            </button>--}}
{{--                        @endif--}}


{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
            <div class="end_org_celina"></div>

    @endif
@endforeach

        </div>
</div>

</body>
</html>
