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
            max-width: 600px;
            margin: 200px auto;
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
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-container">
                    <h2 class="form-title">Arhiva za mesec</h2>
                    <form method="GET" action="{{route('arhiva.mesec')}}">
                        @csrf
                        <div class="form-group">
                            <label for="datetimepicker">Matični broj</label>
                            <div class="input-group" data-target-input="nearest">
                                <select class="form-control custom-select maticni_broj_mesec" id="maticni_broj_mesec" name="maticni_broj_mesec"
                                        aria-describedby="maticni_broj_mesec">
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 100px">
                            <label for="datetimepicker">Mesec - Godina</label>
                            <div class="input-group date datetimepicker-icon" id="datetimepicker" data-target-input="nearest">
                                <input type="text" id="arhiva_datum_mesec" name="arhiva_datum_mesec" class="form-control datetimepicker-input" data-target="#datetimepicker" />
                                <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary btn-block arhiva_maticne_datoteke"> Arhiva maticne datoteke</button>
                        <button type="button" class="btn btn-primary btn-block obracunske_liste"> Obracunske liste</button>
                        <button type="button" class="btn btn-secondary btn-block ukupna_rekapitulacija">Ukupna rekapitulacija</button>

                    </form>
                </div>

            </div>
            <div class="col-sm-6">
                <div class="form-container">
                    <h2 class="form-title">Arhiva za period</h2>
                    <form method="GET" action="{{route('arhiva.mesec')}}">
                        @csrf
                        <div class="form-group">
                            <label for="datetimepicker">Matični broj</label>
                            <div class="input-group  data-target-input="nearest">
                            <select class="custom-select form-control maticni_broj_period" id="maticni_broj_period" name="maticni_broj_period"
                                    aria-describedby="maticni_broj_period">
                            </select>
                            </div>



                        </div>
                <div class="form-group">
                    <label for="datetimepicker1">Period od:</label>
                    <div class="input-group date datetimepicker-icon" id="datetimepicker1" data-target-input="nearest">
                        <input type="text" id="arhiva_datum_od" name="arhiva_datum_od" class="form-control datetimepicker-input" data-target="#datetimepicker1" />
                        <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="datetimepicker2">Period do:</label>
                    <div class="input-group date datetimepicker-icon" id="datetimepicker2" data-target-input="nearest">
                        <input type="text" id="arhiva_datum_do" name="arhiva_datum_do" class="form-control datetimepicker-input" data-target="#datetimepicker2" />
                        <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>

                        <button type="button" class="btn btn-primary btn-block potvrda_proseka">Potvrda (prosek)</button>
                        <button type="button" class="btn btn-primary btn-block godisnji_karton"> Godisnji karton</button>
                        <button type="button" class="btn btn-secondary btn-block ppp_prijava"> PPP Prijava</button>

                    </form>
                </div>

            </div>

        </div>
    </div>
@endsection



@section('custom-scripts')
    <script src="{{asset('admin_assets/plugins/select2/js/select2.full.min.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- Tempus Dominus JS -->
    <script src="https://cdn.jsdelivr.net/npm/tempusdominus-bootstrap-4@5.39.0/build/js/tempusdominus-bootstrap-4.min.js"></script>
    <script>


        // arhiva_maticne_datoteke
        // obracunske_liste
        // ukupna_rekapitulacija
        // potvrda_proseka
        // godisnji_karton
        // ppp_prijava

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

        $(document).on('click', 'body .obracunske_liste', function (e) {
            // var id = $(this).data('month_id');
            // window.location.href = showRoute + id;
            var maticniBroj = $('#maticni_broj_mesec').val();
            var datum = $('#arhiva_datum_mesec').val();

            if(maticniBroj !=='' && datum !=='') {

                window.location.href = '{{ route('arhiva.obracunskeListe') }}' +
                    '?maticniBroj=' + encodeURIComponent(maticniBroj) +
                    '&datum=' + encodeURIComponent(datum);

                // Redirect to the constructed URL

            }
        });

        $(document).on('click', 'body .ukupna_rekapitulacija', function (e) {
            var maticniBroj = $('#maticni_broj_mesec').val();
            var datum = $('#arhiva_datum_mesec').val();

            if(datum !=='') {
                // Construct the URL with query parameters
                window.location.href ='{{ route('arhiva.ukupnaRekapitulacija') }}' +
                    '?datum=' + encodeURIComponent(datum);

                // Redirect to the constructed URL
            }
        });

        $(document).on('click', 'body .potvrda_proseka', function (e) {
            // var id = $(this).data('month_id');
            // window.location.href = showRoute + id;
            var maticniBroj = $('#maticni_broj_period').val();
            var datumOd = $('#arhiva_datum_od').val();
            var datumDo = $('#arhiva_datum_do').val();


            if (maticniBroj !== '' && datumOd !== '' && datumDo!== '') {
                window.location.href ='{{ route('arhiva.potvrdaProseka') }}' +
                    '?maticniBroj=' + encodeURIComponent(maticniBroj) +
                    '&datumOd=' + encodeURIComponent(datumOd) +
                    '&datumDo=' + encodeURIComponent(datumDo);

            }

        });

        $(document).on('click', 'body .godisnji_karton', function (e) {
            // var id = $(this).data('month_id');
            // window.location.href = showRoute + id;
            var maticniBroj = $('#maticni_broj_period').val();
            var datumOd = $('#arhiva_datum_od').val();
            var datumDo = $('#arhiva_datum_do').val();


            if (maticniBroj !== '' && datumOd !== '' && datumDo!== '') {
                window.location.href ='{{ route('arhiva.godisnjiKarton') }}' +
                    '?maticniBroj=' + encodeURIComponent(maticniBroj) +
                    '&datumOd=' + encodeURIComponent(datumOd) +
                    '&datumDo=' + encodeURIComponent(datumDo);

            }
        });

        $(document).on('click', 'body .ppp_prijava', function (e) {
            // var id = $(this).data('month_id');
            var maticniBroj = $('#maticni_broj_period').val();
            var datumOd = $('#arhiva_datum_od').val();
            var datumDo = $('#arhiva_datum_do').val();

            if (maticniBroj !== '' && datumOd !== '' && datumDo!== '') {
                window.location.href = '{{ route('arhiva.pppPrijava') }}' +
                    '?maticniBroj=' + encodeURIComponent(maticniBroj) +
                    '&datumOd=' + encodeURIComponent(datumOd) +
                    '&datumDo=' + encodeURIComponent(datumDo);
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


            $(".maticni_broj_period").select2({
                data: data,
                // width: 'resolve'
            })

            $(".maticni_broj_mesec").select2({
                data: data,
                // width: 'resolve'
            })




        });



        // $(function () {
        //     $('#datetimepicker2').datetimepicker({
        //         format: 'MM.YYYY'
        //     });
        // });
        // $(function () {
        //     $('#datetimepicker3').datetimepicker({
        //         format: 'MM.YYYY'
        //     });
        // });
    </script>
@endsection

