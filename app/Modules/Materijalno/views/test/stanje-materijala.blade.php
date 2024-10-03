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
            <!-- Stanje Materijala -->
            <div class="tab-pane fade show active" id="stanjeMaterijala" role="tabpanel" aria-labelledby="stanjeMaterijala-tab">
                <h3 class="text-center mt-4">Stanje Materijala</h3>
                <table id="stanjeMaterijalaTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>Šifra Magacina</th>
                        <th>Šifra Materijala</th>
                        <th>Količina</th>
                        <th>Vrednost</th>
                        <th>Cena</th>
                    </tr>
                    </thead>
                </table>
            </div>


        </div>
    </div>


@endsection

@section('custom-scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function () {
            // Stanje Materijala DataTable
            $('#stanjeMaterijalaTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('stanjeMaterijala.data') }}',
                columns: [
                    { data: 'magacin_id' },
                    {
                        data: 'sifra_materijala',
                        title: 'Sifra materijala',
                        render: function (data, type, row) {
                            // Prikaz linka koji vodi na stranicu sa detaljima kartice
                            return `<a href="/materijalno/materijal/${row.sifra_materijala}/pregled" class="btn btn-link">${data}</a>`;
                        }
                    },
                    { data: 'kolicina' },
                    { data: 'vrednost' },
                    { data: 'cena' }
                ],
                pageLength: 10, // Broj redova po stranici
                lengthMenu: [10, 25, 50, 100], // Opcije paginacije
            });

        });
    </script>
@endsection
