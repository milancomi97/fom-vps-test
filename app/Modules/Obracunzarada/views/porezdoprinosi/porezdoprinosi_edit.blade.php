@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
@endsection

@section('content')
    <div class="container">
        <div class="content">
            <!-- Content Header (Page header) -->
            <div class="content-header">
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
{{--            --}}
{{--            --}}
{{--            --}}
{{--            --}}
{{--            partija_kredita--}}
            <!-- /.content -->
            <h1 class="text-center"> Izmena Minimalnih bruto osnovica</h1>
            <div class="container pb-5 mb-5">
                <form action="{{ route('porezdoprinosi.update', ['id' => $data->id]) }}" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="M_G_mesec_godina">Mesec i godina:</label>
                        <input type="text" class="form-control" id="M_G_mesec_godina" name="M_G_mesec_godina" value="{{ $data->M_G_mesec_godina }}">
                    </div>


                    <div class="form-group">
                        <label for="IZN1_iznos_poreskog_oslobodjenja">Opis iznosa poreskog oslobodjenja:</label>
                        <input type="text" class="form-control" id="IZN1_iznos_poreskog_oslobodjenja" name="IZN1_iznos_poreskog_oslobodjenja" value="{{ $data->IZN1_iznos_poreskog_oslobodjenja }}">
                    </div>


                    <div class="form-group">
                        <label for="OPPOR_opis_poreza">Opis poreza:</label>
                        <input type="text" class="form-control" id="OPPOR_opis_poreza" name="OPPOR_opis_poreza" value="{{ $data->OPPOR_opis_poreza }}">
                    </div>


                    <div class="form-group">
                        <label for="P1_porez_na_licna_primanja">Porez na licna primanja:</label>
                        <input type="text" class="form-control" id="P1_porez_na_licna_primanja" name="P1_porez_na_licna_primanja" value="{{ $data->P1_porez_na_licna_primanja }}">
                    </div>


                    <div class="form-group">
                        <label for="OPIS1_opis_zdravstvenog_osiguranja_na_teret_radnika">Opis zdravstvenog osiguranja na teret radnika:</label>
                        <input type="text" class="form-control" id="OPIS1_opis_zdravstvenog_osiguranja_na_teret_radnika" name="OPIS1_opis_zdravstvenog_osiguranja_na_teret_radnika" value="{{ $data->OPIS1_opis_zdravstvenog_osiguranja_na_teret_radnika }}">
                    </div>


                    <div class="form-group">
                        <label for="ZDRO_zdravstveno_osiguranje_na_teret_radnika">Zdravstveno osiguranje na teret radnika:</label>
                        <input type="text" class="form-control" id="ZDRO_zdravstveno_osiguranje_na_teret_radnika" name="ZDRO_zdravstveno_osiguranje_na_teret_radnika" value="{{ $data->ZDRO_zdravstveno_osiguranje_na_teret_radnika }}">
                    </div>


                    <div class="form-group">
                        <label for="OPIS2_opis_pio_na_teret_radnika">Opis PIO na teret radnika:</label>
                        <input type="text" class="form-control" id="OPIS2_opis_pio_na_teret_radnika" name="OPIS2_opis_pio_na_teret_radnika" value="{{ $data->OPIS2_opis_pio_na_teret_radnika }}">
                    </div>


                    <div class="form-group">
                        <label for="PIO_pio_na_teret_radnika">Pio na teret radnika:</label>
                        <input type="text" class="form-control" id="PIO_pio_na_teret_radnika" name="PIO_pio_na_teret_radnika" value="{{ $data->PIO_pio_na_teret_radnika }}">
                    </div>


                    <div class="form-group">
                        <label for="OPIS3_opis_osiguranja_od_nezaposlenosti_na_teret_radnika">Opis osiguranja od nezaposljenosti na teret radnika:</label>
                        <input type="text" class="form-control" id="OPIS3_opis_osiguranja_od_nezaposlenosti_na_teret_radnika" name="OPIS3_opis_osiguranja_od_nezaposlenosti_na_teret_radnika" value="{{ $data->OPIS3_opis_osiguranja_od_nezaposlenosti_na_teret_radnika }}">
                    </div>


                    <div class="form-group">
                        <label for="ONEZ_osiguranje_od_nezaposlenosti_na_teret_radnika">Osiguranje od nezaposlenosti na teret radnika:</label>
                        <input type="text" class="form-control" id="ONEZ_osiguranje_od_nezaposlenosti_na_teret_radnika" name="ONEZ_osiguranje_od_nezaposlenosti_na_teret_radnika" value="{{ $data->ONEZ_osiguranje_od_nezaposlenosti_na_teret_radnika }}">
                    </div>


                    <div class="form-group">
                        <label for="UKDOPR_ukupni_doprinosi_na_teret_radnika">Ukupni doprinosi na teret radnika:</label>
                        <input type="text" class="form-control" id="UKDOPR_ukupni_doprinosi_na_teret_radnika" name="UKDOPR_ukupni_doprinosi_na_teret_radnika" value="{{ $data->UKDOPR_ukupni_doprinosi_na_teret_radnika }}">
                    </div>


                    <div class="form-group">
                        <label for="OPIS4_opis_zdravstvenog_osiguranja_na_teret_poslodavca">Opis zdravstvenog osiguranja na teret poslodavca:</label>
                        <input type="text" class="form-control" id="OPIS4_opis_zdravstvenog_osiguranja_na_teret_poslodavca" name="OPIS4_opis_zdravstvenog_osiguranja_na_teret_poslodavca" value="{{ $data->OPIS4_opis_zdravstvenog_osiguranja_na_teret_poslodavca }}">
                    </div>


                    <div class="form-group">
                        <label for="DOPRA_zdravstveno_osiguranje_na_teret_poslodavca">Zdravstveno osiguranje na teret poslodavca:</label>
                        <input type="text" class="form-control" id="DOPRA_zdravstveno_osiguranje_na_teret_poslodavca" name="DOPRA_zdravstveno_osiguranje_na_teret_poslodavca" value="{{ $data->DOPRA_zdravstveno_osiguranje_na_teret_poslodavca }}">
                    </div>


                    <div class="form-group">
                        <label for="OPIS5_opis_pio_na_teret_poslodavca">Opis pio na teret poslodavca:</label>
                        <input type="text" class="form-control" id="OPIS5_opis_pio_na_teret_poslodavca" name="OPIS5_opis_pio_na_teret_poslodavca" value="{{ $data->OPIS5_opis_pio_na_teret_poslodavca }}">
                    </div>
                    <div class="form-group">
                        <label for="DOPRB_pio_na_teret_poslodavca">Ukupni doprinosi na teret poslodavca:</label>
                        <input type="text" class="form-control" id="DOPRB_pio_na_teret_poslodavca" name="DOPRB_pio_na_teret_poslodavca" value="{{ $data->DOPRB_pio_na_teret_poslodavca }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
                </form>
            </div>
        </div>
        <!-- /.content-wrapper -->
    </div>
@endsection



@section('custom-scripts')
@endsection

