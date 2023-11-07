@extends('adminlte.layout.app')

@section('custom-styles')


@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">

        </div>
        <!-- /.content-header -->
        <div class="content pl-5 pr-5 ">
            <div class="container pl-5 pr-5 border">
                <h5 class="pt-2 text-center">Podešavanje korisničkog pristupa za:</h5>
                <h2 class="pb-5 pt-2 text-center">{{$userData->name}}</h2>
                <form id="permissions_config_update" name="permissions_config_update" id="permissions_config_update" method="post" action="{{url('/user/permissions_config_update')}}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="user_id" id="user_id" value="{{$userData->id}}">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <h2 class="h4">Osnovni podaci <i class="text-danger">*</i></h2>
                                <p>
                                    <input type="checkbox" name="osnovni_podaci" id="osnovni_podaci" @if($permissions->osnovni_podaci) checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <h2 class="h4">Finansijsko knjigovodstvo<i class="text-danger">*</i></h2>
                                <p><input type="checkbox" name="finansijsko_k"  id="finansijsko_k"  @if($permissions->finansijsko_k) checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <h2 class="h4">Materijalno knjigovodstvo <i class="text-danger">*</i></h2>
                               <p><input type="checkbox" name="materijalno_k"  id="materijalno_k"  @if($permissions->materijalno_k) checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success">
                               </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <h2 class="h4">Pogonsko knjigovodstvo<i class="text-danger">*</i></h2>
                                <p><input type="checkbox" name="pogonsko" id="pogonsko"  @if($permissions->pogonsko) checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <h2 class="h4">Magacini<i class="text-danger">*</i></h2>
                                <p><input type="checkbox" name="magacini" id="magacini"  @if($permissions->magacini) checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <h2 class="h4">Osnovna sredstva<i class="text-danger">*</i></h2>
                                <p><input type="checkbox" name="osnovna_sredstva" id="osnovna_sredstva"  @if($permissions->osnovna_sredstva) checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <h2 class="h4">Kadrovska evidencija<i class="text-danger">*</i></h2>
                                <p><input type="checkbox" name="kadrovska_evidencija" id="kadrovska_evidencija"  @if($permissions->kadrovska_evidencija) checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <h2 class="h4">Obračun zarada<i class="text-danger">*</i></h2>
                                <p><input type="checkbox" name="obracun_zarada" id="obracun_zarada" @if($permissions->obracun_zarada) checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <h2 class="h4">Tehnologija<i class="text-danger">*</i></h2>
                                <p><input type="checkbox" name="tehnologija" id="tehnologija"  @if($permissions->tehnologija) checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <h2 class="h4">Proizvodnja<i class="text-danger">*</i></h2>
                                <p><input type="checkbox" name="proizvodnja" id="proizvodnja"  @if($permissions->proizvodnja) checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-5 mb-5">
                        <div class="col-md-12">
                            <div class="float-right">
                                <a href="{{url('user/index')}}"> <button type="button" class="btn btn-success">Pregled radnika</button></a>
                                <button type="submit" class="btn btn-primary  ml-2">Sačuvaj izmene</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>
    <!-- /.content-wrapper -->
@endsection


@section('custom-scripts')
    <script src="{{asset('admin_assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
    <script>
        $(function () {
            $("input[data-bootstrap-switch]").each(function(){
                $(this).bootstrapSwitch.defaults.onText='Dostupno';
                $(this).bootstrapSwitch.defaults.offText='Nedostupno';
                $(this).bootstrapSwitch('state', $(this).prop('checked'));

            });
        });
    </script>
@endsection

