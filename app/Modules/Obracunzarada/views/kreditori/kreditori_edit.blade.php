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
            <h1 class="text-center"> Izmena kreditora</h1>
            <div class="container pb-5 mb-5">
                <form action="{{ route('kreditori.update', ['id' => $data->id]) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="sifk_sifra_kreditora">Šifra kreditora:</label>
                        <input type="text" class="form-control" id="sifk_sifra_kreditora" name="sifk_sifra_kreditora" value="{{ $data->sifk_sifra_kreditora }}">
                    </div>

                    <div class="form-group">
                        <label for="imek_naziv_kreditora">Ime kreditora:</label>
                        <input type="text" class="form-control" id="imek_naziv_kreditora" name="imek_naziv_kreditora" value="{{ $data->imek_naziv_kreditora }}">
                    </div>

                    <div class="form-group">
                        <label for="sediste_kreditora">Sedište kreditora:</label>
                        <input type="text" class="form-control" id="sediste_kreditora" name="sediste_kreditora" value="{{ $data->sediste_kreditora }}">
                    </div>

                    <div class="form-group">
                        <label for="tekuci_racun_za_uplatu">Naziv radnog mesta:</label>
                        <input type="text" class="form-control" id="tekuci_racun_za_uplatu" name="tekuci_racun_za_uplatu" value="{{ $data->tekuci_racun_za_uplatu }}">
                    </div>

                    <div class="form-group">
                        <label for="partija_kredita">Naziv radnog mesta:</label>
                        <input type="text" class="form-control" id="partija_kredita" name="partija_kredita" value="{{ $data->partija_kredita }}">
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

