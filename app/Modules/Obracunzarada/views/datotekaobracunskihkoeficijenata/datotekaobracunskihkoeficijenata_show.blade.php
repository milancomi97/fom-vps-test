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

        .napomena_td{
            text-align:center
        }
        .napomena{
            font-size: 20px;
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

            @if(isset($troskovnaMestaPermission[$key]) && $troskovnaMestaPermission[$key])
            <div class="mt-5">
                <h3 class="text-center"> Organizaciona celina: <b>{{$key}} </b> - &nbsp{{$organizacionacelina[0]->organizacionecelina->naziv_troskovnog_mesta}}.</h3>
                <div class="divider"></div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        @foreach($tableHeaders as $keyheader =>$header)
                            <th>{{ $header }}</th>
                        @endforeach
                        <th>Napomena</th>
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
                            <td class="napomena_td" data-napomena-value="{{$value['napomena']}}" data-radnik-name="{{$value['ime']}}" data-record-id="{{$value['id']}}">
                                    @if($value['napomena'])
                                        <span class="napomena text-danger">   <i class="fas fa-sticky-note"></i></span>
                                    @else
                                        <span class="napomena text-primary">  <i class="fas fa-plus" aria-hidden="true"></i></span>
                                    @endif
                            </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
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
                            <textarea class="form-control" disabled id="napomena_text_old" rows="5"></textarea>
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
@endsection

@section('custom-scripts')
    <script>
        let storeRoute ='{!! route('datotekaobracunskihkoeficijenata.update') !!}'
</script>
    <script>

        $(function () {


            $(document).on('click', 'body .napomena_td', function (event) {
                const row = $(this);
                $('#myModal').modal('show');
                var record_id = event.currentTarget.dataset.recordId
                var napomenaData = event.currentTarget.dataset.napomenaValue;
                var radnikNameData = event.currentTarget.dataset.radnikName;

                $('#radnik_modal').text(radnikNameData);

                $('#napomena_text').val('')
                $('#napomena_text_old').val(napomenaData)
                $('#record_id_modal').val(null);
                $('#record_id_modal').val(record_id);

            });

            $('#submitFormBtn').on('click', function (event) {

                var napomena_text = $('#napomena_text').val()

                if (napomena_text !== '') {
                    event.stopImmediatePropagation();
                    var record_id = $('#record_id_modal').val();
                    debugger;

                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: storeRoute,
                        type: 'POST',
                        data: {
                            record_id:record_id,
                            input_value:napomena_text,
                            input_key:'napomena',
                            _token: _token
                        },
                        success: function (response) {
                            if (response.status) {
                                location.reload()
                            } else {
                                // $("#statusMessage").text(response.message).addClass("text-danger");
                            }
                        },
                        error: function (response) {
                            // $("#statusMessage").text("Greska: " + response.message).addClass("error");
                        }
                    });
                }else{
                    $('#myModal').modal('hide');

                }
            });


            setTimeout(function(){
                $('input').prop('disabled', false);
            }, 3000);

            $('[data-toggle="tooltip"]').tooltip()

        });
    </script>
    <script src="{{ asset('modules/obracunzarada/datotekaobracunskihkoef_show/ajax_logic.js') }}"></script>
@endsection
