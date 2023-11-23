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
            <h1 class="text-center"> Izmena kvalifikacije</h1>
            <div class="container pb-5 mb-5">
                <form action="{{ route('strucnakvalifikacija.update', ['id' => $data->id]) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="naziv_troskovnog_mesta">Naziv kvalifikacije:</label>
                        <input type="text" class="form-control" id="naziv_kvalifikacije" name="naziv_kvalifikacije" value="{{ $data->naziv_kvalifikacije }}">
                    </div>

                    <div class="form-group">
                        <label for="sifra_troskovnog_mesta">Sifra kvalifikacije:</label>
                        <input type="text" class="form-control" id="sifra_kvalifikacije" name="sifra_kvalifikacije" value="{{ $data->sifra_kvalifikacije }}">
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

