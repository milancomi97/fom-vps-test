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
            <h1 class="text-center"> Izmena zanimanja</h1>
            <div class="container pb-5 mb-5">
                <form action="{{ route('oblikrada.update', ['id' => $data->id]) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="naziv_oblika_rada">Naziv radnog mesta:</label>
                        <input type="text" class="form-control" id="naziv_oblika_rada" name="naziv_oblika_rada" value="{{ $data->naziv_oblika_rada }}">
                    </div>

                    <div class="form-group">
                        <label for="sifra_oblika_rada">Sifra radnog mesta:</label>
                        <input type="text" class="form-control" id="sifra_oblika_rada" name="sifra_oblika_rada" value="{{ $data->sifra_oblika_rada }}">
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

