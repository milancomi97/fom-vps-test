@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

    <style>
    .input-group-text{
        min-width:200px
    }

    .select2-selection__rendered {
        line-height: 31px !important;
    }
    .select2-container .select2-selection--single {
        height: 40px !important;
    }
    .select2-selection__arrow {
        height: 34px !important;
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
            <h1 class="text-center"> Maticna datoteka radnika </h1>
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="container mt-5">
                        <form>


                            <!-- 1. Maticni broj, Select option -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="maticni_broj">Maticni broj</span>
                                </div>
                                <select class="custom-select maticni_broj" id="maticni_broj" aria-describedby="maticni_broj"></select>
                            </div>

                            <!-- 2. Prezime i Ime, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="prezime_ime">Prezime i Ime</span>
                                </div>
                                <input type="text" class="form-control" id="prezime_ime" aria-describedby="prezime_ime">
                            </div>

                            <!-- 3. Troskovni centar, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="troskovni_centar">Troskovni centar</span>
                                </div>
                                <input type="text" class="form-control" id="troskovni_centar" aria-describedby="troskovni_centar">
                            </div>

                            <!-- 4. Radno mesto, select option -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="radno_mesto">Radno mesto</span>
                                </div>
                                <select class="custom-select" id="radno_mesto" aria-describedby="radno_mesto"></select>
                            </div>

                            <!-- 5. Isplatno mesto, Select option -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="isplatno_mesto">Isplatno mesto</span>
                                </div>
                                <select class="custom-select" id="isplatno_mesto" aria-describedby="isplatno_mesto"></select>
                            </div>

                            <!-- 6. Partija tekuceg racuna, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="partija_racuna">Partija tekuceg racuna</span>
                                </div>
                                <input type="text" class="form-control" id="partija_racuna" aria-describedby="partija_racuna">
                            </div>

                            <!-- 7. Redosled u poentazi, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="redosled_poentazi">Redosled u poentazi</span>
                                </div>
                                <input type="text" class="form-control" id="redosled_poentazi" aria-describedby="redosled_poentazi">
                            </div>

                            <!-- 8. Vrsta rada, select option -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="vrsta_rada">Vrsta rada</span>
                                </div>
                                <select class="custom-select" id="vrsta_rada" aria-describedby="vrsta_rada"></select>
                            </div>

                            <!-- 9. Radna jedinica, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="radna_jedinica">Radna jedinica</span>
                                </div>
                                <input type="text" class="form-control" id="radna_jedinica" aria-describedby="radna_jedinica">
                            </div>

                            <!-- 10. Godine, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="godine">Godine</span>
                                </div>
                                <input type="text" class="form-control" id="godine" aria-describedby="godine">
                            </div>

                            <!-- 11. Meseci, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="meseci">Meseci</span>
                                </div>
                                <input type="text" class="form-control" id="meseci" aria-describedby="meseci">
                            </div>

                            <!-- 12. Minuli rad aktivan, boolean -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input type="checkbox" aria-label="Minuli rad aktivan" id="minuli_rad_aktivan">
                                    </div>
                                </div>
                                <label for="minuli_rad_aktivan" class="form-control">Minuli rad aktivan</label>
                            </div>

                            <!-- 13. Stvarna strucna sprema, select option -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="stvarna_strucna_sprema">Stvarna strucna sprema</span>
                                </div>
                                <select class="custom-select" id="stvarna_strucna_sprema" aria-describedby="stvarna_strucna_sprema"></select>
                            </div>

                            <!-- 14. Priznata strucna sprema, select option -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="priznata_strucna_sprema">Priznata strucna sprema</span>
                                </div>
                                <select class="custom-select" id="priznata_strucna_sprema" aria-describedby="priznata_strucna_sprema"></select>
                            </div>

                            <!-- 15. Koefinicijent slozenosti, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="koefinicijent_slozenosti">Koefinicijent slozenosti</span>
                                </div>
                                <input type="text" class="form-control" id="koefinicijent_slozenosti" aria-describedby="koefinicijent_slozenosti">
                            </div>

                            <!-- 16. Opstina, select option -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="opstina">Opstina</span>
                                </div>
                                <select class="custom-select" id="opstina" aria-describedby="opstina"></select>
                            </div>

                            <!-- 17. Licni broj gradjana, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="licni_broj_gradjana">Licni broj gradjana</span>
                                </div>
                                <input type="text" class="form-control" id="licni_broj_gradjana" aria-describedby="licni_broj_gradjana">
                            </div>

                            <!-- 18. Pol, Radio buttons -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="pol">Pol</span>
                                </div>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="pol" id="male" value="male">
                                        <label class="form-check-label" for="male">Muški</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="pol" id="female" value="female">
                                        <label class="form-check-label" for="female">Ženski</label>
                                    </div>
                                </div>
                            </div>


                            <!-- 19. Sati za nadoknade, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="sati_za_nadoknade">Sati za nadoknade</span>
                                </div>
                                <input type="text" class="form-control" id="sati_za_nadoknade" aria-describedby="sati_za_nadoknade">
                            </div>

                            <!-- 20. Prosek za nadoknade, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="prosek_za_nadoknade">Prosek za nadoknade</span>
                                </div>
                                <input type="text" class="form-control" id="prosek_za_nadoknade" aria-describedby="prosek_za_nadoknade">
                            </div>

                            <!-- 21. Ulica i broj, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="ulica_i_broj">Ulica i broj</span>
                                </div>
                                <input type="text" class="form-control" id="ulica_i_broj" aria-describedby="ulica_i_broj">
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->
    </div>
@endsection



@section('custom-scripts')

    <script src="{{asset('admin_assets/plugins/select2/js/select2.full.min.js')}}"></script>

    <script>

        $(function () {
            $('.maticni_broj').select2({
                minimumInputLength: 3,
                language: {
                inputTooShort: function (args) {
                    var remainingChars = args.minimum - args.input.length;

                    return 'Unesi ' + remainingChars + ' ili vise karaktera';
                }},
                ajax: {
                    url: '{!! route('radnici.findByMat') !!}',
                    dataType: 'json',
                    delay: 500,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            }).on('select2:select', function (e) {
                alert('select event');
            });
        });

    </script>


@endsection

