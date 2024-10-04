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
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active {{ $activeTab == 'materijali' ? 'show active' : '' }}" id="materijali" role="tabpanel">
                    <h3 class="text-center mt-4">Magacini po kontima</h3>
                    <table id="kontaTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>Magacin ID</th>
                            <th>Konto</th>
                            <th>Ukupna Vrednost</th>
                        </tr>
                        </thead>
                    </table>
                </div>            </div>
        </div>
    @endsection

@section('custom-scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function () {
            // Stanje Zaliha DataTable
            $('#kontaTable').DataTable({
                ajax: '{{ route('materijalno.getDataKonta.data') }}', // Ruta za preuzimanje podataka
                columns: [
                    { data: 'magacin_id', title: 'Magacin' }, // Magacin ID
                    { data: 'konto', title: 'Konto' },        // Konto
                    { data: 'ukupna_vrednost', title: 'Ukupna Vrednost' } // Sumirana vrednost
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],  // Opcije za paginaciju
            });
        });
    </script>
@endsection
