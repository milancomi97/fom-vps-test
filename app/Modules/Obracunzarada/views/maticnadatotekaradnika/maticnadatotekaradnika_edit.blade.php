@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

    <style>
        .input-group-text {
            min-width: 200px
        }

        .select2-selection__rendered {
            line-height: 31px !important;
            padding-left: 0 !important;
        }

        .select2-container .select2-selection--single {
            height: 40px !important;
        }

        .select2-selection__arrow {
            height: 34px !important;
        }

        .error {
            border: 1px solid red;
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
                    <h3 id="error-validator-text" class="text-danger d-none font-weight-bold">- Popunite sva polja
                        -</h3>

                        <form id="maticnadatotekaradnika" method="post"
                              action="{{ route('maticnadatotekaradnika.store')}}">
                            @csrf
                            <!-- 1. Maticni broj, Select option -->
                            <input type="hidden" name="user_id" id="user_id">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold"
                                          id="span_maticni_broj">Matični broj:</span>
                                </div>

                                <input type="text" class="form-control" disabled id="MBRD_maticni_broj" aria-describedby="span_maticni_broj"
                                       value="{{$radnikData->MBRD_maticni_broj}}"
                                       name="MBRD_maticni_broj"
                                >


{{--                                <select class="custom-select maticni_broj invisible" id="MBRD_maticni_broj"--}}
{{--                                        name="MBRD_maticni_broj"--}}
{{--                                        aria-describedby="span_maticni_broj"--}}
{{--                                >--}}
{{--                                    <option>pretraga po mat. br.</option>--}}
{{--                                </select>--}}

                                {{--                                <input type="hidden" id="maticni_broj_value">--}}
                            </div>
                                {{--                                <input type="hidden" id="prezime_value">--}}

                                {{--                                <input type="text" class="form-control" id="prezime" aria-describedby="prezime">--}}

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_prezime">Prezime:</span>
                                </div>
                                <input type="text" class="form-control" id="PREZIME_prezime" aria-describedby="span_prezime"
                                       value="{{$radnikData->PREZIME_prezime}}"
                                       name="PREZIME_prezime"
                                >
                            </div>

                            <!-- 2.2  Ime, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_ime">Ime:</span>
                                </div>
                                <input type="text" class="form-control" id="IME_ime" aria-describedby="span_ime"
                                       name="IME_ime">
                            </div>

                            <!-- 3. Troskovni centar, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_sifra_mesta_troska_id">Troškovno mesto:</span>
                                </div>
                                <select class="custom-select" id="troskovno_mesto_id" name="troskovno_mesto_id"
                                        aria-describedby="span_sifra_mesta_troska_id">
                                    <option value="0">Izaberite troškovno mesto</option>
                                    @foreach($troskMesta as $value => $label)
                                        <option value="{{ $label['key'] }}">{{ $label['value']  }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <!-- 4. Radno mesto, select option -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold"
                                          id="span_radno_mesto">Radno mesto:</span>
                                </div>
                                <select class="custom-select" name="RBRM_radno_mesto" id="RBRM_radno_mesto"
                                        aria-describedby="span_radno_mesto">
                                    <option value="0">Izaberite radno mesto</option>
                                    @foreach($radnaMesta as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach


                                </select>
                            </div>

                            <!-- 5. Isplatno mesto, Select option -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_isplatno_mesto">Isplatno mesto:</span>
                                </div>
                                <select class="custom-select" id="RBIM_isplatno_mesto_id" name="RBIM_isplatno_mesto_id"
                                        aria-describedby="span_isplatno_mesto">
                                    <option value="0">Izaberite isplatno mesto</option>
                                    @foreach($isplatnaMesta as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- 6. Partija tekuceg racuna, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold"
                                          id="span_tekuci_racun">Tekuci racun:</span>
                                </div>
                                <input type="text" class="form-control" id="ZRAC_tekuci_racun" name="ZRAC_tekuci_racun"
                                       aria-describedby="span_tekuci_racun">
                            </div>

                            <!-- 7. Redosled u poentazi, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_redosled_poentazi">Redosled u poentazi:</span>
                                </div>
                                <input type="text" class="form-control" id="BRCL_redosled_poentazi"
                                       name="span_redosled_poentazi"
                                       value="9999" aria-describedby="BRCL_redosled_poentazi">
                            </div>

                            <!-- 8. Vrsta rada, select option -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold"
                                          id="span_vrsta_rada">Vrsta rada:</span>
                                </div>
                                <select class="custom-select" id="BR_vrsta_rada" name="BR_vrsta_rada"
                                        aria-describedby="span_vrsta_rada">
                                    <option value="0">Izaberite vrstu rada</option>
                                    @foreach($vrstaRada as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>


                            </div>

                            <!-- 9. Radna jedinica, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_radna_jedinica">Radna jedinica:</span>
                                </div>
                                <input type="text" class="form-control" id="RJ_radna_jedinica" name="RJ_radna_jedinica"
                                       aria-describedby="span_radna_jedinica">
                            </div>

                            <!-- 9.1 Brigada, text field -->

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_brigada">Brigada:</span>
                                </div>
                                <input type="text" class="form-control" id="BRIG_brigada" name="BRIG_brigada"
                                       aria-describedby="span_brigada">
                            </div>


                            <!-- 10. Godine, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold"
                                          id="span_godine">Godine staza:</span>
                                </div>
                                <input type="number" class="form-control" value="0" id="GGST_godine_staza"
                                       name="GGST_godine_staza" max="99" aria-describedby="span_godine">
                            </div>
                            <!-- 11. Meseci, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold"
                                          id="span_meseci">Meseci staza:</span>
                                </div>
                                <input type="number" class="form-control" name="MMST_meseci_staza" value="0" max="11"
                                       id="MMST_meseci_staza" aria-describedby="span_meseci">
                            </div>


                            <!-- 12. Minuli rad aktivan, boolean -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_minuli_rad_aktivan">Minuli rad aktivan:</span>
                                </div>
                                <div class="col col-1">
                                    <input type="checkbox" class="form-control" name="MRAD_minuli_rad_aktivan"
                                           aria-label="Minuli rad aktivan" checked="checked"
                                           id="MRAD_minuli_rad_aktivan">
                                </div>

                            </div>


                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_prebacaj">Prebacaj:</span>
                                </div>
                                <div class="col col-1">
                                    <input type="checkbox" class="form-control" name="PREB_prebacaj"
                                           aria-label="Prebacaj" checked="checked"
                                           id="span_prebacaj">
                                </div>

                            </div>


                            <!-- 13. Stvarna strucna sprema, select option -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_stvarna_strucna_sprema">Stvarna stručna sprema:</span>
                                </div>
                                {{--                                $kvalifikacije--}}
                                <select class="custom-select" id="RBSS_stvarna_strucna_sprema"
                                        name="RBSS_stvarna_strucna_sprema"
                                        aria-describedby="span_stvarna_strucna_sprema">
                                    <option value="0">Izaberite stručnu spremu</option>
                                    @foreach($kvalifikacije as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- 14. Priznata strucna sprema, select option -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_priznata_strucna_sprema">Priznata stručna sprema:</span>
                                </div>
                                <select class="custom-select" id="RBPS_priznata_strucna_sprema"
                                        name="RBPS_priznata_strucna_sprema"
                                        aria-describedby="span_priznata_strucna_sprema">
                                    <option value="0">Izaberite stručnu spremu</option>
                                    @foreach($kvalifikacije as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- 15. Koefinicijent slozenosti, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_osnovna_zarada">Osnovna zarada:</span>
                                </div>
                                <input type="text" class="form-control" id="KOEF_osnovna_zarada"
                                       name="KOEF_osnovna_zarada"
                                       aria-describedby="span_osnovna_zarada">
                            </div>

                            <!-- 17. Licni broj gradjana, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_jmbg">JMBG:</span>
                                </div>
                                <input type="text" class="form-control" id="LBG_jmbg" name="LBG_jmbg"
                                       aria-describedby="span_jmbg">
                            </div>

                            <!-- 18. Pol, Radio buttons -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_pol">Pol:</span>
                                </div>
                                <div class="form-group ml-5"
                                     style="display: flex; align-items: center; justify-content: center; margin-bottom: 0">
                                    <div class="form-check form-check-inline ">
                                        <input class="form-control" type="text" name="POL_pol" id="POL_pol">
                                    </div>
                                </div>
                            </div>


                            <!-- 19. Sati za nadoknade, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_prosecni_sati">Prosečni sati PROVERI:</span>
                                </div>
                                <input type="text" class="form-control" id="PRCAS_ukupni_sati_za_ukupan_bruto_iznost" value="0"
                                       name="PRCAS_ukupni_sati_za_ukupan_bruto_iznost"
                                       aria-describedby="span_prosecni_sati">
                            </div>

                            <!-- 20. Prosek za nadoknade, text field -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_prosecna_zarada">Prosečna zarada:</span>
                                </div>
                                <input type="text" class="form-control" id="IZNETO_ukupna_bruto_zarada" name="IZNETO_ukupna_bruto_zarada"
                                       value="0"
                                       aria-describedby="prosecna_zarada">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_opstina">Opština:</span>
                                </div>
                                <select class="custom-select" name="opstina_id" id="opstina_id"
                                        aria-describedby="opstina">
                                    <option value="0">Izaberite opštinu</option>
                                    @foreach($opstine as $value => $label)
                                        <option value="{{ $value }}">{{ $label['value'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center mt-2  mb-5">
                                    <button id='submit_btn' type="submit" class="btn btn-primary btn-lg">Sačuvaj
                                    </button>
                                </div>
                            </div>
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

            // Maticni broj pretraga
            $('.maticni_broj').select2({
                minimumInputLength: 3,
                language: {
                    inputTooShort: function (args) {
                        var remainingChars = args.minimum - args.input.length;

                        return 'Unesi ' + remainingChars + ' ili vise karaktera';
                    },
                    noResults: function () {
                        return 'Nema rezultata';
                    },
                    searching: function () {
                        return 'Pretražujem...';
                    }
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
                    cache: false
                }
            }).on('select2:select', function (e) {
                var selectedRadnikId = e.params.data.id;
                getRadnikDataById(selectedRadnikId)
            });

            // Maticni broj pretraga END

            // Prezime pretraga
            $('.prezime').select2({
                minimumInputLength: 4,
                language: {
                    inputTooShort: function (args) {
                        var remainingChars = args.minimum - args.input.length;

                        return 'Unesi ' + remainingChars + ' ili vise karaktera';
                    },
                    noResults: function () {
                        return 'Nema rezultata';
                    },
                    searching: function () {
                        return 'Pretražujem...';
                    }
                },
                ajax: {
                    url: '{!! route('radnici.findByPrezime') !!}',
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
                    cache: false
                }
            }).on('select2:select', function (e) {
                var selectedRadnikId = e.params.data.id;
                getRadnikDataById(selectedRadnikId)
            });

            // Prezime pretraga END


        });


        function getRadnikDataById(id) {

            var postData = {
                radnikId: id
            };

            $.ajax({
                url: '{!! route('radnici.getById') !!}',
                method: 'GET',
                dataType: 'json',
                data: postData,
                success: function (response) {

                    $('#ime').val(response.ime)
                    $('#adresa_ulica_broj').val(response.adresa_ulica_broj)
                    $("#opstina_id").val(response.opstina_id)
                    $("#sifra_mesta_troska_id").val(response.sifra_mesta_troska_id)
                    $("#jmbg").val(response.jmbg)
                    $('#user_id').val(response.id);


                    var prezimeOption = new Option(response.prezime, response.prezime, true, true);
                    $('#prezime').append(prezimeOption).trigger('change');
                    var maticniOption = new Option(response.maticni_broj, response.maticni_broj, true, true);
                    $('#maticni_broj').append(maticniOption).trigger('change');
                    // maticni_broj
                    // maticni_broj_value
                    // prezime
                    // prezime_value
                    // response.opstina_id
                    //
                    // opstina_id
                    // sifra_mesta_troska_id
                    // status_ugovor_id
                    // $('#mySelect2').val('1'); // Select the option with a value of '1'
                    // $('#mySelect2').trigger('change');
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


                    // Handle the successful response here
                    $('#result').html('Data from the server: ' + JSON.stringify(response));
                },
                error: function (error) {
                    // Handle errors here
                    console.error('Error:', error);
                }
            });

        }


        $('#maticnadatotekaradnika').submit(function (event) {
            var isValid = true;

            // Loop through each input field
            $(this).find(':input').each(function () {
                // $(this).find(':input[required]').each(function () {

                if ($(this)[0].id === 'tekuci_racun' || $(this)[0].id === 'radna_jedinica' || $(this)[0].id === 'submit_btn' || $(this)[0].id === 'brigada') {
                    return;
                }

                if ($(this).val().trim() === '') {
                    isValid = false;
                    $(this).addClass('error');
                } else {
                    $(this).removeClass('error');
                }
            });

            $(this).find('select').each(function () {
                if ($(this).val() === '0') {
                    isValid = false;
                    $(this).addClass('error');
                } else {
                    $(this).removeClass('error');
                }
            });
            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    $('#scrollToTopBtn').fadeIn();
                } else {
                    $('#scrollToTopBtn').fadeOut();
                }
            });
            if (!isValid) {
                // Prevent form submission if validation fails
                $('#error-validator-text').removeClass('d-none');
                $('html, body').animate({scrollTop: 0}, 800);

                event.preventDefault();
            }
        });

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
