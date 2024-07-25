@extends('obracunzarada::theme.layout.app')

@section('custom-styles')

@endsection

@section('content')

    <div class="container">
        <form>
            @csrf
        </form>
        <div class="content">
            <!-- Content Header (Page header) -->
            <div class="content-header">
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <!-- /.content -->
            <h1 class="text-center"> Troškovna mesta</h1>
            @if(count($data) > 0)
                <table class="table table-bordered table-striped mt-5">
                    <thead>
                    <tr>
                        <th>Sifra troskovnog mesta</th>
                        <th>Poenteri</th>
                        <th>Dodaj poentera</th>
                        <th>Odgovorna lica</th>
                        <th>Dodaj odgovorno lice</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td class="text-center"><b>{{ $item->organizaciona_celina_id }}</b></td>
                            <td>
                                @foreach($item->poenteri_ids as $userId)
                                    <p style="display:block;width:100%;"> {{$radniciFullData[$userId]->maticni_broj}} {{$radniciFullData[$userId]->prezime}}  {{$radniciFullData[$userId]->ime}}  <a href="#"><i class="fa fa-times text-danger delete-poenter" aria-hidden="true" data-user-id='{{$userId}}' data-org-celina="{{$item->organizaciona_celina_id}}" data-month-id='{{$item->obracunski_koef_id}}' ></i></a> </p>

                                @endforeach
                            </td>
                            <td class="text-center">
                                <!-- Edit button -->
                                <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-database add-poenter" aria-hidden="true" data-org-celina="{{$item->organizaciona_celina_id}}" data-month-id='{{$item->obracunski_koef_id}}'></i></a>
                            </td>
                            <td>
                                @foreach($item->odgovorna_lica_ids as $userId)
                                    <p style="display:block;width:100%;"> {{$radniciFullData[$userId]->maticni_broj}} {{$radniciFullData[$userId]->prezime}}  {{$radniciFullData[$userId]->ime}} <a href="#"><i class="fa fa-times text-danger delete-odg-lice" aria-hidden="true" data-user-id='{{$userId}}' data-org-celina="{{$item->organizaciona_celina_id}}" data-month-id='{{$item->obracunski_koef_id}}' ></i></a> </p>
                                @endforeach
                            </td>
                            <td class="text-center">
                                <!-- Edit button -->
                                <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-database add-odg-lice" aria-hidden="true"  data-org-celina="{{$item->organizaciona_celina_id}}" data-month-id='{{$item->obracunski_koef_id}}'></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p>No data available.</p>
            @endif
        </div>

        <!-- /.content-wrapper -->
    </div>

    <div class="modal fade" id="poenterModal" tabindex="-1" role="dialog" aria-labelledby="poenterModalLabel" data-backdrop="false" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="poenterModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" name="month_id_poenter_modal" id="month_id_poenter_modal" value="">
                        <input type="hidden" name="org_celina_poenter_modal" id="org_celina_poenter_modal" value="">

                        <div class="form-group">
                            <label for="selectOption">Poenteri</label>
                            <select class="form-control" id="poenter_selected_id">
                                @foreach($selectPoenteri as $poenter)
                                    <option value="{{$poenter}}">{{$poenter}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" id="izmeniPoenterModal">Izmeni</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="odgLiceModal" tabindex="-1" role="dialog" aria-labelledby="odgLiceModalLabel" data-backdrop="false" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="odgLiceModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" name="month_id_odg_lica_modal" id="month_id_odg_lica_modal" value="">
                        <input type="hidden" name="org_celina_odg_lica_modal" id="org_celina_odg_lica_modal" value="">

                        <div class="form-group">
                            <label for="selectOption">Odgovorna lica</label>
                            <select class="form-control" id="odg_lice_selected_id">
                                @foreach($selectOdgovornaLica as $odgLice)
                                    <option value="{{$odgLice}}">{{$odgLice}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" id="izmeniOdgovornoLiceModal">Izmeni</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection



@section('custom-scripts')
    <script>


        $(document).ready(function () {

            $(document).on('click', 'body .delete-poenter', function (e) {

                var month_id = $(this).data('month-id');
                var user_id = $(this).data('user-id');
                var org_celina_id = $(this).data('org-celina');

                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: '{{route('datotekaobracunskihkoeficijenata.brisanje_pristupa')}}',
                    type: 'POST',
                    data: {
                        month_id:month_id,
                        user_id:user_id,
                        org_celina_id:org_celina_id,
                        type:'poenter_delete',
                        _token: _token
                    },
                    success: function (response) {
                        window.location.reload();

                    },
                    error: function (response) {
                    }
                });

            });


            $(document).on('click', 'body .delete-odg-lice', function (e) {


                var month_id = $(this).data('month-id');
                var user_id = $(this).data('user-id');
                var org_celina_id = $(this).data('org-celina');

                var _token = $('input[name="_token"]').val();


                $.ajax({
                    url: '{{route('datotekaobracunskihkoeficijenata.brisanje_pristupa')}}',
                    type: 'POST',
                    data: {
                        month_id:month_id,
                        user_id:user_id,
                        org_celina_id:org_celina_id,
                        type:'odg_lice_delete',
                        _token: _token
                    },
                    success: function (response) {
                        window.location.reload();

                    },
                    error: function (response) {
                    }
                });
            });





            $(document).on('click', 'body .add-poenter', function (e) {

                $('#poenterModal').modal('show');
                var monthId= $(this).data('month-id');
                var orgCelinaId= $(this).data('org-celina');
                $('#month_id_poenter_modal').val(monthId);
                $('#org_celina_poenter_modal').val(orgCelinaId);
                $('#poenterModalLabel').text(orgCelinaId + '- Nov poenter')

            });

            $(document).on('click', 'body .add-odg-lice', function (e) {

                $('#odgLiceModal').modal('show');


                $('#month_id_odg_lica_modal').val($(this).data('month-id'));
                $('#org_celina_odg_lica_modal').val($(this).data('org-celina'));
                $('#odgLiceModalLabel').text($(this).data('org-celina') + '- Novo odgovorno lice');


            });




            $(document).on('click', 'body #izmeniPoenterModal', function (e) {
                var month_id = $('#month_id_poenter_modal').val();
                var org_celina_id = $('#org_celina_poenter_modal').val();
                var user_id = $('#poenter_selected_id').val();
                var _token = $('input[name="_token"]').val();

                var url = '{{route('datotekaobracunskihkoeficijenata.izmena_pristupa')}}';


                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        month_id:month_id,
                        user_id:user_id,
                        org_celina_id:org_celina_id,
                        type:'poenter_dodaj',
                        _token: _token
                    },
                    success: function (response) {
                        window.location.reload();

                    },
                    error: function (response) {
                    }
                });


            });

            $(document).on('click', 'body #izmeniOdgovornoLiceModal', function (e) {
                var month_id = $('#month_id_odg_lica_modal').val();
                var org_celina_id = $('#org_celina_odg_lica_modal').val();

                var user_id = $('#odg_lice_selected_id').val();

                var url = '{{route('datotekaobracunskihkoeficijenata.izmena_pristupa')}}';
                var _token = $('input[name="_token"]').val();


                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        month_id:month_id,
                        user_id:user_id,
                        org_celina_id:org_celina_id,
                        type:'odg_lice_dodaj',
                        _token: _token
                    },
                    success: function (response) {
                        window.location.reload();

                    },
                    error: function (response) {
                    }
                });

            });



        })


    </script>
@endsection

