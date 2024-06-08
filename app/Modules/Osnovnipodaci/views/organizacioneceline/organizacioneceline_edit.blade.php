@extends('osnovnipodaci::theme.layout.app')

@section('custom-styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

    <style>
        .select2-selection__choice {
            background: #0c84ff !important;
        }

        .error {
            border: 1px solid red;
        }

        .infoAcc {
            margin-bottom: 0;
        }

        #errorContainer {
            color: red;
            text-align: center;
            font-size: 2em;
            margin-bottom: 2em;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="content">
            <!-- Content Header (Page header) -->
            <div class="content-header">
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <!-- /.content -->
            <h1 class="text-center"> Izmena troškovnog mesta</h1>
            <div class="container pb-5 mb-5">
                <form action="{{ route('organizacioneceline.update', ['id' => $data->id]) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="naziv_troskovnog_mesta">Naziv Troskovnog Mesta:</label>
                        <input type="text" class="form-control" id="naziv_troskovnog_mesta"
                               name="naziv_troskovnog_mesta" value="{{ $data->naziv_troskovnog_mesta }}">
                    </div>

                    <div class="form-group">
                        <label for="sifra_troskovnog_mesta">Sifra troskovnog mesta:</label>
                        <input type="text" class="form-control" id="sifra_troskovnog_mesta"
                               name="sifra_troskovnog_mesta" value="{{ $data->sifra_troskovnog_mesta }}">
                    </div>

                    <div class="form-group">
                        <label for="active">Aktivno:</label>
                        <select class="form-control" id="active" name="active">
                            <option value="1" {{ $data->active ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ !$data->active ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Poenteri:</label>
                        <select class="poenteri-basic-multiple" name="poenteri_ids[]" multiple="multiple"
                                style="width: 100%;">
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Odgovorna lica:</label>
                        <select class="odg-lica-basic-multiple" name="odgovorna_lica_ids[]" multiple="multiple"
                                style="width: 100%;">


                        </select>
                    </div>

                    <div class="form-group">
                        <label for="odgovorni_direktori_pravila">Potpisi:</label>
                        <textarea name="odgovorni_direktori_pravila" class="form-control" rows="5" id="odgovorni_direktori_pravila">{!! $potpisiFormated !!}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" >Sačuvaj izmene</button>
                </form>
            </div>
        </div>
        <!-- /.content-wrapper -->
    </div>
@endsection


@section('custom-scripts')
    <script src="{{asset('admin_assets/plugins/jquery/jquery.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2();

            var radniciSelect2String='{!!$radniciSelect2!!}';
            var radniciSelect2Object= JSON.parse(radniciSelect2String);
            var radniciSelect2Array = Object.values(radniciSelect2Object);

            var odgovornaLica = '{!! $odgovornaLica !!}';
            var odgovorniPoenteri = '{!! $odgovorniPoenteri !!}';

            var odgLicaSelect =$('.odg-lica-basic-multiple').select2({
                data: radniciSelect2Array
            });

            var poenteriSelect =$('.poenteri-basic-multiple').select2({
                data: radniciSelect2Array
            });


            odgLicaSelect.val(JSON.parse(odgovornaLica)).trigger("change")
            poenteriSelect.val(JSON.parse(odgovorniPoenteri)).trigger("change")


        });


    </script>
@endsection

