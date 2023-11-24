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
            <!-- /.content -->
            <h1 class="text-center">Izmena vrste plaćanja</h1>
            <div class="container pb-5 mb-5">
                <form action="{{ route('vrsteplacanja.update', ['id' => $data->id]) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="naziv_naziv_vrste_placanja">Naziv vrste plaćanja:</label>
                        <input type="text" class="form-control" id="naziv_naziv_vrste_placanja" name="naziv_naziv_vrste_placanja" value="{{ $data->naziv_naziv_vrste_placanja }}">
                    </div>

                    <div class="form-group">
                        <label for="rbvp_sifra_vrste_placanja">Sifra vrste plaćanja:</label>
                        <input type="text" class="form-control" id="rbvp_sifra_vrste_placanja" name="rbvp_sifra_vrste_placanja" value="{{ $data->rbvp_sifra_vrste_placanja }}">
                    </div>

                    <div class="form-group">
                        <label for="formula_formula_za_obracun">Formula:</label>
                        <input type="text" class="form-control" id="formula_formula_za_obracun" name="formula_formula_za_obracun" value="{{ $data->formula_formula_za_obracun }}">
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

