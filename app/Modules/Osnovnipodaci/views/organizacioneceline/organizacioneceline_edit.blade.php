@extends('osnovnipodaci::theme.layout.app')

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
            <h1 class="text-center"> Izmena troškovnog mesta</h1>
            <div class="container pb-5 mb-5">
                <form action="{{ route('organizacioneceline.update', ['id' => $data->id]) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="naziv_troskovnog_mesta">Naziv Troskovnog Mesta:</label>
                        <input type="text" class="form-control" id="naziv_troskovnog_mesta" name="naziv_troskovnog_mesta" value="{{ $data->naziv_troskovnog_mesta }}">
                    </div>

                    <div class="form-group">
                        <label for="sifra_troskovnog_mesta">Sifra troskovnog mesta:</label>
                        <input type="text" class="form-control" id="sifra_troskovnog_mesta" name="sifra_troskovnog_mesta" value="{{ $data->sifra_troskovnog_mesta }}">
                    </div>

                    <div class="form-group">
                        <label for="active">Aktivno:</label>
                        <select class="form-control" id="active" name="active">
                            <option value="1" {{ $data->active ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ !$data->active ? 'selected' : '' }}>No</option>
                        </select>
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

