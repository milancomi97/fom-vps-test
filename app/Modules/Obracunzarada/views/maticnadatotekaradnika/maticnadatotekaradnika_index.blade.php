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
            <h1 class="text-center"> Matična datoteka radnika </h1>
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="container mt-5">
                        <form>


                            <!-- 1. Maticni broj, Select option -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_maticni_broj">Matični broj:</span>
                                </div>
                                <select class="custom-select maticni_broj" id="maticni_broj" aria-describedby="maticni_broj"><option>pretraga po mat. br.</option></select>

                                <input type="hidden" id="maticni_broj_value">
                            </div>

                            <!-- 2.1 Prezime, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_prezime">Prezime:</span>
                                </div>
                                <input type="text" class="form-control" id="prezime" aria-describedby="prezime">
                            </div>
                            <!-- 2.2  Ime, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_ime">Ime:</span>
                                </div>
                                <input type="text" class="form-control" id="ime" aria-describedby="ime">
                            </div>

                            <!-- 3. Troskovni centar, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_troskovni_centar">Troškovni centar:</span>
                                </div>
                                <input type="text" class="form-control" id="troskovni_centar" aria-describedby="troskovni_centar">
                            </div>
                            <!-- 4. Radno mesto, select option -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_radno_mesto">Radno mesto:</span>
                                </div>
                                <select class="custom-select" id="radno_mesto" aria-describedby="radno_mesto"></select>
                            </div>

                            <!-- 5. Isplatno mesto, Select option -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_isplatno_mesto">Isplatno mesto:</span>
                                </div>
                                <select class="custom-select" id="isplatno_mesto" aria-describedby="isplatno_mesto"></select>
                            </div>

                            <!-- 6. Partija tekuceg racuna, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_partija_racuna">Partija tekuceg racuna:</span>
                                </div>
                                <input type="text" class="form-control" id="partija_racuna" aria-describedby="partija_racuna">
                            </div>

                            <!-- 7. Redosled u poentazi, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_redosled_poentazi">Redosled u poentazi:</span>
                                </div>
                                <input type="text" class="form-control" id="redosled_poentazi" aria-describedby="redosled_poentazi">
                            </div>

                            <!-- 8. Vrsta rada, select option -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_vrsta_rada">Vrsta rada:</span>
                                </div>
                                <select class="custom-select" id="vrsta_rada" aria-describedby="vrsta_rada"></select>
                            </div>

                            <!-- 9. Radna jedinica, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_radna_jedinica">Radna jedinica:</span>
                                </div>
                                <input type="text" class="form-control" id="radna_jedinica" aria-describedby="radna_jedinica">
                            </div>

                            <!-- 10. Godine, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_godine">Godine:</span>
                                </div>
                                <input type="text" class="form-control" id="godine" aria-describedby="godine">
                            </div>

                            <!-- 11. Meseci, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_meseci">Meseci:</span>
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
                                <label for="minuli_rad_aktivan" class="form-control">Minuli rad aktivan:</label>
                            </div>

                            <!-- 13. Stvarna strucna sprema, select option -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_stvarna_strucna_sprema">Stvarna strucna sprema:</span>
                                </div>
                                <select class="custom-select" id="stvarna_strucna_sprema" aria-describedby="stvarna_strucna_sprema"></select>
                            </div>

                            <!-- 14. Priznata strucna sprema, select option -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_priznata_strucna_sprema">Priznata strucna sprema:</span>
                                </div>
                                <select class="custom-select" id="priznata_strucna_sprema" aria-describedby="priznata_strucna_sprema"></select>
                            </div>

                            <!-- 15. Koefinicijent slozenosti, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_koefinicijent_slozenosti">Koefinicijent slozenosti:</span>
                                </div>
                                <input type="text" class="form-control" id="koefinicijent_slozenosti" aria-describedby="koefinicijent_slozenosti">
                            </div>

                            <!-- 16. Opstina, select option -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_opstina">Opstina:</span>
                                </div>
                                <select class="custom-select" id="opstina_id" aria-describedby="opstina">
                                    @foreach($opstine as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- 17. Licni broj gradjana, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_licni_broj_gradjana">Licni broj gradjana:</span>
                                </div>
                                <input type="text" class="form-control" id="licni_broj_gradjana" aria-describedby="licni_broj_gradjana">
                            </div>

                            <!-- 18. Pol, Radio buttons -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_pol">Pol:</span>
                                </div>
                                <div class="form-group ml-5" style="display: flex; align-items: center; justify-content: center; margin-bottom: 0">
                                    <div class="form-check form-check-inline ">
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
                                    <span class="input-group-text font-weight-bold" id="span_sati_za_nadoknade">Sati za nadoknade:</span>
                                </div>
                                <input type="text" class="form-control" id="sati_za_nadoknade" aria-describedby="sati_za_nadoknade">
                            </div>

                            <!-- 20. Prosek za nadoknade, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_prosek_za_nadoknade">Prosek za nadoknade:</span>
                                </div>
                                <input type="text" class="form-control" id="prosek_za_nadoknade" aria-describedby="prosek_za_nadoknade">
                            </div>

                            <!-- 21. Ulica i broj, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_adresa_ulica_broj">Ulica i broj:</span>
                                </div>
                                <input type="text" class="form-control" id="adresa_ulica_broj" aria-describedby="adresa_ulica_broj">
                            </div>

                            <button type="submit" class="btn btn-primary">Sačuvaj</button>
                        </form>
                    </div>
                </div>
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
                },
                    noResults: function () { return 'Nema rezultata'; },
                    searching: function () { return 'Pretražujem...'; }
                },
                ajax: {
                    url: '{!! route('radnici.findByMat') !!}',
                    dataType: 'json',
                    delay: 1000,
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
                var selectedRadnikId = e.params.data.id;
                getRadnikDataById(selectedRadnikId)
            });
        });

        function getRadnikDataById(id){
            alert(id);
            var postData = {
                radnikId: id
            };

            $.ajax({
                url: '{!! route('radnici.getById') !!}',
                method: 'GET',
                dataType: 'json',
                data: postData,
                success: function(response) {

                    $('#ime').val(response.ime)
                    $('#prezime').val(response.prezime)
                    $('#troskovni_centar').val(response.troskovno_mesto)
                    $('#adresa_ulica_broj').val(response.adresa_ulica_broj)

                    //
                    // opstina_id
                    // sifra_mesta_troska_id
                    // status_ugovor_id

                    // {
                    //     "id": 6,
                    //     "interni_maticni_broj": null,
                    //     "ime": "MILADIN",
                    //     "prezime": "JANJIC",
                    //     "srednje_ime": null,
                    //     "slika_zaposlenog": null,
                    //     "maticni_broj": "0003123",
                    //     "troskovno_mesto": "90000000",
                    //     "active": 0,
                    //     "email": "0003123MILADIN@fom.com",
                    //     "jmbg": null,
                    //     "email_verified_at": null,
                    //     "telefon_poslovni": null,
                    //     "licna_karta_broj_mesto_rodjenja": null,
                    //     "adresa_ulica_broj": null,
                    //     "opstina_id": null,
                    //     "drzava_id": null,
                    //     "sifra_mesta_troska_id": null,
                    //     "status_ugovor_id": null,
                    //     "datum_zasnivanja_radnog_odnosa": null,
                    //     "datum_prestanka_radnog_odnosa": "1909-07-01",
                    //     "created_at": null,
                    //     "updated_at": null
                    // }



                    debugger;
                    // Handle the successful response here
                    $('#result').html('Data from the server: ' + JSON.stringify(response));
                },
                error: function(error) {
                    // Handle errors here
                    console.error('Error:', error);
                }
            });

        }

    </script>


@endsection

{{--errorLoading: function () {--}}
{{--return 'The results could not be loaded.';--}}
{{--},--}}
{{--inputTooLong: function (args) {--}}
{{--var overChars = args.input.length - args.maximum;--}}

{{--return 'Please delete ' + overChars + ' character' + (overChars > 1 ? 's' : '');--}}
{{--},--}}
{{--inputTooShort: function (args) {--}}
{{--var remainingChars = args.minimum - args.input.length;--}}

{{--return 'Please add ' + remainingChars + ' or more character' + (remainingChars > 1 ? 's' : '');--}}
{{--},--}}
{{--loadingMore: function () {--}}
{{--return 'Loading more results…';--}}
{{--},--}}
{{--maximumSelected: function (args) {--}}
{{--return 'You can only select ' + args.maximum + ' item' + (args.maximum > 1 ? 's' : '');--}}
{{--},--}}
{{--noResults: function () {--}}
{{--return 'No results found';--}}
{{--},--}}
{{--searching: function () {--}}
{{--return 'Searching…';--}}
{{--}--}}
