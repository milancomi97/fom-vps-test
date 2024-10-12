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
        @include('materijalno::vertical_nav_prosiren')


    </div>

@endsection

@section('custom-scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    <script>
    </script>
@endsection
