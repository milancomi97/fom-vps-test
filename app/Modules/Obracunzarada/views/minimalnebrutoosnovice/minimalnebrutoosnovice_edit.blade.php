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
                        <label for="mesec">Mesec i Godina:</label>
                        <input type="text" class="form-control" id="M_G_mesec_dodina" name="M_G_mesec_dodina" value="{{ $data->M_G_mesec_dodina }}">
                    </div>
                    <div class="form-group">
                        <label for="NT1_prosecna_mesecna_zarada_u_republici">Prosečna mesečna osnovica:</label>
                        <input type="text" class="form-control" id="NT1_prosecna_mesecna_zarada_u_republici" name="NT1_prosecna_mesecna_zarada_u_republici" value="{{ $data->NT1_prosecna_mesecna_zarada_u_republici }}">
                    </div>

                    <div class="form-group">
                        <label for="STOPA2_minimalna_neto_zarada_po_satu">Minimalna neto zarada po satu:</label>
                        <input type="text" class="form-control" id="STOPA2_minimalna_neto_zarada_po_satu" name="STOPA2_minimalna_neto_zarada_po_satu" value="{{ $data->STOPA2_minimalna_neto_zarada_po_satu }}">
                    </div>

                    <div class="form-group">
                        <label for="STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos">Koeficijent najviše osnovice za obračun dobrinos:</label>
                        <input type="text" class="form-control" id="STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos" name="STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos" value="{{ $data->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos }}">
                    </div>


                    <div class="form-group">
                        <label for="P1_stopa_poreza">Stopa poreza:</label>
                        <input type="text" class="form-control" id="P1_stopa_poreza" name="P1_stopa_poreza" value="{{ $data->P1_stopa_poreza }}">
                    </div>


                    <div class="form-group">
                        <label for="STOPA1_koeficijent_za_obracun_neto_na_bruto">Koeficijent za obračun neto na bruto:</label>
                        <input type="text" class="form-control" id="STOPA1_koeficijent_za_obracun_neto_na_bruto" name="STOPA1_koeficijent_za_obracun_neto_na_bruto" value="{{ $data->STOPA1_koeficijent_za_obracun_neto_na_bruto }}">
                    </div>

                    <div class="form-group">
                        <label for="NT2_minimalna_bruto_zarada">Minimalna bruto zarada:</label>
                        <input type="text" class="form-control" id="NT2_minimalna_bruto_zarada" name="NT2_minimalna_bruto_zarada" value="{{ $data->NT2_minimalna_bruto_zarada }}">
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

