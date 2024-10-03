<!-- resources/views/stanje-zaliha/index.blade.php -->

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/fontawesome-free/css/all.min.css')}}">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"/>
    <style>
        div.dataTables_length select{
            width: 40% !important;
            text-align: center !important;
        }

        .container-fluid{
            width: 80%!important;
        }

        .nav-item {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .nav-link {
            margin-left: 10px !important; /* Adjust spacing between icon and text if needed */
        }

        .nav-title-pp{
            margin-top: 1rem !important;

        }

        .fas{
            font-size: 25px !important;
            margin-left: 25% !important;
            margin-right: 50% !important;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="text-center">Pregled podataka</h1>

        <!-- Tabovi za različite entitete -->
        <ul class="nav nav-tabs self-center justify-content-center mt-5 mb-5 ">
            <ul class="nav nav-tabs justify-content-center ">
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('materijalno.materijali.index') }}">
                        <i class="text-secondary fas fa-tools"></i>
                        <p class="nav-title-pp">Materijali</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('materijalno.stanje-materijala.index') }}">
                        <i class="text-info fas fa-tools"></i>
                        <p class="nav-title-pp">Stanje Materijala</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('materijalno.stanje-materijala.index') }}">
                        <i class="text-secondary fas fa-warehouse"></i>
                        <p class="nav-title-pp">Magacin</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('materijalno.kartice.index') }}">
                        <i class="text-secondary fas fa-copy"></i>
                        <p class="nav-title-pp">Kartice</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('materijalno.porudzbine.index') }}">
                        <i class="text-secondary fas fa-file-invoice"></i>
                        <p class="nav-title-pp">Porudžbine</p></a>
                </li>

                <li class="nav-item d-flex align-items-center justify-content-center">
                    <a class="nav-link" href="{{ route('materijalno.porudzbine.index') }}">
                        <i class="text-secondary fas fa-user-friends"></i>
                        <p class="nav-title-pp">Partnera/Komitenti</p>
                    </a>

                </li>

                <li class="nav-item">
                    <a class="nav-link " href="{{ route('materijalno.porudzbine.index') }}">
                        <i class="text-secondary fas fa-file-invoice-dollar"></i>
                        <p class="nav-title-pp">Konta</p></a>
                </li>
        </ul>
        </ul>
    </div>

@endsection

@section('custom-scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    <script>
    </script>
@endsection
