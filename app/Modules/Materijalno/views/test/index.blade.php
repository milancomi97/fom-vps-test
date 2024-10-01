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
        <h1 class="text-center">Pregled podataka</h1>

        <!-- Tabovi za različite entitete -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="materijali-tab" data-toggle="tab" href="#materijali" role="tab" aria-controls="materijali" aria-selected="true">Materijal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="stanjeMaterijala-tab" data-toggle="tab" href="#stanjeMaterijala" role="tab" aria-controls="stanjeMaterijala" aria-selected="false">Stanje Materijala</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="kartice-tab" data-toggle="tab" href="#kartice" role="tab" aria-controls="kartice" aria-selected="false">Kartice</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="porudzbine-tab" data-toggle="tab" href="#porudzbine" role="tab" aria-controls="porudzbine" aria-selected="false">Porudžbine</a>
            </li>
        </ul>

        <!-- Tab sadrzaj za svaku tabelu -->
        <div class="tab-content" id="myTabContent">
            <!-- Materijal -->
            <div class="tab-pane fade show active" id="materijali" role="tabpanel" aria-labelledby="materijali-tab">
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
            </div>

            <!-- Stanje Materijala -->
            <div class="tab-pane fade" id="stanjeMaterijala" role="tabpanel" aria-labelledby="stanjeMaterijala-tab">
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

            <!-- Kartice -->
            <div class="tab-pane fade" id="kartice" role="tabpanel" aria-labelledby="kartice-tab">
                <h3 class="text-center mt-4">Kartice</h3>
                <table id="karticeTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>Šifra dokumenta</th>
                        <th>Ukupna vrednost</th>
                        <th>Pregled dokumenta</th>
                    </tr>
                    </thead>
                </table>
            </div>

            <!-- Porudžbine -->
            <div class="tab-pane fade" id="porudzbine" role="tabpanel" aria-labelledby="porudzbine-tab">
                <h3 class="text-center mt-4">Porudžbine</h3>
                <table id="porudzbineTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>Šifra Porudžbine</th>
                        <th>Naziv</th>
                        <th>Datum Otvaranja</th>
                        <th>Datum Zatvaranja</th>
                        <th>Ugovor</th>
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
    // Materijali DataTable
    $('#materijaliTable').DataTable({
    ajax: '{{ route('materijali.data') }}',
    columns: [
    { data: 'sifra_materijala' },
    { data: 'naziv_materijala' },
    { data: 'standard' },
    { data: 'dimenzija' },
    { data: 'jedinica_mere' },
    ]
    });

    // Stanje Materijala DataTable
        $('#stanjeMaterijalaTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('stanjeMaterijala.data') }}',
            columns: [
                { data: 'magacin_id' },
                { data: 'sifra_materijala' },
                { data: 'kolicina' },
                { data: 'vrednost' },
                { data: 'cena' }
            ],
            pageLength: 10, // Broj redova po stranici
            lengthMenu: [10, 25, 50, 100], // Opcije paginacije
        });


        // Kartice DataTable
    $('#karticeTable').DataTable({
    ajax: '{{ route('kartice.data') }}',
    columns: [
    { data: 'sd' },
    { data: 'sum_total_vrednost' },
        {
            data: 'sd',
            title: 'Ukupna Količina',
            render: function (data, type, row) {
                // Prikaz linka koji vodi na stranicu sa detaljima kartice
                return `<a href="/materijalno/kartica/${row.sd}/pregled" class="btn btn-link">${data}</a>`;
            }
        },
    ]
    });

    // Porudzbine DataTable
    $('#porudzbineTable').DataTable({
    ajax: '{{ route('porudzbine.data') }}',
    columns: [
    { data: 'rbpo' },
    { data: 'napo' },
    { data: 'dident' },
    { data: 'dclose' },
    { data: 'ugovor' },
    ]
    });
    });
    </script>
@endsection
