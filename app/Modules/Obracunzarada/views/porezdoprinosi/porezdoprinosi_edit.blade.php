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
                        <label for="mesec">Mesec:</label>
                        <input type="text" class="form-control" id="mesec" name="mesec" value="{{ $data->mesec }}">
                    </div>

                    <div class="form-group">
                        <label for="godina">Godina:</label>
                        <input type="text" class="form-control" id="godina" name="godina" value="{{ $data->godina }}">
                    </div>


                    <div class="form-group">
                        <label for="opis0_opis_iznos_poreskog_oslobadjanja">Opis iznosa poreskog oslobadjanja:</label>
                        <input type="text" class="form-control" id="opis0_opis_iznos_poreskog_oslobadjanja" name="opis0_opis_iznos_poreskog_oslobadjanja" value="{{ $data->opis0_opis_iznos_poreskog_oslobadjanja }}">
                    </div>


                    <div class="form-group">
                        <label for="izn1_iznos_poreskog_oslobadjanja">Iznos poreskog oslobadjanja:</label>
                        <input type="text" class="form-control" id="izn1_iznos_poreskog_oslobadjanja" name="izn1_iznos_poreskog_oslobadjanja" value="{{ $data->izn1_iznos_poreskog_oslobadjanja }}">
                    </div>


                    <div class="form-group">
                        <label for="oppor_opis_poreza">Opis poreza:</label>
                        <input type="text" class="form-control" id="oppor_opis_poreza" name="oppor_opis_poreza" value="{{ $data->oppor_opis_poreza }}">
                    </div>


                    <div class="form-group">
                        <label for="p1_porez">Porez:</label>
                        <input type="text" class="form-control" id="p1_porez" name="p1_porez" value="{{ $data->p1_porez }}">
                    </div>


                    <div class="form-group">
                        <label for="opis1_opis_zdravstvenog_osiguranja_na_teret_radnika">Opis zdravstvenog osiguranja na teret radnika:</label>
                        <input type="text" class="form-control" id="opis1_opis_zdravstvenog_osiguranja_na_teret_radnika" name="opis1_opis_zdravstvenog_osiguranja_na_teret_radnika" value="{{ $data->opis1_opis_zdravstvenog_osiguranja_na_teret_radnika }}">
                    </div>


                    <div class="form-group">
                        <label for="zdro_zdravstveno_osiguranje_na_teret_radnika">Zdravstveno osiguranje na teret radnika:</label>
                        <input type="text" class="form-control" id="zdro_zdravstveno_osiguranje_na_teret_radnika" name="zdro_zdravstveno_osiguranje_na_teret_radnika" value="{{ $data->zdro_zdravstveno_osiguranje_na_teret_radnika }}">
                    </div>


                    <div class="form-group">
                        <label for="opis2_opis_pio_na_teret_radnika">Opis PIO na teret radnika:</label>
                        <input type="text" class="form-control" id="opis2_opis_pio_na_teret_radnika" name="opis2_opis_pio_na_teret_radnika" value="{{ $data->opis2_opis_pio_na_teret_radnika }}">
                    </div>


                    <div class="form-group">
                        <label for="pio_pio_na_teret_radnika">Pio na teret radnika:</label>
                        <input type="text" class="form-control" id="pio_pio_na_teret_radnika" name="pio_pio_na_teret_radnika" value="{{ $data->pio_pio_na_teret_radnika }}">
                    </div>


                    <div class="form-group">
                        <label for="opis3_opis_osiguranja_od_nezaposlenosti_na_teret_radnika">Opis osiguranja od nezaposljenosti na teret radnika:</label>
                        <input type="text" class="form-control" id="opis3_opis_osiguranja_od_nezaposlenosti_na_teret_radnika" name="opis3_opis_osiguranja_od_nezaposlenosti_na_teret_radnika" value="{{ $data->opis3_opis_osiguranja_od_nezaposlenosti_na_teret_radnika }}">
                    </div>


                    <div class="form-group">
                        <label for="onez_osiguranje_od_nezaposlenosti_na_teret_radnika">Osiguranje od nezaposlenosti na teret radnika:</label>
                        <input type="text" class="form-control" id="onez_osiguranje_od_nezaposlenosti_na_teret_radnika" name="onez_osiguranje_od_nezaposlenosti_na_teret_radnika" value="{{ $data->onez_osiguranje_od_nezaposlenosti_na_teret_radnika }}">
                    </div>


                    <div class="form-group">
                        <label for="ukdop_ukupni_doprinosi_na_teret_radnika">Ukupni doprinosi na teret radnika:</label>
                        <input type="text" class="form-control" id="ukdop_ukupni_doprinosi_na_teret_radnika" name="ukdop_ukupni_doprinosi_na_teret_radnika" value="{{ $data->ukdop_ukupni_doprinosi_na_teret_radnika }}">
                    </div>


                    <div class="form-group">
                        <label for="opis4_opis_zdravstvenog_osiguranja_na_teret_poslodavca">Opis zdravstvenog osiguranja na teret poslodavca:</label>
                        <input type="text" class="form-control" id="opis4_opis_zdravstvenog_osiguranja_na_teret_poslodavca" name="opis4_opis_zdravstvenog_osiguranja_na_teret_poslodavca" value="{{ $data->opis4_opis_zdravstvenog_osiguranja_na_teret_poslodavca }}">
                    </div>


                    <div class="form-group">
                        <label for="dopzp_zdravstveno_osiguranje_na_teret_poslodavca">Zdravstveno osiguranje na teret poslodavca:</label>
                        <input type="text" class="form-control" id="dopzp_zdravstveno_osiguranje_na_teret_poslodavca" name="dopzp_zdravstveno_osiguranje_na_teret_poslodavca" value="{{ $data->dopzp_zdravstveno_osiguranje_na_teret_poslodavca }}">
                    </div>


                    <div class="form-group">
                        <label for="opis5_opis_pio_na_teret_poslodavca">Opis pio na teret poslodavca:</label>
                        <input type="text" class="form-control" id="opis5_opis_pio_na_teret_poslodavca" name="opis5_opis_pio_na_teret_poslodavca" value="{{ $data->opis5_opis_pio_na_teret_poslodavca }}">
                    </div>


                    <div class="form-group">
                        <label for="dopp_pio_na_teret_poslodavca">Pio na teret poslodavca:</label>
                        <input type="text" class="form-control" id="dopp_pio_na_teret_poslodavca" name="dopp_pio_na_teret_poslodavca" value="{{ $data->dopp_pio_na_teret_poslodavca }}">
                    </div>


                    <div class="form-group">
                        <label for="ukdopp_ukupni_doprinosi_na_teret_poslodavca">Ukupni doprinosi na teret poslodavca:</label>
                        <input type="text" class="form-control" id="ukdopp_ukupni_doprinosi_na_teret_poslodavca" name="ukdopp_ukupni_doprinosi_na_teret_poslodavca" value="{{ $data->ukdopp_ukupni_doprinosi_na_teret_poslodavca }}">
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

