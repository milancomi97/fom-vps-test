<?php use App\Modules\Obracunzarada\Consts\UserRoles; ?>

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <style>
        .table-container {
            width: 130%; /* Set your desired width */
            overflow-x: auto; /* Enable horizontal scrollbar */
        }
    </style>
@endsection

@section('content')
    <div class="container-lg">
        <div class="content" >
            <h1 class="text-center">Obracunska lista</h1>
        </div>
        <div class="container-lg">
            <h1 class="text-center">Progamerski deo:</h1>
            <h2 class="text-center">Prikaz SUME</h2>
        <div class="table-container mb-5">
            <table class="table table-striped">
                <thead>
                <tr>
                    @if($zaraData->isNotEmpty())
                        @foreach(array_keys($zaraData->first()->getAttributes()) as $column)
                            <th>{{ $column }}</th>
                        @endforeach
                    @else
                        <h1 class="text-center mt-5">Podaci za unete parametre ne postoje</h1>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($zaraData as $zar)
                    <tr>
                        @foreach($zar->getAttributes() as $value)
                            <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

            <h2 class="text-center">Prikaz DARH</h2>

            <div class="table-container mb-5">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        @if($dkopData->isNotEmpty())
                            @foreach(array_keys($dkopData->first()->getAttributes()) as $column)
                                <th>{{ $column }}</th>
                            @endforeach
                        @else
                            <h1 class="text-center mt-5">Podaci za unete parametre ne postoje</h1>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($dkopData as $dkop)
                        <tr>
                            @foreach($dkop->getAttributes() as $value)
                                <td>{{ $value }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- /.content-wrapper -->

        </div>
    </div>
@endsection



@section('custom-scripts')
    <script>

    </script>
@endsection

