@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <style>
        .error {
            border: 1px solid red;
        }

        .infoAcc {
            margin-bottom: 0;
        }

        #errorContainer {
            color: red;
            text-align: center;
            font-size: 2em;
            margin-bottom: 2em;
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
            <h1 class="text-center"> Izmena zanimanja</h1>
            <div class="container pb-5 mb-5">
                <form action="{{ route('zanimanjasifarnik.update', ['id' => $data->id]) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="naziv_troskovnog_mesta">Naziv zanimanja:</label>
                        <input type="text" class="form-control" id="naziv_zanimanja" name="naziv_zanimanja" value="{{ $data->naziv_zanimanja }}">
                    </div>

                    <div class="form-group">
                        <label for="sifra_troskovnog_mesta">Sifra zanimanja:</label>
                        <input type="text" class="form-control" id="sifra_zanimanja" name="sifra_zanimanja" value="{{ $data->sifra_zanimanja }}">
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

