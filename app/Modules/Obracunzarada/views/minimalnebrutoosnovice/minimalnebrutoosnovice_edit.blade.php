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
                <form action="{{ route('minimalnebrutoosnovice.update', ['id' => $data->id]) }}" method="post">
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
                        <label for="nt1_prosecna_mesecna_osnovica">Prosečna mesečna osnovica:</label>
                        <input type="text" class="form-control" id="nt1_prosecna_mesecna_osnovica" name="nt1_prosecna_mesecna_osnovica" value="{{ $data->nt1_prosecna_mesecna_osnovica }}">
                    </div>

                    <div class="form-group">
                        <label for="stopa2_minimalna_neto_zarada_po_satu">Minimalna neto zarada po satu:</label>
                        <input type="text" class="form-control" id="stopa2_minimalna_neto_zarada_po_satu" name="stopa2_minimalna_neto_zarada_po_satu" value="{{ $data->stopa2_minimalna_neto_zarada_po_satu }}">
                    </div>

                    <div class="form-group">
                        <label for="stopa6_koeficijent_najvise_osnovice_za_obracun_doprinos">Koeficijent najviše osnovice za obračun dobrinos:</label>
                        <input type="text" class="form-control" id="stopa6_koeficijent_najvise_osnovice_za_obracun_doprinos" name="stopa6_koeficijent_najvise_osnovice_za_obracun_doprinos" value="{{ $data->stopa6_koeficijent_najvise_osnovice_za_obracun_doprinos }}">
                    </div>


                    <div class="form-group">
                        <label for="p1_stopa_poreza">Stopa poreza:</label>
                        <input type="text" class="form-control" id="p1_stopa_poreza" name="p1_stopa_poreza" value="{{ $data->p1_stopa_poreza }}">
                    </div>


                    <div class="form-group">
                        <label for="stopa1_koeficijent_za_obracun_neto_na_bruto">Koeficijent za obračun neto na bruto:</label>
                        <input type="text" class="form-control" id="stopa1_koeficijent_za_obracun_neto_na_bruto" name="stopa1_koeficijent_za_obracun_neto_na_bruto" value="{{ $data->stopa1_koeficijent_za_obracun_neto_na_bruto }}">
                    </div>


                    <div class="form-group">
                        <label for="nt3_najniza_osnovica_za_placanje_doprinos">Najniža osnovica za plaćanje dobrinosa:</label>
                        <input type="text" class="form-control" id="nt3_najniza_osnovica_za_placanje_doprinos" name="nt3_najniza_osnovica_za_placanje_doprinos" value="{{ $data->nt3_najniza_osnovica_za_placanje_doprinos }}">
                    </div>


                    <div class="form-group">
                        <label for="nt2_minimalna_bruto_zarada">Minimalna bruto zarada:</label>
                        <input type="text" class="form-control" id="nt2_minimalna_bruto_zarada" name="nt2_minimalna_bruto_zarada" value="{{ $data->nt2_minimalna_bruto_zarada }}">
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

