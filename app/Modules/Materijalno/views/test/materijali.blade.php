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
                    <h3 class="text-center mt-4">Materijali</h3>
                    <table id="materijaliTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>Šifra Materijala</th>
                            <th>Naziv</th>
                            <th>Standard</th>
                            <th>Dimenzija</th>
                            <th>Jedinica Mere</th>
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
            // Materijali DataTable
            $('#materijaliTable').DataTable({
                ajax: '{{ route('materijali.data') }}',
                columns: [
                    {
                        data: 'sifra_materijala',
                        title: 'Sifra materijala',
                        render: function (data, type, row) {
                            // Prikaz linka koji vodi na stranicu sa detaljima kartice
                            return `<a href="/materijalno/materijal/${row.sifra_materijala}/pregled" class="btn btn-link">${data}</a>`;
                        }
                    },
                    { data: 'naziv_materijala' },
                    { data: 'standard' },
                    { data: 'dimenzija' },
                    { data: 'jedinica_mere' },
                ]
            });

        });
    </script>
@endsection
