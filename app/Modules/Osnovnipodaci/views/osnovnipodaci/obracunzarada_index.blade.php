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
    <div class="content" >
        <!-- Content Header (Page header) -->
        <div class="content-header">
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <h1>Stranica za sifarnike Obracun zarada</h1>
        <p> Isplatna mesta</p>
        <p> Kreditori</p>
        <p> Minimalne bruto osnovice</p>
        <p> Poreski doprinosi</p>
        <p> Vrste placanja</p>

        <!-- /.content -->
        <div class="container">

        </div>
    </div>

    <!-- /.content-wrapper -->
    </div>
@endsection



@section('custom-scripts')

@endsection

