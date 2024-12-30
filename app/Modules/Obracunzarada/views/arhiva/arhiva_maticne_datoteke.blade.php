<?php use App\Modules\Obracunzarada\Consts\UserRoles; ?>

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tempus Dominus CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tempusdominus-bootstrap-4@5.39.0/build/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

    <style>
        .select2-selection__rendered {
            line-height:14px !important;
        }
        .form-container {
            /*max-width: 600px;*/
            /*margin: 200px auto;*/
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            margin-bottom: 30px;
            text-align: center;
        }
        </style>
@endsection

@section('content')
    <div class="container mb-5">
        <div class="content mb-5" >
            <h1 class="text-center">Arhiva matične datoteke za: <b>{{$archiveDate}}</b></h1>
     </div>
        <div class="row  justify-content-center">
            <div class="col-sm-6 form-container p-5">
                <div class="">
                    <form method="GET" action="{{route('arhiva.mesec')}}">
                        @csrf
                        <div class="form-group">
                            <div class="input-group" data-target-input="nearest">
                                <select class="form-control custom-select maticni_broj_mesec" id="maticni_broj_mesec" name="maticni_broj_mesec"
                                        aria-describedby="maticni_broj_mesec">
                                </select>
                            </div>
                        </div>
                        <div class="form-group" >
                            <div class="input-group date datetimepicker-icon" id="datetimepicker" data-target-input="nearest">
                                <input type="text" id="arhiva_datum_mesec" name="arhiva_datum_mesec" class="form-control datetimepicker-input" data-target="#datetimepicker" />
                                <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary btn-block arhiva_maticne_datoteke">Nov pregled</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="content">
            <!-- Content Header (Page header) -->
            <div class="content-header">
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <!-- /.content -->
            <div class="container">
                <div class="row justify-content-center">
                    <h3 id="error-validator-text" class="text-danger d-none font-weight-bold"></h3>

                    <form id="maticnadatotekaradnika" method="post"
                          action="{{ route('maticnadatotekaradnika.store')}}">
                        @csrf
                        <!-- 1. Maticni broj, Select option -->
                        <input type="hidden" name="user_id" id="user_id">


                        @if($arhivaMdr->isNotEmpty())

                       @foreach($arhivaMdr[0]->toArray() as $key=> $value)
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold"
                                          id="{{$key}}">{{$key}}</span>
                                </div>

                                <input type="text" class="form-control" disabled id="MBRD_maticni_broj"
                                       aria-describedby="{{$key}}"
                                       value="{{$value}}"
                                       name="MBRD_maticni_broj">
                            </div>
                        @endforeach

                        @else
                            <h1 class="text-center mt-5">Podaci za unete parametre ne postoje</h1>
                        @endif
                        {{--                                <input type="hidden" id="prezime_value">--}}

                        {{--                                <input type="text" class="form-control" id="prezime" aria-describedby="prezime">--}}

                    </form>
                </div>
            </div>
            <div class="container-fluid">
                <h1>Prikaz po vrsti placanja</h1>
                @if($darhData->isNotEmpty())
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Sifra placanja</th>
                            <th>Naziv</th>
                            <th>Sati</th>
                            <th>Procenat</th>
                            <th>Iznos</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($darhData as $row)
                            <tr>
                                <td>{!! $row->sifra_vrste_placanja !!}</td>
                                <td>{!! $row->naziv_vrste_placanja !!}</td>
                                <td>{!! $row->sati !!}</td>
                                <td>{!! $row->procenat !!}</td>
                                <td>{!! $row->iznos !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
    </div>
    <!-- /.content-wrapper -->
    </div>
@endsection



@section('custom-scripts')
    <script src="{{asset('admin_assets/plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- Tempus Dominus JS -->
    <script src="https://cdn.jsdelivr.net/npm/tempusdominus-bootstrap-4@5.39.0/build/js/tempusdominus-bootstrap-4.min.js"></script>
    <script>
        $(document).on('click', 'body .arhiva_maticne_datoteke', function (e) {
            // var id = $(this).data('month_id');
            // window.location.href = showRoute + id;
            // maticni_broj_mesec
            // arhiva_datum_mesec
            var maticniBroj = $('#maticni_broj_mesec').val();
            var datum = $('#arhiva_datum_mesec').val();

            if(maticniBroj !=='' && datum !==''){

                window.location.href = '{{ route('arhiva.arhivaMaticneDatoteke') }}' +
                    '?maticniBroj=' + encodeURIComponent(maticniBroj) +
                    '&datum=' + encodeURIComponent(datum);

                // Redirect to the constructed URL
            }

        });

        $(function () {
            $('.datetimepicker-icon').datetimepicker({
                format: 'MM.YYYY'
            });
        });

        $(document).ready(function () {
            $('#datetimepicker1').datetimepicker({
                format: 'MM.YYYY'
            });

            $('#datetimepicker2').datetimepicker({
                format: 'MM.YYYY'
            });


            var data ={!! json_encode($radniciSelectData) !!};

            $(".maticni_broj_mesec").select2({
                data: data,
                // width: 'resolve'
            })

        });
    </script>
@endsection

