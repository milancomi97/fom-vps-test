<!-- resources/views/stanje-zaliha/index.blade.php -->

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
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
    </style>
@endsection

    @section('content')
        <div class="container-fluid">
            @include('materijalno::vertical_nav_magacin')

            <!-- Dinamičko učitavanje sadržaja taba -->
            <div class="container">
                <h3 class="text-center mt-4">Lista Partnera</h3>
                <table id="partnerTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>Ime</th>
                        <th>Kratko ime</th>
                        <th>PIB</th>
                        <th>Telefon</th>
                        <th>Email</th>
                    </tr>
                    </thead>
                </table>
            </div>
    @endsection

@section('custom-scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#partnerTable').DataTable({
                ajax: {
                    url: '{{ route('materijalno.getDataPartner.data') }}',  // Ruta koja vraća JSON podatke o partnerima
                    dataSrc: 'data'  // Polje u JSON-u iz kojeg DataTable preuzima podatke
                },
                columns: [
                    { data: 'name', title: 'Ime' },
                    { data: 'short_name', title: 'Kratko ime' },
                    { data: 'pib', title: 'PIB' },
                    { data: 'phone', title: 'Telefon' },
                    { data: 'email', title: 'Email' }
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],  // Opcije za paginaciju
            });
        });
    </script>
@endsection
