<?php use App\Modules\Obracunzarada\Consts\UserRoles; ?>

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tempus Dominus CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tempusdominus-bootstrap-4@5.39.0/build/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet">
    <style>

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
                            <label for="datetimepicker">Matični broj (Search po prezimenu, padajuci meni)</label>
                            <div class="input-group" id="maticni_broj" data-target-input="nearest">
                                <input type="text" name="maticni_broj" class="form-control "/>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 100px">
                            <label for="datetimepicker">Mesec - Godina</label>
                            <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                                <input type="text" name="arhiva_datum" class="form-control datetimepicker-input" data-target="#datetimepicker" />
                                <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block"> Arhiva maticne datoteke</button>
                        <button type="submit" class="btn btn-primary btn-block"> Obracunske liste</button>
                        <button type="submit" class="btn btn-secondary btn-block">Ukupna rekapitulacija</button>

                    </form>
                </div>

            </div>
            <div class="col-sm-6">
                <div class="form-container">
                    <h2 class="form-title">Arhiva za period</h2>
                    <form method="GET" action="{{route('arhiva.mesec')}}">
                        @csrf
                        <div class="form-group">
                            <label for="datetimepicker">Matični broj (Search po prezimenu, padajuci meni)</label>
                            <div class="input-group" id="maticni_broj" data-target-input="nearest">
                                <input type="text" name="maticni_broj" class="form-control "/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="datetimepicker">Period od:</label>
                            <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                                <input type="text" name="arhiva_datum" class="form-control datetimepicker-input" data-target="#datetimepicker" />
                                <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="datetimepicker">Period do:</label>
                            <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                                <input type="text" name="arhiva_datum" class="form-control datetimepicker-input" data-target="#datetimepicker" />
                                <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Potvrda (prosek)</button>
                        <button type="submit" class="btn btn-primary btn-block"> Godisnji karton</button>
                        <button type="submit" class="btn btn-secondary btn-block"> PPP Prijava</button>

                    </form>
                </div>

            </div>

        </div>
    </div>
@endsection



@section('custom-scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- Tempus Dominus JS -->
    <script src="https://cdn.jsdelivr.net/npm/tempusdominus-bootstrap-4@5.39.0/build/js/tempusdominus-bootstrap-4.min.js"></script>
    <script>
        $(function () {
            $('#datetimepicker').datetimepicker({
                format: 'MM.YYYY'
            });
        });
    </script>
@endsection

