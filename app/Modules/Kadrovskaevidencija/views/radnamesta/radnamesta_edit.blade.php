@extends('osnovnipodaci::theme.layout.app')

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
                <form action="{{ route('radnamesta.update', ['id' => $data->id]) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="naziv_troskovnog_mesta">Naziv radnog mesta:</label>
                        <input type="text" class="form-control" id="narm_naziv_radnog_mesta" name="narm_naziv_radnog_mesta" value="{{ $data->narm_naziv_radnog_mesta }}">
                    </div>

                    <div class="form-group">
                        <label for="sifra_troskovnog_mesta">Sifra radnog mesta:</label>
                        <input type="text" class="form-control" id="rbrm_sifra_radnog_mesta" name="rbrm_sifra_radnog_mesta" value="{{ $data->rbrm_sifra_radnog_mesta }}">
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

