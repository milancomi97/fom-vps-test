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

        th.sorting{
            padding-right: 5%!important
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
                            <th>naziv_materijala</th>
                            <th>konto</th>
                            <th>dimenzija</th>
                            <th>kvalitet</th>
                            <th>jedinica_mere</th>
                            <th>tezina</th>
                            <th>dimenzije</th>
                            <th>standard</th>
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
                processing: true,
                responsive: true,
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
                    { data:'konto'},
                    { data:'dimenzija'},
                    { data:'kvalitet'},
                    { data:'jedinica_mere'},
                    { data:'tezina'},
                    { data:'dimenzije'},
                    { data:'standard'},
                ],
                initComplete: function () {
                    // Dodajte input polja za pretragu za svaku kolonu
                    var api = this.api();

                    // Dodajte input za pretragu u svaku od kolona
                    api.columns().every(function (index) {
                        var column = this;

                        if (index < 4) { // Ako je indeks kolone manji od 4 (samo za 'sifra_materijala', 'naziv_materijala', 'konto', 'dimenzija')
                            var title = $(column.header()).text();
                            var input = $('<input type="text" placeholder="Pretraži ' + title + '" />')
                                .appendTo($(column.header()))
                                .on('keyup change', function () {

                                    var searchValue = this.value;

                                    if (index === 0) { // Assuming 'sifra_materijala' is the first column (index 0)
                                        // Use regex to match values that start with the input
                                        column.search('^' + searchValue, true, false).draw();
                                    } else {
                                        // Default search for other columns
                                        if (column.search() !== searchValue) {
                                            column.search(searchValue).draw();
                                        }
                                    }

                                });
                        }
                    });
                },
            });

        });
    </script>
@endsection
