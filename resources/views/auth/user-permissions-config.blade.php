@php use App\Modules\Obracunzarada\Consts\UserRoles; @endphp
@extends('obracunzarada::theme.layout.app')

@section('custom-styles')


@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">

        </div>
        <form  name="permissions_config_update" id="permissions_config_update"
              method="post"
              {{--                      action="{{url('/user/permissions_config_update')}}"--}}
              action="{{route('permissionsUpdatePoenter.update')}}"
        >
        <!-- /.content-header -->
        <div class="content pl-5 pr-5 ">
            <div class="container pl-5 pr-5 border">
                <h5 class="pt-2 text-center">Podešavanje korisničkog pristupa za:</h5>
                <h2 class="pb-5 pt-2 text-center">{{$userData->ime}}</h2>

                    {!! csrf_field() !!}
                    <input type="hidden" name="user_id" id="user_id" value="{{$userData->id}}">


                    {{--                    Podesavenje modula --}}

                    {{--                    Podesavenje modula --}}


                    <div class="row">
                        <div class="card card-secondary w-100">
                            <div class="card-header">
                                <h3 class="card-title">Generalno podešavanje:</h3>
                            </div>
                            <div class="card-body">
                                <!-- Minimal style -->
                                <div class="row border-bottom mt-5">
                                    <div class="col-md-6">

                                        <select id="role_id" class="custom-select form-control"
                                                name="role_id">
                                            <option>Izaberite tip korisnika</option>
                                            @foreach(UserRoles::all() as $value => $label)
                                                @if($value == $permissions->role_id)
                                                <option selected value="{{ $value }}">{{ $label }}</option>
                                                @else
                                                <option value="{{ $value }}">{{ $label }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card card-secondary w-100">
                            <div class="card-header">
                                <h3 class="card-title">Podešavanje modula:</h3>
                            </div>
                            <div class="card-body">
                                <!-- Minimal style -->
                                <div class="row border-bottom mt-5">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h2 class="h4">Osnovni podaci <i class="text-danger">*</i></h2>
                                            <p>
                                                <input type="checkbox" name="osnovni_podaci" id="osnovni_podaci"
                                                       @if($permissions->osnovni_podaci) checked
                                                       @endif data-bootstrap-switch data-off-color="danger"
                                                       data-on-color="success">
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h2 class="h4">Finansijsko knjigovodstvo<i class="text-danger">*</i></h2>
                                            <p><input type="checkbox" name="finansijsko_k" id="finansijsko_k"
                                                      @if($permissions->finansijsko_k) checked
                                                      @endif data-bootstrap-switch data-off-color="danger"
                                                      data-on-color="success">
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h2 class="h4">Materijalno knjigovodstvo <i class="text-danger">*</i></h2>
                                            <p><input type="checkbox" name="materijalno_k" id="materijalno_k"
                                                      @if($permissions->materijalno_k) checked
                                                      @endif data-bootstrap-switch data-off-color="danger"
                                                      data-on-color="success">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5 border-bottom">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h2 class="h4">Pogonsko knjigovodstvo<i class="text-danger">*</i></h2>
                                            <p><input type="checkbox" name="pogonsko" id="pogonsko"
                                                      @if($permissions->pogonsko) checked @endif data-bootstrap-switch
                                                      data-off-color="danger" data-on-color="success">
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h2 class="h4">Magacini<i class="text-danger">*</i></h2>
                                            <p><input type="checkbox" name="magacini" id="magacini"
                                                      @if($permissions->magacini) checked @endif data-bootstrap-switch
                                                      data-off-color="danger" data-on-color="success">
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h2 class="h4">Osnovna sredstva<i class="text-danger">*</i></h2>
                                            <p><input type="checkbox" name="osnovna_sredstva" id="osnovna_sredstva"
                                                      @if($permissions->osnovna_sredstva) checked
                                                      @endif data-bootstrap-switch data-off-color="danger"
                                                      data-on-color="success">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5 border-bottom">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h2 class="h4">Kadrovska evidencija<i class="text-danger">*</i></h2>
                                            <p><input type="checkbox" name="kadrovska_evidencija"
                                                      id="kadrovska_evidencija"
                                                      @if($permissions->kadrovska_evidencija) checked
                                                      @endif data-bootstrap-switch data-off-color="danger"
                                                      data-on-color="success">
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h2 class="h4">Obračun zarada<i class="text-danger">*</i></h2>
                                            <p><input type="checkbox" name="obracun_zarada" id="obracun_zarada"
                                                      @if($permissions->obracun_zarada) checked
                                                      @endif data-bootstrap-switch data-off-color="danger"
                                                      data-on-color="success">
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h2 class="h4">Tehnologija<i class="text-danger">*</i></h2>
                                            <p><input type="checkbox" name="tehnologija" id="tehnologija"
                                                      @if($permissions->tehnologija) checked
                                                      @endif data-bootstrap-switch data-off-color="danger"
                                                      data-on-color="success">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5 mb-5 border-bottom">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <h2 class="h4">Proizvodnja<i class="text-danger">*</i></h2>
                                            <p><input type="checkbox" name="proizvodnja" id="proizvodnja"
                                                      @if($permissions->proizvodnja) checked
                                                      @endif data-bootstrap-switch data-off-color="danger"
                                                      data-on-color="success">
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                Objasnjenje
                            </div>
                        </div>
                    </div>


                    {{--


                    {{--                    Podesavenje modula END--}}




            </div>
        </div>
        <div class="row pl-5 pr-5">
            <div class="col-md-6">
                <div class="card card-secondary w-100">
                    <div class="card-header">
                        <h3 class="card-title">Podesavanje pristupa</h3>
                    </div>
                    <div class="card-body">
                        <!-- Minimal style -->
                        <div class="row">
                            <div class="input-group mb-3">
                                @foreach($organizacioneCeline as $celina)

                                    <div class="col-sm-5 mt-2 border-bottom">
                                                <span class="font-weight-bold"
                                                      id="{!! $celina->sifra_troskovnog_mesta !!}">{!! $celina->sifra_troskovnog_mesta !!}  {!! $celina->naziv_troskovnog_mesta !!}</span>
                                    </div>
                                    <div class="col-sm-1 mt-2">
                                        <input type="checkbox"
                                               {{(isset($poenterPermission) && $poenterPermission[$celina->sifra_troskovnog_mesta])  ? 'checked': ''}}  class="form-control"
                                               name="troskovna_mesta_data[{{ $celina->sifra_troskovnog_mesta }}]"
                                               aria-label="{!! $celina->sifra_troskovnog_mesta !!}  {!! $celina->naziv_troskovnog_mesta !!}"
                                               id="{!! $celina->sifra_troskovnog_mesta !!}">
                                    </div>

                                @endforeach
                            </div>

                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        Objasnjenje
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-secondary w-100">
                    <div class="card-header">
                        <h3 class="card-title">Podesavanje odgovornosti poentera</h3>
                    </div>
                    <div class="card-body">
                        @if($permissions->role_id==UserRoles::POENTER)
                            <h1 class="text-center">Jeste poenter</h1>
                        @else
                            <h1 class="text-center">Nije poenter</h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-5 mb-5">
            <div class="col-md-12">
                <div class="float-right">
                    <a href="{{url('user/index')}}">
                        <button type="button" class="btn btn-success">Pregled radnika</button>
                    </a>
                    <button type="submit" class="btn btn-primary  ml-2">Sačuvaj izmene</button>
                </div>
            </div>
        </div>
        </form>
    </div>
    <!-- /.content-wrapper -->
@endsection


@section('custom-scripts')
    <script src="{{asset('admin_assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
    <script>
        $(function () {
            $("input[data-bootstrap-switch]").each(function () {
                $(this).bootstrapSwitch.defaults.onText = 'Dostupno';
                $(this).bootstrapSwitch.defaults.offText = 'Nedostupno';
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            });
        });
    </script>
@endsection

