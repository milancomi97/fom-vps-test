@php use App\Modules\Obracunzarada\Consts\StatusRadnikaObracunskiKoef; @endphp
@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <style>
        .ime_prezime {
            display: block;
            width: 250px;
        }

        .tooltip {
            font-weight: 800;
            font-size: large;
        }

        .main-container {
            margin-left: 100px !important;
        }

        .vrsta_placanja_input {
            width: 50px;
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

        .status_icon{
            font-size: 20px;
        }
        .table-div {
            display: table;
            margin-top: 3rem;
        }
    </style>
@endsection

@section('content')
    <div class="container main-container mb-5">
        <h2>Evidencija rada i odsustvovanje radnika datum: <b>{!! $monthData!!}</b></h2>
        <div class="loader-container" style="text-align: center">
            <h3 id="statusMessage" class="text-success text-center"></h3>
        </div>
        <form>
            @csrf
        </form>
        <div class="loading" style="display: none;">
        </div>
        @foreach($mesecnaTabelaPotenrazaTable as $key => $organizacionacelina)

            @if(isset($troskovnaMestaPermission[$key]) && $troskovnaMestaPermission[$key])
                <div class="table-div">

                    <h3 class="text-center"> Organizaciona celina: <b>{{$key}} </b> -
                        &nbsp{{$organizacionacelina[0]->organizacionecelina->naziv_troskovnog_mesta}}.</h3>

                    <div class="divider"></div>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            @foreach($tableHeaders as $keyheader =>$header)
                                <th>{{ $header }}</th>
                            @endforeach
                            <th>Napomena</th>
                            <th>STATUS</th>

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
                                                                         title={{ $vrstaPlacanja['name']}} data-vrsta-placanja-key={{$vrstaPlacanja['key']}} value={{ $vrstaPlacanja['value']}}>
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
                                    @if($value['status_poentaze']==StatusRadnikaObracunskiKoef::ODOBREN)
                                        <span class="status_icon text-success">   <i class="fas fa-check"></i></span>
                                    @elseif($value['status_poentaze']==StatusRadnikaObracunskiKoef::PROVERAPODATAKA)
                                        <span class="status_icon text-warning">   <i class="far fa-bell"></i></span>
                                    @elseif($value['status_poentaze']==StatusRadnikaObracunskiKoef::PROVERA)
                                        <span class="status_icon text-danger">   <i class=" far fa-times-circle"></i></span>
                                    @endif
                                </td>

                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-8">
                            <h5><b>Status: </b> Nisu svi odobrili/Nisu svi podaci uneti</h5>
                            <p>Više detalja</p>
                        </div>
                        <div class="col-4 text-right">
                            <button class="change-status btn btn-success">Odobri</button>
                            <button class="change-status btn btn-danger">Odbij</button>
                            <button class="change-status btn btn-secondary">Promeni na status 3</button>
                        </div>
                    </div>
                    @endif
                    @endforeach

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

@endsection

@section('custom-scripts')
    <script>
        let storeRoute = '{!! route('datotekaobracunskihkoeficijenata.update') !!}'
    </script>
    <script>

        $(function () {

            $(document).on('click', 'body .change-status', function (event) {
                alert('promena statusa');
            });
            setTimeout(function () {
                $('input').prop('disabled', false);
            }, 3000);

            $('[data-toggle="tooltip"]').tooltip()

        });
    </script>
    <script src="{{ asset('modules/obracunzarada/datotekaobracunskihkoef_show/ajax_logic.js') }}"></script>
    <script src="{{ asset('modules/obracunzarada/datotekaobracunskihkoef_show/modal_logic.js') }}"></script>
@endsection
