@php use App\Modules\Obracunzarada\Consts\UserRoles; @endphp
@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

    <style>
        .button-container {
            display: flex;
            gap: 10px; /* Space between buttons */
            align-items: center; /* Aligns items vertically in the center */
            margin-top: 20px; /* Adjust margin to position the container */
        }

        .button-container .btn {
            margin: 0;
            padding: 10px 20px; /* Adjust padding as needed */
        }
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
                    <h3 id="error-validator-text" class="text-danger d-none font-weight-bold"></h3>

                    <form id="maticnadatotekaradnika" method="post"
                          action="{{ route('maticnadatotekaradnika.update')}}">
                        @csrf
                        <!-- 1. Maticni broj, Select option -->
                        <input type="hidden" name="maticni_broj" id="maticni_broj" value="{{$radnikData->MBRD_maticni_broj}}" >
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold"
                                          id="span_maticni_broj">Matični broj:</span>
                            </div>

                            <input type="text" class="form-control" disabled id="MBRD_maticni_broj"
                                   aria-describedby="span_maticni_broj"
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
                            <input type="text" class="form-control" disabled id="PREZIME_prezime" aria-describedby="span_prezime"
                                   value="{{$radnikData->PREZIME_prezime}}"
                                   name="PREZIME_prezime"
                            >
                        </div>


{{--                        <div class="input-group mb-3">--}}
{{--                            <div class="input-group-prepend">--}}
{{--                                <span class="input-group-text font-weight-bold" id="span_srednje_ime">Srednje Ime:</span>--}}
{{--                            </div>--}}
{{--                            <input type="text" class="form-control" disabled id="srednje_ime" aria-describedby="span_srednje_ime"--}}
{{--                                   value="{{$radnikData->srednje_ime}}"--}}
{{--                                   name="srednje_ime"--}}
{{--                            >--}}
{{--                        </div>--}}

                        <!-- 2.2  Ime, text field -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold" id="span_ime">Ime:</span>
                            </div>
                            <input type="text" class="form-control" disabled id="IME_ime" aria-describedby="span_ime"
                                   value="{{$radnikData->IME_ime}}" name="IME_ime">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold" id="span_ime">E-pošta za platu:</span>
                            </div>
                            <input type="text" class="form-control" id="email_za_plate" aria-describedby="email_za_plate"
                                   value="{{$radnikData->email_za_plate}}" name="email_za_plate">
                        </div>


                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold" id="span_email_za_plate_status">Status E-pošte:</span>
                            </div>
                            <select class="custom-select" id="email_za_plate_poslat" name="email_za_plate_poslat"
                                    aria-describedby="span_email_za_plate_status">

                             @if($radnikData->email_za_plate ==null)
                                    <option value="0" selected>Nije uneta adresa</option>
                                @else
                                @if($radnikData->email_za_plate_poslat==0)
                                        <option value="0" selected>Nije nije poslat</option>
                                        <option value="1" >Poslat</option>
                                    @else
                                        <option value="1" selected>Poslat</option>
                                        <option value="0" >Nije nije poslat</option>
                                    @endif
                                @endif

                            </select>
                        </div>


                        <!-- 3. Troskovni centar, text field -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold" id="span_sifra_mesta_troska_id">Troškovno mesto:</span>
                            </div>
                            <select class="custom-select" id="troskovno_mesto_id" name="troskovno_mesto_id" required
                                    aria-describedby="span_sifra_mesta_troska_id">
                                <option >Izaberite troškovno mesto</option>
                                @foreach($troskMesta as $value => $label)
                                    @if($label['key']== $radnikData->troskovno_mesto_id)
                                        <option selected value="{{ $label['key']}}">{{ $label['value'] }}</option>
                                    @else
                                    <option value="{{ $label['key'] }}">{{ $label['value']  }}</option>
                                    @endif
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
                                @foreach($radnaMesta as $label => $value)
                                    {{--                                        RBRM_radno_mesto--}}
                                    @if($value['rbrm_sifra_radnog_mesta']== $radnikData->RBRM_radno_mesto)
                                        <option selected value="{{ $value['rbrm_sifra_radnog_mesta']}}">{{ $value['rbrm_sifra_radnog_mesta']}} {{ $value['narm_naziv_radnog_mesta'] }}</option>
                                    @else
                                    <option value="{{ $value['rbrm_sifra_radnog_mesta'] }}">{{ $value['rbrm_sifra_radnog_mesta']}} {{ $value['narm_naziv_radnog_mesta'] }}</option>
                                    @endif
                                @endforeach


                            </select>
                        </div>

                        <!-- 5. Isplatno mesto, Select option -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold"
                                      id="span_isplatno_mesto">Isplatno mesto:</span>
                            </div>
                            <select class="custom-select" id="RBIM_isplatno_mesto_id" name="RBIM_isplatno_mesto_id"
                                    aria-describedby="span_isplatno_mesto">
                                <option value="0">Izaberite isplatno mesto</option>
                                @foreach($isplatnaMesta as $key => $value )
                                    @if($value['rbim_sifra_isplatnog_mesta']== $radnikData->RBIM_isplatno_mesto_id)
                                        <option selected value="{{ $value['rbim_sifra_isplatnog_mesta'] }}">{{ $value['rbim_sifra_isplatnog_mesta'] }} {{ $value['naim_naziv_isplatnog_mesta']  }}</option>
                                    @else
                                    <option value="{{ $value['rbim_sifra_isplatnog_mesta'] }}">{{ $value['rbim_sifra_isplatnog_mesta']  }} {{ $value['naim_naziv_isplatnog_mesta']  }}</option>
                                    @endif
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
                                   value="{{$radnikData->ZRAC_tekuci_racun}}"    aria-describedby="span_tekuci_racun">
                        </div>

                        <!-- 7. Redosled u poentazi, text field -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold" id="span_redosled_poentazi">Redosled u poentazi:</span>
                            </div>
                            <input type="number" class="form-control" id="BRCL_redosled_poentazi"
                                   name="BRCL_redosled_poentazi"
                                   value="{{$radnikData->BRCL_redosled_poentazi}}"
                                   aria-describedby="span_redosled_poentazi">
                        </div>

                        <!-- 8. Vrsta rada, select option -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold"
                                          id="span_oblik_rada">Oblik rada:</span>
                            </div>
                            <select class="custom-select" id="P_R_oblik_rada" name="P_R_oblik_rada"
                                    aria-describedby="span_oblik_rada">
                                <option value="0">Izaberite oblik rada</option>
                                @foreach($oblikRada as $label => $value)
                                    @if($value['sifra_oblika_rada']== $radnikData->P_R_oblik_rada)
                                        <option selected value="{{ $value['sifra_oblika_rada'] }}">{{ $value['sifra_oblika_rada'] }} {{ $value['naziv_oblika_rada'] }}</option>
                                    @else
                                    <option value="{{ $value['sifra_oblika_rada'] }}">{{ $value['sifra_oblika_rada'] }} {{ $value['naziv_oblika_rada'] }}</option>
                                    @endif
                                @endforeach
                            </select>


                        </div>


                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold"
                                          id="span_vrsta_rada">Vrsta rada:</span>
                            </div>
                            <select class="custom-select" id="BR_vrsta_rada" name="BR_vrsta_rada"
                                    aria-describedby="span_vrsta_rada">
                                <option value="0">Izaberite vrstu rada</option>
                                @foreach($vrstaRada as $value => $label)
                                    @if($value== $radnikData->BR_vrsta_rada)
                                        <option selected value="{{ $value }}">{{ $label }}</option>
                                    @else
                                    <option value="{{ $value }}">{{ $label }}</option>
                                    @endif
                                @endforeach
                            </select>


                        </div>

                        <!-- 9. Radna jedinica, text field -->


                        <!-- 9.1 Brigada, text field -->

{{--                        <div class="input-group mb-3">--}}
{{--                            <div class="input-group-prepend">--}}
{{--                                <span class="input-group-text font-weight-bold" id="span_brigada">Brigada:</span>--}}
{{--                            </div>--}}
{{--                            <input type="text" class="form-control" id="BRIG_brigada" name="BRIG_brigada"--}}
{{--                                   value="{{$radnikData->BRIG_brigada}}" aria-describedby="span_brigada">--}}
{{--                        </div>--}}


                        <!-- 10. Godine, text field -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold"
                                          id="span_godine">Godine staza:</span>
                            </div>
                            <input type="number" class="form-control" id="GGST_godine_staza"
                                   value="{{$radnikData->GGST_godine_staza}}" name="GGST_godine_staza" max="99"
                                   aria-describedby="span_godine">
                        </div>
                        <!-- 11. Meseci, text field -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold"
                                          id="span_meseci">Meseci staza:</span>
                            </div>
                            <input type="number" class="form-control" name="MMST_meseci_staza" max="11"
                                   value="{{ $radnikData->MMST_meseci_staza}}" id="MMST_meseci_staza"
                                   aria-describedby="span_meseci">
                        </div>


                        <!-- 12. Minuli rad aktivan, boolean -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold" id="span_minuli_rad_aktivan">Minuli rad aktivan:</span>
                            </div>
                            <div class="col col-1">
                                <input type="checkbox" class="form-control" name="MRAD_minuli_rad_aktivan"
                                       aria-label="Minuli rad aktivan"
                                       {{$radnikData->MRAD_minuli_rad_aktivan ==1 ? "checked": ''}}
                                       id="MRAD_minuli_rad_aktivan">
                            </div>
                        </div>



                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold" id="span_ACTIVE_aktivan">Aktivan:</span>
                            </div>
                            <div class="col col-1">
                                <input type="checkbox" class="form-control" name="ACTIVE_aktivan"
                                       aria-label="span_ACTIVE_aktivan"
                                       {{$radnikData->ACTIVE_aktivan ==1 ? "checked": ''}}
                                       id="ACTIVE_aktivan">
                            </div>
                        </div>



{{--                        <div class="input-group mb-3">--}}
{{--                            <div class="input-group-prepend">--}}
{{--                                <span class="input-group-text font-weight-bold" id="span_prebacaj">Prebacaj:</span>--}}
{{--                            </div>--}}
{{--                            <div class="col col-1">--}}
{{--                                <input type="checkbox" class="form-control" name="PREB_prebacaj"--}}
{{--                                       {{$radnikData->PREB_prebacaj ==1 ? "checked": ''}}--}}
{{--                                       aria-label="Prebacaj"--}}
{{--                                       id="span_prebacaj">--}}
{{--                            </div>--}}

{{--                        </div>--}}


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
                                @foreach($kvalifikacije as $label => $value)
                                    @if($value['sifra_kvalifikacije']== $radnikData->RBSS_stvarna_strucna_sprema)
                                        <option selected value="{{ $value['sifra_kvalifikacije'] }}">{{ $value['sifra_kvalifikacije'] }} {{ $value['naziv_kvalifikacije'] }}</option>
                                    @else
                                        <option value="{{ $value['sifra_kvalifikacije'] }}">{{ $value['sifra_kvalifikacije'] }} {{ $value['naziv_kvalifikacije'] }}</option>
                                    @endif

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
                                @foreach($kvalifikacije as $label => $value)
                                    @if($value['sifra_kvalifikacije']== $radnikData->RBPS_priznata_strucna_sprema)
                                        <option selected value="{{ $value['sifra_kvalifikacije'] }}">{{ $value['sifra_kvalifikacije'] }} {{ $value['naziv_kvalifikacije'] }}</option>
                                    @else
                                        <option value="{{ $value['sifra_kvalifikacije'] }}">{{ $value['sifra_kvalifikacije'] }} {{ $value['naziv_kvalifikacije'] }}</option>
                                    @endif

                                @endforeach
                            </select>
                        </div>

                        <!-- 15. Koefinicijent slozenosti, text field -->

                        @if((int) $radnikData->BRCL_redosled_poentazi > 100)

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_osnovna_zarada">Osnovna zarada:</span>
                                </div>
                                <input type="number" class="form-control" id="KOEF_osnovna_zarada"
                                       name="KOEF_osnovna_zarada"
                                       step="any"
                                       value="{{$radnikData->KOEF_osnovna_zarada}}"
                                       aria-describedby="span_osnovna_zarada">
                            </div>

                        @elseif($userData->permission->role_id==UserRoles::SUPERVIZOR)
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold" id="span_osnovna_zarada">Osnovna zarada:</span>
                                </div>
                                <input type="number" class="form-control" id="KOEF_osnovna_zarada"
                                       name="KOEF_osnovna_zarada" step="any"
                                       value="{{$radnikData->KOEF_osnovna_zarada}}"
                                       aria-describedby="span_osnovna_zarada">
                            </div>
                        @endif


                        <!-- 17. Licni broj gradjana, text field -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold" id="span_jmbg">JMBG:</span>
                            </div>
                            <input type="text" class="form-control" id="LBG_jmbg" name="LBG_jmbg"
                                   value="{{$radnikData->LBG_jmbg}}" aria-describedby="span_jmbg">
                        </div>

                        <!-- 18. Pol, Radio buttons -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold" id="span_pol">Pol:</span>
                            </div>
                            <div class="form-group"
                                 style="display: flex; align-items: center; justify-content: center; margin-bottom: 0">
                                <div class="form-check form-check-inline">
                                    <select class="custom-select" id="POL_pol"
                                            name="POL_pol">
                                    @if($radnikData->POL_pol=='Z')
                                            <option selected value="Z">Z</option>
                                            <option   value="Z">Z</option>
                                        @else
                                            <option selected value="M">M</option>
                                            <option value="Z">Z</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>


                        <!-- 19. Sati za nadoknade, text field -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold" id="span_prosecni_sati">Sati zarade za nadoknade:</span>
                            </div>
                            <input type="number" class="form-control" id="PRCAS_ukupni_sati_za_ukupan_bruto_iznost"
                                   value="{{$radnikData->PRCAS_ukupni_sati_za_ukupan_bruto_iznost}}"
                                   name="PRCAS_ukupni_sati_za_ukupan_bruto_iznost"
                                   aria-describedby="span_prosecni_sati">
                        </div>

                        <!-- 20. Prosek za nadoknade, text field -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold" id="span_PRIZ_ukupan_bruto_iznos">Iznos zarade za nadoknade:</span>
                            </div>
                            <input type="text" class="form-control" id="PRIZ_ukupan_bruto_iznos"
                                   name="PRIZ_ukupan_bruto_iznos"
                                   value="{{$radnikData->PRIZ_ukupan_bruto_iznos}}"
                                   aria-describedby="span_PRIZ_ukupan_bruto_iznos">
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold" id="span_adresa_ulica_broj">Ulica broj:</span>
                            </div>
                            <input type="text" class="form-control" id="adresa_ulica_broj" aria-describedby="span_adresa_ulica_broj"
                                   value="{{$radnikData->adresa_ulica_broj}}"
                                   name="adresa_ulica_broj"
                            >
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-bold" id="span_opstina">Opština:</span>
                            </div>
                            <select class="custom-select" name="opstina_id" id="opstina_id"
                                    aria-describedby="opstina">
                                <option value="0">Izaberite opštinu</option>

                                @foreach($opstine as $value => $label)
                                    @if($label['key']== $radnikData->opstina_id)
                                        <option selected value="{{ $label['key']}}">{{ $label['value'] }}</option>
                                    @else
                                    <option value="{{ $value }}">{{ $label['value'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="button-container mt-5 mb-5">

                                <button id='submit_btn' type="submit" class="btn btn-primary">Sačuvaj</button>
                                <a href="{{route('radnici.edit_table',['user_id'=>$radnikData->user_id])}}" class="btn btn-success">Pregled KADR</a>

                                <a href="{{route('radnici.index')}}" class="btn btn-outline-secondary">Tabela radnika</a>
                        </div>
                    </form>

                </div>
                <div class="row justify-content-center">
                    <h3 class="text-center">Sekcija aktivnog meseca</h3>
                </div>
                <div class="row justify-content-center">
                    <div class="button-container mb-5 text-center">
                        <!-- First Form: Deactivation -->
                        <form action="{{ route('radnici.deactivate_current_month', ['maticni_broj' => $radnikData->MBRD_maticni_broj]) }}" method="POST" style="display: inline;">
                            @csrf
                            <button id="submit_btn" type="submit" class="btn btn-danger">Deaktiviranje radnika</button>
                        </form>

                        <!-- Second Form: Activation -->
                        <form action="{{ route('radnici.activate_current_month', ['maticni_broj' => $radnikData->MBRD_maticni_broj]) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-warning">Aktiviranje radnika</button>
                        </form>
                    </div>
                    <div class="container">
                        <h1 class="text-center">Opis:</h1>
                        <h3>Deaktiviranje radnika - isključivanje radnika iz trenutne listu poentažе (forma poentera za unos)</h3>
                        <h3>Aktiviranje radnika - uključivanje radnika u trenutnu listu poenaže (forma poentera za unos)</h3>
                    </div>
                </div>


            </div>
        </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
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

                    // Handle the successful response here
                    $('#result').html('Data from the server: ' + JSON.stringify(response));
                },
                error: function (error) {
                    // Handle errors here
                    console.error('Error:', error);
                }
            });

        }


    </script>
    <script>
        $(document).ready(function () {
            // Cache DOM elements
            const form = $('#maticnadatotekaradnika');
            const submitBtn = $('#submit_btn');
            const errorText = $('#error-validator-text');

            // Function to validate form inputs
            function validateForm() {
                let isValid = true;
                let errorMessages = [];

                // Example fields to validate
                const troskovnoMesto = $('#troskovno_mesto_id');


                // Troškovno mesto validation
                if (!troskovnoMesto.val() || troskovnoMesto.val() === "0" ||  troskovnoMesto.val() ==="Izaberite troškovno mesto") {
                    errorMessages.push('Izaberite troškovno mesto.');
                    troskovnoMesto.addClass('error');
                    isValid = false;
                } else {
                    troskovnoMesto.removeClass('error');
                }



                // Display error messages
                if (!isValid) {
                    errorText.html(errorMessages.join('<br>')).removeClass('d-none');
                } else {
                    errorText.addClass('d-none');
                }

                return isValid;
            }

            // Attach validation to form submit
            form.on('submit', function (event) {
                debugger;
                if (!validateForm()) {
                    event.preventDefault(); // Prevent submission if validation fails
                }
            });
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
